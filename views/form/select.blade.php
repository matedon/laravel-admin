<div class="form-group {!! !$errors->has($errorKey) ?: 'has-error' !!}">

  <label for="{{ $id }}" class="col-sm-{{ $width['label'] }} control-label">
    {{ $label }}
  </label>

  <div class="col-sm-{{ $width['field'] }}">

    @include('admin::form.error')
    <div
      class="input-group"
      data-block="field-select"
      data-options-field-select='{!! $dataSet !!}'>

      @if ($prepend)
        <span class="input-group-addon">{!! $prepend !!}</span>
      @endif

      <select
        data-element="field-select-input"
        class="form-control {{ $class }}" style="width: 100%;"
        name="{{$name}}" {!! $attributes !!}>
        @foreach($options as $select => $option)
          <option value="{{ $select }}"
            {{ $select == $value ? 'selected' : '' }}>
            {{ $option }}
          </option>
        @endforeach
      </select>

      @if ($append)
        <span class="input-group-addon clearfix">{!! $append !!}</span>
      @endif

      <input
        data-element="field-select-keeper"
        type="hidden" name="{{ $name }}" value="{{ $value }}">
    </div>


    @include('admin::form.help-block')

  </div>
</div>
