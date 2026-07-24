<div>
    <form wire:submit.prevent="onUpdateLicense">
        <div class="card">
            <div class="card-body">
                <p>{!! __('A :license is only valid for 1 website. Running multiple websites on a single license is a copyright violation.', ['license' => '<a href="https://codecanyon.net/licenses/standard" target="_blank">single license</a>']) !!}</p>
                <p>{{ __('So in case you only have a single license and want to transfer it from one domain to another. Just reset the license, then you can use it on the new domain.') }}</p>
                
				<div class="alert-message">
				  <!-- Session Status -->
				  <x-auth-session-status class="mb-4" :status="session('status')" />
											  
				  <!-- Validation Errors -->
				  <x-auth-validation-errors class="mb-4" :errors="$errors" />
				</div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                      <tbody>
                        <tr>
                            <td class="align-middle bg-light fw-bold">{{ __('Purchase Code') }}</td>
                            <td class="align-middle">
                                <input type="text" class="form-control" wire:model.defer="purchase_code">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle bg-light fw-bold">{{ __('Domain') }}</td>
                            <td class="align-middle">
                                <input type="text" class="form-control" wire:model="domain" disabled>
                            </td>
                        </tr>
                      </tbody>
                    </table>
                </div>

                <div class="form-group mt-3 text-end mb-0">
                    <button class="btn bg-gradient-primary mb-0" wire:loading.attr="disabled">
                      <span>
                        <div wire:loading.inline wire:target="onUpdateLicense">
                          <x-loading />
                        </div>
                        <span>{{ __('Save Changes') }}</span>
                      </span>
                    </button>

                    <a href="https://envato.themeluxury.com/reset-license/" class="btn bg-gradient-danger mb-0" target="_blank">
                        <i class="fas fa-redo me-1"></i>
                        {{ __('Reset License') }}
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>