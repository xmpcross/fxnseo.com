<?php

namespace App\Support;

use App\Models\Admin\SeoSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\SchemaOrg\Schema;

class PublicStructuredData
{
    /**
     * Build the JSON-LD graph for the current public page.
     *
     * @return array<\Spatie\SchemaOrg\Type>
     */
    public static function build($page = null, $translation = null, $header = null, $category = null): array
    {
        $settings = SeoSetting::current();
        if (! $settings->enabled) {
            return [];
        }

        $siteName = $settings->site_name ?: config('app.name');
        $organizationName = $settings->organization_name ?: $siteName;
        $siteUrl = url('/');
        $currentUrl = url()->current();
        $title = trim((string) data_get($translation, 'page_title'))
            ?: trim((string) data_get($translation, 'title'))
            ?: $siteName;
        $description = trim(strip_tags((string) data_get($translation, 'short_description')))
            ?: trim(strip_tags((string) data_get($translation, 'description')))
            ?: $settings->site_description
            ?: config('meta.description');
        $description = Str::limit(preg_replace('/\s+/', ' ', $description), 300, '');
        $type = (string) data_get($page, 'type');
        $slug = (string) data_get($page, 'slug');
        $image = self::absoluteUrl(
            data_get($translation, 'featured_image')
                ?: data_get($page, 'featured_image')
                ?: $settings->default_image
                ?: config('meta.image')
        );
        $logo = self::absoluteUrl($settings->organization_logo ?: data_get($header, 'logo_light') ?: '/assets/img/logo-light.svg');
        $socialProfiles = collect(preg_split('/\r\n|\r|\n/', (string) $settings->social_profiles))
            ->map(fn ($url) => trim($url))->filter()->values()->all();

        $organization = Schema::organization()
            ->setProperty('@id', $siteUrl . '#organization')
            ->name($organizationName)
            ->url($siteUrl)
            ->logo($logo)
            ->sameAs($socialProfiles);

        $website = Schema::webSite()
            ->setProperty('@id', $siteUrl . '#website')
            ->name($siteName)
            ->url($siteUrl)
            ->description($settings->site_description ?: config('meta.description'))
            ->publisher(['@id' => $siteUrl . '#organization']);

        $schemas = [];
        if ($settings->organization_schema) {
            $schemas[] = $organization;
        }
        if ($settings->website_schema) {
            $schemas[] = $website;
        }

        if ($type === 'post' && $settings->article_schema) {
            $schemas[] = Schema::article()
                ->setProperty('@id', $currentUrl . '#article')
                ->mainEntityOfPage($currentUrl)
                ->headline($title)
                ->description($description)
                ->url($currentUrl)
                ->image($image)
                ->datePublished(self::date(data_get($page, 'created_at')))
                ->dateModified(self::date(data_get($page, 'updated_at')))
                ->author(['@id' => $siteUrl . '#organization'])
                ->publisher(['@id' => $siteUrl . '#organization']);
        } elseif ($type === 'tool' && $settings->software_schema) {
            $schemas[] = Schema::softwareApplication()
                ->setProperty('@id', $currentUrl . '#software')
                ->name($title)
                ->url($currentUrl)
                ->description($description)
                ->image($image)
                ->applicationCategory('BusinessApplication')
                ->operatingSystem('Any modern web browser')
                ->offers(Schema::offer()->price(0)->priceCurrency('USD'));
        } elseif (! in_array($type, ['post', 'tool'], true) && $settings->webpage_schema) {
            $schemas[] = Schema::webPage()
                ->setProperty('@id', $currentUrl . '#webpage')
                ->name($title)
                ->url($currentUrl)
                ->description($description)
                ->isPartOf(['@id' => $siteUrl . '#website']);
        }

        if ($settings->breadcrumb_schema && $slug !== '' && $type !== 'home') {
            $parentName = $type === 'post' ? 'Blog' : ($type === 'tool' ? 'SEO Tools' : null);
            $parentUrl = $type === 'post' ? url('/blog') : ($type === 'tool' ? url('/tools') : null);
            $crumbs = [['name' => 'Home', 'item' => $siteUrl]];
            if ($parentName) {
                $crumbs[] = ['name' => $parentName, 'item' => $parentUrl];
            }
            if ($type === 'post' && data_get($category, 'title')) {
                $crumbs[1]['name'] = data_get($category, 'title');
            }
            $crumbs[] = ['name' => $title, 'item' => $currentUrl];
            $schemas[] = self::breadcrumbs($crumbs);
        }

        $faq = self::extractFaq((string) data_get($translation, 'description'));
        if ($settings->faq_schema && $faq) {
            $schemas[] = Schema::faqPage()->mainEntity($faq);
        }

        return $schemas;
    }

    private static function breadcrumbs(array $crumbs)
    {
        return Schema::breadcrumbList()->itemListElement(
            collect($crumbs)->values()->map(function (array $crumb, int $index) {
                return Schema::listItem()
                    ->position($index + 1)
                    ->name($crumb['name'])
                    ->item($crumb['item']);
            })->all()
        );
    }

    /** @return array<\Spatie\SchemaOrg\Question> */
    private static function extractFaq(string $html): array
    {
        if ($html === '' || ! preg_match('/(?:FAQ|Frequently Asked Questions)/i', strip_tags($html))) {
            return [];
        }

        preg_match_all('#<p[^>]*>\s*<strong[^>]*>(.*?)</strong>(.*?)</p>#is', $html, $matches, PREG_SET_ORDER);

        return collect($matches)->map(function (array $match) {
            $question = trim(html_entity_decode(strip_tags($match[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $answer = trim(html_entity_decode(strip_tags($match[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($question === '' || $answer === '') {
                return null;
            }

            return Schema::question()
                ->name($question)
                ->acceptedAnswer(Schema::answer()->text($answer));
        })->filter()->values()->all();
    }

    private static function absoluteUrl(?string $value): string
    {
        $value = (string) $value;
        return Str::startsWith($value, ['http://', 'https://'])
            ? $value
            : url('/' . ltrim($value, '/'));
    }

    private static function date($value): string
    {
        return $value ? Carbon::parse($value)->toIso8601String() : now()->toIso8601String();
    }
}
