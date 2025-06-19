<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{asset('front/auth/assets/img/logos/logo.svg')}}">
    <title>EliteQuine - Forgot Password</title>
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
    <style>
        .text-danger {
    color: red;
    font-size: 0.875em;
}

.is-invalid {
    border-color: red;
}
    </style>

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
                            <h2>Forgot Password!</h2>
                        </div>

                        <form action="{{ route('forget.password.post') }}" method="post" class="row g-3 needs-validation error"
                            id="forgot-password-form">
                            @csrf
                            <div>
                                <label for="">Email <span class="text-danger">*</span></label>
                                <input class="form-control inner-form" placeholder="Enter email address"
                                    value="{{old('email')}}" name="email" type="text" autocomplete="off">
                                @if($errors->has('email'))
                                <span class="error text-danger">{{$errors->first('email')}}</span>
                                @endif
                            </div>
                            
                            <button class="btn btn-primary w-100" type="submit" id="forgot-password-form-submit">Send Request</button>
                            <h6 class="text-center">Don’t have an account, <a href="{{route('register')}}"><ins>Create
                                        new account</ins></a></h6>

                            <h6 class="text-center">Already have an account, <a href="{{route('login')}}"><ins>Login
                                here</ins></a>
                            </h6>
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
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
    $(document).ready(function() {
    $("#forgot-password-form").validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Please enter your email address",
                email: "The email should be in the format: john@domain.tld"
            }
        },
        errorClass: 'text-danger',  // red color for error text
        errorElement: 'span',       // wrap error in <span>
        highlight: function(element) {
            $(element).addClass('is-invalid');  // add red border
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid'); // remove red border
        },
        submitHandler: function(form) {
            $('#forgot-password-form-submit').prop('disabled', true).text('Please wait...');
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

</body>

</html>