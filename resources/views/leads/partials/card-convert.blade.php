<form id="convertLeadToDealForm" method="POST" action="javascript:void(0)" onsubmit="submitFormCrm(event, 'convertLeadToDealForm', '{{ route('laravel-crm.leads.store-as-deal', $lead) }}', 'Lead convertido a Deal correctamente', '{{ route('laravel-crm.leads.index') }}')">
    @csrf
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.convert_lead_to_deal')) }}
            @endslot

            @slot('actions')
                <span class="float-right">
                    <a type="button" class="btn btn-outline-secondary btn-sm" href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.leads.index') }}')"><span class="fa fa-angle-double-left"></span> {{ ucfirst(__('laravel-crm::lang.back_to_leads')) }}</a>
                </span>
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::deals.partials.fields', [
                  'deal' => $lead,
                  'lead' => $lead
             ])

        @endcomponent

        @component('laravel-crm::components.card-footer')
            <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.leads.index') }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
            <button type="submit" class="btn btn-primary">{{ ucfirst(__('laravel-crm::lang.save')) }}</button>
        @endcomponent

    @endcomponent
</form>
