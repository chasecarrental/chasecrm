@include('laravel-crm::styles')

<div class="card">
    <div class="card-header">
        <h3 class="card-title float-left m-0">{{ $activity->title }}</h3>
        <span class="float-right">
            <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.activities.index') }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-angle-double-left"></span> Back to activities</a> |
            <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.activities.edit', $activity) }}')" class="btn btn-outline-secondary btn-sm">Edit</a>
            <form id="deleteActivityForm_{{ $activity->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteActivityForm_{{ $activity->id }}', '{{ route('laravel-crm.activities.destroy', $activity) }}', '{{ __('Activity deleted successfully!') }}', '{{ route('laravel-crm.activities.index') }}')">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button class="btn btn-danger btn-sm" type="submit" data-model="activity"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
            </form>
        </span>
    </div>
    <div class="card-body card-show">
        <div class="row">
            <div class="col-sm-6 border-right">
                <!-- Contenido de la primera columna -->
            </div>
            <div class="col-sm-6">
                <!-- Contenido de la segunda columna -->
            </div>
        </div>
    </div>
</div>

@include('laravel-crm::codification')
