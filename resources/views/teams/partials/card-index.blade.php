@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ ucfirst(__('laravel-crm::lang.teams')) }}
        @endslot

        @slot('actions')
            @can('create crm teams')
            <span class="float-right">
                <a type="button" class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.teams.create') }}')">
                    <span class="fa fa-plus"></span> {{ ucfirst(__('laravel-crm::lang.add_team')) }}
                </a>
            </span>
            @endcan
        @endslot

    @endcomponent

    @component('laravel-crm::components.card-table')

        <table class="table mb-0 card-table table-hover">
            <thead>
            <tr>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.name')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.created_by')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.created')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.updated')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.users')) }}</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($teams as $team)
                <tr class="has-link" data-url="{{ url(route('laravel-crm.teams.show',$team)) }}" >
                    <td>{{ $team->name }}</td>
                    <td>{{ $team->userCreated->name }}</td>
                    <td>{{ $team->created_at }}</td>
                    <td>{{ $team->updated_at }}</td>
                    <td>{{ $team->users->count() }}</td>
                    <td class="disable-link text-right">
                        @can('view crm teams')
                        <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.teams.show', $team) }}')" class="btn btn-outline-secondary btn-sm">
                            <span class="fa fa-eye" aria-hidden="true"></span>
                        </a>
                        @endcan
                        @can('edit crm teams')
                        <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.teams.edit', $team) }}')" class="btn btn-outline-secondary btn-sm">
                            <span class="fa fa-edit" aria-hidden="true"></span>
                        </a>
                        @endcan
                        @can('delete crm teams')
                        <form id="deleteTeamForm_{{ $team->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteTeamForm_{{ $team->id }}', '{{ route('laravel-crm.teams.destroy', $team) }}', '{{ __('Team deleted successfully!') }}', '{{ route('laravel-crm.teams.index') }}')">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.team') }}">
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

    @if($teams instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @component('laravel-crm::components.card-footer')
            <ul class="pagination justify-content-end">
                @if ($teams->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/teams?page=' . ($teams->currentPage() - 1)) }}')">Previous</a>
                    </li>
                @endif

                @foreach ($teams->getUrlRange(1, $teams->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $teams->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/teams?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($teams->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/teams?page=' . ($teams->currentPage() + 1)) }}')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        @endcomponent
    @endif

@endcomponent
