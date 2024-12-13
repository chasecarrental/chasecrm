<?php

namespace VentureDrake\LaravelCrm\Http\Livewire;

use Livewire\Component;
use VentureDrake\LaravelCrm\Models\Product;
use VentureDrake\LaravelCrm\Services\SettingService;
use VentureDrake\LaravelCrm\Traits\NotifyToast;

class LiveInvoiceLines extends Component
{
    use NotifyToast;

    private $settingService;
    public $comments = [];
    public $invoice;
    public $invoiceLines;

    public $order_product_id;
    public $invoice_line_id;

    public $product_id = [];

    public $name = [];

    public $order_quantities;

    public $price = [];

    public $quantity = [];

    public $amount = [];

    public $inputs = [];

    public $i = 0;

    public $sub_total = 0;

    public $tax = 0;

    public $total = 0;

    public $fromOrder;

    public $old;
    public $products;

    protected $listeners = ['loadInvoiceLineDefault'];

    public function boot(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function mount($invoice, $invoiceLines, $old = null, $fromOrder = false)
    {
        $data = [];

        foreach (Product::all() as $product) {
            $data[$product->name] = $product->id;
        }
        info($data);
        $this->products = $data;
        $this->invoice = $invoice;
        $this->invoiceLines = $invoiceLines;
        $this->old = $old;
        $this->fromOrder = $fromOrder;

        if ($this->old) {
            foreach ($this->old as $old) {
                $this->add($this->i);
                $this->order_product_id[$this->i] = $old['order_product_id'] ?? null;
                $this->invoice_line_id[$this->i] = $old['invoice_line_id'] ?? null;
                $this->product_id[$this->i] = $old['product_id'] ?? null;
                $this->name[$this->i] = Product::find($old['product_id'])->name ?? null;
                $this->quantity[$this->i] = $old['quantity'] ?? null;
                $this->comments[$this->i] = $old['comments'] ?? null;
                if ($this->fromOrder) {
                    foreach ($this->invoiceLines as $invoiceLine) {
                        for ($i = 0; $i <= $this->getRemainOrderQuantity($invoiceLine); $i++) {
                            $this->order_quantities[$this->i][$i] = $i;
                        }
                    }
                }

                $this->price[$this->i] = $old['price'] ?? null;
                $this->amount[$this->i] = $old['amount'] ?? null;
            }
        } elseif ($this->invoiceLines && $this->invoiceLines->count() > 0) {

            foreach ($this->invoiceLines as $invoiceLine) {
                $this->add($this->i);

                if ($this->fromOrder) {

                    $this->order_product_id[$this->i] = $invoiceLine->id;
                } else {

                    $this->invoice_line_id[$this->i] = $invoiceLine->id;
                }

                $this->product_id[$this->i] = $invoiceLine->product->id ?? null;
                $this->name[$this->i] = $invoiceLine->product->name ?? null;
                $this->quantity[$this->i] = $invoiceLine->quantity;

                if ($this->fromOrder) {
                    for ($i = 0; $i <= $this->getRemainOrderQuantity($invoiceLine); $i++) {
                        $this->order_quantities[$this->i][$i] = $i;
                        $this->quantity[$this->i] = $i;
                    }
                }

                $this->price[$this->i] = $invoiceLine->price / 100;
                $this->amount[$this->i] = $invoiceLine->amount / 100;
                $this->comments[$this->i] = $invoiceLine->comments;
            }

        } elseif (!$this->fromOrder) {
            $this->add($this->i);
        }

        $this->calculateAmounts();
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        $this->price[$i] = null;
        $this->quantity[$i] = null;
        array_push($this->inputs, $i);

        $this->dispatch('addedItem', ['id' => $this->i]);
        $this->calculateAmounts();
    }

    public function loadInvoiceLineDefault($id)
    {

        if (isset($this->product_id[$this->i])) {

            if ($product = \VentureDrake\LaravelCrm\Models\Product::find($this->product_id[$this->i])) {
                $this->price[$this->i] = ($product->getDefaultPrice()->unit_price / 100);
                $this->quantity[$this->i] = 1;
            } else {
                $this->price[$this->i] = null;
                $this->quantity[$this->i] = null;
                $this->amount[$this->i] = null;
            }
        } else {
            $this->product_id[$this->i] = $id;
            $this->price[$this->i] = null;
            $this->quantity[$this->i] = null;
            $this->amount[$this->i] = null;

        }


        $this->calculateAmounts();
    }
    public function changeTbody()
    {

        $this->showTbody = true;
    }
    public function calculateAmounts()
    {

        $this->sub_total = 0;
        $this->tax = 0;
        $this->total = 0;

        for ($i = 1; $i <= $this->i; $i++) {
            if (isset($this->product_id[$i])) {

                if ($product = \VentureDrake\LaravelCrm\Models\Product::find($this->product_id[$i])) {
                    $taxRate = $product->taxRate->rate ?? $product->tax_rate ?? 0;
                } elseif ($taxRate = $this->settingService->get('tax_rate')) {
                    $taxRate = $taxRate->value;
                } else {
                    $taxRate = 0;
                }


                if (is_numeric($this->price[$i]) && is_numeric($this->quantity[$i])) {

                    $this->amount[$i] = $this->price[$i] * $this->quantity[$i];
                    $this->price[$i] = $this->currencyFormat($this->price[$i]);
                } else {

                    $this->amount[$i] = 0;
                }

                $this->sub_total += $this->amount[$i];
                $this->tax += $this->amount[$i] * ($taxRate / 100);
                $this->amount[$i] = $this->currencyFormat($this->amount[$i]);
            }
        }

        $this->total = $this->sub_total + $this->tax;

        $this->sub_total = $this->currencyFormat($this->sub_total);
        $this->tax = $this->currencyFormat($this->tax);
        $this->total = $this->currencyFormat($this->total);


    }

    public function remove($id)
    {


        $this->i = $this->i - 1;
        if (isset($this->inputs[$id - 1])) {
            // Si existe el índice $id-1, eliminamos ese índice
            unset($this->inputs[$id - 1]);
        } else {
            // Si no existe el índice $id-1, eliminamos $id
            unset($this->inputs[$id]);
        }

        // Eliminar el valor usando el índice ajustado
        unset(
            $this->product_id[$id],
            $this->name[$id],
            $this->price[$id],
            $this->quantity[$id],
            $this->amount[$id],
            $this->comments[$id]
        );

        // Reorganizar las claves y los valores
        $this->inputs = $this->reorganizeValues($this->inputs, true);
        $this->product_id = $this->reorganizeValues($this->product_id, false);
        $this->name = $this->reorganizeValues($this->name, false);
        $this->price = $this->reorganizeValues($this->price, false);
        $this->quantity = $this->reorganizeValues($this->quantity, false);
        $this->amount = $this->reorganizeValues($this->amount, false);
        $this->comments = $this->reorganizeValues($this->comments, false);



        // Recalcular montos si es necesario
        $this->dispatch('reInitInputs', ['inputs' => $this->inputs, "product" => $this->product_id]);

        $this->calculateAmounts();
    }

    /**
     * Función para reorganizar los valores y las claves de un array
     */
    private function reorganizeValues($array, $isInput)
    {
        // Verificar si el valor pasado es un array
        if (!is_array($array)) {
            // Si no es un array, simplemente devolver el valor tal como está
            return $array;
        }
        $newArray = [];
        $index = 1; // Comenzamos desde 1 para que las claves comiencen desde 1

        foreach ($array as $key => $value) {
            if ($isInput) {
                $newArray[$index] = $index; // Reorganizamos tanto clave como valor igual INDEX (es input) 
            } else {
                $newArray[$index] = $value; // Reorganizamos tanto clave como valor
            }

            $index++;
        }

        return $newArray;
    }



    public function testFunction()
    {



        info("cambiando datos del input");
    }
    protected function currencyFormat($number)
    {
        return number_format($number, 2, '.', '');
    }

    public function getRemainOrderQuantity($orderProduct)
    {
        $quantity = $orderProduct->quantity;
        foreach ($this->fromOrder->invoices as $invoice) {
            if ($invoiceProduct = $invoice->invoiceLines()->where('order_product_id', $orderProduct->id)->first()) {
                $quantity -= $invoiceProduct->quantity;
            }
        }

        return $quantity;
    }

    public function render()
    {
        return view('laravel-crm::livewire.invoice-lines');
    }
}
