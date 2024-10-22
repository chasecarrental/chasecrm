@if($model->searchValue(request()))
<a type="button" class="btn btn-outline-secondary btn-sm"  href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.'.$route.'.search') }}')" ><span class="fa fa-angle-double-left"></span> {{ ucfirst(__('laravel-crm::lang.back_to_search_results')) }}</a>
@else    
<a type="button" class="btn btn-outline-secondary btn-sm"  href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.'.$route.'.index') }}')"  ><span class="fa fa-angle-double-left"></span> {{ ucfirst(__('laravel-crm::lang.back_to_'.$route)) }}</a>
@endif    