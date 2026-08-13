<div>
    <form wire:submit.prevent="save">
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="card mb-3">
            <div class="card-header bg-gradient-info d-flex align-items-center justify-content-between">
                <h6 class="text-white mb-0">{{ __('SEO Settings') }}</h6>
                <div class="form-check form-switch mb-0">
                    <input id="seo-enabled" class="form-check-input" type="checkbox" wire:model.defer="enabled">
                    <label class="form-check-label text-white" for="seo-enabled">{{ __('Enable structured data') }}</label>
                </div>
            </div>
            <div class="card-body">
                <p class="text-muted text-sm">{{ __('Global defaults are used when a page has no specific SEO value. Page and post metadata takes priority.') }}</p>
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label class="form-label" for="seo-site-name">{{ __('Site name') }}</label>
                        <input id="seo-site-name" class="form-control" type="text" wire:model.defer="site_name">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="form-label" for="seo-author">{{ __('Default author') }}</label>
                        <input id="seo-author" class="form-control" type="text" wire:model.defer="author_name">
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label" for="seo-description">{{ __('Default description') }}</label>
                        <textarea id="seo-description" class="form-control" rows="3" maxlength="320" wire:model.defer="site_description"></textarea>
                        <small class="form-hint">{{ __('Recommended: 150–160 characters.') }}</small>
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="form-label" for="seo-image">{{ __('Default sharing image URL') }}</label>
                        <input id="seo-image" class="form-control" type="text" wire:model.defer="default_image">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="form-label" for="seo-twitter">{{ __('X / Twitter username') }}</label>
                        <input id="seo-twitter" class="form-control" type="text" placeholder="@fxnseo" wire:model.defer="twitter_site">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-gradient-info"><h6 class="text-white mb-0">{{ __('Organization') }}</h6></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label class="form-label" for="seo-org-name">{{ __('Organization name') }}</label>
                        <input id="seo-org-name" class="form-control" type="text" wire:model.defer="organization_name">
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label class="form-label" for="seo-org-logo">{{ __('Organization logo URL') }}</label>
                        <input id="seo-org-logo" class="form-control" type="text" wire:model.defer="organization_logo">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="seo-socials">{{ __('Official social profiles') }}</label>
                        <textarea id="seo-socials" class="form-control" rows="5" wire:model.defer="social_profiles"></textarea>
                        <small class="form-hint">{{ __('Enter one complete profile URL per line for Organization sameAs data.') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header bg-gradient-info"><h6 class="text-white mb-0">{{ __('Automatic schema types') }}</h6></div>
            <div class="card-body"><div class="row">
                @foreach (['organization_schema' => __('Organization'), 'website_schema' => __('WebSite'), 'webpage_schema' => __('WebPage'), 'article_schema' => __('Article for blog posts'), 'software_schema' => __('SoftwareApplication for tools'), 'breadcrumb_schema' => __('Breadcrumbs'), 'faq_schema' => __('FAQ when questions are detected')] as $field => $label)
                    <div class="col-md-6 col-xl-4 mb-3"><div class="border rounded p-3 h-100">
                        <div class="form-check form-switch mb-0">
                            <input id="{{ $field }}" class="form-check-input" type="checkbox" wire:model.defer="{{ $field }}">
                            <label class="form-check-label fw-bold" for="{{ $field }}">{{ $label }}</label>
                        </div>
                    </div></div>
                @endforeach
            </div></div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-outline-secondary mb-0" type="button" wire:click="restoreDefaults" wire:loading.attr="disabled">{{ __('Restore defaults') }}</button>
            <button class="btn bg-gradient-primary mb-0" type="submit" wire:loading.attr="disabled">
                <span wire:loading.inline wire:target="save"><x-loading /></span> {{ __('Save SEO Settings') }}
            </button>
        </div>
    </form>
</div>
