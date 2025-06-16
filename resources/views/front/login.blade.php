<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{asset('front/auth/assets/img/logos/logo.svg')}}">
    <title>Elite Equine - Sign In</title>
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="{{asset('front/auth/assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('front/auth/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link id="pagestyle" href="{{asset('front/auth/assets/css/material-dashboard.css?v=3.2.0')}}" rel="stylesheet" />

    <!-- new -->
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href="{{asset('front/auth/assets/css/custom.css')}}">

</head>

<body>

    <section class="login-section d-flex justify-content-center align-items-center">
        <div class="container ">
            <div class="row align-items-center justify-content-between">

                <div class="col-lg-6">
                    <div class="login-section-form">
                        <a href="{{route('home')}}">
                            <img src="{{asset('front/auth/assets/img/logos/logo.svg')}}" class="logo" alt="logo">
                        </a>
                        <div class="section-form-heading mb-4">
                            <h2>Welcome Back!</h2>
                        </div>
                        <form action="{{ route('loginPost') }}" method="post" class="row g-3 needs-validation error"
                            id="login-form">
                            @csrf
                            <div>
                                <label for="">Email <span class="text-danger">*</span></label>
                                <input class="form-control inner-form" placeholder="Enter email address"
                                    value="{{old('email')}}" name="email" type="text" autocomplete="off">
                                @if($errors->has('email'))
                                  <span class="error text-danger">{{$errors->first('email')}}</span>
                                @endif
                            </div>
                            <div class="Password-form">
                                <label for="">Password <span class="text-danger">*</span></label>
                                <input class="form-control inner-form" placeholder="Enter Password" name="password" id="password"
                                    value="" type="password" autocomplete="off">

                                <div class="icon_eye">
                                    <img src="{{asset('front/auth/assets/img/eyeoff.svg')}}" class="toggle-password-input" data-toggle="#password" alt="Toggle Password">
                                </div>
                                <span toggle="#password-field" class="bi bi-eye field-icon toggle-password"></span>

                                @if($errors->has('password'))
                                <span class="error text-danger">{{$errors->first('password')}}</span>
                                @endif

                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="remember">Keep me login</label>
                                </div>
                                <span><a href="{{route('forget.password.get')}}" class="password-teg fw-bold">Forgot your password?</a></span>
                            </div>

                            <button class="btn btn-primary w-100" type="submit" id="login-form-submit">Log in</button>
                            <h6 class="text-center">Don’t have an account, <a href="{{route('register')}}"><ins class="text-gold">Create new account</ins></a></h6>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{asset('front/auth/assets/img/login-site-img.jpg')}}" class="login-img w-100" alt="img-1">
                </div>
            </div>
        </div>
    </section>

    <!-- <--------------------------------------------// js CDN & files--------------------------------------------->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
        integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
    $(document).ready(function() {
        $("#login-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,                }
            },
            messages: {
                email: {
                    required: "Please enter your username",
                    email: "The email should be in the format: john@domain.tld"
                },
                password: {
                    required: "Please enter your password"
                }
            },
            errorClass: 'error text-danger',
            errorElement: 'span',
            
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                $('#login-form-submit').prop('disabled', true).text('Please wait...');
                form.submit();
            }
        });
    });
    </script>


    <script>
    function alertMessage(type, message) {
        Swal.fire({
            toast: true,
            title: message,
            icon: type,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    }
    </script>


    @if ($message = session('success'))
    <script>
    alertMessage('success', '{{$message}}');
    </script>
    @endif

    @if ($message = session('error'))
    <script>
    alertMessage('error', '{{$message}}');
    </script>
    @endif

    <script>
    $(document).ready(function () {
      $(".toggle-password-input").click(function () {
        var input = $($(this).attr("data-toggle"));
        var img = $(this);
 
        if (input.attr("type") === "password") {
          input.attr("type", "text");
          img.attr("src", "{{ asset('front/auth/assets/img/aye.svg') }}");
        } else {
          input.attr("type", "password");
          img.attr("src", "{{ asset('front/auth/assets/img/eyeoff.svg') }}");
        }
      });
    });
  </script>


</body>

</html>