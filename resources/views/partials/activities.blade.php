@livewire('notes', [
'model' => $model,
'pinned' => true
])
<ul class="nav nav-tabs nav-activities">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" id="tab-activity" href="#panel-activities">{{ ucfirst(__('laravel-crm::lang.activity')) }}</a>
    </li>
    @isset($orders)
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" id="tab-orders" href="#panel-orders">{{ ucfirst(__('laravel-crm::lang.orders')) }}</a>
        </li>
    @endisset
    @isset($invoices)
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" id="tab-invoices" href="#panel-invoices">{{ ucfirst(__('laravel-crm::lang.invoices')) }}</a>
        </li>
    @endisset
    @isset($deliveries)
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" id="tab-deliveries" href="#panel-deliveries">{{ ucfirst(__('laravel-crm::lang.deliveries')) }}</a>
        </li>
    @endisset
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" id="tab-notes" href="#panel-notes">{{ ucfirst(__('laravel-crm::lang.notes')) }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" id="tab-tasks" href="#panel-tasks">{{ ucfirst(__('laravel-crm::lang.tasks')) }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" id="tab-calls" href="#panel-calls">{{ ucfirst(__('laravel-crm::lang.calls')) }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" id="tab-meetings" href="#panel-meetings">{{ ucfirst(__('laravel-crm::lang.meetings')) }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" id="tab-lunches" href="#panel-lunches">{{ ucfirst(__('laravel-crm::lang.lunches')) }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" id="tab-files" href="#panel-files">{{ ucfirst(__('laravel-crm::lang.files')) }}</a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="panel-activities">
        <div class="card-body pl-0 pr-0">
            @livewire('activities', ['model' => $model])
        </div>
    </div>
    @isset($orders)
    <div class="tab-pane fade" id="panel-orders">
        <div class="card-body pl-0 pr-0">
            @include('laravel-crm::orders.partials.card-index-related', ['orders' => $orders])
        </div>
    </div>
    @endisset
    @isset($invoices)
    <div class="tab-pane fade" id="panel-invoices">
        <div class="card-body pl-0 pr-0">
            @include('laravel-crm::invoices.partials.card-index-related', ['invoices' => $invoices])
        </div>
    </div>
    @endisset
    @isset($deliveries)
    <div class="tab-pane fade" id="panel-deliveries">
        <div class="card-body pl-0 pr-0">
            @include('laravel-crm::deliveries.partials.card-index-related', ['deliveries' => $deliveries])
        </div>
    </div>
    @endisset
    <div class="tab-pane fade" id="panel-notes">
        <div class="card-body pl-0 pr-0">
            @livewire('notes', ['model' => $model])
        </div>
    </div>
    <div class="tab-pane fade" id="panel-tasks">
        <div class="card-body pl-0 pr-0">
            @livewire('tasks', ['model' => $model])
        </div>
    </div>
    <div class="tab-pane fade" id="panel-calls">
        <div class="card-body pl-0 pr-0">
            @livewire('calls', ['model' => $model])
        </div>
    </div>
    <div class="tab-pane fade" id="panel-meetings">
        <div class="card-body pl-0 pr-0">
            @livewire('meetings', ['model' => $model])
        </div>
    </div>
    <div class="tab-pane fade" id="panel-lunches">
        <div class="card-body pl-0 pr-0">
            @livewire('lunches', ['model' => $model])
        </div>
    </div>
    <div class="tab-pane fade" id="panel-files">
        <div class="card-body pl-0 pr-0">
            @livewire('files', ['model' => $model])
        </div>
    </div>
</div>
