<form id="orderForm" method="POST" action="{{ url(route('laravel-crm.orders.update', $order)) }}" onsubmit="submitFormCrm(event, 'orderForm', '{{ route('laravel-crm.orders.update', $order) }}', 'Order updated successfully', '{{ route('laravel-crm.orders.show', $order) }}')">
    @csrf
    @method('PUT')
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.edit_order')) }}
            @endslot

            @slot('actions')
                @include('laravel-crm::partials.return-button', [
                'model' => $order,
                'route' => 'orders'
                ])
            @endslot
        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::orders.partials.fields')

        @endcomponent

        @component('laravel-crm::components.card-footer')
            <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.orders.index') }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
            <button type="submit" class="btn btn-primary">{{ ucwords(__('laravel-crm::lang.save_changes')) }}</button>
        @endcomponent

    @endcomponent
</form>
