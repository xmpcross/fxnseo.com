<?php

namespace App\Http\Livewire\Public;

use Livewire\Component;
use App\Models\Admin\Page as PublicPage;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

use App\Models\Admin\General;
use App\Models\Admin\Social;
use App\Models\Admin\Menu;
use App\Models\Admin\Header;
use App\Models\Admin\Footer;
use App\Models\Admin\Gdpr;
use App\Models\Admin\Advanced;
use App\Models\Admin\Advertisement;
use App\Models\Admin\FooterTranslation;
use Livewire\WithPagination;

class Blog extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $topic = '';
    public $sort = 'newest';
    protected $queryString = [
        'search' => ['except' => ''],
        'topic' => ['except' => ''],
        'sort' => ['except' => 'newest'],
    ];

    public function updatedSearch() { $this->resetPage(); }
    public function updatedTopic() { $this->resetPage(); }
    public function updatedSort() { $this->resetPage(); }

    public function clearFilters()
    {
        $this->search = '';
        $this->topic = '';
        $this->resetPage();
    }

    public static function topicFor($slug)
    {
        if (strpos($slug, 'youtube') !== false) return 'YouTube';
        if (strpos($slug, 'backlink') !== false || strpos($slug, 'link-building') !== false) return 'Backlinks';
        return 'Technical SEO';
    }
    
    public function render()
    {
        $query = PublicPage::with('translations')->translatedIn(app()->getLocale())
            ->where('type', 'post')->where('post_status', true);
        $totalArticles = (clone $query)->count();
        $featuredPost = (clone $query)->orderByDesc('id')->first();
        $search = trim(mb_substr((string) $this->search, 0, 150));
        if ($search !== '') {
            $query->whereHas('translations', function ($translation) use ($search) {
                $translation->where('locale', app()->getLocale())->where(function ($text) use ($search) {
                    $text->where('title', 'like', '%' . $search . '%')
                        ->orWhere('short_description', 'like', '%' . $search . '%');
                });
            });
        }
        if ($this->topic === 'youtube') {
            $query->where('slug', 'like', '%youtube%');
        } elseif ($this->topic === 'backlinks') {
            $query->where(function ($q) {
                $q->where('slug', 'like', '%backlink%')->orWhere('slug', 'like', '%link-building%');
            });
        } elseif ($this->topic === 'technical') {
            $query->where('slug', 'not like', '%youtube%')->where('slug', 'not like', '%backlink%')
                ->where('slug', 'not like', '%link-building%');
        }
        $pageTrans = $query->orderBy('id', $this->sort === 'oldest' ? 'ASC' : 'DESC')->paginate(9);
        $pageTrans->withPath(route('blog'))->appends(array_filter([
            'search' => $this->search, 'topic' => $this->topic,
            'sort' => $this->sort === 'newest' ? null : $this->sort,
        ], function ($value) { return $value !== null && $value !== ''; }));

        $page          = PublicPage::where('type', 'home')->first();
        $general       = General::orderBy('id', 'DESC')->first();

        if ( !empty($pageTrans) ) {

                $url         = route('blog') . ($pageTrans->currentPage() > 1 ? '?page=' . $pageTrans->currentPage() : '');
                $image       = $page->featured_image;
                $name        = config('app.name');

                switch ($general->maintenance_mode) {
                    case true:
                            $title       = __('This site is undergoing maintenance!');
                            $description = __('Site is currently under maintenance. We are working hard to give you the best experience and will be back shortly.');
                        break;
                    
                    default:
                            $title       = __('SEO Insights & Guides');
                            $description = __('Actionable SEO tips, tool tutorials, and how-to guides to help you improve your rankings and grow your organic traffic.');
                        break;
                }

                //Meta
                $siteName = ' ' . env('APP_SEPARATOR') . ' ' . env('APP_NAME');
                SEOMeta::setTitle($title . $siteName);
                SEOMeta::setDescription($description);
                SEOMeta::setCanonical($url);
                SEOMeta::addMeta('robots', 'follow, index, max-snippet:-1, max-video-preview:-1, max-image-preview:large', 'name');
                
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

            return view('livewire.public.blog', [
                'page'      => $page,
                'general'   => $general,
                'pageTrans' => $pageTrans,
                'featuredPost' => $featuredPost,
                'totalArticles' => $totalArticles
            ])->layout('layouts.blog', [
                'blogPageNumber' => $pageTrans->currentPage(),
                'blogSearch' => $this->search,
                'blogTopic' => $this->topic,
                'blogSort' => $this->sort,
                'page'          => $page,
                'pageTrans'     => $pageTrans,
                'general'       => $general,
                'advertisement' => Advertisement::orderBy('id', 'DESC')->first(),
                'siteTitle'     => env('APP_NAME'),
                'menus'         => Menu::with('children')->where(['parent_id' => 'id'])->orderBy('sort','ASC')->get()->toArray(),
                'header'        => Header::orderBy('id', 'DESC')->first(),
                'advanced'      => Advanced::orderBy('id', 'DESC')->first(),
                'footer'        => FooterTranslation::where('locale', app()->getLocale())->first(),
                'socials'       => Social::orderBy('id', 'ASC')->get()->toArray(),
                'notice'        => Gdpr::orderBy('id', 'DESC')->first()
            ]);
        
        } else abort(404);
    }

}
