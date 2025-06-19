<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{asset('front/auth/assets/img/logos/logo.svg')}}">
    <title>Elite Quine - @yield('title')</title>
    <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="{{asset('front/auth/assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('front/auth/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
        <link href="https://cdn-uicons.flaticon.com/uicons-solid-straight/css/uicons-solid-straight.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link id="pagestyle" href="{{asset('front/auth/assets/css/material-dashboard.css?v=3.2.0')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel='stylesheet' href="{{asset('front/auth/assets/select2/select2.min.css')}}">
    <!-- new -->
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href="{{asset('front/auth/assets/css/custom.css')}}">
    <link rel='stylesheet' href="{{asset('front/auth/assets/css/chart-style.css')}}">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- map box -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.9.0/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-supported/v1.0.0/mapbox-gl-supported.js"></script>
</head>

<body class="g-sidenav-show">

    {{-- <div class="preloader">
        <img src="{{asset('front/auth/assets/img/logos/logo.svg')}}" alt="loader" class="" />
    </div> --}}

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- sidebar -->
    @include('frontauth/layouts/menu')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div id="wrapper" style="overflow: hidden; margin-right: 15px 0px !important; min-height: 100vh;">

            <!-- Navbar -->
            @include('frontauth/layouts/header')

            <hr class="horizontal dark mt-0 my-2">
            <!-- End Navbar -->

            @yield('content')

        </div>
    </main>


    <!--   Core JS Files   -->
    
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="{{asset('front/auth/assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('front/auth/assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('front/auth/assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('front/auth/assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script src="{{asset('front/auth/assets/js/plugins/chartjs.min.js')}}"></script>
    <script src="{{asset('front/auth/assets/js/custom-validation.js')}}"></script>






    <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    </script>
    <!-- Github buttons -->
    
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('front/auth/assets/js/material-dashboard.min.js?v=3.2.0')}}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{asset('front/auth/assets/js/main.js')}}"></script>
   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
    integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

    <script src="{{asset('front/auth/assets/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('front/auth/assets/select2/select2.js')}}"></script>
    <script src="{{asset('front/auth/assets/js/chart-main.js')}}"></script>

    @yield('script')    


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
    @if ($message = session('warning'))
    <script>
    alertMessage('warning', '{{$message}}');
    </script>
    @endif    

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                tags: "true",
                placeholder: "Select an option",
                // allowClear: true
            });
        });


        //---------for removing the records alert------------//
        @if(Session::has('message'))
            Swal.fire("EliteQuine", "{{ Session::get('message') }}", "success");
        @elseif(Session::has('error'))
            Swal.fire("EliteQuine", "{{ Session::get('error') }}", "error");
        @endif
        $(document).on('click', '.confirm-button', function(e) {
            var href = $(this).data('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            })
        });
        //-------------Removing records alert into the db--------------------------//

    
        $(".preloader").fadeOut();

    </script>
</body>

</html>