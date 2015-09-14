<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/css/vendor/semantic-ui/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="/css/backend.css">
    <title>Webshop</title>
</head>
<body>
    @include('backend.partials.navigation')
    @yield('dashboard')
    @yield('content')


</body>
</html>