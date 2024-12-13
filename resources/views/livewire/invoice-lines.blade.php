<div>
    <h6 class="text-uppercase section-h6-title">
        <span class="fa fa-cart-arrow-down" aria-hidden="true"></span> {{ ucfirst(__('laravel-crm::lang.invoice_lines')) }}
        <span class="float-right">
            <button type="button" class="btn btn-outline-secondary btn-sm" wire:click.prevent="add({{ $i }})">
                <span class="fa fa-plus" aria-hidden="true"></span>
            </button>
        </span>
    </h6>
    <hr class="mb-0" />
    <script type="text/javascript">
        products = {!! \VentureDrake\LaravelCrm\Http\Helpers\AutoComplete\productsSelect2() !!};
        console.log(products); // Asegúrate de que los productos están correctamente formateados
    </script>
    <span id="invoiceLines">
        <div class="row mt-3">
            <div class="col-4">
                @include('laravel-crm::partials.form.text', [
                    'name' => 'sub_total',
                    'label' => ucfirst(__('laravel-crm::lang.sub_total')),
                    'type' => 'number',
                    'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                    'attributes' => [
                        'wire:model' => 'sub_total',
                        'step' => .01,
                        'readonly' => 'readonly',
                    ]
                ])
            </div>
            <div class="col-4">
                @include('laravel-crm::partials.form.text', [
                    'name' => 'tax',
                    'label' => ucfirst(__('laravel-crm::lang.tax')),
                    'type' => 'number',
                    'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                    'attributes' => [
                        'wire:model' => 'tax',
                        'step' => .01,
                        'readonly' => 'readonly',
                    ]
                ])
            </div>
            <div class="col-4">
                @include('laravel-crm::partials.form.text', [
                    'name' => 'total',
                    'label' => ucfirst(__('laravel-crm::lang.total')),
                    'type' => 'number',
                    'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                    'attributes' => [
                        'wire:model' => 'total',
                        'step' => .01,
                        'readonly' => 'readonly',
                    ]
                ])
            </div>
        </div>
        <hr>
        <div id="linesProducts">
            @foreach ($inputs as $key => $value)
                @include('laravel-crm::invoice-lines.partials.fields')
            @endforeach
        </div>
    </span>

    @script
    <script>
        // Hacer que la función sea global
        window.initializeSelect2 = function (selector, products, wireKey) {
            $(selector).select2({
                data: products
            })
            .on('change', function () {
                const selectedValue = $(this).val();
                const selectedText = $(this).find("option:selected").text();
    
                // Actualizar Livewire
                $wire.set(`product_id.${wireKey}`, selectedValue);
                $wire.set(`name.${wireKey}`, selectedText);
    
                // Despachar evento para cargar detalles
                $wire.dispatch('loadInvoiceLineDefault', { id: selectedValue });
            });
        };
    
        // Inicialización de todos los select existentes al cargar el DOM
        document.addEventListener('DOMContentLoaded', () => {
            $('select[id^="select_invoiceLines"]').each(function () {
                const key = $(this).data('value'); // Obtener índice dinámico
                window.initializeSelect2(this, products, key);
            });
        });
    
        // Listener para nuevos selects añadidos dinámicamente
        window.addEventListener('addedItem', event => {
            const key =  event.detail[0].id; // Índice dinámico del nuevo input
            const selector = `#select_invoiceLines\\[${key}\\]\\[product_id\\]`;
            setTimeout(() => {
                window.initializeSelect2(selector, products, key);
            }, 500);
            
        });
    
        // Listener para reinicializar selects tras un cambio en los inputs
        window.addEventListener('reInitInputs', event => {
            for (const key in event.detail[0].inputs) {
                if (event.detail[0].inputs.hasOwnProperty(key)) {
                    const selector = `#select_invoiceLines\\[${key}\\]\\[product_id\\]`;
    
                    window.initializeSelect2(selector, products, key);
    
                    // Seleccionar valor actual en Livewire
                   // $(selector).val(event.detail[0].product[key]).trigger('change');
                }
            }
        });
    </script>
    
    @endscript
</div>
