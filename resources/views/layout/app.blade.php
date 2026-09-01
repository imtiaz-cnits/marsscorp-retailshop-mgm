<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>MARSS CORPORATION | Sign In</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- App favicon -->
    <link
      rel="shortcut icon"
      href="{{asset('back-end/assets/icons/nexus-pos-logo.svg')}}"
      type="image/x-icon"
    />

    <!-- Bootstrap Css -->
    <link
      href="{{asset('back-end/assets/css/bootstrap.min.css')}}"
      id="bootstrap-style"
      rel="stylesheet"
      type="text/css"
    />

    <!-- CSS Link-->
    <link rel="stylesheet" href="{{asset('back-end/assets/css/style.css')}}" />
    <link href="{{ asset('back-end/assets/css/toastify.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('back-end/assets/js/toastify-js.js') }}"></script>
    <script src="{{ asset('back-end/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('back-end/assets/js/config.js') }}"></script>

  </head>

  <body>

    <div id="loader" class="LoadingOverlay d-none">
        <div class="Line-Progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <div>
        @yield('content')
    </div>


    <script src="{{asset('back-end/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('back-end/assets/js/app.js')}}"></script>
  </body>
</html>
