@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ ucfirst(__('laravel-crm::lang.users')) }}
        @endslot

        @slot('actions')
            @can('create crm users')
            <span class="float-right">
                <a type="button" class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.users.create') }}')">
                    <span class="fa fa-plus"></span> {{ ucfirst(__('laravel-crm::lang.add_user')) }}
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
                <th scope="col">{{ ucwords(__('laravel-crm::lang.email')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.email_verified')) }}</th>
                <th scope="col">{{ __('laravel-crm::lang.CRM_Access') }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.role')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.created')) }}</th>
                <th scope="col">{{ ucwords(__('laravel-crm::lang.last_online')) }}</th>
                <th scope="col" width="150"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr class="has-link" data-url="{{ url(route('laravel-crm.users.show',$user)) }}">

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->email_verified_at ? $user->email_verified_at->format($dateFormat . ' ' . $timeFormat) : null }}</td>
                    <td>{{ $user->crm_access ? 'Yes' : 'No' }}</td>
                    <td>{{ $user->roles()->first()->name ?? null }}</td>
                    <td>{{ $user->created_at->format($dateFormat) }}</td>
                    <td>{{ $user->last_online_at ? \Carbon\Carbon::parse($user->last_online_at)->diffForHumans() : 'Never' }}</td>
                    <td class="disable-link text-right">
                        @can('view crm users')
                        <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.users.show', $user) }}')" class="btn btn-outline-secondary btn-sm">
                            <span class="fa fa-eye" aria-hidden="true"></span>
                        </a>
                        @endcan
                        @can('edit crm users')
                        <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.users.edit', $user) }}')" class="btn btn-outline-secondary btn-sm">
                            <span class="fa fa-edit" aria-hidden="true"></span>
                        </a>
                        @endcan
                        @can('delete crm users')
                        <form id="deleteUserForm_{{ $user->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteUserForm_{{ $user->id }}', '{{ route('laravel-crm.users.destroy', $user) }}', '{{ __('User deleted successfully!') }}', '{{ route('laravel-crm.users.index') }}')">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.user') }}" {{ auth()->user()->id == $user->id ? 'disabled' : null }}>
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

    @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
        @component('laravel-crm::components.card-footer')
            <ul class="pagination justify-content-end">
                @if ($users->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/users?page=' . ($users->currentPage() - 1)) }}')">Previous</a>
                    </li>
                @endif

                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $users->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/users?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($users->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/users?page=' . ($users->currentPage() + 1)) }}')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        @endcomponent
    @endif

@endcomponent
