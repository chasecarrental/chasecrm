
@include('laravel-crm::styles')
    <div class="card">
        <div class="card-header">
            @include('laravel-crm::layouts.partials.nav-activities')
        </div>
        <div class="card-body">
            <h3 class="mb-3"> {{ ucfirst(__('laravel-crm::lang.files')) }}</h3>
            @if($files && $files->count() > 0)
                @foreach($files as $file)
                    @livewire('file',[
                        'file' => $file
                    ], key($file->id))
                @endforeach
            @endif
        </div>
        @if($files instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="card-footer">
            <ul class="pagination justify-content-end">
                @if ($files->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/files?page=' . ($files->currentPage() - 1)) }}')">Previous</a>
                    </li>
                @endif
    
                @foreach ($files->getUrlRange(1, $files->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $files->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/files?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach
    
                @if ($files->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/files?page=' . ($files->currentPage() + 1)) }}')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        </div>
    @endif
    
    </div>


    @include('laravel-crm::codification')
