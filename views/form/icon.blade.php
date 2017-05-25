<div class="form-group {!! !$errors->has($errorKey) ?: 'has-error' !!}">

  <label for="{{$id}}" class="col-sm-{{$width['label']}} control-label">{{$label}}</label>

  <div class="col-sm-{{$width['field']}}">

    @include('admin::form.error')

    <div
      class="input-group"
      data-block="field-icon"
      data-options-field-icon='{!! $dataSet !!}'>

      @if ($prepend)
        <span class="input-group-addon">{!! $prepend !!}</span>
      @endif

      <input data-element="field-icon-input" {!! $attributes !!} />

      @if ($append)
        <span class="input-group-addon clearfix">{!! $append !!}</span>
      @endif

    </div>

    @include('admin::form.help-block')

  </div>
</div>