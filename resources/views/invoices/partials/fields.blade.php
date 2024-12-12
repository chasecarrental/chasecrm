<div class="row">
    {{--
    <div class="col-sm-5 border-right">
        @include('laravel-crm::partials.form.hidden',[
             'name' => 'order_id',
             'value' => old('order_id', $invoice->order->id ?? $order->id ?? null),
        ])
        <span class="autocomplete">
             @include('laravel-crm::partials.form.hidden',[
               'name' => 'person_id',
               'value' => old('person_id', $invoice->person->id ?? $person->id ?? null),
            ])
            <script type="text/javascript">
                 people =  {!! \VentureDrake\LaravelCrm\Http\Helpers\AutoComplete\people() !!}
            </script>
            @include('laravel-crm::partials.form.text',[
               'name' => 'person_name',
               'label' => ucfirst(__('laravel-crm::lang.contact_person')),
               'prepend' => '<span class="fa fa-user" aria-hidden="true"></span>',
               'value' => old('person_name', $invoice->person->name ?? $person->name ?? null),
               'attributes' => [
                  'autocomplete' => \Illuminate\Support\Str::random()
               ],
               'required' => 'true'
            ])
        </span>
        <span class="autocomplete">
            @include('laravel-crm::partials.form.hidden',[
              'name' => 'organisation_id',
              'value' => old('organisation_id', $invoice->organisation->id ?? $organisation->id ??  null),
            ])
            <script type="text/javascript">
                 organisations = {!! \VentureDrake\LaravelCrm\Http\Helpers\AutoComplete\organisations() !!}
            </script>
            @include('laravel-crm::partials.form.text',[
                'name' => 'organisation_name',
                'label' => ucfirst(__('laravel-crm::lang.organization')),
                'prepend' => '<span class="fa fa-building" aria-hidden="true"></span>',
                'value' => old('organisation_name',$invoice->organisation->name ?? $organisation->name ?? null),
                'attributes' => [
                  'autocomplete' => \Illuminate\Support\Str::random()
               ],
               'required' => 'true'
            ])
             <script type="text/javascript">
                $(document).ready(function() {
                    // Asumiendo que el ID de tu input es 'input_organisation_name'
                    $("#input_organisation_name").on('blur', function() {
                        // Obtiene el valor ingresado por el usuario
                        var nombreOrganizacionIngresado = $(this).val().trim();
            
                        // Verifica si el nombre ingresado existe en los nombres de las organizaciones
                        // Asume que 'organisations' es un objeto donde las claves son nombres de organización
                        var existe = Object.keys(organisations).includes(nombreOrganizacionIngresado);
            
                        if (existe) {
                            console.log("La organización existe.");
                            var orgId = organisations[nombreOrganizacionIngresado];
                        
                            // Simula la selección de la organización
                            // Asumiendo que tienes una función onSelectOrganisation que maneja la selección
                            simulateOrganisationSelection(orgId);
    
                            // Adicionalmente, si necesitas realizar acciones como si el usuario hubiera elegido la organización...
                            
                          
                        } else {
                            console.log("La organización no existe o no ha sido seleccionada correctamente.");
                          
                        }
                    });
                    function simulateOrganisationSelection(orgId) {
                     
                        // Establece el valor de 'organisation_id' basado en el ID de la organización encontrada
                        $('input[name="organisation_id"]').val(orgId).trigger('change');
    
                        // Aquí podrías agregar más lógica, como deshabilitar campos si es necesario
                        $('.autocomplete-organisation').find('input, select').attr('disabled', 'disabled');
                        $('.autocomplete-organisation').find('.autocomplete-new').hide();
    
                        // Simular la obtención y muestra de información adicional de la organización mediante AJAX
                        $.ajax({
                            url: '/crm/organisations/' + orgId + '/autocomplete', // Asegúrate de ajustar esta URL a tu API real
                            cache: false
                        }).done(function(data) {
                            // Actualiza los campos con la información de la organización obtenida
                            // Asegúrate de que los nombres de los campos aquí coincidan con los tuyos
                            $('.autocomplete-organisation').find('input[name="line1"]').val(data.address_line1);
                            $('.autocomplete-organisation').find('input[name="line2"]').val(data.address_line2);
                            // Continúa actualizando otros campos según sea necesario...
                        }).fail(function() {
                            console.log("Error al recuperar información de la organización");
                        });
                    }
                    
                });
            </script>   
        </span>
        <div class="row">
            <div class="col-sm-6">
                @include('laravel-crm::partials.form.text',[
                      'name' => 'reference',
                      'label' => ucfirst(__('laravel-crm::lang.reference')),
                      'value' => old('reference', $invoice->reference ?? $order->reference ?? null)
                  ])
            </div>
            <div class="col-sm-6">
                @include('laravel-crm::partials.form.select',[
                     'name' => 'currency',
                     'label' => ucfirst(__('laravel-crm::lang.currency')),
                     'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\currencies(),
                     'value' => old('currency', $invoice->currency ?? $order->currency ?? \VentureDrake\LaravelCrm\Models\Setting::currency()->value ?? 'USD')
                 ])
           
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                @include('laravel-crm::partials.form.text',[
                      'name' => 'issue_date',
                      'label' => ucfirst(__('laravel-crm::lang.issue_date')),
                      'value' => old('issue_date', (isset($invoice->issue_date)) ? \Carbon\Carbon::parse($invoice->issue_date)->format($dateFormat) : null),
                       'attributes' => [
                         'autocomplete' => \Illuminate\Support\Str::random()
                       ],
                       'required' => 'true'
                  ])
            </div>
            <div class="col-sm-6">
                @include('laravel-crm::partials.form.text',[
                       'name' => 'due_date',
                       'label' => ucfirst(__('laravel-crm::lang.due_date')),
                       'value' => old('due_date', (isset($invoice->due_date)) ? \Carbon\Carbon::parse($invoice->due_date)->format($dateFormat) : null),
                       'attributes' => [
                         'autocomplete' => \Illuminate\Support\Str::random()
                       ],
                       'required' => 'true'
                   ])
            </div>
        </div>
        @include('laravel-crm::partials.form.textarea',[
             'name' => 'terms',
             'label' => ucfirst(__('laravel-crm::lang.terms')),
             'rows' => 5,
             'value' => old('terms', $invoice->terms ?? $invoiceTerms->value ??  null)
        ])
       
    </div> --}}
    <div class="col-sm-7">
        @livewire('invoice-lines',[
            'invoice' => $invoice ?? null,
            'invoiceLines' => $invoice->invoiceLines ?? $order->orderProducts ?? null,
            'old' => old('invoiceLines'),
            'fromOrder' => (isset($order)) ? $order : false
        ])
    </div>
</div>
