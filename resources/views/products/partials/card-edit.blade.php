<form method="POST" id="productForm" action="{{ url(route('laravel-crm.products.update', $product)) }}" 
onsubmit="submitFormCrm(event, 'productForm', '{{ url(route('laravel-crm.products.update', $product)) }}', 
'¡Se ha editado correctamente el producto!', '{{ route('laravel-crm.products.show', $product ?? 1) }}')">
    @csrf
    @method('PUT')
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.edit_product')) }}
            @endslot

            @slot('actions')
                @include('laravel-crm::partials.return-button',[
                    'model' => $product,
                    'route' => 'products'
                ])
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::products.partials.fields')

        @endcomponent

        @component('laravel-crm::components.card-footer')
                <a href="#" onclick="loadContent('{{ url(route('laravel-crm.products.index')) }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
                <button type="submit" class="btn btn-primary">{{ ucwords(__('laravel-crm::lang.save_changes')) }}</button>
        @endcomponent

    @endcomponent
</form>