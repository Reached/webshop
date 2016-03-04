<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css">
    <title>Webshop</title>
    <meta id="token" content="{{ csrf_token() }}">
</head>
<body>
    @include('backend.partials.navigation')
    @yield('dashboard')
    <div class="app-container">
        @yield('content')
    </div>
    @yield('products')
    @yield('scripts')
</body>
</html>