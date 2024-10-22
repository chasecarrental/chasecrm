@include('laravel-crm::styles')

<div class="card">
    <div class="card-header">
        <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.activities.index') }}')" class="btn btn-link">{{ __('Activities') }}</a>
        @include('laravel-crm::layouts.partials.nav-activities')
    </div>
    <div class="card-body">
        @if($activities && $activities->count() > 0)
            @foreach($activities as $activity)
                <div id="activity_{{ $activity->id }}">
                    @include('laravel-crm::activities.partials.activity', ['activity' => $activity])
                </div>
            @endforeach
        @else
            <p>{{ __('No activities available.') }}</p>
        @endif
    </div>
    @if($activities instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="card-footer">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ $activities->previousPageUrl() }}')">{{ __('Previous') }}</a>
                    </li>
                    @foreach ($activities->getUrlRange(1, $activities->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $activities->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ $url }}')">{{ $page }}</a>
                        </li>
                    @endforeach
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ $activities->nextPageUrl() }}')">{{ __('Next') }}</a>
                    </li>
                </ul>
            </nav>
        </div>
    @endif
</div>

@include('laravel-crm::codification')
