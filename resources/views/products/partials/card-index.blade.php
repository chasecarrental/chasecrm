@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ ucfirst(__('laravel-crm::lang.products')) }}
        @endslot
    
        @slot('actions')
            @can('create crm products')
            <span class="float-right"><a type="button" class="btn btn-primary btn-sm" href="#" onclick="loadContent('{{ url(route('laravel-crm.products.create')) }}')"><span class="fa fa-plus"></span> {{ ucfirst(__('laravel-crm::lang.add_product')) }}</a></span>
            @endcan
        @endslot

    @endcomponent

    @component('laravel-crm::components.card-table')

        <table class="table mb-0 card-table table-hover">
            <thead>
            <tr>
                <th scope="col" colspan="2">{{ ucfirst(__('laravel-crm::lang.name')) }}</th>
                <th scope="col">{{ ucfirst(__('laravel-crm::lang.code')) }}</th>
                <th scope="col">{{ ucfirst(__('laravel-crm::lang.category')) }}</th>
                <th scope="col">{{ ucfirst(__('laravel-crm::lang.unit')) }}</th>
                <th scope="col">{{ ucfirst(__('laravel-crm::lang.price')) }} ({{ \VentureDrake\LaravelCrm\Models\Setting::currency()->value ?? 'USD' }})</th>
                <th scope="col">{{ ucfirst(__('laravel-crm::lang.tax')) }}</th>
                <th scope="col">{{ ucfirst(__('laravel-crm::lang.tax_rate')) }}</th>
                <th scope="col">{{ ucfirst(__('laravel-crm::lang.active')) }}</th>
                <th scope="col">{{ ucfirst(__('laravel-crm::lang.owner')) }}</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr class="has-link" data-url="{{ url(route('laravel-crm.products.show',$product)) }}">
                    <td>{{ $product->name }}</td>
                    <td>@if($product->xeroItem)<img src="/vendor/laravel-crm/img/xero-icon.png" height="20" />@endif</td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->productCategory->name ?? null }}</td>
                    <td>{{ $product->unit }}</td>
                    <td>{{ (isset($product->getDefaultPrice()->unit_price)) ? money($product->getDefaultPrice()->unit_price ?? null, $product->getDefaultPrice()->currency) : null }}</td>
                    <td>{{ $product->taxRate->name ?? null }}</td>
                    <td>{{ $product->tax_rate ?? $product->taxRate->rate ?? 0 }}%</td>
                    <td>{{ ($product->active == 1) ? 'YES' : 'NO' }}</td>
                    <td>{{ $product->ownerUser->name ?? null }}</td>
                    <td class="disable-link text-right">
                        @can('view crm products')
                        <a href="#" onclick="loadContent('{{  route('laravel-crm.products.show',$product) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-eye" aria-hidden="true"></span></a>
                        @endcan
                        @can('edit crm products')
                        <a href="#" onclick="loadContent('{{  route('laravel-crm.products.edit',$product) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a>
                        @endcan
                        @can('delete crm products')    
                        <form id="deleteProductForm_{{ $product->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteProductForm_{{ $product->id }}', '{{ route('laravel-crm.clients.destroy', $product) }}', '{{ __('Client deleted successfully!') }}', '{{ route('laravel-crm.clients.index') }}')">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.product') }}"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
                        </form>
                        @endcan    
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        
    @endcomponent
    
    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator )
        @component('laravel-crm::components.card-footer')
            <ul class="pagination justify-content-end">
                @if ($products->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/products?page=' . ($products->currentPage() - 1)) }}')">Previous</a>
                    </li>
                @endif

                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    <li class="page-item @if ($page == $products->currentPage()) active @endif">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/products?page=' . $page) }}')">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($products->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/products?page=' . ($products->currentPage() + 1)) }}')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                @endif
            </ul>
        @endcomponent
    @endif
@endcomponent    