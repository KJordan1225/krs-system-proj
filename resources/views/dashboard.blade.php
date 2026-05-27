@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


<h1>Dashboard</h1>

<p>Welcome, {{ auth()->user()->name }}</p>

<form method="POST" action="{{ route('logout') }}">
    @csrf    
    <button type="submit" class="btn btn-primary">Logout</button>
</form>

@endsection