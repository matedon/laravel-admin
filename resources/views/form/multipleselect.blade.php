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
        data-placeholder="{{ trans('admin::lang.choose') }}"
        name="{{$name}}[]" multiple
        {!! $attributes !!}>
        @foreach($options as $select => $option)
          <option value="{{ $select }}"
            {{ in_array($select, (array)old($column, $value)) ? 'selected' : '' }}>
            {{ $option }}
          </option>
        @endforeach
      </select>

      @if ($append)
        <span class="input-group-addon clearfix">{!! $append !!}</span>
      @endif

      <input type="hidden" name="{{ $name }}[]">
    </div>

    @include('admin::form.help-block')

  </div>
</div>

