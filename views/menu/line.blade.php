<span>
  <i class="fa fa-lg fa-fw {{ $branch['icon'] }}"></i>
  <strong>{{ $branch['title'] }}</strong>
  @if (!isset($branch['children']))
    (<a href="{{ admin_url($branch['uri']) }}" class="dd-nodrag">
      {{ $branch['uri'] }}
    </a>)
  @endif
</span>
