<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <title>Admin | Log in</title> -->
  <title>@yield('title', 'Admin Elight-Equine')</title>
  <link rel="icon" href="{{ asset('front/home/assets/images/logo/favicon.svg') }}" type="image/x-icon" id="favicon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin_assets/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin_assets/custom.css')}}">

  <style>
    .invalid-feedback {
      display: none;
      color: red;
      font-size: 0.875em;
    }
    .is-invalid ~ .invalid-feedback {
      display: block;
    }
    .login-box{
  width: 100%;
}

    .login-box .card{
      padding: 35px 24px;
  width: 100%;
  border-radius: 16px;
  border: 1px solid rgba(35, 31, 32, 0.01);
background: rgba(35, 31, 32, 0.33);
backdrop-filter: blur(17.100000381469727px);
    }
    .input-group-text{
      background:white;
    }
    .form-control{
  width: 100%;
  padding: 15px 30px;
  color: var(--text);
  background: #fff;
 border: 1px solid #A19061;
  margin-bottom: 10px;
  min-height:52px;
}
.btn.btn-primary {
  background-color: #A19061;
  border: 1px solid #A19061;
  padding: 13px 32px;
  border-radius: 50px;
  color: var(--white);
  font-size: 18px;
  font-weight: 500;
  transition: 0.3s ease-in-out;
  margin: 0;
  box-shadow: none;
}

.btn.btn-primary:hover {
  background-color: #262626;
  border: 1px solid #262626;
  color: var(--white);
  box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(64, 64, 64, 0.4);

}
.form-control{
 border-radius: 50px;
}
.form-group{
  border-radius: 50px;
  position: relative;
}

.form-group i {
 position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
}
  </style>
</head>
<body class="hold-transition login-page" style="background-image: url('{{ asset('images/background-horse.jpeg') }}');
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  min-height: 100vh;">


<div class="col-md-3">
  <div class="login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="login-logo mb-5">
    <img src="{{asset('front/home/assets/images/logo/logo.svg')}}" alt="" /></a>
  </div>
    <div>
    @if ($errors->any())
      <div class="alert alert-danger">
          @foreach ($errors->all() as $error)
            {{ $error }}
          @endforeach
      </div>
    @endif
      <form id="loginForm" action="{{route('admin.login.store')}}" method="post">
        @csrf
        <div class="form-group mb-1">
          <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
        </div>
        @error('email')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <div class="invalid-feedback" id="emailError">Please enter a valid email address.</div>

        <div class="form-group mb-1 mt-3 ">
          <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password">
          <i class="fa fa-eye toggle-password" style="cursor:pointer;" id="togglePassword"></i>
        </div>

        @error('password')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
        <div class="invalid-feedback" id="passwordError">Please enter your password.</div>

        <button type="submit" class="btn btn-primary w-100 mt-4">Sign In</button>
      </form>


    </div>
    <!-- /.login-card-body -->
  </div>
</div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('admin_assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin_assets/dist/js/adminlte.min.js')}}"></script>

<!-- JavaScript Validation -->
<script>
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    let isValid = true;

    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    const emailValue = emailField.value.trim();
    const passwordValue = passwordField.value.trim();
    const emailRegex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;

    // Reset previous state
    emailField.classList.remove('is-invalid');
    passwordField.classList.remove('is-invalid');
    emailError.style.display = 'none';
    passwordError.style.display = 'none';

    // Validate email
    if (!emailValue || !emailRegex.test(emailValue)) {
      emailField.classList.add('is-invalid');
      emailError.style.display = 'block';
      isValid = false;
    }

    // Validate password
    if (!passwordValue) {
      passwordField.classList.add('is-invalid');
      passwordError.style.display = 'block';
      isValid = false;
    }

    if (!isValid) {
      e.preventDefault();
    }
  });
</script>

<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
  });

  $(".alert-danger").fadeOut(5000);
</script>
</body>
</html>
