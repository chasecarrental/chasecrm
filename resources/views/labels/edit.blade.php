
@include('laravel-crm::layouts.partials.meta')

@include('laravel-crm::styles') 
<form method="POST" id="labelForm" action="{{ url(route('laravel-crm.labels.update', $label)) }}" 
onsubmit="submitFormCrm(event, 'labelForm', '{{ url(route('laravel-crm.labels.update', $label)) }}', 
'¡Se ha editado correctamente!', '{{ route('laravel-crm.labels.show', $label ?? 1) }}')">
<form method="POST" action="{{ url(route('laravel-crm.labels.update', $label)) }}">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-header">
            @include('laravel-crm::layouts.partials.nav-settings')
        </div>
        <div class="card-body">
            <h3 class="mb-3"> {{ ucfirst(trans('laravel-crm::lang.edit_label')) }} <span class="float-right"><a type="button" class="btn btn-outline-secondary btn-sm" href="#" onclick="loadContent('{{ url(route('laravel-crm.labels.index')) }}')"><span class="fa fa-angle-double-left"></span> {{ ucfirst(trans('laravel-crm::lang.back_to_labels')) }}</a></span></h3>
            @include('laravel-crm::labels.partials.fields')
        </div>
        @component('laravel-crm::components.card-footer')
            <a href="#" onclick="loadContent('{{ url(route('laravel-crm.labels.index')) }}')" class="btn btn-outline-secondary">{{ ucfirst(trans('laravel-crm::lang.cancel')) }}</a>
            <button type="submit" class="btn btn-primary">{{ ucwords(trans('laravel-crm::lang.save_changes')) }}</button>
        @endcomponent
    </div>
</form>

@include('laravel-crm::codification') 
