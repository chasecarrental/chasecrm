<form id="leadCreateForm" method="POST" action="javascript:void(0)" onsubmit="submitFormCrm(event, 'leadCreateForm', '{{ route('laravel-crm.leads.store') }}', 'Lead creado correctamente', '{{ route('laravel-crm.leads.index') }}')">
    @csrf
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.create_lead')) }}
            @endslot

            @slot('actions')
                @include('laravel-crm::partials.return-button', [
                    'model' => new \VentureDrake\LaravelCrm\Models\Lead(),
                    'route' => 'leads'
                ])
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')
            @include('laravel-crm::leads.partials.fields')
        @endcomponent

        @component('laravel-crm::components.card-footer')
            <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.leads.index') }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
            <button type="submit" class="btn btn-primary">{{ ucfirst(__('laravel-crm::lang.save')) }}</button>
        @endcomponent

    @endcomponent
</form>
