<form method="POST" id="editUserForm" action="{{ url(route('laravel-crm.users.update', $user)) }}" onsubmit="submitFormCrm(event,'editUserForm', '{{ url(route('laravel-crm.users.update', $user)) }}', '{{ __('User updated successfully!') }}', '{{ url(route('laravel-crm.users.index')) }}')">
    @csrf
    @method('PUT')
    @component('laravel-crm::components.card')

        @component('laravel-crm::components.card-header')

            @slot('title')
                {{ ucfirst(__('laravel-crm::lang.edit_user')) }}
            @endslot

            @slot('actions')
                <span class="float-right">
                    <a type="button" class="btn btn-outline-secondary btn-sm" href="javascript:void(0)" onclick="loadContent('{{ url(route('laravel-crm.users.index')) }}')">
                        <span class="fa fa-angle-double-left"></span> {{ ucfirst(__('laravel-crm::lang.back_to_users')) }}
                    </a>
                </span>
            @endslot

        @endcomponent

        @component('laravel-crm::components.card-body')

            @include('laravel-crm::users.partials.fields')

        @endcomponent

        @component('laravel-crm::components.card-footer')
            <a href="javascript:void(0)" onclick="loadContent('{{ url(route('laravel-crm.users.index')) }}')" class="btn btn-outline-secondary">
                {{ ucfirst(__('laravel-crm::lang.cancel')) }}
            </a>
            <button type="submit" class="btn btn-primary">
                {{ ucwords(__('laravel-crm::lang.save_changes')) }}
            </button>
        @endcomponent

    @endcomponent
</form>
