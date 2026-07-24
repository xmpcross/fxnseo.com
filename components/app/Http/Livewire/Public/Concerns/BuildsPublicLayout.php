<?php

namespace App\Http\Livewire\Public\Concerns;

use App\Models\Admin\Advanced;
use App\Models\Admin\Advertisement;
use App\Models\Admin\FooterTranslation;
use App\Models\Admin\Gdpr;
use App\Models\Admin\General;
use App\Models\Admin\Header;
use App\Models\Admin\Menu;
use App\Models\Admin\Page as PublicPost;
use App\Models\Admin\Sidebar;
use App\Models\Admin\Social;
use App\Models\Admin\User;

/**
 * Assembles the variable bag that `layouts.public` expects (navbar, footer,
 * sidebar, ads, gdpr, etc.) so Strapi-powered pages render inside the exact
 * same site chrome as native pages. The layout renders $pageTrans->title /
 * ->subtitle / ->description itself, so callers pass synthetic $page/$pageTrans
 * objects built from Strapi content via publicPage()/pageTrans().
 */
trait BuildsPublicLayout
{
    /** A stand-in for the Page model — only the fields the layout reads. */
    protected function publicPage(array $overrides = []): object
    {
        return (object) array_merge([
            'id'             => 0,
            'type'           => 'page',   // not 'tool'/'post'/'contact'/'report'
            'ads_status'     => false,
            'category_id'    => 0,
            'featured_image' => null,
        ], $overrides);
    }

    /** A stand-in for the translated page — title/subtitle/description are HTML-safe. */
    protected function pageTrans(string $title, string $subtitle = '', string $description = ''): object
    {
        return (object) [
            'title'        => $title,
            'subtitle'     => $subtitle,
            'description'  => $description,
            'translations' => [],
        ];
    }

    /** The full layout data array, mirroring the native Posts/Pages components. */
    protected function layoutData(object $page, object $pageTrans): array
    {
        $recentPosts = PublicPost::where('type', 'post')
            ->where('post_status', true)
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($p) {
                $t = $p->translate(app()->getLocale());
                if ($t) {
                    $t->slug           = $p->slug;
                    $t->target         = $p->target;
                    $t->featured_image = $p->featured_image;
                }
                return $t;
            })->take(Sidebar::first()->post_count)->filter()->toArray();

        $popularTools = PublicPost::where('type', 'tool')
            ->where('popular', true)
            ->where('tool_status', true)
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($p) {
                $t = $p->translate(app()->getLocale());
                if ($t) {
                    $t->slug             = $p->slug;
                    $t->target           = $p->target;
                    $t->custom_tool_link = $p->custom_tool_link;
                }
                return $t;
            })->take(Sidebar::first()->tool_count)->filter()->toArray();

        return [
            'page'          => $page,
            'pageTrans'     => $pageTrans,
            'general'       => General::orderBy('id', 'DESC')->first(),
            'profile'       => User::with('user_socials')->where('is_admin', true)->first(),
            'advertisement' => Advertisement::first(),
            'sidebar'       => Sidebar::first(),
            'recent_posts'  => $recentPosts,
            'popular_tools' => $popularTools,
            'siteTitle'     => env('APP_NAME'),
            'menus'         => Menu::with('children')->where(['parent_id' => 'id'])->orderBy('sort', 'ASC')->get()->toArray(),
            'header'        => Header::first(),
            'advanced'      => Advanced::first(),
            'footer'        => FooterTranslation::where('locale', app()->getLocale())->first(),
            'socials'       => Social::orderBy('id', 'ASC')->get()->toArray(),
            'notice'        => Gdpr::first(),
        ];
    }
}
