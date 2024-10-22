<div class="row">
    <div class="col-sm-6 border-right">
        @include('laravel-crm::partials.form.text',[
         'name' => 'name',
         'label' => ucfirst(__('laravel-crm::lang.name')),
         'value' => old('name', $team->name ?? null),
         'required' => 'true'
       ])
        @include('laravel-crm::partials.form.text',[
          'name' => 'phone',
          'label' => ucfirst(__('translation.phone')),
          'value' => old('phone', $team->phone ?? null),
          'required' => 'true'
        ])
         @include('laravel-crm::partials.form.text',[
          'name' => 'address',
          'label' => ucfirst(__('translation.address')),
          'value' => old('address', $team->address ?? null),
          'required' => 'true'
        ])
    </div>
    <div class="col-sm-6">
        <h6 class="text-uppercase">{{ ucfirst(__('laravel-crm::lang.users')) }}</h6>
        @include('laravel-crm::partials.form.multiselect',[
        'name' => 'team_users',
        'label' => null,
        'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\optionsFromModel($users, null),
        'value' => old('users', (isset($team)) ? $team->users()->orderBy('name','ASC')->get()->pluck('id')->toArray() : null)
      ])
    </div>
</div>