<input
  type="text"
  class="form-control"
  placeholder="{{ $placeholder }}"
  name="{{ $name }}"
  value="{{ request($name, $value) }}"
  {!! $attributes !!}>
