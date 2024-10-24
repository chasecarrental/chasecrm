@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ ucfirst(__('laravel-crm::lang.leads')) }}
        @endslot

        @slot('actions')
            @include('laravel-crm::partials.filters', [
                'action' => route('laravel-crm.leads.filter'),
                'model' => '\VentureDrake\LaravelCrm\Models\Lead'
            ])
            @can('create crm leads')
               <a type="button" class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.leads.create') }}')"><span class="fa fa-plus"></span>  {{ ucfirst(__('laravel-crm::lang.add_lead')) }}</a>
            @endcan
        @endslot

    @endcomponent

    @component('laravel-crm::components.card-table')

        <table class="table mb-0 card-table table-hover ">
            <thead>
            <tr>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.created')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.title')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.labels')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.value')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.client')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.organization')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.contact_person')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.owner')) }}</th>
                <th scope="col" width="210"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($leads as $lead)
                <tr class="has-link" data-url="{{ url(route('laravel-crm.leads.show',$lead)) }}">
                    <td>{{ $lead->created_at->diffForHumans() }}</td>
                    <td>{{ $lead->title }}</td>
                    <td>@include('laravel-crm::partials.labels',[
                            'labels' => $lead->labels,
                            'limit' => 3
                        ])</td>
                    <td>{{ money($lead->amount, $lead->currency) }}</td>
                    <td>{{ $lead->client->name ?? null}}</td>
                    <td>{{ $lead->organisation->name ?? null}}</td>
                    <td>{{ $lead->person->name ??  null }}</td>
                    <td>{{ $lead->ownerUser->name ?? null }}</td>
                    <td class="disable-link text-right">
                        @hasdealsenabled
                            @can('edit crm leads')
                            <a  href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.leads.convert-to-deal',$lead) }}')" class="btn btn-success btn-sm"> {{ ucfirst(__('laravel-crm::lang.convert')) }}</a>
                            @endcan
                        @endhasdealsenabled
                        @can('view crm leads')
                        <a  href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.leads.show',$lead)  }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-eye" aria-hidden="true"></span></a>
                        @endcan
                        @can('edit crm leads')
                        <a  href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.leads.edit',$lead)  }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a>
                        @endcan
                        @can('delete crm leads')
                        <form id="deleteLeadForm_{{ $lead->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteLeadForm_{{ $lead->id }}', '{{ route('laravel-crm.leads.destroy', $lead) }}', '{{ __('Lead deleted successfully!') }}', '{{ route('laravel-crm.leads.index') }}')">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.lead') }}">
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

    @if($leads instanceof \Illuminate\Pagination\LengthAwarePaginator )
        @component('laravel-crm::components.card-footer')
            <ul class="pagination justify-content-end">
                @if ($leads->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/leads?page=' . ($leads->currentPage() - 1)) }}')">Previous</a></li>
                @endif

                @foreach ($leads->getUrlRange(1, $leads->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $leads->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/leads?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($leads->hasMorePages())
                    <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/leads?page=' . ($leads->currentPage() + 1)) }}')">Next</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        @endcomponent
    @endif

@endcomponent
