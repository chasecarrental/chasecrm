<div class="row justify-content-end mt-1">
    <div class="col">
      
        
        <span style="position: absolute;top:13%; right: 5px;">
            <button type="button" class="btn btn-outline-danger btn-sm btn-close" wire:click.prevent="remove({{ $value }})"></button>
        </span>
       
    </div>
</div>



<span wire:ignore>
    @include('laravel-crm::partials.form.select',[
        'name' => 'products['.$value.'][product_id]',
        'label' => ucfirst(__('laravel-crm::lang.name')),
        'options' => [
            $this->product_id[$value] ?? null => $this->name[$value] ?? null,
        ],
        'value' => $this->product_id[$value] ?? null,
        'attributes' => [
            'id' =>'select_quoteItems_'.$value,
          
            'data-value' => $value
        ]
    ])
</span>

<div class="row mt-2">
    
    <div class="col-4 border-0 pt-0">
        
        @include('laravel-crm::partials.form.text',[
            'name' => 'products['.$value.'][unit_price]',
            'label' => ucfirst(__('laravel-crm::lang.price')),
            'type' => 'number',
            'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
            'attributes' => [
                'wire:model' => 'unit_price.'.$value,
                'wire:change' => 'calculateAmounts',
                'step' => .01
            ]
        ])

        

    </div>
    <div class="col-4 border-0 pt-0">
       
          
        @include('laravel-crm::partials.form.text',[
            'name' => 'products['.$value.'][quantity]',
            'label' => ucfirst(__('laravel-crm::lang.quantity')),
            'type' => 'number',
            'attributes' => [
                'wire:model' => 'quantity.'.$value,
                'wire:change' => 'calculateAmounts'
            ]
        ])
       
    </div>
    <div class="col-4 border-0 pt-0">
        @include('laravel-crm::partials.form.text',[
            'name' => 'products['.$value.'][amount]',
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
    @include('laravel-crm::partials.form.text',[
        'name' => 'products['.$value.'][comments]',
        'label' => ucfirst(__('laravel-crm::lang.comments')),
        'attributes' => [
            'wire:model' => 'comments.'.$value,
        ]
    ])
</div>

