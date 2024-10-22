@component('laravel-crm::components.card')

    <div class="card-header">
        @include('laravel-crm::layouts.partials.nav-activities')
    </div>

    <div class="card-body p-0">
        <div class="tab-content">
            <div class="tab-pane active" id="roles" role="tabpanel">
                <h3 class="m-3"> {{ ucfirst(__('laravel-crm::lang.tasks')) }}</h3>
                <div class="table-responsive">
                    <table class="table mb-0 card-table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">{{ ucwords(__('laravel-crm::lang.created')) }}</th>
                            <th scope="col">{{ ucfirst(__('laravel-crm::lang.status')) }}</th>
                            <th scope="col">{{ ucfirst(__('laravel-crm::lang.task')) }}</th>
                            <th scope="col">{{ ucfirst(__('laravel-crm::lang.description')) }}</th>
                            <th scope="col">{{ ucfirst(__('laravel-crm::lang.due')) }}</th>
                            <th scope="col">{{ ucfirst(__('laravel-crm::lang.created_by')) }}</th>
                            <th scope="col">{{ ucfirst(__('laravel-crm::lang.assigned_to')) }}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($tasks && $tasks->count() > 0)
                            @foreach($tasks as $task)
                                @livewire('task',[
                                'task' => $task,
                                'view' => 'task-table'
                                ], key($task->id))
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">
                                    {{ ucfirst(__('laravel-crm::lang.no_tasks')) }}
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($tasks instanceof \Illuminate\Pagination\LengthAwarePaginator)
    @component('laravel-crm::components.card-footer')
        <ul class="pagination justify-content-end">
            @if ($tasks->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/tasks?page=' . ($tasks->currentPage() - 1)) }}')">Previous</a>
                </li>
            @endif

            @foreach ($tasks->getUrlRange(1, $tasks->lastPage()) as $page => $url)
                <li class="page-item @if ($page == $tasks->currentPage()) active @endif">
                    <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/tasks?page=' . $page) }}')">{{ $page }}</a>
                </li>
            @endforeach

            @if ($tasks->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/tasks?page=' . ($tasks->currentPage() + 1)) }}')">Next</a>
                </li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    @endcomponent
@endif


@endcomponent
