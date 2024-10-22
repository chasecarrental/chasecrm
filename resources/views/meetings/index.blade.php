@include('laravel-crm::styles')



    <div class="card">
        <div class="card-header">
            @include('laravel-crm::layouts.partials.nav-activities')
        </div>
        <div class="card-body">
            <h3 class="mb-3"> {{ ucfirst(__('laravel-crm::lang.meetings')) }}</h3>
            @if($meetings && $meetings->count() > 0)
                @foreach($meetings as $meeting)
                    @livewire('meeting',[
                        'meeting' => $meeting
                    ], key($meeting->id))
                @endforeach
            @endif
        </div>
        @if($meetings instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="card-footer">
            <ul class="pagination justify-content-end">
                @if ($meetings->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/meetings?page=' . ($meetings->currentPage() - 1)) }}')">Previous</a>
                    </li>
                @endif
    
                @foreach ($meetings->getUrlRange(1, $meetings->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $meetings->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/meetings?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach
    
                @if ($meetings->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/meetings?page=' . ($meetings->currentPage() + 1)) }}')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </div>
    @endif
    
    </div>




@include('laravel-crm::codification')
