<div id="page-content" class="contact-page-wrap py-2">
  <div class="row g-4 align-items-stretch">
    <!-- Contact Form Column -->
    <div class="col-lg-7">
      <div class="contact-card contact-form-card">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        
        <div class="contact-card-header mb-4">
          <span class="contact-kicker"><i class="fas fa-paper-plane text-emerald me-2"></i>{{ __('Send a Message') }}</span>
          <h2 class="contact-card-title">{{ __('How can we help you?') }}</h2>
          <p class="contact-card-subtitle">{{ __('Fill out the details below. Whether you have feedback, questions about our tools, or found a bug, we read every note.') }}</p>
        </div>

        <!-- Contact Form -->
        <form id="formContact" wire:submit.prevent="sendMessage" class="contact-form-body">
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label" for="contact-name">{{ __('Full Name') }} <span class="text-danger">*</span></label>
              <div class="input-group-modern">
                <span class="input-icon"><i class="far fa-user"></i></span>
                <input id="contact-name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('e.g. John Doe') }}" wire:model.defer="name" type="text" required />
              </div>
            </div>

            <div class="col-md-6">
              <label class="form-label" for="contact-email">{{ __('Email Address') }} <span class="text-danger">*</span></label>
              <div class="input-group-modern">
                <span class="input-icon"><i class="far fa-envelope"></i></span>
                <input id="contact-email" type="email" class="form-control @error('email') is-invalid @enderror" wire:model.defer="email" placeholder="{{ __('e.g. name@company.com') }}" required />
              </div>
            </div>
          </div>

          <div class="form-group mb-4">
            <label class="form-label" for="contact-message">{{ __('Your Message') }} <span class="text-danger">*</span></label>
            <div class="textarea-group-modern">
              <textarea id="contact-message" class="form-control @error('message') is-invalid @enderror" wire:model.defer="message" rows="7" placeholder="{{ __('Tell us what tools you are using, describe any problem or share your suggestions...') }}" required></textarea>
            </div>
          </div>

          @if ( \App\Models\Admin\General::first()->captcha_status )
            <div class="mb-4">
              <x-public.recaptcha />
            </div>
          @endif

          <div class="contact-action-row">
            <button class="btn btn-emerald-action" type="submit" wire:loading.attr="disabled">
              <span wire:loading wire:target="sendMessage" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
              <span wire:loading.remove wire:target="sendMessage"><i class="fas fa-paper-plane me-2"></i></span>
              <span>{{ __('Send Message') }}</span>
              <span class="btn-arrow ms-2">→</span>
            </button>
            <span class="contact-privacy-note text-sm text-subtle">
              <i class="fas fa-shield-alt text-emerald me-1"></i> {{ __('No spam. Your email is never shared.') }}
            </span>
          </div>
        </form>
      </div>
    </div>

    <!-- Contact Direct Channels Column (Matches Home Dashboard Theme) -->
    <div class="col-lg-5">
      <div class="contact-card contact-channels-card">
        <div class="channels-header mb-4">
          <div class="channels-badge">
            <span class="pulse-indicator"></span>
            <span>{{ __('Direct Channels') }}</span>
          </div>
          <h2 class="channels-title">{{ __('Get in Touch') }}</h2>
          <p class="channels-lead">{{ __('Prefer to write directly, report an uptime issue, or suggest a new tool integration? Reach us through any channel below.') }}</p>
        </div>

        <div class="channels-list mb-4">
          <div class="channel-item">
            <div class="channel-icon">
              <i class="fas fa-envelope"></i>
            </div>
            <div class="channel-info">
              <span class="channel-label">{{ __('General Inquiries') }}</span>
              <a href="mailto:contact@fxnseo.com" class="channel-link">contact@fxnseo.com</a>
            </div>
          </div>

          <div class="channel-item">
            <div class="channel-icon">
              <i class="fas fa-headset"></i>
            </div>
            <div class="channel-info">
              <span class="channel-label">{{ __('Technical & Tool Support') }}</span>
              <a href="mailto:support@fxnseo.com" class="channel-link">support@fxnseo.com</a>
            </div>
          </div>

          <div class="channel-item">
            <div class="channel-icon">
              <i class="fas fa-globe"></i>
            </div>
            <div class="channel-info">
              <span class="channel-label">{{ __('Official Platform') }}</span>
              <a href="https://fxnseo.com" class="channel-link">{{ __('fxnseo.com') }}</a>
            </div>
          </div>

          <div class="channel-item">
            <div class="channel-icon">
              <i class="fas fa-clock"></i>
            </div>
            <div class="channel-info">
              <span class="channel-label">{{ __('Typical Response Window') }}</span>
              <span class="channel-text">{{ __('Within 1–2 business days') }}</span>
            </div>
          </div>
        </div>

        <!-- Helpful Quick Links Box inside the card -->
        <div class="channels-help-box">
          <div class="help-box-content">
            <div class="help-box-icon"><i class="fas fa-bolt text-emerald"></i></div>
            <div>
              <div class="help-box-title">{{ __('Looking for instant answers?') }}</div>
              <div class="help-box-desc">{{ __('Browse common workflows and tool guides in our FAQ library.') }}</div>
            </div>
          </div>
          <a href="{{ localization()->getLocalizedURL(app()->getLocale(), '/faqs') }}" class="help-box-link">
            <span>{{ __('Visit Knowledge Hub') }}</span>
            <i class="fas fa-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>