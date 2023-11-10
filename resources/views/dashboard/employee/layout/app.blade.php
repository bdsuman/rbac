<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Event Management Login</title>
    <link rel="icon" type="image/x-icon" href="{{asset('/favicon.ico')}}" />
    <link href="{{asset('backend/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="{{asset('backend/css/animate.min.css')}}" rel="stylesheet" />
    <link href="{{asset('backend/css/fontawesome.css')}}" rel="stylesheet" />
    <link href="{{asset('backend/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('backend/css/toastify.min.css')}}" rel="stylesheet" />
    <script src="{{asset('backend/js/toastify-js.js')}}"></script>
    <script src="{{asset('backend/js/axios.min.js')}}"></script>
    <script src="{{asset('backend/js/config.js')}}"></script>
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
<script>

</script>

<script src="{{asset('backend/js/bootstrap.bundle.js')}}"></script>

</body>
</html>
