<form method="POST" id="clientForm" action="{{ url(route('laravel-crm.clients.update', $client)) }}" 
onsubmit="submitFormCrm(event, 'clientForm', '{{ url(route('laravel-crm.clients.update', $client)) }}', 
'¡Se ha editado correctamente el cliente!', '{{ route('laravel-crm.clients.show', $client ?? 14) }}')">
    @csrf
    @method('PUT')
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.edit_client')) }}
            @endslot

            @slot('actions')
                @include('laravel-crm::partials.return-button',[
                    'model' => $client,
                    'route' => 'clients'
                ])
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::clients.partials.fields')

        @endcomponent

        @component('laravel-crm::components.card-footer')
            <a href="#" onclick="loadContent('{{ url(route('laravel-crm.clients.index')) }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
            <button type="submit" class="btn btn-primary">{{ ucwords(__('laravel-crm::lang.save_changes')) }}</button>
        @endcomponent

    @endcomponent
</form>