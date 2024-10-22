<form method="POST" id="personForm" action="{{ url(route('laravel-crm.people.update', $person)) }}" 
onsubmit="submitFormCrm(event, 'personForm', '{{ url(route('laravel-crm.people.update', $person)) }}', 
'¡Se ha editado correctamente la persona!', '{{ route('laravel-crm.people.show', $person ?? 1) }}')">
    @csrf
    @method('PUT')
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.edit_person')) }}
            @endslot

            @slot('actions')
                @include('laravel-crm::partials.return-button',[
                    'model' => $person,
                    'route' => 'people'
                ])
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::people.partials.fields')

        @endcomponent

        @component('laravel-crm::components.card-footer')
                <a href="#" onclick="loadContent('{{ url(route('laravel-crm.people.index')) }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
                <button type="submit" class="btn btn-primary">{{ ucwords(__('laravel-crm::lang.save_changes')) }}</button>
        @endcomponent

    @endcomponent
</form>