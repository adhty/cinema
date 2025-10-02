@extends('layouts.auth')

@section('content')
<div class="min-vh-100 d-flex flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card p-4 shadow">
          <div class="card-body text-center">
            <h2>Login</h2>
            <p class="text-muted">Sign in to your account</p>
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email" required autofocus>
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
