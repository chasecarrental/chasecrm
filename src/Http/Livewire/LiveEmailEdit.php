<?php

namespace VentureDrake\LaravelCrm\Http\Livewire;

use Livewire\Component;

class LiveEmailEdit extends Component
{
    public $emails;
    public $address = [];
    public $type = [];
    public $primary = [];
    public $emailId = [];
    public $old;
    public $updateMode = false;
    public $inputs = [];
    public $i = 0;

    public function mount($emails, $old)
    {
        $this->emails = $emails;
        $this->old = $old;
     
        if ($this->old) {
          
            foreach ($this->old as $email) {
                $this->add($this->i);
                $this->address[$this->i] = $email['address'] ?? null;
                $this->type[$this->i] = $email['type'] ?? null;
                if(isset($email['primary']) && $email['primary'] === 0){
                    $this->primary[$this->i] = false;
                }elseif(isset($email['primary'])){
                    $this->primary[$this->i] = true;
                }else{
                    $this->primary[$this->i] = false;
                }
              
                $this->emailId[$this->i] = $email['id'] ?? null;
            }
        } elseif ($this->emails && $this->emails->count() > 0) {
           
            foreach ($this->emails as $email) {
                $this->add($this->i);
                $this->address[$this->i] = $email->address;
                $this->type[$this->i] = $email->type;
                $this->primary[$this->i] = $email->primary;
                if($email->primary === 0){
                    $this->primary[$this->i] = false;
                }else{
                    $this->primary[$this->i] = true;
                }
                $this->emailId[$this->i] = $email->id;
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
        $this->dispatch('addEmailInputs');
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function render()
    {
        return view('laravel-crm::livewire.email-edit');
    }

    private function resetInputFields()
    {
        $this->address = '';
        $this->type = '';
        $this->primary = 0;
        $this->emailId = '';
    }
}
