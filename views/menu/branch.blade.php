<li class="dd-item" data-id="{{ $branch[$keyName] }}">
  <div class="dd-handle">
    {!! $branchCallback($branch) !!}
    <span class="pull-right dd-nodrag">
      <div class="btn-group btn-group" role="group" style="display: flex">
        <a
          class="btn btn-xs btn-primary"
          href="{{ $path }}/{{ $branch[$keyName] }}/edit">
          <i class="fa fa-lg fa-fw fa-edit"></i>
        </a>
        <a
          href="javascript:void(0);"
          class="btn btn-xs btn-danger"
          data-element="menu-tree__delete">
          <i class="fa fa-lg fa-fw fa-trash"></i>
        </a>
      </div>
    </span>
  </div>
  @if(isset($branch['children']))
    <ol class="dd-list">
      @foreach($branch['children'] as $branch)
        @include($branchView, $branch)
      @endforeach
    </ol>
  @endif
</li>