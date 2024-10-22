<div class="phone-numbers">
    <h6 class="text-uppercase section-h6-title"><span>{{ ucfirst(__('laravel-crm::lang.phone_numbers')) }}</span> <span class="float-right"><button class="btn btn-outline-secondary btn-sm" wire:click.prevent="add({{$i}})"><span class="fa fa-plus" aria-hidden="true"></span></button></span></h6>
    <hr />
    @foreach($inputs as $key => $value)
        <input type="hidden" wire:model="phoneId.{{ $value }}" name="phones[{{ $value }}][id]">
        <div class="form-row">
            <div class="col-sm-6">
                <div class="form-group @error('phones.'.$value.'.number') text-danger @enderror">
                    <label>{{ ucfirst(__('laravel-crm::lang.phone')) }}</label>
                    <input type="text" class="form-control @error('phones.'.$value.'.number') is-invalid @enderror" wire:model="number.{{ $value }}" name="phones[{{ $value }}][number]">
                    @error('phones.'.$value.'.number') <span class="text-danger invalid-feedback-custom">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group @error('phones.'.$value.'.type') text-danger @enderror">
                    <label>{{ ucfirst(__('laravel-crm::lang.type')) }}</label>
                    <select class="form-control custom-select @error('phones.'.$value.'.type') is-invalid @enderror" wire:model="type.{{ $value }}" name="phones[{{ $value }}][type]">
                        @foreach(\VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\phoneTypes() as $optionKey => $optionName)
                            <option value="{{ $optionKey }}">{{ $optionName }}</option>
                        @endforeach
                    </select>
                    @error('phones.'.$value.'.type') <span class="text-danger invalid-feedback-custom">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-sm-1">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="primaryCheckboxPhone{{ $value }}" wire:model="primary.{{ $value }}" name="phones[{{ $value }}][primary]">
                    <label class="form-check-label" for="primaryCheckboxPhone{{ $value }}">
                        {{ ucfirst(__('laravel-crm::lang.primary')) }}
                    </label>
                </div>
                @error('primary.'.$value) 
                    <div class="text-danger invalid-feedback-custom">{{ $message }}</div>
                @enderror
                <!-- Este div es para separar visualmente el mensaje de error del botón -->
                <div style="margin-top: 10px;">
                    <button class="btn btn-danger btn-sm" wire:click.prevent="remove({{$key}})">
                        <span class="fa fa-trash-o" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
            
        </div>
    @endforeach
    @push('livewire-js')
        <script>
            $(document).ready(function () {
                window.addEventListener('addPhoneInputs', event => {
                    $('input[type=checkbox][data-toggle^=toggle]').bootstrapToggle('destroy').bootstrapToggle('refresh');
                });
            });
        </script>
    @endpush
</div>


