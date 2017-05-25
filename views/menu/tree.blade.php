<div
  class="box"
  data-block="menu-tree"
  data-options-menu-tree='{!! $dataSet !!}'>

  <div class="box-header">

    <div class="btn-group">
      <a class="btn btn-primary btn-sm"
         data-element="menu-tree__expand">
        <i class="fa fa-lg fa-fw fa-plus-square-o"></i>
        {{ trans('admin::lang.expand') }}
      </a>
      <a class="btn btn-primary btn-sm"
         data-element="menu-tree__collapse">
        <i class="fa fa-lg fa-fw fa-minus-square-o"></i>
        {{ trans('admin::lang.collapse') }}
      </a>
    </div>

    <div class="btn-group">
      <a class="btn btn-info btn-sm"
         data-element="menu-tree__save">
        <i class="fa fa-lg fa-fw fa-save"></i>
        {{ trans('admin::lang.save') }}
      </a>
    </div>

    <div class="btn-group">
      <a class="btn btn-warning btn-sm"
         data-element="menu-tree__refresh">
        <i class="fa fa-lg fa-fw fa-refresh"></i>
        {{ trans('admin::lang.refresh') }}
      </a>
    </div>

    @if($useCreate)
      <div class="btn-group pull-right">
        <a class="btn btn-success btn-sm" href="{{ $path }}/create">
          <i class="fa fa-lg fa-fw fa-save"></i>
          {{ trans('admin::lang.new') }}
        </a>
      </div>
    @endif

  </div>

  <div class="box-body table-responsive no-padding">
    <div
      class="dd"
      data-element="menu-tree__nestable">
      <ol class="dd-list">
        @each($branchView, $items, 'branch')
      </ol>
    </div>
  </div>

</div>