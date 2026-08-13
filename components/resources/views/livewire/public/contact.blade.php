<div id="page-content" class="py-3">
  <div class="row g-4">
    <div class="col-lg-7">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    
    <!-- Contact Form -->
    <form id="formContact" wire:submit.prevent="sendMessage">
        <div class="pb-2">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">{{ __('Full name') }} *</label>
                    <div class="input-group mb-3">
                        <input class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Enter your name') }}" wire:model.defer="name" type="text" required />
                    </div>
                </div>

                <div class="col-md-6 ps-md-2">
                    <label class="form-label">{{ __('Email') }} *</label>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.defer="email" placeholder="{{ __('Enter your email') }}" required />
                    </div>
                </div>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">{{ __('Message') }} *</label>
                <textarea class="form-control @error('message') is-invalid @enderror" wire:model.defer="message" rows="10" placeholder="{{ __('Describe your problem here!') }}" required></textarea>
            </div>

            @if ( \App\Models\Admin\General::first()->captcha_status )
              <x-public.recaptcha />
            @endif

            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="form-group mb-0">
                        <button class="btn bg-gradient-primary mb-0">
                            <span>
                                <div wire:loading wire:target="sendMessage">
                                    <x-loading />
                                </div>
                                <span>{{ __('Send Message') }}</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>

    <div class="col-lg-5">
      <div class="contact-methods">
        <h3 class="h5 fw-bold mb-2">{{ __('Get in touch') }}</h3>
        <p class="text-sm text-secondary mb-4">{{ __('Have a question, a suggestion, or found an issue? Reach out — we are here to help.') }}</p>

        <div class="contact-method d-flex align-items-start mb-3">
          <div class="contact-method-icon"><i class="fas fa-envelope"></i></div>
          <div>
            <div class="fw-bold">{{ __('Email') }}</div>
            <a href="mailto:contact@fxnseo.com">contact@fxnseo.com</a>
          </div>
        </div>

        <div class="contact-method d-flex align-items-start mb-3">
          <div class="contact-method-icon"><i class="fas fa-headset"></i></div>
          <div>
            <div class="fw-bold">{{ __('Support') }}</div>
            <a href="mailto:support@fxnseo.com">support@fxnseo.com</a>
          </div>
        </div>

        <div class="contact-method d-flex align-items-start mb-3">
          <div class="contact-method-icon"><i class="fas fa-globe"></i></div>
          <div>
            <div class="fw-bold">{{ __('Website') }}</div>
            <a href="https://fxnseo.com">fxnseo.com</a>
          </div>
        </div>

        <div class="contact-method d-flex align-items-start">
          <div class="contact-method-icon"><i class="fas fa-clock"></i></div>
          <div>
            <div class="fw-bold">{{ __('Response time') }}</div>
            <span class="text-sm text-secondary">{{ __('Within 1-2 business days') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>