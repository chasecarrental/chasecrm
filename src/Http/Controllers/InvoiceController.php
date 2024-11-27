<?php

namespace VentureDrake\LaravelCrm\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use VentureDrake\LaravelCrm\Http\Requests\StoreInvoiceRequest;
use VentureDrake\LaravelCrm\Http\Requests\UpdateInvoiceRequest;
use VentureDrake\LaravelCrm\Models\Invoice;
use VentureDrake\LaravelCrm\Models\Order;
use VentureDrake\LaravelCrm\Models\Organisation;
use VentureDrake\LaravelCrm\Models\Person;
use VentureDrake\LaravelCrm\Services\InvoiceService;
use VentureDrake\LaravelCrm\Services\OrganisationService;
use VentureDrake\LaravelCrm\Services\PersonService;
use VentureDrake\LaravelCrm\Services\SettingService;
use Mpdf\Mpdf;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\File;
class InvoiceController extends Controller
{
    /**
     * @var SettingService
     */
    private $settingService;

    /**
     * @var PersonService
     */
    private $personService;

    /**
     * @var OrganisationService
     */
    private $organisationService;

    /**
     * @var InvoiceService
     */
    private $invoiceService;

    public function __construct(SettingService $settingService, PersonService $personService, OrganisationService $organisationService, InvoiceService $invoiceService)
    {
        $this->settingService = $settingService;
        $this->personService = $personService;
        $this->organisationService = $organisationService;
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Invoice::resetSearchValue($request);
        $params = Invoice::filters($request);

        if (Invoice::filter($params)->get()->count() < 30) {
            $invoices = Invoice::filter($params)->latest()->get();
        } else {
            $invoices = Invoice::filter($params)->latest()->paginate(30);
        }

        return view('laravel-crm::invoices.index', [
            'invoices' => $invoices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        switch ($request->model) {
            case "person":
                $person = Person::find($request->id);

                break;

            case "organisation":
                $organisation = Organisation::find($request->id);

                break;

            case "order":
                $order = Order::find($request->id);
                $person = $order->person;
                $organisation = $order->organisation;

                break;
        }

        $invoiceTerms = $this->settingService->get('invoice_terms');

        return view('laravel-crm::invoices.create', [
            'person' => $person ?? null,
            'organisation' => $organisation ?? null,
            'order' => $order ?? null,
            'prefix' => $this->settingService->get('invoice_prefix'),
            'number' => (Invoice::latest()->first()->number ?? 1000) + 1,
            'invoiceTerms' => $invoiceTerms,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceRequest $request)
    {

        if ($request->person_name && !$request->person_id) {
            $person = $this->personService->createFromRelated($request);
        } elseif ($request->person_id) {
            $person = Person::find($request->person_id);
        }

        if ($request->organisation_name && !$request->organisation_id) {
            $organisation = $this->organisationService->createFromRelated($request);
        } elseif ($request->organisation_id) {
            $organisation = Organisation::find($request->organisation_id);
        }

        $this->invoiceService->create($request, $person ?? null, $organisation ?? null);

        flash(ucfirst(trans('laravel-crm::lang.invoice_created')))->success()->important();
        return response()->json(["response" => true]);
        // return redirect(route('laravel-crm.invoices.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        if ($invoice->person) {
            $email = $invoice->person->getPrimaryEmail();
            $phone = $invoice->person->getPrimaryPhone();
            $address = $invoice->person->getPrimaryAddress();
        }

        if ($invoice->organisation) {
            $organisation_address = $invoice->organisation->getPrimaryAddress();
        }

        return view('laravel-crm::invoices.show', [
            'invoice' => $invoice,
            'email' => $email ?? null,
            'phone' => $phone ?? null,
            'address' => $address ?? null,
            'organisation_address' => $organisation_address ?? null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        if ($invoice->person) {
            $email = $invoice->person->getPrimaryEmail();
            $phone = $invoice->person->getPrimaryPhone();
        }

        if ($invoice->organisation) {
            $address = $invoice->organisation->getPrimaryAddress();
        }

        return view('laravel-crm::invoices.edit', [
            'invoice' => $invoice,
            'email' => $email ?? null,
            'phone' => $phone ?? null,
            'address' => $address ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        if ($request->person_name && !$request->person_id) {
            $person = $this->personService->createFromRelated($request);
        } elseif ($request->person_id) {
            $person = Person::find($request->person_id);
        }

        if ($request->organisation_name && !$request->organisation_id) {
            $organisation = $this->organisationService->createFromRelated($request);
        } elseif ($request->organisation_id) {
            $organisation = Organisation::find($request->organisation_id);
        }

        $invoice = $this->invoiceService->update($request, $invoice, $person ?? null, $organisation ?? null);

        flash(ucfirst(trans('laravel-crm::lang.invoice_updated')))->success()->important();

        return redirect(route('laravel-crm.invoices.show', $invoice));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        flash(ucfirst(trans('laravel-crm::lang.invoice_deleted')))->success()->important();
        return response()->json(["response" => true]);
        //return redirect(route('laravel-crm.invoices.index'));
    }

    public function download_old_1(Invoice $invoice)
    {


        if ($invoice->person) {
            $email = $invoice->person->getPrimaryEmail();
            $phone = $invoice->person->getPrimaryPhone();
            $address = $invoice->person->getPrimaryAddress();
        }

        if ($invoice->organisation) {
            $organisation_address = $invoice->organisation->getPrimaryAddress();
        }

        return Pdf::setOption([
            'fontDir' => public_path('vendor/laravel-crm/fonts'),
        ])->loadView('pdf.invoice', [
                    'invoice' => $invoice,
                    'contactDetails' => $this->settingService->get('invoice_contact_details')->value ?? null,
                    'email' => $email ?? null,
                    'phone' => $phone ?? null,
                    'address' => $address ?? null,
                    'organisation_address' => $organisation_address ?? null,
                    'fromName' => $this->settingService->get('organisation_name')->value ?? null,
                    'logo' => $this->settingService->get('logo_file')->value ?? null
                ])->download('invoice-' . strtolower($invoice->invoice_id) . '.pdf');
    }
    public function download(Invoice $invoice)
    {

        try {
            // Lee el contenido del archivo CSS de Bootstrap line1,city,country,code
            $bootstrapCSS = file_get_contents(public_path('buildVelzon/css/bootstrap.min.css'));
            $appCss = file_get_contents(public_path('buildVelzon/css/app.min.css'));
            $related = $this->settingService->get('team');
            $emails = $related->emails;
            $phones = $related->phones;
            $addresses = $related->addresses;

            if (isset($emails[0])) {
                $empresaEmail = $emails[0]['address'];
            }

            if (isset($phones[0])) {
                $phone_empresa = $phones[0]['number'];
            }
            if (isset($addresses[0])) {
                $address_empresa = $addresses[0]["line1"];
                $city_empresa = $addresses[0]["city"];
                $country_empresa = $addresses[0]["country"];
                $zipCode_empresa = $addresses[0]["code"];
            }

            if ($invoice->person) {
                $email = $invoice->person->getPrimaryEmail();
                $phone = $invoice->person->getPrimaryPhone();
                $address = $invoice->person->getPrimaryAddress();
            }

            if ($invoice->organisation) {
                $organisation_address = $invoice->organisation->getPrimaryAddress();
            }

            $logoPath = public_path($this->settingService->get('logo_file')->value);
            $logoBase64 = base64_encode(File::get($logoPath));
            // Carga la vista de la factura en una variable


            $html = view('pdf.invoice', [
                'invoice' => $invoice,
                'contactDetails' => $this->settingService->get('invoice_contact_details')->value ?? null,
                'email' => $email ?? null,
                'phone' => $phone ?? null,
                'address' => $address ?? null,
                'organisation_address' => $organisation_address ?? null,
                'fromName' => $this->settingService->get('organisation_name')->value ?? null,
                'logoBase64' => $logoBase64, // Envía la imagen como base64 a la vista
                'empresa_email' => $empresaEmail ?? null,
                'empresa_phone' => $phone_empresa ?? null,
                'empresa_address' => $address_empresa ?? null,
                'empresa_city' => $city_empresa ?? null,
                'empresa_country' => $country_empresa ?? null,
                'empresa_zipCode' => $zipCode_empresa ?? null,
                'tax_rate' => $this->settingService->get('tax_rate')->value ?? null
            ])->render();

            // Configura DomPDF
            $dompdf = new Dompdf();
            $dompdf->set_option('isHtml5ParserEnabled', true); // Habilita el uso de CSS en línea

            // Aplica los estilos de Bootstrap (en línea)
            $htmlWithBootstrap = '<style>' . $appCss . '</style>' . '<style>' . $bootstrapCSS . '</style>' . $html;
            $dompdf->loadHtml($htmlWithBootstrap);

            // Genera el PDF
            $dompdf->render();

            // Descarga el PDF
            return $dompdf->stream('invoice.pdf');

        } catch (\Exception $e) {
            // Maneja cualquier excepción
            return response()->json(['error' => 'Error al generar el PDF' . $e], 500);
        }
    }
    public function download_show(Invoice $invoice)
    {

        try {
            $related = $this->settingService->get('team');
            $emails = $related->emails;
            $phones = $related->phones;
            $addresses = $related->addresses;

            if (isset($emails[0])) {
                $empresaEmail = $emails[0]['address'];
            }

            if (isset($phones[0])) {
                $phone_empresa = $phones[0]['number'];
            }
            if (isset($addresses[0])) {
                $address_empresa = $addresses[0]["line1"];
                $city_empresa = $addresses[0]["city"];
                $country_empresa = $addresses[0]["country"];
                $zipCode_empresa = $addresses[0]["code"];
                $line_1 = $addresses[0]["line1"];
            }

            if ($invoice->amount_paid == $invoice->total) {
                // Si no se debe nada, la factura está pagada.
                $status = "translation.paid";
                $status_color = "success";

            } else if ($invoice->amount_paid > 0 && $invoice->amount_paid < $invoice->total) {
                // Si se debe algo pero es menor al total, entonces es un pago parcial.
                $status = "translation.partialPayment";
                $status_color = "warning";

            } else {
                // Si se debe el total o más, se considera pendiente de pago. 
                // Este último caso cubre la condición de monto igual al total y cualquier situación inesperada.
                $status = "translation.pendingPayment";
                $status_color = "danger";

            }

            if ($invoice->person) {
                $email = $invoice->person->getPrimaryEmail();
                $phone = $invoice->person->getPrimaryPhone();
                $address = $invoice->person->getPrimaryAddress();
            }

            if ($invoice->organisation) {

                $tax_id = $invoice->organisation->tax_id;
                $organisation_address = $invoice->organisation->getPrimaryAddress();
                $billing_address = $invoice->organisation->getBillingAddress();

                if (!$billing_address) {
                    $billing_address = $organisation_address;
                }

                $shipping_address = $invoice->organisation->getShippingAddress();
                if (!$shipping_address) {
                    $shipping_address = $billing_address;
                }
            }
            $invoice_terms = $this->settingService->get('invoice_terms')->value;


            return view('invoices-details', [
                'empresa_name' => $this->settingService->get('organisation_name')->value ?? null,
                'vat_number' => $this->settingService->get('vat_number')->value ?? null,
                'invoice' => $invoice,
                'contactDetails' => $this->settingService->get('invoice_contact_details')->value ?? null,
                'email' => $email ?? null,
                'phone' => $phone ?? null,
                'address' => $address ?? null,
                'organisation_address' => $organisation_address ?? null,
                'billing_address' => $billing_address ?? null,
                'shipping_address' => $shipping_address ?? null,
                'fromName' => $this->settingService->get('organisation_name')->value ?? null,
                'logo' => $this->settingService->get('logo_file')->value, // Envía la imagen como base64 a la vista
                'empresa_email' => $empresaEmail ?? null,
                'empresa_phone' => $phone_empresa ?? null,
                'empresa_address' => $address_empresa ?? null,
                'empresa_city' => $city_empresa ?? null,
                'empresa_country' => $country_empresa ?? null,
                'empresa_zipCode' => $zipCode_empresa ?? null,
                'empresa_line_1' => $line_1 ?? null,
                'tax_rate' => $this->settingService->get('tax_rate')->value ?? null,
                'invoice_terms' => $invoice_terms,
                'paymentStatus' => $status,
                'paymentStatusColor' => $status_color,
                'tax_id' => $tax_id ?? null
            ]);



        } catch (\Exception $e) {
            // Maneja cualquier excepción
            return response()->json(['error' => 'Error al generar el PDF' . $e], 500);
        }
    }
    public function duplicate(Invoice $invoice)
    {
        $dateformat = $this->settingService->get('date_format');
        if ($invoice->person_name && !$invoice->person_id) {
            $person = $this->personService->createFromRelated($invoice);
        } elseif ($invoice->person_id) {
            $person = Person::find($invoice->person_id);
        }

        if ($invoice->organisation_name && !$invoice->organisation_id) {
            $organisation = $this->organisationService->createFromRelated($invoice);
        } elseif ($invoice->organisation_id) {
            $organisation = Organisation::find($invoice->organisation_id);
        }

        $invoiceLines = $invoice->invoiceLines()->get();
        $this->invoiceService->duplicate($invoice, $person ?? null, $organisation ?? null, $invoiceLines, $dateformat);

        flash(ucfirst(trans('laravel-crm::lang.invoice_created')))->success()->important();
        return response()->json(["response" => true]);
        //return redirect(route('laravel-crm.invoices.index'));


    }

}
