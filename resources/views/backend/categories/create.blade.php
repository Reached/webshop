@extends('backend.backendLayout')

@section('content')
    <h1>Create a new category</h1>

    <form action="/admin/categories/store" method="POST" id="create-category-form">
        {{ csrf_field() }}
        <label for="category_name">Category name</label>
        <input type="text" name="category_name" id="category_name" placeholder="Category name">

        <div class="select">
            <label for="is_active">Should the product be active?</label>
            <select name="is_active" id="is_active">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <input type="submit">
    </form>
@endsection