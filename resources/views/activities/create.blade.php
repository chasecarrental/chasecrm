@include('laravel-crm::layouts.partials.meta')

@include('laravel-crm::styles')

<form method="POST" id="createActivityForm" action="{{ url(route('laravel-crm.activities.store')) }}" onsubmit="submitFormCrm(event, 'createActivityForm', '{{ route('laravel-crm.activities.store') }}', '{{ __('Activity created successfully!') }}', '{{ route('laravel-crm.activities.index') }}')">
    @csrf
    <div class="card">
        <div class="card-header">
            <h3 class="card-title float-left m-0">Create activity</h3>
            <span class="float-right">
                <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.activities.index') }}')" class="btn btn-outline-secondary btn-sm">
                    <span class="fa fa-angle-double-left"></span> Back to activities
                </a>
            </span>
        </div>
        <div class="card-body">
            @include('laravel-crm::activities.partials.fields')
        </div>
        <div class="card-footer">
            <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.activities.index') }}')" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>

@include('laravel-crm::codification')
