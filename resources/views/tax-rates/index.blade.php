
@include('laravel-crm::layouts.partials.meta')

    @include('laravel-crm::styles') 

    <div class="card">
        <div class="card-header">
            @include('laravel-crm::layouts.partials.nav-settings')
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="roles" role="tabpanel">
                    <h3 class="mb-3"> {{ ucfirst(__('laravel-crm::lang.tax_rates')) }}  @can('create crm tax rates')<span class="float-right"><a type="button" class="btn btn-primary btn-sm" href="#" onclick="loadContent('{{ url(route('laravel-crm.tax-rates.create')) }}')"><span class="fa fa-plus"></span>  {{ ucfirst(__('laravel-crm::lang.add_tax_rate')) }}</a></span>@endcan</h3>
                    <div class="table-responsive">
                        <table class="table mb-0 card-table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">{{ ucfirst(__('laravel-crm::lang.name')) }}</th>
                                <th scope="col">{{ ucfirst(__('laravel-crm::lang.rate')) }}</th>
                                <th scope="col">{{ ucfirst(__('laravel-crm::lang.products')) }}</th>
                                <th scope="col">{{ ucfirst(__('laravel-crm::lang.created')) }}</th>
                                <th scope="col">{{ ucfirst(__('laravel-crm::lang.updated')) }}</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($taxRates as $taxRate)
                                <tr class="has-link" data-url="{{ url(route('laravel-crm.tax-rates.show',$taxRate)) }}">
                                    <td>{{ $taxRate->name }}</td>
                                    <td>{{ $taxRate->rate }}%</td>
                                    <td>{{ $taxRate->products->count() }}</td>
                                    <td>{{ $taxRate->created_at->format($dateFormat) }}</td>
                                    <td>{{ $taxRate->updated_at->format($dateFormat) }}</td>
                                    <td class="disable-link text-right">
                                     @can('view crm tax rates')
                                        <a href="#" onclick="loadContent('{{  route('laravel-crm.tax-rates.show',$taxRate) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-eye" aria-hidden="true"></span></a>
                                        @endcan
                                        @can('edit crm tax rates')
                                            <a href="#" onclick="loadContent('{{  route('laravel-crm.tax-rates.edit',$taxRate) }}')" class="btn btn-outline-secondary btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a>
                                        @endcan
                                        @can('delete crm tax rates')
                                        <form id="deleteTaxRateForm_{{ $taxRate->id }}" method="POST" class="form-check-inline mr-0 form-delete-button" onsubmit="submitFormCrm(event, 'deleteTaxRateForm_{{ $taxRate->id }}', '{{ route('laravel-crm.tax-rates.destroy', $taxRate) }}', '{{ __('Deleted successfully!') }}', '{{ route('laravel-crm.tax-rates.index') }}')">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.tax_rate') }}"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
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

        @if($taxRates instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @component('laravel-crm::components.card-footer')
                <ul class="pagination justify-content-end">
                    @if ($taxRates->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/taxRates?page=' . ($taxRates->currentPage() - 1)) }}')">Previous</a>
                        </li>
                    @endif

                    @foreach ($taxRates->getUrlRange(1, $taxRates->lastPage()) as $page => $url)
                        <li class="page-item @if ($page == $taxRates->currentPage()) active @endif">
                            <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/taxRates?page=' . $page) }}')">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($taxRates->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="javascript:void(0)" onclick="loadContent('{{ url('crm/taxRates?page=' . ($taxRates->currentPage() + 1)) }}')">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled"><span class="page-link">Next</span></li>
                    @endif
                </ul>
            @endcomponent
        @endif
    </div>


    @include('laravel-crm::codification') 
