<?php

namespace App\Http\Livewire\Public;

use App\Http\Livewire\Public\Concerns\BuildsPublicLayout;
use App\Services\StrapiClient;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Support\Str;
use Livewire\Component;

/**
 * Strapi-powered single resource page (fxnseo-post by slug). Renders the post's
 * markdown content as the article body inside the standard public layout.
 */
class ResourceShow extends Component
{
    use BuildsPublicLayout;

    public string $slug;

    public function mount($slug)
    {
        $this->slug = $slug;

        if (app(StrapiClient::class)->post($this->slug) === null) {
            abort(404);
        }
    }

    public function render()
    {
        $strapi = app(StrapiClient::class);
        $post   = $strapi->post($this->slug);

        if ($post === null) {
            abort(404);
        }

        $title    = $post['title'] ?? '';
        $excerpt  = $post['excerpt'] ?? '';
        $bodyMd   = $post['content'] ?? '';
        $bodyHtml = $bodyMd !== '' ? Str::markdown($bodyMd) : '';
        $cover    = $strapi->mediaUrl($post['coverImage'] ?? null);

        $metaTitle = $post['seoTitle'] ?: $title;
        $metaDesc  = $post['seoDescription'] ?: $excerpt;
        $siteName  = ' ' . env('APP_SEPARATOR') . ' ' . env('APP_NAME');
        $url       = route('home') . '/resources/' . $this->slug;

        SEOMeta::setTitle($metaTitle . $siteName);
        SEOMeta::setDescription($metaDesc);
        SEOMeta::setCanonical($url);
        SEOMeta::addMeta('robots', 'follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large', 'name');

        OpenGraph::addProperty('type', 'article')
            ->setTitle($metaTitle)
            ->setDescription($metaDesc)
            ->setUrl($url)
            ->setSiteName(env('APP_NAME'));
        if ($cover) {
            OpenGraph::addImage($cover);
        }

        TwitterCard::setType('summary_large_image')
            ->setTitle($metaTitle)
            ->setDescription($metaDesc)
            ->setUrl($url);
        if ($cover) {
            TwitterCard::setImage($cover);
        }

        // Build the article body the layout will render (cover image + markdown HTML).
        $description = '';
        if ($cover) {
            $description .= '<img src="' . e($cover) . '" alt="' . e($title) . '" class="img-fluid rounded-3 mb-4 w-100" loading="lazy">';
        }
        $description .= $bodyHtml;

        $page      = $this->publicPage(['id' => 'resource', 'featured_image' => $cover]);
        $pageTrans = $this->pageTrans($title, $excerpt, $description);

        return view('livewire.public.resource-show')
            ->layout('layouts.public', $this->layoutData($page, $pageTrans));
    }
}
