
@include('laravel-crm::layouts.partials.meta')

    @include('laravel-crm::styles') 
    <form id="taxRateForm" method="POST" action="{{ url(route('laravel-crm.tax-rates.store')) }}" onsubmit="submitFormCrm(event, 'taxRateForm', '{{ url(route('laravel-crm.tax-rates.store')) }}', '¡Se ha guardado correctamente!', '{{ route('laravel-crm.tax-rates.show', $taxRate ?? 1) }}')">
        @csrf
        <div class="card">
            <div class="card-header">
                @include('laravel-crm::layouts.partials.nav-settings')
            </div>
            <div class="card-body">
                <h3 class="mb-3">{{ ucfirst(trans('laravel-crm::lang.add_tax_rate')) }} <span class="float-right"><a type="button" class="btn btn-outline-secondary btn-sm" href="#" onclick="loadContent('{{ url(route('laravel-crm.tax-rates.index')) }}')"><span class="fa fa-angle-double-left"></span> {{ ucfirst(trans('laravel-crm::lang.back_to_tax_rates')) }}</a></span></h3>
                @include('laravel-crm::tax-rates.partials.fields')
            </div>
            @component('laravel-crm::components.card-footer')
                <a href="#" onclick="loadContent('{{ url(route('laravel-crm.tax-rates.index')) }}')" class="btn btn-outline-secondary">{{ ucfirst(trans('laravel-crm::lang.cancel')) }}</a>
                <button type="submit" class="btn btn-primary">{{ ucfirst(trans('laravel-crm::lang.save')) }}</button>
            @endcomponent
        </div>
    </form>

    @include('laravel-crm::codification') 
