@extends('layouts.app')
@section('content')
<div class="row justify-content-center my-5">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header text-center">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</div>
            <div class="card-body">
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Email Password Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
