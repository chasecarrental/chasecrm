

@include('laravel-crm::styles')


    <div class="card">
        <div class="card-header">
            @include('laravel-crm::layouts.partials.nav-activities')
        </div>
        <div class="card-body">
            <h3 class="mb-3"> {{ ucfirst(__('laravel-crm::lang.calls')) }}</h3>
            @if($calls && $calls->count() > 0)
                @foreach($calls as $call)
                    @livewire('call',[
                        'call' => $call
                    ], key($call->id))
                @endforeach
            @endif
        </div>
        @if($calls instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="card-footer">
            <ul class="pagination justify-content-end">
                @if ($calls->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/calls?page=' . ($calls->currentPage() - 1)) }}')">Previous</a>
                    </li>
                @endif
    
                @foreach ($calls->getUrlRange(1, $calls->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $calls->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/calls?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach
    
                @if ($calls->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/calls?page=' . ($calls->currentPage() + 1)) }}')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </div>
    @endif
    
    </div>


    @include('laravel-crm::codification')