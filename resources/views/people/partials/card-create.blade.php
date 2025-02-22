<form id="personForm" method="POST" action="{{ url(route('laravel-crm.people.store')) }}" onsubmit="submitFormCrm(event, 'personForm', '{{ url(route('laravel-crm.people.store')) }}', '¡Se ha guardado correctamente la persona!', '{{ route('laravel-crm.people.index') }}')">
    @csrf
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.create_person')) }}
            @endslot

            @slot('actions')
                @include('laravel-crm::partials.return-button',[
                    'model' => new \VentureDrake\LaravelCrm\Models\Person(),
                    'route' => 'people'
                ])
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')
            
                @include('laravel-crm::people.partials.fields')
            
        @endcomponent
        
        @component('laravel-crm::components.card-footer')
                <a href="#" onclick="loadContent('{{ url(route('laravel-crm.people.index')) }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
                <button type="submit" class="btn btn-primary">{{ ucfirst(__('laravel-crm::lang.save')) }}</button>
        @endcomponent
        
    @endcomponent
</form>