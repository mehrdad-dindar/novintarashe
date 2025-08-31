@php
    $config = config("general.supported_gateways.{$gateway->key}");
@endphp

<div class="row">
    <div class="form-group col-md-12">
        <fieldset class="checkbox">
            <div class="vs-checkbox-con vs-checkbox-primary">
                <input type="checkbox"
                       data-gateway="{{ $gateway->id }}"
                       name="gateways[{{ $gateway->id }}][is_active]"
                    {{ old("gateways.{$gateway->id}.is_active", $gateway->is_active) ? 'checked' : '' }}>

                <span class="vs-checkbox">
                    <span class="vs-checkbox--check">
                        <i class="vs-icon feather icon-check"></i>
                    </span>
                </span>
                <span>{{ $config['label'] ?? $gateway->name }}</span>
            </div>
        </fieldset>
    </div>

    <div class="col-md-2 form-group">
        <label>ترتیب نمایش</label>
        <input type="number"
               name="gateways[{{ $gateway->id }}][ordering]"
               class="form-control ltr {{ $gateway->key }}"
               data-parent="{{ $gateway->id }}"
               value="{{ old("gateways.{$gateway->id}.ordering", $gateway->ordering) }}">
    </div>

    <div class="col-md-4 form-group">
        <label>عنوان</label>
        <input type="text"
               name="gateways[{{ $gateway->id }}][name]"
               class="form-control {{ $gateway->key }}"
               data-parent="{{ $gateway->id }}"
               value="{{ old("gateways.{$gateway->id}.name", $gateway->name) }}">
    </div>
    @foreach($config['fields'] ?? [] as $field => $label)
        <div class="col-md-4 form-group">
            <label>{{ $label }}</label>
            <input type="text"
                   name="gateways[{{ $gateway->id }}][configs][{{ $field }}]"
                   data-parent="{{ $gateway->id }}"
                   class="form-control ltr {{ $gateway->key }}"
                   value="{{ old("gateways.{$gateway->id}.configs.$field", $gateway->config($field)) }}"
                   required>
        </div>
    @endforeach
</div>
