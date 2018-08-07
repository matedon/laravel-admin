<!-- Main Footer -->
<footer class="main-footer">
  <!-- To the right -->
  <div class="pull-right hidden-xs">
    <strong>Version</strong>
    {{ composer_json('version') }}
  </div>
  <!-- Default to the left -->
  <strong>
    Powered by
    <a href="{{ composer_json('homepage') }}" target="_blank">
      {{ composer_json('name') }}
    </a>
  </strong>
</footer>