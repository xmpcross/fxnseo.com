<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Admin\SeoSetting;
use Artesaos\SEOTools\Facades\SEOMeta;
use Livewire\Component;

class Seo extends Component
{
    public $enabled, $site_name, $site_description, $organization_name, $organization_logo;
    public $default_image, $author_name, $twitter_site, $social_profiles;
    public $organization_schema, $website_schema, $webpage_schema, $article_schema;
    public $software_schema, $breadcrumb_schema, $faq_schema;

    public function mount()
    {
        $this->fill(SeoSetting::current()->only(array_keys($this->rules())));
    }

    protected function rules(): array
    {
        return [
            'enabled' => 'boolean',
            'site_name' => 'required|string|max:120',
            'site_description' => 'required|string|max:320',
            'organization_name' => 'required|string|max:120',
            'organization_logo' => 'required|string|max:2048',
            'default_image' => 'required|string|max:2048',
            'author_name' => 'nullable|string|max:120',
            'twitter_site' => ['nullable', 'string', 'max:50', 'regex:/^@?[A-Za-z0-9_]+$/'],
            'social_profiles' => 'nullable|string|max:5000',
            'organization_schema' => 'boolean',
            'website_schema' => 'boolean',
            'webpage_schema' => 'boolean',
            'article_schema' => 'boolean',
            'software_schema' => 'boolean',
            'breadcrumb_schema' => 'boolean',
            'faq_schema' => 'boolean',
        ];
    }

    public function save()
    {
        $data = $this->validate();
        $urls = collect(preg_split('/\r\n|\r|\n/', (string) $data['social_profiles']))
            ->map(fn ($url) => trim($url))->filter();

        foreach ($urls as $url) {
            if (! filter_var($url, FILTER_VALIDATE_URL) || ! in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true)) {
                $this->addError('social_profiles', __('Every social profile must be a complete http or https URL, one per line.'));
                return;
            }
        }

        $data['social_profiles'] = $urls->unique()->implode("\n");
        $data['twitter_site'] = $data['twitter_site'] ? '@' . ltrim($data['twitter_site'], '@') : null;
        SeoSetting::current()->update($data);
        $this->fill($data);

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('SEO settings updated successfully!')]);
    }

    public function restoreDefaults()
    {
        $settings = SeoSetting::current();
        $settings->update(SeoSetting::defaults());
        $this->fill($settings->fresh()->only(array_keys($this->rules())));
        $this->resetValidation();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => __('SEO defaults restored successfully!')]);
    }

    public function render()
    {
        SEOMeta::setTitle(__('SEO Settings') . ' ' . env('APP_SEPARATOR') . ' ' . env('APP_NAME'));

        return view('livewire.admin.settings.seo')->layout('layouts.admin', [
            'breadcrumbs' => [
                ['title' => __('Admin'), 'url' => route('admin.dashboard.index')],
                ['title' => __('SEO Settings'), 'url' => null],
            ],
        ]);
    }
}
