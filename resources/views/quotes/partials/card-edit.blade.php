<form id="quoteEditForm_{{ $quote->id }}" method="POST" action="{{ url(route('laravel-crm.quotes.update', $quote)) }}" 
    onsubmit="submitFormCrm(event, 'quoteEditForm_{{ $quote->id }}', '{{ route('laravel-crm.quotes.update', $quote) }}', 'Quote updated successfully!', '{{ route('laravel-crm.quotes.show', $quote) }}')">
  @csrf
  @method('PUT')
  @component('laravel-crm::components.card')

      @component('laravel-crm::components.card-header')

          @slot('title')
              {{ ucfirst(__('laravel-crm::lang.edit_quote')) }}
          @endslot

          @slot('actions')
              @include('laravel-crm::partials.return-button',[
                  'model' => $quote,
                  'route' => 'quotes'
              ])
          @endslot

      @endcomponent

      @component('laravel-crm::components.card-body')

          @include('laravel-crm::quotes.partials.fields')

      @endcomponent

      @component('laravel-crm::components.card-footer')
          <a href="javascript:void(0)" onclick="loadContent('{{ route('laravel-crm.quotes.index') }}')" class="btn btn-outline-secondary">{{ ucfirst(__('laravel-crm::lang.cancel')) }}</a>
          <button type="submit" class="btn btn-primary">{{ ucwords(__('laravel-crm::lang.save_changes')) }}</button>
      @endcomponent

  @endcomponent
</form>
