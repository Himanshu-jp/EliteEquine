<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EliteQuine - @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('front/home/assets/images/logo/favicon.svg')}}" />
    <!-------------------------------- Css Links ------------------------------------>
    <link rel="stylesheet" href="{{asset('front/home/assets/Bootstrap/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="{{asset('front/home/assets/css/style.css')}}" />    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel='stylesheet' href="{{asset('front/auth/assets/select2/select2.min.css')}}">
    
    {{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css"> --}}
    <link rel='stylesheet' href="{{asset('front/auth/assets/datepicker/jquery-ui.min.css')}}">

    <!-- map box -->
     <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />
     <script src="https://api.mapbox.com/mapbox-gl-js/v3.9.0/mapbox-gl.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-supported/v1.0.0/mapbox-gl-supported.js"></script>
</head>

<body id="home">
    <!-------------------------------- Header ------------------------------------>
    <header class="header-inner position-sticky">
        <nav class="navbar navbar-expand-xl">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{route('home')}}">
                    <img src="{{asset('front/home/assets/images/logo/logo.svg')}}" alt="" /></a>
                <div class="d-lg-none">
                    <div type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                        aria-controls="offcanvasExample"><img
                            src="{{asset('front/home/assets/images/icons/menu-list.svg')}}" width="24px" alt="menu-list">
                    </div>
                </div>
                <div class="collapse navbar-collapse f-flex align-items-end gap-3" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ (Request::is('horse*') || Request::is('horse-listing')) ? 'active' : '' }}" aria-current="page" href="{{route('horse-listing')}}">Horses</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (Request::is('equipment*') || Request::is('equipment-listing')) ? 'active' : '' }}" href="{{route('equipment-listing')}}">Equipment & Apparel</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (Request::is('barns*') || Request::is('barns-listing')) ? 'active' : '' }}" href="{{route('barns-listing')}}">Barns & Housing</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ (Request::is('service*') || Request::is('service-listing')) ? 'active' : '' }}" href="{{route('service-listing')}}">Services & Jobs</a>
                        </li>
                       
                        <li class="nav-item">
                            <a class="nav-link {{ (Request::is('community*') || Request::is('community-events')) ? 'active' : '' }}" href="{{route('community-events')}}">Community & Events</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-3 ms-4">

                        @if(auth()->check()) 
                            
                            {{--<div onclick="window.location.href='{{route('checkout')}}'" class="position-relative">
                                <img src="{{asset('front/home/assets/images/icons/shoping.svg')}}" width="24" alt="">
                            </div>--}}
                            <div class="dropdown text-end">
                                <a href="#"
                                    class="d-block link-body-emphasis text-decoration-none dropdown-toggle text-light"
                                    data-bs-toggle="dropdown" aria-expanded="false">

                                    @if(auth()->check() && auth()->user()->profile_photo_path) 
                                        <img src="{{ asset('storage/'.auth()->user()->profile_photo_path) }}" alt="mdo" width="50" height="50" style="border-radius: 18px;">
                                    @else
                                        <img src="{{ asset('front/auth/assets/img/user-img.png') }}" alt="mdo" width="50" height="50" style="border-radius: 18px;">
                                    @endif                                    
                                    <span class="text-secondary">{{ auth()->user()->username }}</span>
                                </a>
                                <ul class="dropdown-menu text-small">
                                    <li><a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{route('product')}}">Submit Ad</a></li>
                                    <li><a class="dropdown-item" href="{{route('profile')}}">Profile</a></li>
                                    <li><a class="dropdown-item" href="{{route('settings')}}">Settings</a></li>
                                    <li><a class="dropdown-item" href="{{route('logout')}}">Sign out</a></li>
                                </ul>
                            </div>

                        @else

                            {{-- <a href="{{route('login')}}" class="commen_btn">Login</a> --}}
                            <a href="{{route('register')}}" class="commen_btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" class="me-2" height="16" viewBox="0 0 16 16" fill="none">
  <path d="M7 12V3.85L4.4 6.45L3 5L8 0L13 5L11.6 6.45L9 3.85V12H7ZM2 16C1.45 16 0.979333 15.8043 0.588 15.413C0.196666 15.0217 0.000666667 14.5507 0 14V11H2V14H14V11H16V14C16 14.55 15.8043 15.021 15.413 15.413C15.0217 15.805 14.5507 16.0007 14 16H2Z" fill="#080808"/>
</svg> Login/Submit Ad</a>

                            {{-- <a href="no-add-found02.php" class="commen_btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none"> 
                            <path d="M7 12V3.85L4.4 6.45L3 5L8 0L13 5L11.6 6.45L9 3.85V12H7ZM2 16C1.45 16 0.979333 15.8043 0.588 15.413C0.196666 15.0217 0.000666667 14.5507 0 14V11H2V14H14V11H16V14C16 14.55 15.8043 15.021 15.413 15.413C15.0217 15.805 14.5507 16.0007 14 16H2Z" fill="#080808" class="pe-2" /></svg>Submit Ad</a> --}}

                        @endif

                    </div>
                </div>
            </div>
            </div>
            </div>
        </nav>
    </header>

    <div class="preloader" style="display: none;">
        <img src="{{asset('front/auth/assets/img/logos/logo.svg')}}" alt="loader" class="" />
    </div>
    

    @if(auth()->check()) 
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <div class="offcanvas-title" id="offcanvasExampleLabel">
                    <div class="dropdown">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle text-light"
                            data-bs-toggle="dropdown" aria-expanded="false">

                            @if(auth()->check() && auth()->user()->profile_photo_path) 
                                <img src="{{ asset('storage/'.auth()->user()->profile_photo_path) }}" alt="mdo" width="50" height="50" style="border-radius: 18px;">
                            @else
                                <img src="{{ asset('front/auth/assets/img/user-img.png') }}" alt="mdo" width="50" height="50" style="border-radius: 18px;">
                            @endif
                            <span class="text-secondary">{{ auth()->user()->username }}</span>
                        </a>
                        <ul class="dropdown-menu text-small">
                            <li><a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{route('product')}}">Submit Ad</a></li>
                            <li><a class="dropdown-item" href="{{route('profile')}}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{route('settings')}}">Settings</a></li>
                            <li><a class="dropdown-item" href="{{route('logout')}}">Sign out</a></li>
                        </ul>
                    </div>
                </div>
                <div data-bs-dismiss="offcanvas" aria-label="Close">
                    <img src="{{asset('front/home/assets/images/icons/close.svg')}}" width="24" alt="">
                </div>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="{{route('horse-listing')}}">Horses</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('equipment-listing')}}">Equipment & Apparel</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('barns-listing')}}">Barns & Housing</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('service-listing')}}">Services & Jobs</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('community-events')}}">Community & Events</a>
                    </li>
                </ul>
            </div>
        </div>
    @else
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <img src="{{asset('front/home/assets/images/logo/logo.svg')}}" alt="" /></a>
                <div data-bs-dismiss="offcanvas" aria-label="Close">
                    <img src="{{asset('front/home/assets/images/icons/close.svg')}}" width="24" alt="">
                </div>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="{{route('horse-listing')}}">Horses</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('equipment-listing')}}">Equipment & Apparel</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('barns-listing')}}">Barns & Housing</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('service-listing')}}">Services & Jobs</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('community-events')}}">Community & Events</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3 ms-4">
                    {{-- <a href="{{route('login')}}" class="commen_btn">Login</a> --}}
                    <a href="{{route('register')}}" class="commen_btn">Register</a>
                    {{-- <a href="#" class="commen_btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            viewBox="0 0 16 16" fill="none">
                            <path
                                d="M7 12V3.85L4.4 6.45L3 5L8 0L13 5L11.6 6.45L9 3.85V12H7ZM2 16C1.45 16 0.979333 15.8043 0.588 15.413C0.196666 15.0217 0.000666667 14.5507 0 14V11H2V14H14V11H16V14C16 14.55 15.8043 15.021 15.413 15.413C15.0217 15.805 14.5507 16.0007 14 16H2Z"
                                fill="#080808" />
                        </svg>Submit Ad</a> --}}
                </div>
            </div>
        </div>
    @endif