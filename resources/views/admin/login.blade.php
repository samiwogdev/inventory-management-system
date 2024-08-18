@extends('admin.layout.default_layout')
@section('content')
<div class="login-userheading">
    <h3>Sign In</h3>
    <h4>Please login to your account</h4>
</div>
@if (Session::has('error_message'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error:</strong> {{ Session::get('error_message') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show pb-0" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form class="" action="{{ url('admin/login') }}" method="POST">@csrf
    <div class="form-login">
        <label>Email</label>
        <div class="form-addons">
            <input name="email" type="text" placeholder="Enter your email address">
            <img src="assets/img/icons/mail.svg" alt="img">
        </div>
    </div>
    <div class="form-login">
        <label>Password</label>
        <div class="pass-group">
            <input name="password" type="password" class="pass-input" placeholder="Enter your password">
            <span class="fas toggle-password fa-eye-slash"></span>
        </div>
    </div>
    <!--<div class="form-login">
        <div class="alreadyuser">
            <h4><a href="forgetpassword.html" class="hover-a">Forgot Password?</a></h4>
        </div>
    </div>-->
    <div class="form-login">
        <input type="submit" value="Sign In" class="btn btn-login" href="index.html">
    </div>
</form>
<!-- <div class="signinform text-center">
    <h4>Don’t have an account? <a href="signup.html" class="hover-a">Sign Up</a></h4>
</div> -->


</div>
</div>
<div class="login-img">
    <img src="assets/img/login.jpg" alt="img">
</div>
</div>
</div>
</div>

@endsection