<div>
    <h6 class="text-uppercase section-h6-title">
        <span class="fa fa-cart-arrow-down" aria-hidden="true"></span>  {{ ucfirst(__('laravel-crm::lang.invoice_lines')) }}
        <span class="float-right">
            <button type="button" class="btn btn-outline-secondary btn-sm" wire:click.prevent="add({{ $i }})">
                <span class="fa fa-plus" aria-hidden="true"></span>
            </button>
        </span>
    </h6>
    <hr class="mb-0" />
    <script type="text/javascript">
         products =  {!! \VentureDrake\LaravelCrm\Http\Helpers\AutoComplete\productsSelect2() !!}
    </script>
    <span id="invoiceLines">
        <div class="row mt-3">
            <div class="col-4">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'sub_total',
                     'label' => ucfirst(__('laravel-crm::lang.sub_total')),
                     'type' => 'number',
                     'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                    
                     'attributes' => [
                     
                         'wire:model' => 'sub_total',
                         'step' => .01,
                         'readonly' => 'readonly'
                     ]
                  ])
            </div>
            <div class="col-4">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'tax',
                    'label' => ucfirst(__('laravel-crm::lang.tax')),
                    'type' => 'number',
                    'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                   
                    'attributes' => [
                        
                        'wire:model' => 'tax',
                        'step' => .01,
                        'readonly' => 'readonly'
                    ]
                    ])
            </div>
            <div class="col-4">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'total',
                    'label' => ucfirst(__('laravel-crm::lang.total')),
                    'type' => 'number',
                    'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                   
                    'attributes' => [
                       
                        'wire:model' => 'total',
                        'step' => .01,
                        'readonly' => 'readonly'
                    ]
                    ])
            </div>
        </div>
        <hr>
        <div id="linesProducts">
            @foreach($inputs as $key => $value)
                @php
                    //info("EL VALOR DEL INPUT ES: ".$value);
                @endphp
                @include('laravel-crm::invoice-lines.partials.fields')
            @endforeach
        </div>
      
    </span>

<!--  @script

    <script>
           
        
          
           
            window.addEventListener('addedItem', event => {
                setTimeout(function() {
                    if($('meta[name=dynamic_products]').length > 0){
                    var tags = JSON.parse($('meta[name=dynamic_products]').attr('content'));
                }else{
                    var tags = true;
                }

                var selectProduct = $("#select_invoiceLines\\[" + event.detail[0].id + "\\]\\[product_id\\]");

               selectProduct.select2({
                    data: products
                }).select2('open')
                    .on('change', function (e) {
                        $wire.set('product_id.' + $(this).data('value'), $(this).val());
                        $wire.set('name.' + $(this).data('value'), $(this).find("option:selected").text());
                        
                        $wire.dispatch('loadInvoiceLineDefault', { id: $(this).val() });
                    });

                    
                }, 5000); // Esperar 500 milisegundos antes de ejecutar el bloque de código
            });

            setTimeout(() => {
                var selectProduct = $("#select_invoiceLines\\[1\\]\\[product_id\\]");

                selectProduct.select2({
                    data: products
                }).select2('open')
                    .on('change', function (e) {
                        $wire.set('product_id.' + $(this).data('value'), $(this).val());
                        $wire.set('name.' + $(this).data('value'), $(this).find("option:selected").text());
                        
                        $wire.dispatch('loadInvoiceLineDefault', { id: $(this).val() });
                    });
            }, 700); // Esperar 500 milisegundos antes de ejecutar el bloque de código

            window.addEventListener('reInitInputs', event => {
                setTimeout(function() {
                    // Recorremos el objeto en lugar de asumir que es un array
                    for (const key in event.detail[0].inputs) {
                        if (event.detail[0].inputs.hasOwnProperty(key)) {
                            let input = event.detail[0].inputs[key]; // Este es el valor actual del input

                            // Selecciona el producto correspondiente usando el ID del input
                            var selectProduct = $("#select_invoiceLines\\[" + key + "\\]\\[product_id\\]");

                            // Inicializa el select2 con los productos
                            selectProduct.select2({
                                data: products // Asegúrate de que 'products' esté disponible con los datos correctos
                            }).val(event.detail[0].product[key]).trigger('change') // Abre el select
                            .on('change', function (e) {
                                // Actualiza los valores en Livewire cuando se cambia la selección
                                $wire.set('product_id.' + $(this).data('value'), $(this).val());
                                $wire.set('name.' + $(this).data('value'), $(this).find("option:selected").text());

                                // Despacha otro evento para cargar los detalles de la línea de factura
                                $wire.dispatch('loadInvoiceLineDefault', { id: $(this).val() });
                            });
                        }
                    }
                }, 700); // Espera 500ms antes de ejecutar el bloque de código
            });



       
    </script>
    
    @endscript-->  
</div>