<form id="organisationForm" method="POST" action="{{ url(route('laravel-crm.organisations.store')) }}" onsubmit="submitFormCrm(event, 'organisationForm', '{{ url(route('laravel-crm.organisations.store')) }}', '¡Se ha guardado correctamente la organizacion!', '{{ route('laravel-crm.organisations.index') }}')">
    @csrf
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.create_organization')) }}
            @endslot

            @slot('actions')
                @include('laravel-crm::partials.return-button',[
                    'model' => new \VentureDrake\LaravelCrm\Models\Organisation(),
                    'route' => 'organisations'
                ])
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::organisations.partials.fields')

        @endcomponent

        @component('laravel-crm::components.card-footer')
            <a  href="#" onclick="loadContent('{{ url(route('laravel-crm.organisations.index')) }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
            <button type="submit" class="btn btn-primary">{{ ucfirst(__('laravel-crm::lang.save')) }}</button>
        @endcomponent

    @endcomponent
</form>