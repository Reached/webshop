@extends('frontend.shop')

@section('content')

    @foreach($sessionData as $value)
        {{ $value->name }}
    @endforeach

@endsection