<?php

namespace VentureDrake\LaravelCrm\Http\Livewire;

use Livewire\Component;

class LivePhoneEdit extends Component
{
    public $phones;
    public $number = [];
    public $type = [];
    public $primary = [];
    public $phoneId = [];
    public $old;
    public $updateMode = false;
    public $inputs = [];
    public $i = 0;

    public function mount($phones, $old)
    {
        $this->phones = $phones;
        $this->old = $old;

        if ($this->old) {
            foreach ($this->old as $phone) {
                $this->add($this->i);
                $this->number[$this->i] = $phone['number'] ?? null;
                $this->type[$this->i] = $phone['type'] ?? null;
                if(isset($phone['primary']) && $phone['primary'] === 0){
                    $this->primary[$this->i] = false;
                }elseif(isset($phone['primary'])){
                    $this->primary[$this->i] = true;
                }else{
                    $this->primary[$this->i] = false;
                }
                
                $this->phoneId[$this->i] = $phone['id'] ?? null;
            }
        } elseif ($this->phones && $this->phones->count() > 0) {
            foreach ($this->phones as $phone) {
                $this->add($this->i);
                $this->number[$this->i] = $phone->number;
                $this->type[$this->i] = $phone->type;
                if($phone->primary === 0){
                    $this->primary[$this->i] = false;
                }else{
                    $this->primary[$this->i] = true;
                }
              
                $this->phoneId[$this->i] = $phone->id;
            }
        } else {
            $this->add($this->i);
        }
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
        $this->dispatch('addPhoneInputs');
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function render()
    {
        return view('laravel-crm::livewire.phone-edit');
    }

    private function resetInputFields()
    {
        $this->number = '';
        $this->type = '';
        $this->primary = 0;
        $this->phoneId = '';
    }
}
