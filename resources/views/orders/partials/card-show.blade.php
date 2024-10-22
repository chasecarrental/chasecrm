@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ $order->title }}
        @endslot

        @slot('actions')
            <span class="float-right">
                @include('laravel-crm::partials.return-button',[
                    'model' => $order,
                    'route' => 'orders'
                ]) |
                @can('edit crm orders')
                    @if(! $order->invoiceComplete())
                        @hasinvoicesenabled
                        <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.invoices.create',['model' => 'order', 'id' => $order->id]) }}')" class="btn btn-success btn-sm">{{ ucwords(__('laravel-crm::lang.invoice')) }}</a>
                        @endhasinvoicesenabled
                    @endif
                    @if(! $order->deliveryComplete())
                        @hasdeliveriesenabled
                        <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.deliveries.create',['model' => 'order', 'id' => $order->id]) }}')" class="btn btn-success btn-sm">{{ ucwords(__('laravel-crm::lang.create_delivery')) }}</a>
                        @endhasdeliveriesenabled
                    @endif
                @endcan
                @can('view crm orders')
                    <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.orders.download', $order) }}')" class="btn btn-outline-secondary btn-sm">{{ ucfirst(__('laravel-crm::lang.download')) }}</a>
                @endcan
                @include('laravel-crm::partials.navs.activities') |
                @can('edit crm orders')
                <a href="javascript:void(0)" onclick="loadContent('{{ url(route('laravel-crm.orders.edit', $order)) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a>
                @endcan
                @can('delete crm orders')
                <form id="deleteOrderForm_{{ $order->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteOrderForm_{{ $order->id }}', '{{ route('laravel-crm.orders.destroy', $order) }}', '{{ __('Order deleted successfully!') }}', '{{ route('laravel-crm.orders.index') }}')">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.order') }}"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
                </form>
                @endcan
            </span>
        @endslot

    @endcomponent

    @component('laravel-crm::components.card-body')

        <div class="row card-show card-fa-w30">
            <div class="col-sm-6 border-right">
                <h6 class="text-uppercase">{{ ucfirst(__('laravel-crm::lang.details')) }}</h6>
                <hr />
                <dl class="row">
                    <dt class="col-sm-4 text-right">{{ ucfirst(__('laravel-crm::lang.number')) }}</dt>
                    <dd class="col-sm-8">{{ $order->order_id }}</dd>
                    <dt class="col-sm-4 text-right">Reference</dt>
                    <dd class="col-sm-8">{{ $order->reference }}</dd>
                    @hasquotesenabled
                    @if($order->quote)
                        <dt class="col-sm-4 text-right">{{ ucfirst(__('laravel-crm::lang.quote')) }}</dt>
                        <dd class="col-sm-8"><a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.quotes.show', $order->quote) }}')">{{ $order->quote->quote_id }}</a></dd>
                    @endif
                    @endhasquotesenabled
                    <dt class="col-sm-4 text-right">Description</dt>
                    <dd class="col-sm-8">{{ $order->description }}</dd>
                    @foreach($addresses as $address)
                        <dt class="col-sm-4 text-right">{{ ($address->addressType) ? ucfirst($address->addressType->name).' ' : null }}{{ ucfirst(__('laravel-crm::lang.address')) }}</dt>
                        <dd class="col-sm-8">
                            {{ \VentureDrake\LaravelCrm\Http\Helpers\AddressLine\addressSingleLine($address) }} {{ ($address->primary) ? '(Primary)' : null }}
                        </dd>
                    @endforeach
                    <dt class="col-sm-4 text-right">Labels</dt>
                    <dd class="col-sm-8">@include('laravel-crm::partials.labels',[
                            'labels' => $order->labels
                    ])</dd>
                    <dt class="col-sm-4 text-right">Owner</dt>
                    <dd class="col-sm-8">{{ $order->ownerUser->name ?? null }}</dd>
                </dl>
                <h6 class="mt-4 text-uppercase">{{ ucfirst(__('laravel-crm::lang.client')) }}</h6>
                <hr />
                <p><span class="fa fa-address-card" aria-hidden="true"></span> @if($order->client)<a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.clients.show',$order->client) }}')">{{ $order->client->name }}</a>@endif </p>
                <h6 class="mt-4 text-uppercase">{{ ucfirst(__('laravel-crm::lang.organization')) }}</h6>
                <hr />
                <p><span class="fa fa-building" aria-hidden="true"></span> @if($order->organisation)<a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.organisations.show',$order->organisation) }}')">{{ $order->organisation->name }}</a>@endif</p>
                <p><span class="fa fa-map-marker" aria-hidden="true"></span> {{ ($organisation_address) ? \VentureDrake\LaravelCrm\Http\Helpers\AddressLine\addressSingleLine($organisation_address) : null }} </p>
                <h6 class="mt-4 text-uppercase">{{ ucfirst(__('laravel-crm::lang.contact_person')) }}</h6>
                <hr />
                <p><span class="fa fa-user" aria-hidden="true"></span> @if($order->person)<a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.people.show',$order->person) }}')">{{ $order->person->name }}</a>@endif </p>
                @isset($email)
                    <p><span class="fa fa-envelope" aria-hidden="true"></span> <a href="mailto:{{ $email->address }}">{{ $email->address }}</a> ({{ ucfirst($email->type) }})</p>
                @endisset
                @isset($phone)
                    <p><span class="fa fa-phone" aria-hidden="true"></span> <a href="tel:{{ $phone->number }}">{{ $phone->number }}</a> ({{ ucfirst($phone->type) }})</p>
                @endisset
            </div>
            <div class="col-sm-6">
                @include('laravel-crm::partials.activities', [
                    'model' => $order
                ])
            </div>
        </div>

    @endcomponent

@endcomponent
