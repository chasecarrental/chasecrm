<div class="form-group @error($name) text-danger @enderror">
    @isset($label)
    <label for="{{ $name }}[]">{{ $label }}@isset($required)<span class="required-label"> *</span>@endisset</label>
    @endisset
    
    @isset($prepend)
    <div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroupPrepend">{!! $prepend !!}</span>
    </div>
    @endisset
    
    <select id="select_{{ $name }}" name="{{ $name }}" class="form-control custom-select select2 @error($name) is-invalid @enderror" @include('laravel-crm::partials.form.attributes')>
        @foreach($options as $country)
            <option value="{{ $country['id'] }}" {{ ((isset($value) && $value == $country['id'])) ? 'selected' : null }}>
                {{ $country['name'] }}
            </option>
        @endforeach    
    </select>
    
    @isset($prepend)
    </div>
    @endisset
    
    @error($name)
    <div class="text-danger invalid-feedback-custom">{{ $message }}</div>
    @enderror
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });
    });
</script>
