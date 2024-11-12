<div>
    <h6 class="text-uppercase section-h6-title"><span class="fa fa-cart-arrow-down" aria-hidden="true"></span> {{ ucfirst(__('laravel-crm::lang.quote_items')) }} 
        <span class="float-right">
            <button class="btn btn-outline-secondary btn-sm" wire:click.prevent="add({{ $i }})">
                <span class="fa fa-plus" aria-hidden="true">
                </span>
            </button>
        </span>
    </h6>
    <hr class="mb-0" />
    <script type="text/javascript">
         products =  {!! \VentureDrake\LaravelCrm\Http\Helpers\AutoComplete\productsSelect2() !!}
    </script>
    <span id="quoteProducts"> 
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
        <div class="row mt-3">
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

        <div id="quoteProducts">
            @foreach($inputs as $key => $value)
                @include('laravel-crm::quote-products.partials.fields')
            @endforeach
        </div>
    </span>


    @script
    <script>
         window.removeEventListener('addedItem', () => {});

        $(document).ready(function () {
          
            window.addEventListener('addedItem', event => {
                setTimeout(function() {
                    if($('meta[name=dynamic_products]').length > 0){
                    var tags = JSON.parse($('meta[name=dynamic_products]').attr('content'));
                }else{
                    var tags = true;
                }

                var selectProduct = $("#select_products\\[" + event.detail[0].id + "\\]\\[product_id\\]");

               selectProduct.select2({
                    data: products
                }).select2('open')
                    .on('change', function (e) {
                        $wire.set('product_id.' + $(this).data('value'), $(this).val());
                        $wire.set('name.' + $(this).data('value'), $(this).find("option:selected").text());
                        
                        $wire.dispatch('loadItemDefault', { id: $(this).data('value') });
                    });

                    
                }, 500); // Esperar 500 milisegundos antes de ejecutar el bloque de código
            });
            setTimeout(() => {
                var selectProduct = $("#select_products\\[1\\]\\[product_id\\]");

                selectProduct.select2({
                    data: products
                }).select2('open')
                    .on('change', function (e) {
                        $wire.set('product_id.' + $(this).data('value'), $(this).val());
                        $wire.set('name.' + $(this).data('value'), $(this).find("option:selected").text());
                        
                        $wire.dispatch('loadItemDefault', { id: $(this).data('value') });
                    });
            }, 500);

        });
    </script>
    @endscript


</div>