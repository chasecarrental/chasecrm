<form method="POST" id="organisationForm" action="{{ url(route('laravel-crm.organisations.update', $organisation)) }}" 
onsubmit="submitFormCrm(event, 'organisationForm', '{{ url(route('laravel-crm.organisations.update', $organisation)) }}', 
'¡Se ha editado correctamente la organizacion!', '{{ route('laravel-crm.organisations.show', $organisation ?? 1) }}')">
    @csrf
    @method('PUT')
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.edit_organization')) }}
            @endslot

            @slot('actions')
                @include('laravel-crm::partials.return-button',[
                    'model' => $organisation,
                    'route' => 'organisations'
                ])
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::organisations.partials.fields')

        @endcomponent

        @component('laravel-crm::components.card-footer')
            <a href="#" onclick="loadContent('{{ url(route('laravel-crm.organisations.index')) }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
            <button type="submit" class="btn btn-primary">{{ ucwords(__('laravel-crm::lang.save_changes')) }}</button>
        @endcomponent

    @endcomponent
</form>