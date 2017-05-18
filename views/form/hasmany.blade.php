<div class="row">
  <div class="col-md-{{ $width['label'] }}">
    <h4 class="pull-right">
      {{ $label }}
    </h4>
  </div>
  <div class="col-md-{{ $width['field'] }}"></div>
</div>

<hr style="margin-top: 0px;">

<div id="has-many-{{ $column }}" class="has-many-{{ $column }}">

  <div class="has-many-{{ $column }}-forms">

    @foreach($forms as $form)

      @php($fieldRender = '')
      @foreach($form->fields() as $field)
        @php($fieldRender .= $field->render())
      @endforeach

      @include('admin::form.hasmany-template', ['content' => $fieldRender])

    @endforeach

    @unset($form)
  </div>

  <template class="{{ $column }}-tpl">
    @include('admin::form.hasmany-template', ['content' => $template])
  </template>

  <div class="form-group">
    <label class="col-sm-{{ $width['label'] }} control-label"></label>
    <div class="col-sm-{{ $width['field'] }}">
      <div class="add btn btn-success btn-sm">
        <i class="fa fa-fw fa-lg fa-save"></i>
        {{ trans('admin::lang.new') }}
      </div>
    </div>
  </div>

</div>