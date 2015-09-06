@if(Auth::user())
Hi {{ Auth::user()->name }}
  <a href="/logout">Log out</a>
@endif
<header class="main-nav">
<div class="menu-overlay">
    <div class="mobile-menu-content">
      <div class="close-button">
        <i class="entypo-cancel"></i>
      </div>
      <h2>Menu</h2>
    </div>
</div>

<a href="/" class="logo"><img src="/images/logo.svg"></a>
    <ul class="nav">
      <li><a href="#">Our Products</a></li>
      <li><a href="#">About Us</a></li>
      <li><a href="#">Contact Us</a></li>
      <li class="shopping-cart">
        <a href="/cart"><span id="shopping-cart">{{ Cart::count() }}</span> Your Cart</a>
      </li>
    </ul>
    <button class="open-mobile-nav"><i class="entypo-menu"></i></button>
    <ul class="mobile-nav">
      <li><a href="#" class="active">Home</a></li>
      <li><a href="#">Products</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
</header>