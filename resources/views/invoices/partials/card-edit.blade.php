<form id="updateInvoiceForm_{{ $invoice->id }}" method="POST" onsubmit="submitFormCrm(event, 'updateInvoiceForm_{{ $invoice->id }}', '{{ route('laravel-crm.invoices.update', $invoice) }}', '{{ __('Invoice updated successfully!') }}', '{{ route('laravel-crm.invoices.index') }}')">
    @csrf
    @method('PUT')
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.edit_invoice')) }}
            @endslot

            @slot('actions')
                <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.invoices.index') }}')" class="btn btn-outline-secondary">
                    {{ ucfirst(__('laravel-crm::lang.cancel')) }}
                </a>
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::invoices.partials.fields')

        @endcomponent

        @component('laravel-crm::components.card-footer')
            <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.invoices.index') }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
            <button type="submit" class="btn btn-primary">{{ ucwords(__('laravel-crm::lang.save_changes')) }}</button>
        @endcomponent

    @endcomponent
</form>
