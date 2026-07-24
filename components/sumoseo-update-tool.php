<?php
/**
 * Update an SEO tool page's translated content (subtitle / short_description /
 * description / title / page_title) for the SumoSEO app. Called by the
 * ai-writer-cli (generate-fxnseo-tool-content.js).
 *
 * Usage: php sumoseo-update-tool.php <path-to-json>
 * JSON keys: slug (required), subtitle, short_description, description (markdown),
 *            title, page_title, overwrite (bool)
 * Prints JSON: {"id":<page id>,"slug":...} or {"skipped":true,...}
 *
 * Run as www-data:  sudo -u www-data php sumoseo-update-tool.php /tmp/tool.json
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Admin\Page;
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
if (!is_array($data) || empty($data['slug'])) {
    out(['error' => 'Invalid payload (missing slug)'], 1);
}

$page = Page::where('slug', $data['slug'])->where('type', 'tool')->first();
if (!$page) {
    out(['error' => 'tool not found: ' . $data['slug']], 1);
}

$t = $page->translateOrNew('en');

// Skip if already populated, unless overwrite requested.
$hasContent = !empty(trim((string) $t->subtitle)) && !empty(trim((string) $t->description));
if ($hasContent && empty($data['overwrite'])) {
    out(['skipped' => true, 'slug' => $data['slug'], 'id' => $page->id]);
}

if (array_key_exists('title', $data) && $data['title'] !== null && $data['title'] !== '') {
    $t->title = $data['title'];
}
if (array_key_exists('page_title', $data) && $data['page_title'] !== null && $data['page_title'] !== '') {
    $t->page_title = $data['page_title'];
}
if (array_key_exists('subtitle', $data)) {
    $t->subtitle = $data['subtitle'];
}
if (array_key_exists('short_description', $data)) {
    $t->short_description = $data['short_description'];
}
if (array_key_exists('description', $data) && $data['description'] !== null) {
    $md = (string) $data['description'];
    $t->description = $md !== '' ? (string) Str::markdown($md) : '';
}

try {
    $page->save();
    out(['id' => $page->id, 'slug' => $data['slug'], 'updated' => true]);
} catch (\Throwable $e) {
    out(['error' => $e->getMessage()], 1);
}
