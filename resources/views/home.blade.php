@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="text-center">
    <h1>Welcome to Our Company</h1>
    <p>Your journey starts here. We are excited to have you!</p>
    <img src="{{ asset('images/images.jpg') }}" alt="Project Image">
</div>
@endsection

