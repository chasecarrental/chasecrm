
@include('laravel-crm::styles')
    <div class="card">
        <div class="card-header">
            @include('laravel-crm::layouts.partials.nav-activities')
        </div>
        <div class="card-body">
            <h3 class="mb-3"> {{ ucfirst(__('laravel-crm::lang.lunches')) }}</h3>
            @if($lunches && $lunches->count() > 0)
                @foreach($lunches as $lunch)
                    @livewire('lunch',[
                        'lunch' => $lunch
                    ], key($lunch->id))
                @endforeach
            @endif
        </div>
        @if($lunches instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="card-footer">
            <ul class="pagination justify-content-end">
                @if ($lunches->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/lunches?page=' . ($lunches->currentPage() - 1)) }}')">Previous</a>
                    </li>
                @endif
    
                @foreach ($lunches->getUrlRange(1, $lunches->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $lunches->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/lunches?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach
    
                @if ($lunches->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/lunches?page=' . ($lunches->currentPage() + 1)) }}')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </div>
    @endif
    
    </div>


    @include('laravel-crm::codification')
