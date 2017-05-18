<div class="has-many-{{ $column }}-form fields-group">

  {!! $content !!}

  <div class="form-group">
    <label class="col-sm-{{ $width['label'] }} control-label"></label>
    <div class="col-sm-{{ $width['field'] }}">
      <div class="remove btn btn-warning btn-sm pull-right">
        <i class="fa fa-fw fa-lg fa-trash"></i>
        {{ trans('admin::lang.remove') }}
      </div>
    </div>
  </div>
  <hr>
</div>