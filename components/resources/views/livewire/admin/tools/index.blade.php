<div>

		<button class="btn bg-gradient-primary mb-0" data-bs-toggle="modal" data-bs-target="#addNewTool"><i class="fas fa-plus me-1 me-1"></i> {{ __('Add New Custom Tool Link') }}</button>

        <form wire:submit.prevent="onImportTools" class="d-inline-block">
            <div class="form-group">
                <button class="btn bg-gradient-success mb-0">
                    <span>
                          <i wire:loading.remove wire:target="onImportTools" class="fas fa-file-import me-1"></i>
                          <i wire:loading wire:target="onImportTools" class="spinner-border spinner-border-sm me-1"></i>
                      	  <span>{{ __('Import new Tools') }}</span>
                    </span>
                </button>
            </div>
        </form>

        <button class="btn bg-gradient-info mb-0" data-bs-toggle="modal" data-bs-target="#importAddonPackages"><i class="fas fa-sync me-1 me-1"></i> {{ __('Import Addon Packages') }}</button>

		<div class="card my-4">
			<div class="card-header pb-0">
				<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
					<div>
						<h5 class="mb-1">{{ __('Laravel SEO Packages') }}</h5>
						<p class="text-sm text-muted mb-0">{{ __('Installed SEO packages use separate responsibilities to prevent duplicate metadata: Meta Manager handles standard and social tags, SEOTools handles WebSite JSON-LD, and Laravel-SEO handles Organization and application schema.') }}</p>
					</div>
					<span class="badge bg-gradient-success align-self-start align-self-md-center">{{ collect($seo_packages)->where('installed', true)->count() }}/{{ count($seo_packages) }} {{ __('installed') }}</span>
				</div>
			</div>
			<div class="card-body">
				<div class="row g-3">
					@foreach ($seo_packages as $package)
						<div class="col-12 col-lg-4">
							<div class="border rounded p-3 h-100">
								<div class="d-flex align-items-start justify-content-between gap-3 mb-2">
									<div class="d-flex align-items-center gap-2">
										<span class="d-inline-flex align-items-center justify-content-center bg-light text-primary rounded" style="width: 2.5rem; height: 2.5rem;"><i class="fas fa-search"></i></span>
										<div>
											<h6 class="mb-0">{{ $package['name'] }}</h6>
											<code class="text-xs">{{ $package['package'] }}</code>
										</div>
									</div>
									<span class="badge bg-{{ $package['installed'] ? 'success' : ($package['compatible'] ? 'secondary' : 'warning') }}">{{ $package['installed'] ? __('Installed') : ($package['compatible'] ? __('Not installed') : __('Incompatible')) }}</span>
								</div>
								<p class="text-sm mb-3">{{ $package['description'] }}</p>
								<div class="d-flex align-items-center justify-content-between">
									<span class="text-xs text-muted">{{ $package['version'] ?: __('Unavailable') }}</span>
									<div class="d-flex align-items-center gap-2">
										@if ($package['active'])
											<span class="badge bg-gradient-primary">{{ __('Active') }}</span>
										@elseif ($package['compatible'] && $package['installed'])
											<span class="badge bg-light text-dark">{{ __('Standby') }}</span>
										@else
											<span class="badge bg-light text-dark">{{ __('Framework upgrade required') }}</span>
										@endif
										<a href="{{ $package['url'] }}" target="_blank" rel="noopener noreferrer" class="text-sm" title="{{ __('Package documentation') }}"><i class="fas fa-external-link-alt"></i></a>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>

		<!-- begin:Form Search -->
		<form id="formSearchTool">
			<div class="input-group mb-3">
				<input type="text" class="form-control" wire:model="searchQuery" placeholder="{{ __('Search with title...') }}">
			</div>
		</form>
		<!-- end:Form Search -->

		<div class="card">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Tool Name') }}</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Tool Slug') }}</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Category') }}</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Default Language') }}</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Translation Progress') }}</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Status') }}</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('ADS') }}</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('New') }}</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Popular') }}</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Position') }}</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Latest updates') }}</th>
							<th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@if ( $tools->isNotEmpty() )

							@foreach ($tools as $tool)
								<tr>
									<td class="align-middle">{{ ( empty( $tool->custom_tool_link ) ) ? $tool->tool_name : __('Custom Link'); }}</td>
									<td class="align-middle">
										<div class="d-flex px-2 py-1">
											<div class="d-flex align-items-center">{{ ( empty( $tool->custom_tool_link ) ) ? $tool->slug : $tool->custom_tool_link; }}</div>
										</div>
									</td>
									<td class="align-middle">
										@if ( !empty($tool->category_id) )
											<span>{{ \App\Models\Admin\PageCategory::where('id', $tool->category_id)->first()->title ?? '' }}</span>
										@endif
									</td>
									<td class="align-middle">
										<img src="{{ asset('assets/img/flags/' . $default_lang . '.svg') }}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="{{ \App\Models\Admin\Languages::where('code', $default_lang)->first()->name }}" data-bs-original-title="{{ \App\Models\Admin\Languages::where('code', $default_lang)->first()->name }}" title="{{ \App\Models\Admin\Languages::where('code', $default_lang)->first()->name }}" alt="{{ \App\Models\Admin\Languages::where('code', $default_lang)->first()->name }}" class="lang-image mx-auto"> 
									</td>
                                    <td class="align-middle">
                                        @if (count( $tool->translations ) == $total_lang)
                                            <span class="badge bg-success">{{ count( $tool->translations ) }}/{{ $total_lang }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ count( $tool->translations ) }}/{{ $total_lang }}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge bg-{{ ($tool->tool_status) ? 'success' : 'secondary' }}">{{ ($tool->tool_status) ? __('Enabled') : __('Disabled') }}</span>
                                    </td>
									<td class="align-middle">
										<div class="form-check form-switch mb-0">
											<input class="form-check-input" type="checkbox" wire:click="onAds({{ $tool->id }}, {{ $tool->ads_status ? 'true' : 'false' }})" {{ $tool->ads_status ? 'checked' : '' }}>
										</div>
									</td>
									<td class="align-middle">
										<div class="form-check form-switch mb-0">
											<input class="form-check-input" type="checkbox" wire:click="onNewTool({{ $tool->id }}, {{ $tool->new ? 'true' : 'false' }})" {{ $tool->new ? 'checked' : '' }}>
										</div>
									</td>
									<td class="align-middle">
										<div class="form-check form-switch mb-0">
											<input class="form-check-input" type="checkbox" wire:click="onPopularTool({{ $tool->id }}, {{ $tool->popular ? 'true' : 'false' }})" {{ $tool->popular ? 'checked' : '' }}>
										</div>
									</td>
									<td class="align-middle">
										<span class="badge bg-gradient-secondary">{{ $tool->position }}</span>
									</td>
									<td class="align-middle">
										<span>{{ $tool->updated_at }}</span>
									</td>
									<td class="align-middle">

										<div class="btn-group w-100">
											<a href="{{ route('admin.tools.translations.index', $tool->id ) }}" class="btn bg-gradient-primary mb-0" title="{{ __('Translations') }}"><i class="fas fa-language icon"></i> {{ __('Translations') }}</a>
	                                        <a wire:click="onEnableTool( {{ $tool->id }} )" class="btn bg-gradient-success mb-0" title="{{ __('Enable') }}">
	                                            <i class="fas fa-check icon"></i>
	                                            {{ __('Enable') }}
	                                        </a>

	                                        <a wire:click="onDisableTool( {{ $tool->id }} )" class="btn bg-gradient-warning mb-0" title="{{ __('Disable') }}">
	                                            <i class="fas fa-ban icon"></i>
	                                            {{ __('Disable') }}
	                                        </a>
											<a wire:click="onShowEditToolModal( {{ $tool->id }} )" class="btn bg-gradient-info mb-0" title="{{ __('Edit') }}"><i class="fas fa-edit icon"></i> {{ __('Edit') }}</a>
											<a wire:click="onDeleteConfirmTool( {{ $tool->id }} )" class="btn bg-gradient-danger mb-0" title="{{ __('Delete') }}"><i class="fas fa-trash icon"></i> {{ __('Delete') }}</a>
										</div>

									</td>
								</tr>

							@endforeach

						@else

							<tr>
								<td colspan="11">{{ __('No record found') }}</td>
							</tr>

						@endif

					</tbody>
				</table>
			</div>
			
			@if( $tools->hasPages() )
				<div class="mx-auto mt-3">
					<!-- begin:pagination -->
					{{ $tools->links() }}
					<!-- begin:pagination -->
				</div>
			@endif
		</div>

	    <!-- Begin::Add New Tool -->
	    <div class="modal fade" id="addNewTool" tabindex="-1" role="dialog" aria-labelledby="addNewToolLabel" aria-hidden="true">
	      <div class="modal-dialog modal-dialog-centered">
	        <div class="modal-content">
	          <div class="modal-header">
	            <h6 class="modal-title" id="addNewToolModalLabel">{{ __('Add New Custom Tool Link') }}</h6>
	            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div>

	          @livewire('admin.tools.create')

	        </div>
	      </div>
	    </div>
	    <!-- End::Add New Tool -->

	    <!-- Begin::Import Addon Packages -->
	    <div class="modal fade" id="importAddonPackages" tabindex="-1" role="dialog" aria-labelledby="importAddonPackagesLabel" aria-hidden="true">
	      <div class="modal-dialog modal-dialog-centered">
	        <div class="modal-content">
	          <div class="modal-header">
	            <h6 class="modal-title" id="importAddonPackagesModalLabel">{{ __('Import Addon Packages') }}</h6>
	            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div>

	          @livewire('admin.tools.addons')

	        </div>
	      </div>
	    </div>
	    <!-- End::Import Addon Packages -->

	    <!-- Begin::Edit Tool -->
	    <div class="modal fade" id="editTool" tabindex="-1" role="dialog" aria-labelledby="editToolLabel" aria-hidden="true">
	      <div class="modal-dialog modal-dialog-centered">
	        <div class="modal-content">
	          <div class="modal-header">
	            <h6 class="modal-title" id="editToolModalLabel">{{ __('Edit Tool') }}</h6>
	            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div>

	          @livewire('admin.tools.edit')
	          
	        </div>
	      </div>
	    </div>
	    <!-- End::Edit Tool -->

		<script src="{{ asset('components/public/vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
		<script>
		(function( $ ) {
			"use strict";

			document.addEventListener('livewire:load', function () {

				window.addEventListener('swal:modal', event => {

					const swalWithBootstrapButtons = Swal.mixin({
					  customClass: {
					    confirmButton: 'btn bg-gradient-success',
					    cancelButton: 'btn bg-gradient-danger'
					  },
					  buttonsStyling: false
					})

					swalWithBootstrapButtons.fire({
					  title: event.detail.title,
					  text: event.detail.text,
					  icon: event.detail.type,
					  showCancelButton: true,
					  confirmButtonText: "{{ __('Yes, delete it!') }}",
					  cancelButtonText: "{{ __('Cancel') }}"
					}).then((result) => {
					  if (result.isConfirmed) {
					    window.livewire.emit('onDeleteTool', event.detail.id)
					  }
					});
			
				});

			});

		})( jQuery );
		</script>

</div>
