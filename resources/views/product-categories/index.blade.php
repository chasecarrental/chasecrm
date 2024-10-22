
@include('laravel-crm::layouts.partials.meta')

    @include('laravel-crm::styles') 

    <div class="card">
        <div class="card-header">
            @include('laravel-crm::layouts.partials.nav-settings')
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="roles" role="tabpanel">
                    <h3 class="mb-3"> {{ ucfirst(__('laravel-crm::lang.product_categories')) }}  @can('create crm product categories')<span class="float-right"><a type="button" class="btn btn-primary btn-sm" href="#" onclick="loadContent('{{ url(route('laravel-crm.product-categories.create')) }}')"><span class="fa fa-plus"></span>  {{ ucfirst(__('laravel-crm::lang.add_product_category')) }}</a></span>@endcan</h3>
                    <div class="table-responsive">
                        <table class="table mb-0 card-table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">{{ ucfirst(__('laravel-crm::lang.name')) }}</th>
                                <th scope="col">{{ ucfirst(__('laravel-crm::lang.products')) }}</th>
                                <th scope="col">{{ ucfirst(__('laravel-crm::lang.created')) }}</th>
                                <th scope="col">{{ ucfirst(__('laravel-crm::lang.updated')) }}</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($productCategories as $productCategory)
                                <tr class="has-link" data-url="{{ url(route('laravel-crm.product-categories.show',$productCategory)) }}">
                                    <td>{{ $productCategory->name }}</td>
                                    <td>{{ $productCategory->products->count() }}</td>
                                    <td>{{ $productCategory->created_at->format($dateFormat) }}</td>
                                    <td>{{ $productCategory->updated_at->format($dateFormat) }}</td>
                                    <td class="disable-link text-right">
                                        @can('view crm product categories')
                                        <a href="#" onclick="loadContent('{{  route('laravel-crm.product-categories.show', $productCategory) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-eye" aria-hidden="true"></span></a>
                                        @endcan
                                        @can('edit crm product categories')
                                            <a href="#" onclick="loadContent('{{  route('laravel-crm.product-categories.edit', $productCategory) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a>
                                        @endcan
                                        @can('delete crm product categories')
                                        <form id="deleteProductCategoriesForm_{{ $productCategory->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteProductCategoriesForm_{{ $productCategory->id }}', '{{ route('laravel-crm.product-categories.destroy', $productCategory) }}', '{{ __('Deleted successfully!') }}', '{{ route('laravel-crm.product-categories.index') }}')">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.product_category') }}"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        @if($productCategories instanceof \Illuminate\Pagination\LengthAwarePaginator )
            @component('laravel-crm::components.card-footer')
                <ul class="pagination justify-content-end">
                    @if ($productCategories->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/productCategories?page=' . ($productCategories->currentPage() - 1)) }}')">Previous</a>
                        </li>
                    @endif

                    @foreach ($productCategories->getUrlRange(1, $productCategories->lastPage()) as $page => $url)
                        <li class="page-item @if ($page == $productCategories->currentPage()) active @endif">
                            <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/productCategories?page=' . $page) }}')">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($productCategories->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/productCategories?page=' . ($productCategories->currentPage() + 1)) }}')">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>
            @endcomponent
        @endif
    </div>

    @include('laravel-crm::codification') 
