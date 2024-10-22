<form id="clientForm" method="POST" action="{{ url(route('laravel-crm.clients.store')) }}" onsubmit="submitFormCrm(event, 'clientForm', '{{ url(route('laravel-crm.clients.store')) }}', '¡Se ha guardado correctamente el cliente!', '{{ route('laravel-crm.clients.show', $client ?? 1) }}')">
    @csrf
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.create_client')) }}
            @endslot

            @slot('actions')
                @include('laravel-crm::partials.return-button',[
                    'model' => new \VentureDrake\LaravelCrm\Models\Client(),
                    'route' => 'clients'
                ])
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::clients.partials.fields')

        @endcomponent

        @component('laravel-crm::components.card-footer')
            <a href="#" onclick="loadContent('{{ url(route('laravel-crm.clients.index')) }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
            <button type="submit" class="btn btn-primary">{{ ucfirst(__('laravel-crm::lang.save')) }}</button>
        @endcomponent

    @endcomponent
</form>