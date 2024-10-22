@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ ucfirst(__('laravel-crm::lang.people')) }}
        @endslot
    
        @slot('actions')
            @include('laravel-crm::partials.filters', [
                'action' => route('laravel-crm.people.filter'),
                'model' => '\VentureDrake\LaravelCrm\Models\Person'
            ])
            @can('create crm people')
            <span class="float-right"><a type="button" class="btn btn-primary btn-sm" href="#" onclick="loadContent('{{ url(route('laravel-crm.people.create')) }}')"><span class="fa fa-plus"></span>  {{ ucfirst(__('laravel-crm::lang.add_person')) }}</a></span>
            @endcan
        @endslot

    @endcomponent

    @component('laravel-crm::components.card-table')
        
        <table class="table mb-0 card-table table-hover">
            <thead>
                <tr>
                    <th scope="col" style="font-size: 14px;">@sortablelink('first_name', ucwords(__('laravel-crm::lang.name')))</th>
                    <th scope="col" style="font-size: 14px;">{{ ucwords(__('laravel-crm::lang.labels')) }}</th>
                    <th scope="col" style="font-size: 14px;">{{ ucwords(__('laravel-crm::lang.email')) }}</th>
                    <th scope="col" style="font-size: 14px;">{{ ucwords(__('laravel-crm::lang.phone')) }}</th>
                    <th scope="col" style="font-size: 14px;">{{ ucwords(__('laravel-crm::lang.open_deals')) }}</th>
                    <th scope="col" style="font-size: 14px;">{{ ucwords(__('laravel-crm::lang.lost_deals')) }}</th>
                    <th scope="col" style="font-size: 14px;">{{ ucwords(__('laravel-crm::lang.won_deals')) }}</th>
                    <th scope="col" style="font-size: 14px;">{{ ucwords(__('laravel-crm::lang.next_activity')) }}</th>
                    <th scope="col" style="font-size: 14px;">{{ ucwords(__('laravel-crm::lang.owner')) }}</th>
                    <th scope="col"  width="200"></th>
                </tr>
                
            </thead>
            <tbody>
            @foreach($people as $person)
                <tr class="has-link" data-url="{{ url(route('laravel-crm.people.show',$person)) }}">
                    <td>{{ $person->name }}</td>
                    <td>@include('laravel-crm::partials.labels',[
                            'labels' => $person->labels,
                            'limit' => 3
                        ])</td>
                    <td>{{ $person->getPrimaryEmail()->address ?? null }}</td>
                    <td>{{ $person->getPrimaryPhone()->number ?? null }}</td>
                    <td>{{ $person->deals->whereNull('closed_at')->count() }}</td>
                    <td>{{ $person->deals->where('closed_status', 'lost')->count() }}</td>
                    <td>{{ $person->deals->where('closed_status', 'won')->count() }}</td>
                    <td></td>
                    <td>{{ $person->ownerUser->name ?? null }}</td>
                    <td class="disable-link text-right">
                        @hasleadsenabled
                        @can('create crm leads')
                            <a href="#" onclick="loadContent('{{ route('laravel-crm.leads.create', ['model' => 'person', 'id' => $person->id]) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-arrow-right" aria-hidden="true"></span> <span class="fa fa-crosshairs" aria-hidden="true"></span></a>
                        @endcan
                        @endhasleadsenabled
                        @hasdealsenabled
                        @can('create crm deals')
                            <a href="#" onclick="loadContent('{{ route('laravel-crm.deals.create', ['model' => 'person', 'id' => $person->id]) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-arrow-right" aria-hidden="true"></span> <span class="fa fa-dollar" aria-hidden="true"></span></a>
                        @endcan
                        @endhasdealsenabled
                        @hasquotesenabled
                        @can('create crm quotes')
                            <a href="#" onclick="loadContent('{{ route('laravel-crm.quotes.create', ['model' => 'person', 'id' => $person->id]) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-arrow-right" aria-hidden="true"></span> <span class="fa fa-file-text" aria-hidden="true"></span></a>
                        @endcan
                        @endhasquotesenabled
                        @hasordersenabled
                        @can('create crm orders')
                            <a href="#" onclick="loadContent('{{ route('laravel-crm.orders.create', ['model' => 'person', 'id' => $person->id]) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-arrow-right" aria-hidden="true"></span> <span class="fa fa-shopping-cart" aria-hidden="true"></span></a>
                        @endcan
                        @endhasordersenabled
                        @can('view crm people')
                        <a href="#" onclick="loadContent('{{  route('laravel-crm.people.show',$person) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-eye" aria-hidden="true"></span></a>
                        @endcan
                        @can('edit crm people')
                        <a href="#" onclick="loadContent('{{  route('laravel-crm.people.edit',$person) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a>
                        @endcan
                        @can('delete crm people')    
                        <form id="deletePersonForm_{{ $person->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deletePersonForm_{{ $person->id }}', '{{ route('laravel-crm.people.destroy', $person) }}', '{{ __('Person deleted successfully!') }}', '{{ route('laravel-crm.people.index') }}')">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.person') }}"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
                        </form>
                        @endcan    
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        
    @endcomponent
    
    @if($people instanceof \Illuminate\Pagination\LengthAwarePaginator )
        @component('laravel-crm::components.card-footer')
            <ul class="pagination justify-content-end">
                @if ($people->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/people?page=' . ($people->currentPage() - 1)) }}')">Previous</a>
                    </li>
                @endif

                @foreach ($people->getUrlRange(1, $people->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $people->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/people?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($people->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/people?page=' . ($people->currentPage() + 1)) }}')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        @endcomponent
    @endif
    
@endcomponent    