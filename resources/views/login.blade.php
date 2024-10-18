@extends('templates.app')

@section('content-dinamis')
<div class="container">
    @if (Session::get('failed'))
        <div class="alert alert-danger">{{Session('failed')}}</div>
    @endif
 <h1>Login</h1>
</div>    
    <form action="{{route('loginAuth')}}" method="POST">
        @csrf
    <div class="form form-group">
        <label for="email" class="form form-label">Email</label>
        <input type="email" class="form-control form-control-lg border-0 bg-light" name="email" id="email">
    </div>
    <div class="form form-group">
        <label for="password" class="form form-label">Password</label>
        <input type="password" class="form-control form-control-lg border-0 bg-light" name="password" id="password">
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    </form>
@endsection