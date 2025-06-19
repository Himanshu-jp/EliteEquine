<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{asset('front/auth/assets/img/logos/logo.svg')}}">
    <title>EliteQuine - Reset Password</title>
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

    <section class="login-section d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="container ">
            <div class="row align-items-center justify-content-between">

                <div class="col-lg-6">
                    <div class="login-section-form">
                        <a href="{{route('home')}}">
                            <img src="{{asset('front/auth/assets/img/logos/logo.svg')}}" class="logo" alt="logo">
                        </a>
                        <div class="section-form-heading mb-4">
                            <h2>Reset Password!</h2>
                        </div>

                        <form action="{{ route('reset.password.post') }}" method="post" class="row g-3 needs-validation error"
                            id="reset-form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="type" value="{{ $type }}">

                            <div>
                                <label for="">Email Address *</label>
                                <input class="form-control inner-form" placeholder="Enter Password*" name="email" id="email"
                                     type="text" autocomplete="off" value="{{ $email ?? old('email') }}">
                                @if($errors->has('email'))
                                <span class="error text-danger">{{$errors->first('email')}}</span>
                                @endif
                            </div>

                            
                            <div class="Password-form">
                                <label for="">Password *</label>
                                <input class="form-control inner-form" placeholder="Enter Password*" name="password" id="password"
                                    value="" type="password" autocomplete="off">

                                <div class="icon_eye">
                                    <img src="{{asset('front/auth/assets/img/eyeoff.svg')}}" class="toggle-password-input" data-toggle="#password" alt="Toggle Password">
                                </div>
                                <span toggle="#password-field" class="bi bi-eye field-icon toggle-password"></span>

                                @if($errors->has('password'))
                                <span class="error text-danger">{{$errors->first('password')}}</span>
                                @endif
                            </div>
                            
                            <div class="Password-form">
                                <label for="">Confirm Password *</label>
                                <input class="form-control inner-form" placeholder="Enter Confirm Password*" name="password_confirmation" id="password_confirmation"
                                    value="" type="password" autocomplete="off">

                                <div class="icon_eye">
                                    <img src="{{asset('front/auth/assets/img/eyeoff.svg')}}" class="toggle-password-input" data-toggle="#password_confirmation" alt="Toggle Password">
                                </div>
                                <span toggle="#password-field" class="bi bi-eye field-icon toggle-password"></span>

                                @if($errors->has('password_confirmation'))
                                <span class="error text-danger">{{$errors->first('password_confirmation')}}</span>
                                @endif

                            </div>

                            <button class="btn btn-primary w-100" type="submit" id="reset-form-submit">Reset Password</button>
                            <h6 class="text-center"><a href="{{route('login')}}"><ins>Back to Login</ins></a></h6>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{asset('front/auth/assets/img/login-site-img.jpg')}}" class="login-img" alt="img-1">
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

        $.validator.addMethod("strongPassword", function(value, element) {
                return this.optional(element) ||
                    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/.test(value);
            },
            "Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character."
        );

        $("#reset-form").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    maxlength: 255
                },
                password: {
                    required: true,
                    strongPassword: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                email: {
                    required: "Please enter your email address",
                    email: "The email should be in the format: john@domain.tld",
                    maxlength: "Email must not exceed 255 characters"
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 8 characters"
                },
                password_confirmation: {
                    required: "Please confirm your password",
                    equalTo: "Passwords do not match"
                },
            },
            submitHandler: function(form) {
                $('#reset-form-submit').prop('disabled', true).text('Please wait...');
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