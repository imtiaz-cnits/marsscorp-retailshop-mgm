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
    type="image/x-icon" />

  <!-- Bootstrap Css -->
  <link
    href="{{asset('back-end/assets/css/bootstrap.min.css')}}"
    id="bootstrap-style"
    rel="stylesheet"
    type="text/css" />

  <!-- Google Fonts: Valley Sans & Baloo Da 2 -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@400;500;600;700;800&family=Valley+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

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