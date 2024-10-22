<div class="row">
    <div class="col-sm-6 border-right">
        <div class="row">
            <div class="col-2">
                @include('laravel-crm::partials.form.text',[
                     'name' => 'title',
                     'label' => ucfirst(__('laravel-crm::lang.title')),
                     'value' => old('title', $person->title ?? null)
                 ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                      'name' => 'first_name',
                      'label' => ucfirst(__('laravel-crm::lang.first_name')),
                      'value' => old('first_name', $person->first_name ?? null),
                      'required' => 'true'
                  ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                   'name' => 'last_name',
                   'label' => ucfirst(__('laravel-crm::lang.last_name')),
                   'value' => old('last_name', $person->last_name ?? null)
               ])
            </div>
        </div>
        <div class="row">
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'middle_name',
                    'label' => ucfirst(__('laravel-crm::lang.middle_name')),
                    'value' => old('middle_name', $person->middle_name ?? null)
                ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.select',[
                   'name' => 'gender',
                   'label' => ucfirst(__('laravel-crm::lang.gender')),
                   'options' => [
                       '',
                       'male' => 'Male',
                       'female' => 'Female'
                       ],
                   'value' => old('gender', $person->gender ?? null)
               ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                      'name' => 'birthday',
                      'label' => ucfirst(__('laravel-crm::lang.birthday')),
                      'value' => old('birthday', $person->birthday ?? null),
                      'attributes' => [
                          'autocomplete' => \Illuminate\Support\Str::random()
                       ]
                  ])
            </div>
        </div>
        <!-- New Fields -->
        <div class="row">
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'document_national',
                    'label' => ucfirst(__('translation.document_national')),
                    'value' => old('document_national', $person->document_national ?? null)
                ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'document_passport',
                    'label' => ucfirst(__('translation.document_passport')),
                    'value' => old('document_passport', $person->document_passport ?? null)
                ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'document_driving_license',
                    'label' => ucfirst(__('translation.document_driving_license')),
                    'value' => old('document_driving_license', $person->document_driving_license ?? null)
                ])
            </div>
        </div>
        <div class="row">
            <div class="col">
                @include('laravel-crm::partials.form.newSelect',[
                    'name' => 'document_national_country',
                    'label' => ucfirst(__('translation.document_national_country')),
                    'options' => $countries, // Assuming $countries is an array of country options passed to the view
                    'value' => old('document_national_country', $person->document_national_country ?? null)
                ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.newSelect',[
                    'name' => 'document_passport_country',
                    'label' => ucfirst(__('translation.document_passport_country')),
                    'options' => $countries,
                    'value' => old('document_passport_country', $person->document_passport_country ?? null)
                ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.newSelect',[
                    'name' => 'document_driving_license_country',
                    'label' => ucfirst(__('translation.document_driving_license_country')),
                    'options' => $countries,
                    'value' => old('document_driving_license_country', $person->document_driving_license_country ?? null)
                ])
            </div>
        </div>
        <div class="row">
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'document_national_issued',
                    'label' => ucfirst(__('translation.document_national_issued')),
                    'value' => old('document_national_issued', $person->document_national_issued ?? null),
                    'attributes' => [
                        'autocomplete' => \Illuminate\Support\Str::random()
                     ]
                ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'document_passport_issued',
                    'label' => ucfirst(__('translation.document_passport_issued')),
                    'value' => old('document_passport_issued', $person->document_passport_issued ?? null),
                    'attributes' => [
                        'autocomplete' => \Illuminate\Support\Str::random()
                     ]
                ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'document_driving_license_issued',
                    'label' => ucfirst(__('translation.document_driving_license_issued')),
                    'value' => old('document_driving_license_issued', $person->document_driving_license_issued ?? null),
                    'attributes' => [
                        'autocomplete' => \Illuminate\Support\Str::random()
                     ]
                ])
            </div>
        </div>
        <div class="row">
            <div class="col">
    
                @include('laravel-crm::partials.form.text',[
                    'name' => 'document_national_expiration',
                    'label' => ucfirst(__('translation.document_national_expiration')),
                    'value' => old('document_national_expiration', $person->document_national_expiration ?? null),
                    'attributes' => [
                        'autocomplete' => \Illuminate\Support\Str::random()
                     ]
                ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'document_passport_expiration',
                    'label' => ucfirst(__('translation.document_passport_expiration')),
                    'value' => old('document_passport_expiration', $person->document_passport_expiration ?? null),
                    'attributes' => [
                        'autocomplete' => \Illuminate\Support\Str::random()
                     ]
                ])
            </div>
            <div class="col">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'document_driving_license_expiration',
                    'label' => ucfirst(__('translation.document_driving_license_expiration')),
                    'value' => old('document_driving_license_expiration', $person->document_driving_license_expiration ?? null),
                    'attributes' => [
                        'autocomplete' => \Illuminate\Support\Str::random()
                     ]
                ])
            </div>
        </div>
        
        @include('laravel-crm::partials.form.textarea',[
           'name' => 'description',
           'label' => ucfirst(__('laravel-crm::lang.description')),
           'rows' => 5,
           'value' => old('description', $person->description ?? null) 
        ])
        @include('laravel-crm::partials.form.multiselect',[
            'name' => 'labels',
            'label' => ucfirst(__('laravel-crm::lang.labels')),
            'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\optionsFromModel(\VentureDrake\LaravelCrm\Models\Label::all(), false),      
            'value' =>  old('labels', (isset($person)) ? $person->labels->pluck('id')->toArray() : null)
        ])
        @include('laravel-crm::partials.form.select',[
         'name' => 'user_owner_id',
         'label' => ucfirst(__('laravel-crm::lang.owner')),
         'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\users(false),
         'value' =>  old('user_owner_id', $person->user_owner_id ?? auth()->user()->id),
       ])
    </div>
    <div class="col-sm-6">
        @livewire('phone-edit', [
        'phones' => $phones ?? null,
        'old' => old('phones')
        ])
        
        @livewire('email-edit', [
        'emails' => $emails ?? null,
        'old' => old('emails')
        ])

        @livewire('address-edit', [
        'addresses' => $addresses ?? null,
        'old' => old('addresses')
        ])
    </div>
</div>