<?php

namespace App\Http\Livewire\Public;

use App\Http\Livewire\Public\Concerns\BuildsPublicLayout;
use App\Services\StrapiClient;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Strapi-powered "Resources" listing — reads the fxnseo-post collection from
 * the Strapi CMS and renders it inside the standard public layout.
 */
class Resources extends Component
{
    use WithPagination;
    use BuildsPublicLayout;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $strapi   = app(StrapiClient::class);
        $pageNum  = max(1, (int) request()->query('page', 1));
        $response = $strapi->posts($pageNum, 12);

        $posts = collect($response['data'] ?? [])->map(function ($item) use ($strapi) {
            return [
                'title'    => $item['title'] ?? '',
                'slug'     => $item['slug'] ?? '',
                'excerpt'  => $item['excerpt'] ?? '',
                'cover'    => $strapi->mediaUrl($item['coverImage'] ?? null),
            ];
        })->all();

        $pagination = $response['meta']['pagination'] ?? ['page' => 1, 'pageCount' => 1];

        $title       = __('Resources');
        $description = __('Guides, insights and resources from the fxnSEOTools team.');
        $siteName    = ' ' . env('APP_SEPARATOR') . ' ' . env('APP_NAME');

        SEOMeta::setTitle($title . $siteName);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical(route('home') . '/resources');
        SEOMeta::addMeta('robots', 'follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large', 'name');

        // Render the card grid to HTML and feed it to the layout's content-box
        // (so the "Resources" heading sits above the grid, as on native pages).
        $grid = view('livewire.public.partials.resources-grid', [
            'posts'      => $posts,
            'pagination' => $pagination,
        ])->render();

        $page      = $this->publicPage(['id' => 'resources']);
        $pageTrans = $this->pageTrans($title, $description, $grid);

        return view('livewire.public.resources')
            ->layout('layouts.public', $this->layoutData($page, $pageTrans));
    }
}
