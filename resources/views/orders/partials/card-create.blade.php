<form id="orderForm" method="POST" action="{{ url(route('laravel-crm.orders.store')) }}" onsubmit="submitFormCrm(event, 'orderForm', '{{ route('laravel-crm.orders.store') }}', 'Order created successfully', '{{ route('laravel-crm.orders.index') }}')">
    @csrf
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.create_order')) }} 
                @isset($quote)
                    {{ __('laravel-crm::lang.from_quote') }} 
                    <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.quotes.show', $quote) }}')">{{ $quote->quote_id }}</a>
                @endisset
            @endslot

            @slot('actions')
                @if(isset($quote))
                    @include('laravel-crm::partials.return-button',[
                        'model' => new \VentureDrake\LaravelCrm\Models\Quote(),
                        'route' => 'quotes'
                    ])
                @else    
                    @include('laravel-crm::partials.return-button',[
                        'model' => new \VentureDrake\LaravelCrm\Models\Order(),
                        'route' => 'orders'
                    ])
                @endif    
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::orders.partials.fields')

        @endcomponent

        @component('laravel-crm::components.card-footer')
            <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.orders.index') }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
            <button type="submit" class="btn btn-primary">{{ ucfirst(__('laravel-crm::lang.save')) }}</button>
        @endcomponent

    @endcomponent
</form>
