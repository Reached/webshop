<!DOCTYPE html>
<html>
	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/app.css">
    <title>Webshop</title>
  </head>
  <body>

      {{-- Navigation and overlays --}}
      @include('frontend.partials.navigation')

      {{-- Product grid --}}
      @yield('products')
      {{-- Shopping cart --}}
      @yield('shoppingCart')
      {{-- Checkout --}}
      @yield('content')

      {{-- Footer and scripts --}}
      @include('frontend.partials.footer')

  </body>
</html>
