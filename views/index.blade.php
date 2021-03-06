<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ Admin::title() }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="{{ asset("/packages/admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
  <!-- Font Awesome -->
  {{--
    <link rel="stylesheet" href="{{ asset("/packages/admin/font-awesome/css/font-awesome.min.css") }}">
  --}}
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  <!-- Theme style -->
  <link rel="stylesheet"
        href="{{ asset("/packages/admin/AdminLTE/dist/css/skins/" . config('admin.skin') .".min.css") }}">

  {!! Admin::css() !!}
  <link rel="stylesheet" href="{{ asset("/packages/admin/nestable/jquery.nestable.css") }}">
  <link rel="stylesheet" href="{{ asset("/packages/admin/toastr/build/toastr.min.css") }}">
  <link rel="stylesheet" href="{{ asset("/packages/admin/bootstrap3-editable/css/bootstrap-editable.css") }}">
  <!--
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,600,600i,700,700&subset=latin-ext">
  -->
  <link rel="stylesheet" href="{{ asset("/packages/admin/google-fonts/Source-Sans-Pro.css") }}">
  <link rel="stylesheet" href="{{ asset("/packages/admin/AdminLTE/dist/css/AdminLTE.min.css") }}">

  <!-- REQUIRED JS SCRIPTS -->
  <script src="{{ asset ("/packages/admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
  <script src="{{ asset ("/packages/admin/AdminLTE/bootstrap/js/bootstrap.min.js") }}"></script>
  <script src="{{ asset ("/packages/admin/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js") }}"></script>
  <script src="{{ asset ("/packages/admin/AdminLTE/dist/js/app.min.js") }}"></script>
  <script src="{{ asset ("/packages/admin/jquery-pjax/jquery.pjax.js") }}"></script>

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body class="hold-transition {{config('admin.skin')}} {{join(' ', config('admin.layout'))}}">
<div class="wrapper">

  @include('admin::partials.header')

  @include('admin::partials.sidebar')

  <div class="content-wrapper" id="pjax-container">
    @yield('content')
    {!! Admin::script() !!}
  </div>

  @include('admin::partials.footer')

</div>

<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset ("/packages/admin/AdminLTE/plugins/chartjs/Chart.min.js") }}"></script>
<script src="{{ asset ("/packages/admin/nestable/jquery.nestable.js") }}"></script>
<script src="{{ asset ("/packages/admin/toastr/build/toastr.min.js") }}"></script>
<script src="{{ asset ("/packages/admin/bootstrap3-editable/js/bootstrap-editable.min.js") }}"></script>

{!! Admin::js() !!}

<script src="{{ asset ("/packages/admin/laravel-admin/scripts/attach.js") }}"></script>
<script src="{{ asset ("/packages/admin/laravel-admin/scripts/display/switch.js") }}"></script>
<script src="{{ asset ("/packages/admin/laravel-admin/scripts/field/switch.js") }}"></script>
<script src="{{ asset ("/packages/admin/laravel-admin/scripts/field/select.js") }}"></script>
<script src="{{ asset ("/packages/admin/laravel-admin/scripts/field/icon.js") }}"></script>
<script src="{{ asset ("/packages/admin/laravel-admin/scripts/action/delete.js") }}"></script>
<script src="{{ asset ("/packages/admin/laravel-admin/scripts/block/menu-tree.js") }}"></script>

<script>
  (function () {
    window.LA = {
      token: '{{ csrf_token() }}'
    }

    $.fn.editable.defaults.params = function (params) {
      params._token = window.LA.token
      params._editable = 1
      params._method = 'PUT'
      return params
    }

    window.toastr.options = {
      closeButton: true,
      progressBar: true,
      showMethod: 'slideDown',
      timeOut: 4000
    }

    $.pjax.defaults.timeout = 5000
    $.pjax.defaults.maxCacheLength = 0

    $document = $(document)

      .pjax('a:not(a[target="_blank"])', {
        container: '#pjax-container'
      })

      .on('submit', 'form[pjax-container]', function (event) {
        $.pjax.submit(event, '#pjax-container')
      })

      .on('pjax:popstate', function () {
        $document.one('pjax:end', function (event) {
          $(event.target).find('script[data-exec-on-popstate]').each(function () {
            $.globalEval(this.text || this.textContent || this.innerHTML || '')
          })
        })
      })

      .on('pjax:send', function (xhr) {
        if (xhr.relatedTarget && xhr.relatedTarget.tagName && xhr.relatedTarget.tagName.toLowerCase() === 'form') {
          $submit_btn = $('form[pjax-container] :submit')
          if ($submit_btn) {
            $submit_btn.button('loading')
          }
        }
      })

      .on('pjax:complete', function (xhr) {
        if (xhr.relatedTarget && xhr.relatedTarget.tagName && xhr.relatedTarget.tagName.toLowerCase() === 'form') {
          $submit_btn = $('form[pjax-container] :submit')
          if ($submit_btn) {
            $submit_btn.button('reset')
          }
        }
      })

    $('.sidebar-menu li:not(.treeview) > a').on('click', function () {
      var $parent = $(this).parent().addClass('active')
      $parent.siblings('.treeview.active').find('> a').trigger('click')
      $parent.siblings().removeClass('active').find('li').removeClass('active')
    })

  })(jQuery)
</script>

</body>
</html>
