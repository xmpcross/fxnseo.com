<?php

namespace App\Http\Livewire\Public;

use Livewire\Component;
use App\Models\Admin\Page as PublicPage;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

use App\Models\Admin\General;
use App\Models\Admin\Social;
use App\Models\Admin\User;
use App\Models\Admin\Menu;
use App\Models\Admin\Header;
use App\Models\Admin\Footer;
use App\Models\Admin\Gdpr;
use App\Models\Admin\Advanced;
use App\Models\Admin\Advertisement;
use App\Models\Admin\FooterTranslation;
use App\Models\Admin\Redirect;
use App\Models\Admin\Sidebar;
use App\Models\Admin\PageCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Pages extends Component
{
    public $slug;
    public $type;

    public function mount($slug)
    {
        try {

            $this->slug = $slug;
  
            $redirectUrl = Redirect::where('old_slug', $this->slug)->first();

            if ($redirectUrl && $redirectUrl->new_slug) {
                return redirect()->to($redirectUrl->new_slug);
            }

            abort(404);

        } catch (\Exception $e) {}

    }
    
    public function render()
    {

        try {

            $page          = PublicPage::where('slug', $this->slug)->where('type', '<>', 'post')->firstOrFail();
            $general       = General::first();
   
            switch ( $page->type ) {

                case 'tool':
                        $pageTrans = PublicPage::withTranslation()->translatedIn( app()->getLocale() )->whereTranslation('page_id', $page->id)->where('tool_status', true)->firstOrFail();
                    break;

                default:
                        $pageTrans = PublicPage::withTranslation()->translatedIn( app()->getLocale() )->whereTranslation('page_id', $page->id)->where('page_status', true)->firstOrFail();
                    break;
            }

            $url = route('home') . '/' . $this->slug;
            $image = $pageTrans->featured_image;
            $name = config('app.name');

            switch ($general->maintenance_mode) {
                case true:
                        $title       = __('This site is undergoing maintenance!');
                        $description = __('Site is currently under maintenance. We are working hard to give you the best experience and will be back shortly.');
                    break;
                
                default:
                        $title       = $pageTrans->page_title;
                        $description = $pageTrans->short_description;
                    break;
            }
    
            //Meta
            $siteName = $pageTrans->sitename_status ? ' ' . env('APP_SEPARATOR') . ' ' . env('APP_NAME') : '';
            SEOMeta::setTitle($title . $siteName);
            SEOMeta::setDescription($description);
            SEOMeta::setCanonical($url);

            if ( $pageTrans->robots_meta ) {
                SEOMeta::addMeta('robots', 'follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large', 'name');
            }
            else SEOMeta::addMeta('robots', 'noindex, follow', 'name');

            //Facebook
            OpenGraph::addProperty('type', 'article')
                                    ->addProperty('locale', localization()->getCurrentLocaleRegional() )
                                    ->addImage($image)
                                    ->setTitle($title)
                                    ->setDescription($description)
                                    ->setUrl($url)
                                    ->setSiteName($name);

            //Twitter
            TwitterCard::setType('summary_large_image')
                                ->setImage($image)
                                ->setTitle($title)
                                ->setDescription($description)
                                ->setUrl($url);

            $advanced = Advanced::first();

            $recent_posts = PublicPage::where('type', 'post')
                                ->where('post_status', true)
                                ->orderBy('id', 'DESC')
                                ->get()
                                ->map(function ($page) {
                                    $translatedPage = $page->translate( app()->getLocale() );
                                    if ($translatedPage) {
                                        $translatedPage->slug           = $page->slug;
                                        $translatedPage->target         = $page->target;
                                        $translatedPage->featured_image = $page->featured_image;
                                    }
                                    return $translatedPage;
                                })->take( Sidebar::first()->post_count )->filter()->toArray();

            $popular_tools = PublicPage::where('type', 'tool')
                                ->where('popular', true)
                                ->where('tool_status', true)
                                ->orderBy('id', 'DESC')
                                ->get()
                                ->map(function ($page) {
                                    $translatedPage = $page->translate( app()->getLocale() );
                                    if ($translatedPage) {
                                        $translatedPage->slug             = $page->slug;
                                        $translatedPage->target           = $page->target;
                                        $translatedPage->custom_tool_link = $page->custom_tool_link;
                                    }
                                    return $translatedPage;
                                })->take( Sidebar::first()->tool_count )->filter()->toArray();

            $related_tools = PublicPage::where('type', 'tool')
                                ->where('tool_status', true)
                                ->where('category_id', $page->category_id)
                                ->where('id', '!=', $page->id)
                                ->inRandomOrder()
                                ->get()
                                ->map(function ($page) {
                                    $translatedPage = $page->translate( app()->getLocale() );
                                    if ($translatedPage) {
                                        $translatedPage->slug             = $page->slug;
                                        $translatedPage->new              = $page->new;
                                        $translatedPage->target           = $page->target;
                                        $translatedPage->icon_image       = $page->icon_image;
                                        $translatedPage->custom_tool_link = $page->custom_tool_link;
                                        return $translatedPage;
                                    }
                                    return null;
                                })->filter()->take( General::first()->related_tools_count )->toArray();

            $pillarKeywords = [
                'backlink-monitoring-guide' => ['backlink', 'monitor', 'lost link', 'referring domain', 'link tracking'],
                'link-opportunity-guide' => ['link building', 'link opportunity', 'prospect', 'outreach', 'backlink'],
                'seo-audit-guide' => ['seo audit', 'report', 'technical seo', 'backlink', 'website'],
            ];
            $relatedPillarPosts = [];
            if (isset($pillarKeywords[$page->slug])) {
                $keywords = $pillarKeywords[$page->slug];
                $relatedPillarPosts = PublicPage::where('type', 'post')
                    ->where('post_status', true)
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->map(function ($post) use ($keywords) {
                        $translation = $post->translate(app()->getLocale());
                        if (!$translation) {
                            return null;
                        }

                        $haystack = mb_strtolower(implode(' ', [
                            $post->slug,
                            $translation->title,
                            $translation->short_description,
                            strip_tags($translation->description),
                        ]));
                        $score = collect($keywords)->sum(function ($keyword) use ($haystack) {
                            return substr_count($haystack, mb_strtolower($keyword));
                        });
                        $category = $post->category_id ? PageCategory::find($post->category_id) : null;

                        return [
                            'slug' => $post->slug,
                            'title' => $translation->title,
                            'short_description' => $translation->short_description,
                            'featured_image' => $post->featured_image,
                            'published_at' => $post->created_at,
                            'category' => $category->title ?? __('Blog'),
                            'score' => $score,
                            'id' => $post->id,
                        ];
                    })
                    ->filter(function ($post) { return $post && $post['score'] > 0; })
                    ->sort(function ($left, $right) {
                        return [$right['score'], $right['id']] <=> [$left['score'], $left['id']];
                    })
                    ->take(4)
                    ->values()
                    ->toArray();
            }

        return view('livewire.public.pages', [
            'page'          => $page,
            'general'       => $general,
            'pageTrans'     => $pageTrans,
            'related_tools' => $related_tools
        ])->layout('layouts.public', [
            'page'          => $page,
            'pageTrans'     => $pageTrans,
            'general'       => $general,
            'profile'       => User::with('user_socials')->where('is_admin', true)->first(),
            'advertisement' => Advertisement::first(),
            'sidebar'       => Sidebar::first(),
            'recent_posts'  => $recent_posts,
            'popular_tools' => $popular_tools,
            'related_pillar_posts' => $relatedPillarPosts,
            'siteTitle'     => env('APP_NAME'),
            'menus'         => Menu::with('children')->where(['parent_id' => 'id'])->orderBy('sort','ASC')->get()->toArray(),
            'header'        => Header::first(),
            'advanced'      => $advanced,
            'footer'        => FooterTranslation::where('locale', app()->getLocale())->first(),
            'socials'       => Social::orderBy('id', 'ASC')->get()->toArray(),
            'notice'        => Gdpr::first()
        ]);

        } catch (ModelNotFoundException $e) {

            abort(404);

        } catch (\Exception $e) {
            
            if ( $e->getMessage() == null) {
                abort(404);
            }
            return view('livewire.public.install.welcome')->layout('layouts.install');
        }

    }


}
