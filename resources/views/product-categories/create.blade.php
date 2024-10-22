
@include('laravel-crm::layouts.partials.meta')

@include('laravel-crm::styles') 
<form id="productCategoryForm" method="POST" action="{{ url(route('laravel-crm.product-categories.store')) }}" onsubmit="submitFormCrm(event, 'productCategoryForm', '{{ url(route('laravel-crm.product-categories.store')) }}', '¡Se ha guardado correctamente la categoria!', '{{ route('laravel-crm.product-categories.show', $productCategory ?? 1) }}')">
    @csrf
    <div class="card">
        <div class="card-header">
            @include('laravel-crm::layouts.partials.nav-settings')
        </div>
        <div class="card-body">
            <h3 class="mb-3">{{ ucfirst(trans('laravel-crm::lang.create_product_category')) }} <span class="float-right"><a type="button" class="btn btn-outline-secondary btn-sm" href="#" onclick="loadContent('{{ url(route('laravel-crm.product-categories.index')) }}')"><span class="fa fa-angle-double-left"></span> {{ ucfirst(trans('laravel-crm::lang.back_to_product_categories')) }}</a></span></h3>
            @include('laravel-crm::product-categories.partials.fields')
        </div>
        @component('laravel-crm::components.card-footer')
            <a href="#" onclick="loadContent('{{ url(route('laravel-crm.product-categories.index')) }}')" class="btn btn-outline-secondary">{{ ucfirst(trans('laravel-crm::lang.cancel')) }}</a>
            <button type="submit" class="btn btn-primary">{{ ucfirst(trans('laravel-crm::lang.save')) }}</button>
        @endcomponent
    </div>
</form>

@include('laravel-crm::codification') 
