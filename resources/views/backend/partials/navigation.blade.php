<div class="ui labeled icon menu">
    <div class="item">
        <img src="/images/logo.svg">
    </div>
    <a class="item" href="/admin/products">
        <i class="star icon"></i>
        Products
    </a>
    <a class="item">
        <i class="cubes icon"></i>
        Orders
    </a>
    <a class="item">
        <i class="users icon"></i>
        Users
    </a>
    <a class="item">
        <i class="cogs icon"></i>
        Settings
    </a>
    <div class="right menu">
        <div class="ui item">
            Hello, {{ Auth::user()->first_name }}
        </div>
        <div class="item">
            <a class="ui red button" href="/logout">Log out</a>
        </div>
    </div>
</div>