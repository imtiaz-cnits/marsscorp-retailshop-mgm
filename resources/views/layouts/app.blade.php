<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>MARSS CORPORATION | Sign In</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- App favicon -->
  <link
    rel="shortcut icon"
    href="{{asset('backend/assets/icons/nexus-pos-logo.svg')}}"
    type="image/x-icon" />

  <!-- Google Fonts: Valley Sans & Baloo Da 2 -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Baloo+Da+2:wght@400;500;600;700;800&family=Valley+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

  <!-- Bootstrap Css -->
  <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

  <!-- Vite Tailwind CSS & JS -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link href="{{ asset('backend/assets/css/toastify.min.css') }}" rel="stylesheet" />
  <script src="{{ asset('backend/assets/js/toastify-js.js') }}"></script>
  <script src="{{ asset('backend/assets/js/axios.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/config.js') }}"></script>

</head>

<body class="font-sans antialiased text-slate-900 bg-slate-50">

  <div id="loader" class="LoadingOverlay hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[9999] flex items-center justify-center">
    <div class="Line-Progress w-48 h-1.5 bg-slate-200 overflow-hidden rounded-full">
      <div class="indeterminate h-full bg-emerald-600 rounded-full animate-pulse"></div>
    </div>
  </div>

  <div>
    @yield('content')
  </div>


</body>

</html>