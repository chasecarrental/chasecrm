<div class="row">
    <div class="col-sm-6 border-right">
        @include('laravel-crm::partials.form.text',[
          'name' => 'name',
          'label' => ucfirst(__('laravel-crm::lang.name')),
          'value' => old('name', $user->name ?? null),
          'required' => 'true'
        ])
        @include('laravel-crm::partials.form.text',[
          'name' => 'email',
          'label' => ucfirst(__('laravel-crm::lang.email')),
          'value' => old('email', $user->email ?? null),
          'required' => 'true'
        ])
        @include('laravel-crm::partials.form.password',[
          'name' => 'password',
          'label' => ucfirst(__('laravel-crm::lang.password')),
          'value' => old('password'),
          'required' => 'true'
        ])
        @include('laravel-crm::partials.form.password',[
          'name' => 'password_confirmation',
          'label' => ucfirst(__('laravel-crm::lang.confirm_password')),
          'value' => old('password_confirmation'),
          'required' => 'true'
        ])
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="crm_access" name="crm_access" 
                   {{ (isset($user) && ($user->crm_access == 1 || $user->isCrmOwner())) ? 'checked' : null }}
                   {{ (isset($user) && $user->isCrmOwner()) ? 'disabled' : null }}>
            <label class="form-check-label" for="crm_access">{{ ucfirst(__('laravel-crm::lang.CRM_access')) }}</label>
        </div>
        @if(isset($user) && $user->isCrmOwner())
            @include('laravel-crm::partials.form.select',[
               'name' => 'role',
               'label' => ucfirst(__('laravel-crm::lang.CRM_role')),
               'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\optionsFromModel(VentureDrake\LaravelCrm\Models\Role::crm()->when(config('laravel-crm.teams'), function ($query) {
                    return $query->where('team_id', auth()->user()->currentTeam->id);
                })->get()),
               'value' => old('role', ($user->roles()->first()->id ?? null) ?? null),
               'attributes' => [
                   'disabled' => 'disabled'
               ]
            ])
        @else
            @include('laravel-crm::partials.form.select',[
                'name' => 'role',
                'label' => ucfirst(__('laravel-crm::lang.CRM_role')),
                'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\optionsFromModel(VentureDrake\LaravelCrm\Models\Role::crm()->when(config('laravel-crm.teams'), function ($query) {
                    return $query->where('team_id', auth()->user()->currentTeam->id);
                })->get()),
                'value' => old('role', ((isset($user)) ? ($user->roles()->first()->id ?? null) : null)),
            ]) 
        @endif
        
        @if(Auth::user()->hasRole('Administrador'))
            <div class="form-group mt-2">
                {{ Form::label('location', 'Ubicación') }}
                {{ Form::select('location', $locations, $user->location, ['class' => 'form-control' . ($errors->has('location') ? ' is-invalid' : '')]) }}
                {!! $errors->first('location', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        @endif

        @hasteamsenabled
        <h6 class="text-uppercase mt-4 section-h6-title">{{ ucfirst(__('laravel-crm::lang.teams')) }}</h6>
        <hr>
        @include('laravel-crm::partials.form.multiselect',[
            'name' => 'user_teams',
            'label' => null,
            'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\optionsFromModel($teams, null),
            'value' => old('user_teams', (isset($user)) ? $user->crmTeams()->orderBy('name','ASC')->get()->pluck('id')->toArray() : null)
        ])
        @endhasteamsenabled

        <div class="d-flex justify-content-between align-items-center mt-4">
            <h6 class="text-uppercase section-h6-title mb-0">Ubicaciones</h6>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="all_locations" name="all_locations" 
                       {{ (isset($user) && ($user->all_locations)) ? 'checked' : null }}>
                <label class="form-check-label" for="all_locations">Todas</label>
            </div>
        </div>
        <hr>        
        @include('laravel-crm::partials.form.multiselect',[
            'name' => 'user_locations',
            'label' => null,
            'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\optionsFromModel($offices, null),
            'value' => old('user_locations', (isset($user)) ? $user->locations()->orderBy('location_name','ASC')->get()->pluck('id')->toArray() : null)
        ])
    </div>
    <div class="col-sm-6">
        @livewire('phone-edit', [
        'phones' => $phones ?? null,
        'old' => old('phones')
        ])

        @livewire('address-edit', [
        'addresses' => $addresses ?? null,
        'old' => old('addresses')
        ])
    </div>
</div>