<?php
/**
 * Import an article directly into the SumoSEO native blog (pages + page_translations)
 * so it appears under /admin/posts and /blog. Images are automatically saved locally.
 *
 * Usage: php sumoseo-import-post.php <path-to-json>
 * JSON keys: title, slug, excerpt, content (markdown), seoTitle, seoDescription,
 *            featured_image (optional local path or URL)
 * Prints JSON: {"id":<page id>,"slug":"<final slug>"} on success.
 *
 * Run as www-data to keep any framework-written cache files correctly owned:
 *   sudo -u www-data php sumoseo-import-post.php /tmp/post.json
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Admin\Page;
use App\Models\Admin\PageCategory;
use Illuminate\Support\Str;

function out(array $data, int $code = 0): void
{
    fwrite(STDOUT, json_encode($data));
    exit($code);
}

$file = $argv[1] ?? '';
if (!$file || !is_file($file)) {
    out(['error' => 'JSON file argument missing or not found'], 1);
}

$data = json_decode(file_get_contents($file), true);
$imageOnly = is_array($data) && !empty($data['set_featured_image_only']);
if (!is_array($data) || (!$imageOnly && empty($data['title'])) || ($imageOnly && empty($data['slug']))) {
    out(['error' => $imageOnly ? 'Invalid image-update payload (missing slug)' : 'Invalid JSON payload (missing title)'], 1);
}

// Unique slug within pages
$base = Str::slug(($data['slug'] ?? '') ?: ($data['title'] ?? ''));
$slug = $base ?: 'post';

// Image-only update: set featured_image on an existing native post, no new row.
if (!empty($data['set_featured_image_only'])) {
    $page = Page::where('slug', $slug)->first();
    if (!$page) {
        out(['error' => 'page not found for slug: ' . $slug], 1);
    }
    $rawImage = $data['featured_image'] ?? null;
    $page->featured_image = $rawImage ? str_replace('strapi.fxnstudio.com', 'cms.fxnstudio.com', $rawImage) : null;
    $page->save();
    out(['id' => $page->id, 'slug' => $slug, 'updated_image' => true]);
}

// Backfill/import: skip instead of duplicating when the slug already exists.
if (!empty($data['skip_if_exists']) && Page::where('slug', $slug)->exists()) {
    out(['skipped' => true, 'slug' => $slug]);
}

$i = 2;
while (Page::where('slug', $slug)->exists()) {
    $slug = $base . '-' . $i;
    $i++;
}

$contentMd   = (string) ($data['content'] ?? '');
$contentHtml = $contentMd !== '' ? (string) Str::markdown($contentMd) : '';

try {
    $page = new Page;
    $page->slug           = $slug;
    $page->type           = 'post';
    $rawImage = $data['featured_image'] ?? null;
    $page->featured_image = $rawImage ? str_replace('strapi.fxnstudio.com', 'cms.fxnstudio.com', $rawImage) : null;
    $page->post_status    = !empty($data['publish']) ? 1 : 0; // draft => hidden from /blog, still in /admin/posts
    $page->page_status    = 1;

    if (!empty($data['category']) || !empty($data['category_slug'])) {
        $cat = PageCategory::where('slug', $data['category_slug'] ?? '')
            ->orWhere('title', $data['category'] ?? '')
            ->first();
        if ($cat) {
            $page->category_id = $cat->id;
        }
    }

    $page->save();

    $t = $page->translateOrNew('en');
    $t->page_title        = $data['seoTitle'] ?: $data['title'];
    $t->title             = $data['title'];
    $t->subtitle          = $data['seoDescription'] ?? '';
    $t->short_description = $data['excerpt'] ?? '';
    $t->description       = $contentHtml;
    $t->robots_meta       = 0;
    $t->sitename_status   = 1;
    $page->save();

    out(['id' => $page->id, 'slug' => $slug]);
} catch (\Throwable $e) {
    out(['error' => $e->getMessage()], 1);
}
