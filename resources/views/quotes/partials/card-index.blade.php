@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ ucfirst(__('laravel-crm::lang.quotes')) }}
        @endslot

        @slot('actions')
            @include('laravel-crm::partials.filters', [
                'action' => route('laravel-crm.quotes.filter'),
                'model' => '\VentureDrake\LaravelCrm\Models\Quote'
            ])
            @can('create crm quotes')
            <span class="float-right">
                <a type="button" class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.quotes.create') }}')">
                    <span class="fa fa-plus"></span> {{ ucfirst(__('laravel-crm::lang.add_quote')) }}
                </a>
            </span>
            @endcan
        @endslot

    @endcomponent

    @component('laravel-crm::components.card-table')

        <table class="table mb-0 card-table table-hover">
            <thead>
            <tr>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.created')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.number')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.reference')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.title')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.labels')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.customer')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.total')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.issue_at')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.expire_at')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.owner')) }}</th>
                <th scope="col" width="360"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($quotes as $quote)
               <tr class="has-link @if($quote->accepted_at) table-success @elseif($quote->rejected_at) table-danger @endif" data-url="{{ url(route('laravel-crm.quotes.show',$quote)) }}">
                   <td>{{ $quote->created_at->diffForHumans() }}</td>
                   <td>{{ $quote->quote_id }}</td>
                   <td>{{ $quote->reference }}</td>
                   <td>{{ $quote->title }}</td>
                   <td>@include('laravel-crm::partials.labels',[ 'labels' => $quote->labels, 'limit' => 3 ])</td>
                   <td>{{ $quote->client->name ?? null }}<br><small>{{ $quote->organisation->name ?? null }}</small></td>
                   <td>{{ money($quote->total, $quote->currency) }}</td>
                   <td>{{ $quote->issue_at ? $quote->issue_at->format($dateFormat) : null }}</td>
                   <td>{{ $quote->expire_at ? $quote->expire_at->format($dateFormat) : null }}</td>
                   <td>{{ $quote->ownerUser->name ?? null }}</td>
                   <td class="disable-link text-right">
                       @can('edit crm quotes')
                           @if(!$quote->accepted_at && !$quote->rejected_at)
                               <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.quotes.accept', $quote) }}')" class="btn btn-success btn-sm">{{ ucfirst(__('laravel-crm::lang.accept')) }}</a>
                               <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.quotes.reject', $quote) }}')" class="btn btn-danger btn-sm">{{ ucfirst(__('laravel-crm::lang.reject')) }}</a>
                           @elseif($quote->accepted_at && $quote->orders()->count() < 1)
                               <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.quotes.unaccept', $quote) }}')" class="btn btn-outline-secondary btn-sm">{{ ucfirst(__('laravel-crm::lang.unaccept')) }}</a>
                               <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.orders.create',['model' => 'quote', 'id' => $quote->id]) }}')" class="btn btn-success btn-sm">{{ ucfirst(__('laravel-crm::lang.create_order')) }}</a>
                           @endif
                        @endcan
                        @can('view crm quotes')
                           <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.quotes.download', $quote) }}')" class="btn btn-outline-secondary btn-sm">
                               <span class="fa fa-download" aria-hidden="true"></span>
                           </a>
                           <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.quotes.show', $quote) }}')" class="btn btn-outline-secondary btn-sm">
                               <span class="fa fa-eye" aria-hidden="true"></span>
                           </a>
                        @endcan
                        @can('edit crm quotes')
                            @if(! $quote->accepted_at)
                                <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.quotes.edit', $quote) }}')" class="btn btn-outline-secondary btn-sm">
                                    <span class="fa fa-edit" aria-hidden="true"></span>
                                </a>
                            @endif
                        @endcan
                        @can('delete crm quotes')
                        <form id="deleteQuoteForm_{{ $quote->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteQuoteForm_{{ $quote->id }}', '{{ route('laravel-crm.quotes.destroy', $quote) }}', '{{ __('Quote deleted successfully!') }}', '{{ route('laravel-crm.quotes.index') }}')">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.quote') }}">
                                <span class="fa fa-trash-o" aria-hidden="true"></span>
                            </button>
                        </form>
                        
                        @endcan
                   </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endcomponent

    @if($quotes instanceof \Illuminate\Pagination\LengthAwarePaginator )
        @component('laravel-crm::components.card-footer')
            <ul class="pagination justify-content-end">
                @if ($quotes->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/quotes?page=' . ($quotes->currentPage() - 1)) }}')">Previous</a></li>
                @endif
                @foreach ($quotes->getUrlRange(1, $quotes->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $quotes->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/quotes?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach
                @if ($quotes->hasMorePages())
                    <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/quotes?page=' . ($quotes->currentPage() + 1)) }}')">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        @endcomponent
    @endif

@endcomponent
