@extends('layouts.app')

@section('content')

    <div class="welcome-container">

        <h1> Welcome to a Simple Product App </h1>
        <hr>

        <p class="justified-text">Effortlessly manage Products, Prices & Stock Quantities with this lightweight and user-friendly application. Click below to get started!</p>

        <a href="{{ route('products.index') }}" class="btn btn-primary"> Get Started </a>

        <hr>

        <div class="">
            <a href="https://github.com/Kimnate/Simple-Product-App" target="_blank">
                <i class="bx bxl-github custom-icon"> </i>
            </a>

        </div>
        <small> Or check it out on Github </small>

    </div>

@endsection
