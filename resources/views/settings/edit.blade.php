
@include('laravel-crm::layouts.partials.meta')

    @include('laravel-crm::styles') 
 
    <form id="settingForm" method="POST" action="{{ url(route('laravel-crm.settings.update')) }}" onsubmit="submitFormCrm(event, 'settingForm', '{{ url(route('laravel-crm.settings.update')) }}', '¡Se ha guardado correctamente!', '{{ route('laravel-crm.settings.edit', $setting ?? 1) }}')">
        @csrf
        <div class="card">
            <div class="card-header">
                @include('laravel-crm::layouts.partials.nav-settings')
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="settings" role="tabpanel">
                        @include('laravel-crm::settings.partials.fields')
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">{{ ucwords(trans('laravel-crm::lang.save_changes')) }}</button>
            </div>
        </div>
    </form>

    @include('laravel-crm::codification') 
