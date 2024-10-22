@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ ucfirst(__('laravel-crm::lang.organizations')) }}
        @endslot

        @slot('actions')
            @include('laravel-crm::partials.filters', [
                'action' => route('laravel-crm.organisations.filter'),
                'model' => '\VentureDrake\LaravelCrm\Models\Organisation'
            ])
            @can('create crm organisations')
            <span class="float-right"><a type="button" class="btn btn-primary btn-sm" href="#" onclick="loadContent('{{ url(route('laravel-crm.organisations.create')) }}')"><span class="fa fa-plus"></span>  {{ ucfirst(__('laravel-crm::lang.add_organization')) }}</a></span>
            @endcan
        @endslot

    @endcomponent

    @component('laravel-crm::components.card-table')

        <table class="table mb-0 card-table table-hover">
            <thead>
            <tr>
                <th scope="col" colspan="2">@sortablelink('name', ucwords(__('laravel-crm::lang.name')))</th>
                <th scope="col">@sortablelink('organisationType.name', ucwords(__('laravel-crm::lang.type')))</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.labels')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.open_deals')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.lost_deals')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.won_deals')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.next_activity')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.owner')) }}</th>
                <th scope="col" width="150"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($organisations as $organisation)
                <tr class="has-link" data-url="{{ url(route('laravel-crm.organisations.show',$organisation)) }}">
                    <td>{{ $organisation->name }} </td>
                    <td>@if($organisation->xeroContact)<img src="/vendor/laravel-crm/img/xero-icon.png" height="20" />@endif</td>
                    <td>{{ $organisation->organisationType->name ?? null }}</td>
                    <td>@include('laravel-crm::partials.labels',[
                            'labels' => $organisation->labels,
                            'limit' => 3
                        ])</td>
                    <td>{{ $organisation->deals->whereNull('closed_at')->count() }}</td>
                    <td>{{ $organisation->deals->where('closed_status', 'lost')->count() }}</td>
                    <td>{{ $organisation->deals->where('closed_status', 'won')->count() }}</td>
                    <td></td>
                    <td>{{ $organisation->ownerUser->name ?? null }}</td>
                    <td class="disable-link text-right">
                        @hasleadsenabled
                        @can('create crm leads')
                        <a href="#" onclick="loadContent('{{ route('laravel-crm.leads.create', ['model' => 'organisation', 'id' => $organisation->id]) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-arrow-right" aria-hidden="true"></span> <span class="fa fa-crosshairs" aria-hidden="true"></span></a>
                        @endcan
                        @endhasleadsenabled
                        @hasdealsenabled
                        @can('create crm deals')
                            <a href="#" onclick="loadContent('{{ route('laravel-crm.deals.create', ['model' => 'organisation', 'id' => $organisation->id]) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-arrow-right" aria-hidden="true"></span> <span class="fa fa-dollar" aria-hidden="true"></span></a>
                        @endcan
                        @endhasdealsenabled
                        @hasquotesenabled
                        @can('create crm quotes')
                            <a href="#" onclick="loadContent('{{ route('laravel-crm.quotes.create', ['model' => 'organisation', 'id' => $organisation->id]) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-arrow-right" aria-hidden="true"></span> <span class="fa fa-file-text" aria-hidden="true"></span></a>
                        @endcan
                        @endhasquotesenabled
                        @hasordersenabled
                        @can('create crm orders')
                            <a href="#" onclick="loadContent('{{ route('laravel-crm.orders.create', ['model' => 'organisation', 'id' => $organisation->id]) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-arrow-right" aria-hidden="true"></span> <span class="fa fa-shopping-cart" aria-hidden="true"></span></a>
                        @endcan
                        @endhasordersenabled
                        @can('view crm organisations')
                        <a href="#" onclick="loadContent('{{ route('laravel-crm.organisations.show',$organisation) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-eye" aria-hidden="true"></span></a>
                        @endcan
                        @can('edit crm organisations')
                        <a href="#" onclick="loadContent('{{ route('laravel-crm.organisations.edit',$organisation) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a>
                        @endcan
                        @can('delete crm organisations')    
                        <form id="deleteOrgForm_{{ $organisation->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteOrgForm_{{ $organisation->id }}', '{{ route('laravel-crm.organisations.destroy', $organisation) }}', '{{ __('Organisation deleted successfully!') }}', '{{ route('laravel-crm.organisations.index') }}')">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.organization') }}"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
                        </form>
                        @endcan    
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        
    @endcomponent

   
    @if($organisations instanceof \Illuminate\Pagination\LengthAwarePaginator )
        @component('laravel-crm::components.card-footer')
            <ul class="pagination justify-content-end">
                @if ($organisations->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/organisations?page=' . ($organisations->currentPage() - 1)) }}')">Previous</a>
                    </li>
                @endif

                @foreach ($organisations->getUrlRange(1, $organisations->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $organisations->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/organisations?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($organisations->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/organisations?page=' . ($organisations->currentPage() + 1)) }}')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        @endcomponent
    @endif

@endcomponent    