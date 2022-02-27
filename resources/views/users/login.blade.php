@extends('users.header')
@section('content')
<br><br>
<div class="card">
    <h1 class="text-center text-primary">Welcome to Virtual Wallet</h1>
    <br>
        
    <div class="card-body">
    @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
            <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('warning'))
            <div class="alert alert-warning alert-block">
            <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
            <strong>{{ $message }}</strong>
            </div>
        @endif
        <br>
    <form method="post" action="{{url('user/logincheck')}}">
    @csrf
   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email </label>
    <input type="mail" class="form-control" name="email" required="">
  </div>

  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" required="">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
    </div>
</div>
@endsection