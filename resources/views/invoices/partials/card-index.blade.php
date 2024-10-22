@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ ucfirst(__('laravel-crm::lang.invoices')) }}
        @endslot

        @slot('actions')
            @include('laravel-crm::partials.filters', [
                'action' => route('laravel-crm.invoices.filter'),
                'model' => '\VentureDrake\LaravelCrm\Models\Invoice'
            ])
            @can('create crm invoices')
            <span class="float-right"><a type="button" class="btn btn-primary btn-sm" onclick="loadContent('{{ route('laravel-crm.invoices.create') }}')"><span class="fa fa-plus"></span>  {{ ucfirst(__('laravel-crm::lang.add_invoice')) }}</a></span>
            @endcan
        @endslot

    @endcomponent

    @component('laravel-crm::components.card-table')
        <table class="table  table-hover">
            <thead>
            <tr>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.number')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.reference')) }}</th>
                @hasordersenabled
                    <th scope="col">{{ ucwords(__('laravel-crm::lang.order')) }}</th>
                @endhasordersenabled
                <th scope="col">{{ ucwords(__('laravel-crm::lang.to')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.date')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.due_date')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.overdue_by')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.paid_date')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.paid')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.due')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.sent')) }}</th>
                <th scope="col" width="180"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
               <tr @if(! $invoice->xeroInvoice) class="has-link"  data-url="{{ url(route('laravel-crm.invoices.show', $invoice)) }}" @endif>
                   <td>{{ $invoice->xeroInvoice->number ?? $invoice->invoice_id }}</td>
                   <td>{{ $invoice->xeroInvoice->reference ?? $invoice->reference }}</td>
                   @hasordersenabled
                   <td>
                       @if($invoice->order)
                           <a href="#"  onclick="loadContent('{{ route('laravel-crm.orders.show', $invoice->order) }}')">{{ $invoice->order->order_id }}</a>
                       @endif
                   </td>
                   @endhasordersenabled
                   <td>
                       {{ $invoice->organisation->name ?? null }}
                       @if($invoice->person)
                           <br /><small>{{ $invoice->person->name }}</small>
                       @endif    
                   </td>
                   <td>{{ $invoice->issue_date->format($dateFormat) }}</td>
                   <td>{{ $invoice->due_date->format($dateFormat) }}</td>
                   <td class="text-danger">
                       @if(! $invoice->fully_paid_at && $invoice->due_date->diffinDays() > 0 && $invoice->due_date < \Carbon\Carbon::now()->timezone($timezone))
                           {{ $invoice->due_date->diffForHumans(false, true) }}
                       @endif
                   </td>
                   <td>{{ ($invoice->fully_paid_at) ? $invoice->fully_paid_at->format($dateFormat) : null }}</td>
                   <td>{{ money($invoice->amount_paid, $invoice->currency) }}</td>
                   <td>{{ money($invoice->amount_due, $invoice->currency) }}</td>
                   <td>
                       @if($invoice->sent == 1)
                           <span class="text-success">Sent</span>
                       @endif
                   </td>
                    <td class="disable-link text-right">
                        @if(! $invoice->xeroInvoice)
                            @livewire('send-invoice', ['invoice' => $invoice])
                            <a class="btn btn-outline-secondary btn-sm" onclick="loadContent('{{ route('laravel-crm.invoices.download', $invoice) }}')" href="#"><span class="fa fa-download" aria-hidden="true"></span></a>
                            @if(! $invoice->fully_paid_at)
                                @livewire('pay-invoice', ['invoice' => $invoice])
                            @endif
                            @can('view crm invoices')
                            <a onclick="loadContent('{{ route('laravel-crm.invoices.show', $invoice) }}')" href="#" class="btn btn-outline-secondary btn-sm"><span class="fa fa-eye" aria-hidden="true"></span></a>
                            @endcan
                            @if($invoice->amount_paid <= 0)
                                @can('edit crm invoices')
                                <a href="#" onclick="loadContent('{{ route('laravel-crm.invoices.edit', $invoice) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a>
                                @endcan
                                @can('delete crm invoices')
                                <form id="deleteInvoiceForm_{{ $invoice->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteInvoiceForm_{{ $invoice->id }}', '{{ route('laravel-crm.invoices.destroy', $invoice) }}', '{{ __('Invoice deleted successfully!') }}', '{{ route('laravel-crm.invoices.index') }}')">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.invoice') }}">
                                        <span class="fa fa-trash-o" aria-hidden="true"></span>
                                    </button>
                                </form>
                                @endcan
                            
                            @endif   
                            <form id="duplicateInvoiceForm_{{ $invoice->id }}" action="{{ route('laravel-crm.invoices.duplicate', $invoice) }}" method="POST" class="form-check-inline form-duplicate-button" onsubmit="submitFormCrm(event, 'duplicateInvoiceForm_{{ $invoice->id }}', '{{ route('laravel-crm.invoices.duplicate', $invoice) }}', '{{ __('Invoice duplicated successfully!') }}', '{{ route('laravel-crm.invoices.index') }}')">
                                {{ method_field('POST') }}
                                {{ csrf_field() }}
                                <button id="DuplicateInvoiceBtn" class="btn btn-primary btn-sm" data-model="{{ __('laravel-crm::lang.invoice') }}" type="submit">
                                    <span class="fa fa-exchange" aria-hidden="true"></span>
                                </button>
                            </form>
                            
                         
                        @else
                            <img src="/vendor/laravel-crm/img/xero-icon.png" height="30" />
                        @endif    

                        <!-- Script específico para este invoice -->
                     
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endcomponent

    @if($invoices instanceof \Illuminate\Pagination\LengthAwarePaginator )
        @component('laravel-crm::components.card-footer')
            <ul class="pagination justify-content-end">
                @if ($invoices->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/invoices?page=' . ($invoices->currentPage() - 1)) }}')">Previous</a>
                    </li>
                @endif

                @foreach ($invoices->getUrlRange(1, $invoices->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $invoices->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/invoices?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($invoices->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/invoices?page=' . ($invoices->currentPage() + 1)) }}')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        @endcomponent
    @endif

@endcomponent
