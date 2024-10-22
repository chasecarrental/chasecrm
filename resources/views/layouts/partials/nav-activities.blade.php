<ul class="nav nav-tabs card-header-tabs" id="activitiesNav" role="tablist">
    @can('view crm activities')
    <li class="nav-item">
        <a class="nav-link" 
           href="javascript:void(0)" 
           onclick="loadContent('{{ route('laravel-crm.activities.index') }}')" 
           data-url="{{ route('laravel-crm.activities.index') }}" 
           role="tab" 
           aria-controls="activities" 
           aria-selected="true">
            {{ ucwords(__('laravel-crm::lang.activity')) }}
        </a>
    </li>
    @endcan
    @can('view crm activities')
    <li class="nav-item">
        <a class="nav-link" 
           href="javascript:void(0)" 
           onclick="loadContent('{{ route('laravel-crm.notes.index') }}')" 
           data-url="{{ route('laravel-crm.notes.index') }}" 
           role="tab" 
           aria-controls="notes" 
           aria-selected="true">
            {{ ucwords(__('laravel-crm::lang.notes')) }}
        </a>
    </li>
    @endcan
    @can('view crm activities')
    <li class="nav-item">
        <a class="nav-link" 
           href="javascript:void(0)" 
           onclick="loadContent('{{ route('laravel-crm.tasks.index') }}')" 
           data-url="{{ route('laravel-crm.tasks.index') }}" 
           role="tab" 
           aria-controls="tasks" 
           aria-selected="true">
            {{ ucwords(__('laravel-crm::lang.tasks')) }}
        </a>
    </li>
    @endcan
    @can('view crm activities')
    <li class="nav-item">
        <a class="nav-link" 
           href="javascript:void(0)" 
           onclick="loadContent('{{ route('laravel-crm.calls.index') }}')" 
           data-url="{{ route('laravel-crm.calls.index') }}" 
           role="tab" 
           aria-controls="calls" 
           aria-selected="true">
            {{ ucwords(__('laravel-crm::lang.calls')) }}
        </a>
    </li>
    @endcan
    @can('view crm activities')
    <li class="nav-item">
        <a class="nav-link" 
           href="javascript:void(0)" 
           onclick="loadContent('{{ route('laravel-crm.meetings.index') }}')" 
           data-url="{{ route('laravel-crm.meetings.index') }}" 
           role="tab" 
           aria-controls="meetings" 
           aria-selected="true">
            {{ ucwords(__('laravel-crm::lang.meetings')) }}
        </a>
    </li>
    @endcan
    @can('view crm activities')
    <li class="nav-item">
        <a class="nav-link" 
           href="javascript:void(0)" 
           onclick="loadContent('{{ route('laravel-crm.lunches.index') }}')" 
           data-url="{{ route('laravel-crm.lunches.index') }}" 
           role="tab" 
           aria-controls="lunches" 
           aria-selected="true">
            {{ ucwords(__('laravel-crm::lang.lunches')) }}
        </a>
    </li>
    @endcan
    @can('view crm activities')
    <li class="nav-item">
        <a class="nav-link" 
           href="javascript:void(0)" 
           onclick="loadContent('{{ route('laravel-crm.files.index') }}')" 
           data-url="{{ route('laravel-crm.files.index') }}" 
           role="tab" 
           aria-controls="files" 
           aria-selected="true">
            {{ ucwords(__('laravel-crm::lang.files')) }}
        </a>
    </li>
    @endcan
</ul>

<script>

        lastUrlSelected = localStorage.getItem('lastUrl');
      
        if (lastUrlSelected) {
            // Seleccionar todos los enlaces con la clase 'nav-link'
            const navLinks = document.querySelectorAll('#activitiesNav .nav-link');

            // Iterar sobre cada enlace
            navLinks.forEach(link => {
                const linkUrl = link.getAttribute('data-url');
                if (lastUrlSelected === linkUrl) {
                    // Agregar la clase 'active' si la URL coincide
                    link.classList.add('active');
                } else {
                    // Asegurarse de que no tenga la clase 'active' si no coincide
                    link.classList.remove('active');
                }
            });
        }

</script>
