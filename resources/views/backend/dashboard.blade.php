@extends('backend.backendLayout')

@section('dashboard')
    <div class="container">
        <div class="ui grid">
            <div class="fourteen wide column centered">
                <h1 class="ui huge header">Welcome back {{ Auth::user()->name }}</h1>
                <p>What do you wanna do today?</p>
                <a href="#" class="ui button orange">Manage my products</a>
                <a href="#" class="ui button orange">See my orders</a>
            </div>
        </div>
    </div>
@endsection