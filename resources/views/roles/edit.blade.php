
@include('laravel-crm::layouts.partials.meta')

    @include('laravel-crm::styles') 
    @php
        $roleEdit = $role;
    @endphp
      <script>
        
        roleId = @json($roleEdit);
        roleId = roleId.id;
     
    </script>
    <div class="card">
        <div class="card-header">
            @include('laravel-crm::layouts.partials.nav-settings')
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="roles" role="tabpanel">
                    <h3 class="mb-3">{{ ucfirst(__('laravel-crm::lang.edit_role')) }}: {{ $role->name }} <span class="float-right">
                            <a type="button" class="btn btn-outline-secondary btn-sm" href="#" onclick="loadContent('{{ url(route('laravel-crm.roles.index')) }}')"><span class="fa fa-angle-double-left"></span> {{ ucfirst(__('laravel-crm::lang.back_to_roles')) }}</a>
                        </span></h3>
                    @include('rol.rol')
                </div>
            </div>
        </div>
      
    </div>

    @include('laravel-crm::codification') 