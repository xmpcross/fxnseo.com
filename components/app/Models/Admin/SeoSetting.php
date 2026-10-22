<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'enabled' => 'boolean',
        'organization_schema' => 'boolean',
        'website_schema' => 'boolean',
        'webpage_schema' => 'boolean',
        'article_schema' => 'boolean',
        'software_schema' => 'boolean',
        'breadcrumb_schema' => 'boolean',
        'faq_schema' => 'boolean',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], static::defaults());
    }

    public static function defaults(): array
    {
        return [
            'enabled' => true,
            'site_name' => config('app.name'),
            'site_description' => config('meta.description'),
            'organization_name' => config('app.name'),
            'organization_logo' => '/assets/img/logo-light.svg',
            'default_image' => config('meta.image'),
            'author_name' => config('meta.author'),
            'twitter_site' => config('meta.twitter_site'),
            'social_profiles' => "https://www.facebook.com/fxnseo/\nhttps://x.com/fxnseo",
            'organization_schema' => true,
            'website_schema' => true,
            'webpage_schema' => true,
            'article_schema' => true,
            'software_schema' => true,
            'breadcrumb_schema' => true,
            'faq_schema' => true,
        ];
    }
}
