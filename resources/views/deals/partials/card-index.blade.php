@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ ucfirst(__('laravel-crm::lang.deals')) }}
        @endslot

        @slot('actions')
            @include('laravel-crm::partials.filters', [
                'action' => route('laravel-crm.deals.filter'),
                'model' => '\VentureDrake\LaravelCrm\Models\Deal'
            ])
            @can('create crm deals')
            <span class="float-right">
                <a type="button" class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.deals.create') }}')">
                    <span class="fa fa-plus"></span> {{ ucfirst(__('laravel-crm::lang.add_deal')) }}
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
                <th scope="col">{{ ucwords(__('laravel-crm::lang.title')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.labels')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.value')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.client')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.organization')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.contact_person')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.expected_close')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.owner')) }}</th>
                <th scope="col" width="240"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($deals as $deal)
                <tr class="has-link @if($deal->closed_status == 'won') table-success @elseif($deal->closed_status == 'lost') table-danger @endif" data-url="{{ url(route('laravel-crm.deals.show', $deal)) }}">
                    <td>{{ $deal->created_at->diffForHumans() }}</td>
                    <td>{{ $deal->title }}</td>
                    <td>@include('laravel-crm::partials.labels', [
                            'labels' => $deal->labels,
                            'limit' => 3
                        ])</td>
                    <td>{{ money($deal->amount, $deal->currency) }}</td>
                    <td>{{ $deal->client->name ?? null }}</td>
                    <td>{{ $deal->organisation->name ?? null }}</td>
                    <td>{{ $deal->person->name ?? null }}</td>
                    <td>{{ ($deal->expected_close) ? $deal->expected_close->format($dateFormat) : null }}</td>
                    <td>{{ $deal->ownerUser->name ?? null }}</td>
                    <td class="disable-link text-right">
                        @can('edit crm deals')
                        @if(!$deal->closed_at)
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.deals.won', $deal) }}')" class="btn btn-success btn-sm">{{ ucfirst(__('laravel-crm::lang.won')) }}</a>
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.deals.lost', $deal) }}')" class="btn btn-danger btn-sm">{{ ucfirst(__('laravel-crm::lang.lost')) }}</a>
                        @else
                            <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.deals.reopen', $deal) }}')" class="btn btn-outline-secondary btn-sm">{{ ucfirst(__('laravel-crm::lang.reopen')) }}</a>
                        @endif
                        @endcan
                        @can('view crm deals')
                        <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.deals.show', $deal) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-eye" aria-hidden="true"></span></a>
                        @endcan
                        @can('edit crm deals')
                        <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.deals.edit', $deal) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a>
                        @endcan
                        @can('delete crm deals')
                        <form id="deleteDealForm_{{ $deal->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteDealForm_{{ $deal->id }}', '{{ route('laravel-crm.deals.destroy', $deal) }}', '{{ __('Deal deleted successfully!') }}', '{{ route('laravel-crm.deals.index') }}')">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.deal') }}"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endcomponent

    @if($deals instanceof \Illuminate\Pagination\LengthAwarePaginator )
    @component('laravel-crm::components.card-footer')
        <ul class="pagination justify-content-end">
            @if ($deals->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/deals?page=' . ($deals->currentPage() - 1)) }}')">Previous</a>
                </li>
            @endif

            @foreach ($deals->getUrlRange(1, $deals->lastPage()) as $page => $url)
                <li class="page-item @if ($page == $deals->currentPage()) active @endif">
                    <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/deals?page=' . $page) }}')">{{ $page }}</a>
                </li>
            @endforeach

            @if ($deals->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/deals?page=' . ($deals->currentPage() + 1)) }}')">Next</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    @endcomponent
@endif


@endcomponent
