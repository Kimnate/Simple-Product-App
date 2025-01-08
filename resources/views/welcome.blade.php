@extends('layouts.app')

@section('content')

    <div class="welcome-container">

        <h1> Welcome to Simple Products App </h1>
        <p>Effortlessly manage Products, Prices & Stock Quantities with this lightweight and user-friendly application. Click below to get started!</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary"> Get Started </a>

    </div>

@endsection
