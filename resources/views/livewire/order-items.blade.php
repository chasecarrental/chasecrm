<div>
    <h6 class="text-uppercase section-h6-title"><span class="fa fa-cart-arrow-down" aria-hidden="true"></span> {{ ucfirst(__('laravel-crm::lang.order_items')) }} 
        @if(!$fromQuote)
        <span class="float-right">
            <button class="btn btn-outline-secondary btn-sm" wire:click.prevent="add({{ $i }})">
                <span class="fa fa-plus" aria-hidden="true">
                </span>
            </button>
        </span>
        @endif
    </h6>
    <hr class="mb-0" />
    <script type="text/javascript">
         products =  {!! \VentureDrake\LaravelCrm\Http\Helpers\AutoComplete\productsSelect2() !!}
    </script>
    <span id="orderTotal">
        <div class="row mt-3">
            <div class="col-3">
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
            <div class="col-3">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'discount',
                    'label' => ucfirst(__('laravel-crm::lang.discount')),
                     'type' => 'number',
                    'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                     'attributes' => [
                         'wire:model' => 'discount',
                         'step' => .01,
                         'readonly' => 'readonly'
                     ]
                  ])
            </div>
            <div class="col-3">
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
            <div class="col-3">
                @include('laravel-crm::partials.form.text',[
                    'name' => 'adjustment',
                    'label' => ucfirst(__('laravel-crm::lang.adjustment')),
                     'type' => 'number',
                     'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                     'attributes' => [
                         'wire:model' => 'adjustment',
                         'step' => .01,
                         'readonly' => 'readonly'
                     ]
                  ])
            </div>
        </div>
        <div class="row mt-2">
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
        
        
    </span>

    <div id="orderProducts">
        @foreach($inputs as $key => $value)
            @include('laravel-crm::order-products.partials.fields')
        @endforeach
    </div>

    @script
    <script>
        // Elimina el listener 'addedItem' si ya existe
        window.removeEventListener('addedItem', () => {});
    
        // Agrega el listener para 'addedItem'
        window.addEventListener('addedItem', event => {
            setTimeout(function() {
                let tags;
                if ($('meta[name=dynamic_products]').length > 0) {
                    tags = JSON.parse($('meta[name=dynamic_products]').attr('content'));
                } else {
                    tags = true;
                }
    
                let selectProduct = $("#select_products\\[" + event.detail[0].id + "\\]\\[product_id\\]");
    
                selectProduct.select2({
                    data: products
                }).select2('open')
                    .on('change', function (e) {
                        try {
                            $wire.set('product_id.' + $(this).data('value'), $(this).val());
                            $wire.set('name.' + $(this).data('value'), $(this).find("option:selected").text());
                            $wire.dispatch('loadItemDefault', { id: $(this).data('value') });
                        } catch (error) {
                            console.error("Error en el evento 'addedItem' al intentar interactuar con $wire:", error);
                        }
                    });
            }, 500); // Esperar 500 milisegundos antes de ejecutar el bloque de código
        });
    
        // Configura el primer selectProduct con un retardo de 500ms
        setTimeout(() => {
            let selectProduct = $("#select_products\\[1\\]\\[product_id\\]");
    
            selectProduct.select2({
                data: products
            }).select2('open')
                .on('change', function (e) {
                    try {
                        $wire.set('product_id.' + $(this).data('value'), $(this).val());
                        $wire.set('name.' + $(this).data('value'), $(this).find("option:selected").text());
                        $wire.dispatch('loadItemDefault', { id: $(this).data('value') });
                    } catch (error) {
                        console.error("Error en el setTimeout al intentar interactuar con $wire:", error);
                    }
                });
        }, 500);
    </script>
    @endscript
</div>
