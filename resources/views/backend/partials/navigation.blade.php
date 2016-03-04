
<nav class="backend-navigation">
    <div class="logo-box">
        <a href="#" class="logo">
            <div class="logo-symbol"></div>
        </a>
    </div>
    <div class="regular-links">
    <a href="/admin/orders" class="{{ isActive('admin/orders') }} nav-item">
        <div class="icon icon-orders"></div>
        <p>Orders</p>
    </a>

    <a href="/admin/products" class="{{ isActive('admin/products') }} nav-item">
        <div class="icon icon-products"></div>
        <p>Products</p>
    </a>

    <a href="#" class="nav-item">
        <div class="icon icon-statistics"></div>
        <p>Statistics</p>
    </a>

    <a href="#" class="nav-item">
        <div class="icon icon-categories"></div>
        <p>Categories</p>
    </a>

    <a href="#" class="nav-item">
        <div class="icon icon-settings"></div>
        <p>Settings</p>
    </a>

    <a href="#" class="nav-item">
        <div class="icon icon-profile"></div>
        <p>Profile</p>
    </a>
    </div>
    {{--Hello {{ Auth::user()->first_name }}--}}
</nav>


