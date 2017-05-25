@if(Admin::user()->visible($item['roles']))
  @if(!isset($item['children']))
    <li>
      <a href="{{ Admin::url($item['uri']) }}">
        <i class="fa fa-lg fa-fw {{$item['icon']}}"></i>
        &nbsp;
        <span>{{admin_translate('menu', $item['title'], $item['title'])}}</span>
      </a>
    </li>
  @else
    <li class="treeview">
      <a href="#">
        <i class="fa fa-lg fa-fw {{$item['icon']}}"></i>
        &nbsp;
        <span>{{$item['title']}}</span>
        <i class="fa fa-lg fa-fw fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        @foreach($item['children'] as $item)
          @include('admin::partials.menu', $item)
        @endforeach
      </ul>
    </li>
  @endif
@endif