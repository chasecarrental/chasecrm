<div class="row justify-content-end mt-1">
    <div class="col">
        @if(!$fromOrder)
        
        <span style="position: absolute;top:13%; right: 5px;">
            <button type="button" class="btn btn-outline-danger btn-sm btn-close" wire:click.prevent="remove({{ $value }})"></button>
        </span>
        @endif    
    </div>
</div>
<span wire:ignore>
    @if($fromOrder)

        @include('laravel-crm::partials.form.hidden',[
            'name' => 'invoiceLines['.$value.'][product_id]',
            'attributes' => [
               'wire:model' => 'product_id.'.$value,
            ]
        ])

        @include('laravel-crm::partials.form.text',[
           'name' => 'invoiceLines['.$value.'][name]',
           'label' => ucfirst(__('laravel-crm::lang.name')),
           'attributes' => [
               'wire:model' => 'name.'.$value,
               'readonly' => 'readonly'
           ]
       ])

    @else
    @php
        // Imprimir valores con info()
        info('Value: '.$value);
        info('Product ID: '.json_encode($this->product_id[$value] ?? null));
        info('Product Name: '.json_encode($this->name[$value] ?? null));
    @endphp
        @include('laravel-crm::partials.form.select',[
            'name' => 'invoiceLines['.$value.'][product_id]',
            'label' => ucfirst(__('laravel-crm::lang.name')),
            'options' => [
                $this->product_id[$value] ?? null => $this->name[$value] ?? null, // Solo una opción por ahora
            ],
            'value' => $this->product_id[$value] ?? null, // Aseguramos que el valor por defecto sea correcto
            'attributes' => [
                'id' =>'select_invoiceLines_'.$value, // ID único para cada select
                'data-value' => $value // Este valor es para ayudar a depuración o JS
            ]
        ])
    
    @endif
</span>
<div class="row mt-2">
    
        <div class="col-4 border-0 pt-0">
            @if($fromOrder)
                
                    @include('laravel-crm::partials.form.text',[
                        'name' => 'invoiceLines['.$value.'][price]',
                        'label' => ucfirst(__('laravel-crm::lang.price')),
                        'type' => 'number',
                        'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                        'attributes' => [
                            'wire:model' => 'price.'.$value,
                            'wire:change' => 'calculateAmounts()',
                            'step' => .01,
                            'readonly' => 'readonly'
                        ]
                    ])
            
            
            @else
                @include('laravel-crm::partials.form.text',[
                'name' => 'invoiceLines['.$value.'][price]',
                'label' => ucfirst(__('laravel-crm::lang.price')),
                'type' => 'number',
                'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                'attributes' => [
                    'wire:model' => 'price.'.$value,
                    'wire:change' => 'calculateAmounts()',
                    'step' => .01
                ]
                ])

            

            @endif
        </div>
        <div class="col-4 border-0 pt-0">
            @if($fromOrder)
                @include('laravel-crm::partials.form.select',[
                    'name' => 'invoiceLines['.$value.'][quantity]',
                    'label' => ucfirst(__('laravel-crm::lang.quantity')),
                    'options' => $this->order_quantities[$value],
                    'value' => $this->quantity[$value] ?? null,
                    'attributes' => [
                        'wire:model' => 'quantity.'.$value,
                        'data-value' => $value,
                        'wire:change' => 'calculateAmounts()'
                    ]
                ])
            @else
              
                @include('laravel-crm::partials.form.text',[
                    'name' => 'invoiceLines['.$value.'][quantity]',
                    'label' => ucfirst(__('laravel-crm::lang.quantity')),
                    'type' => 'number',
                    'attributes' => [
                        'wire:model' => 'quantity.'.$value,
                        'wire:change' => 'calculateAmounts()'
                    ]
                ])
            @endif
        </div>
        <div class="col-4 border-0 pt-0">
            @include('laravel-crm::partials.form.text',[
                'name' => 'invoiceLines['.$value.'][amount]',
                 'label' => ucfirst(__('laravel-crm::lang.amount')),
                 'type' => 'number',
                 'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                 'attributes' => [
                     'wire:model' => 'amount.'.$value,
                     'step' => .01,
                     'readonly' => 'readonly'
                 ]
             ])
        </div>
   
</div>

<div>
    @if($fromOrder)
            @include('laravel-crm::partials.form.text',[
               'name' => 'invoiceLines['.$value.'][comments]',
               'label' => ucfirst(__('laravel-crm::lang.comments')),
               'attributes' => [
                   'wire:model' => 'comments.'.$value,
                    'readonly' => 'readonly'
               ]
           ])
        @else    
            @include('laravel-crm::partials.form.text',[
               'name' => 'invoiceLines['.$value.'][comments]',
               'label' => ucfirst(__('laravel-crm::lang.comments')),
               'attributes' => [
                   'wire:model' => 'comments.'.$value,
               ]
           ])
       @endif
</div>

