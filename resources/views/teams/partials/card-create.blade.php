<form method="POST" id="createTeamForm" action="{{ url(route('laravel-crm.teams.store')) }}" onsubmit="submitFormCrm(event, 'createTeamForm', '{{ route('laravel-crm.teams.store') }}', '{{ __('Team creado exitosamente') }}', '{{ route('laravel-crm.teams.index') }}')">
    @csrf
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.create_team')) }}
            @endslot

            @slot('actions')
                <span class="float-right">
                    <a type="button" class="btn btn-outline-secondary btn-sm" href="javascript:void(0)" onclick="loadContent('{{ url(route('laravel-crm.teams.index')) }}')">
                        <span class="fa fa-angle-double-left"></span> {{ ucfirst(__('laravel-crm::lang.back_to_teams')) }}
                    </a>
                </span>
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::teams.partials.fields')

        @endcomponent

        @component('laravel-crm::components.card-footer')
            <a href="javascript:void(0)" onclick="loadContent('{{ url(route('laravel-crm.teams.index')) }}')" class="btn btn-outline-secondary">
                {{ ucfirst(__('laravel-crm::lang.cancel')) }}
            </a>
            <button type="submit" class="btn btn-primary">
                {{ ucfirst(__('laravel-crm::lang.save')) }}
            </button>
        @endcomponent

    @endcomponent
</form>
