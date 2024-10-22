<form id="productForm" method="POST" action="{{ url(route('laravel-crm.products.store')) }}" onsubmit="submitFormCrm(event, 'productForm', '{{ url(route('laravel-crm.products.store')) }}', '¡Se ha guardado correctamente el producto!', '{{ route('laravel-crm.products.show', $product ?? 1) }}')">
    @csrf
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.create_product')) }}
            @endslot

            @slot('actions')
                @include('laravel-crm::partials.return-button',[
                    'model' => new \VentureDrake\LaravelCrm\Models\Product(),
                    'route' => 'products'
                ])
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')
            
                @include('laravel-crm::products.partials.fields')
            
        @endcomponent
        
        @component('laravel-crm::components.card-footer')
                <a href="#" onclick="loadContent('{{ url(route('laravel-crm.products.index')) }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
                <button type="submit" class="btn btn-primary">{{ ucfirst(__('laravel-crm::lang.save')) }}</button>
        @endcomponent
        
    @endcomponent
</form>