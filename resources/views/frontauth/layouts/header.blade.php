<nav class="navbar navbar-main navbar-expand-lg px-0 py-3 mx-3 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="true">
    <div class="container-fluid gap-3 px-0">
        <div class="w-100 order-2 order-md-1">
            <h3 class="mb-2 h4 font-weight-bolder d-none d-md-block">Welcome 
                @if(auth()->check()) 
                    {{ auth()->user()->name }}                 
                @endif
            </h3>

            {{-- <div class="ms-md-auto d-flex align-items-center mobile-top-search d-lg-none">
                <input type="text" class="form-control" placeholder="Search for anything...">
                <img src="{{asset('front/auth/assets/img/icons/search-icon.svg')}}">
            </div> --}}
        </div>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 gap-2 order-2 order-md-2" id="navbar">
            {{-- <div class="ms-md-auto d-flex align-items-center top-search">
                <input type="text" class="form-control" placeholder="Search for anything...">
                <img src="{{asset('front/auth/assets/img/icons/search-icon.svg')}}">
            </div> --}}
            <ul class="navbar-nav d-flex align-items-center  justify-content-end gap-2">

                {{-- <li class="nav-item notification-box dropdown pe-3 d-flex align-items-center">
                    <a href="#" class="nav-link text-body p-0 d-flex align-items-center gap-2" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{asset('front/auth/assets/img/icons/notification-ball.svg')}}" alt="notification">
                        <sub>3</sub>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{asset('front/auth/assets/img/team-2.jpg')}}"
                                            class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New message</span> from Laur
                                        </h6>
                                        <p class="text-xs text-secondary mb-0"><i class="fa fa-clock me-1"></i>13
                                            minutes ago</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{asset('front/auth/assets/img/small-logos/logo-spotify.svg')}}"
                                            class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New album</span> by Travis Scott
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            1 day
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg')}}"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>credit-card</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                                    fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(453.000000, 454.000000)">
                                                            <path class="color-background"
                                                                d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                opacity="0.593633743"></path>
                                                            <path class="color-background"
                                                                d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">Payment successfully
                                            completed</h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                
                <li class="nav-item dropdown pe-3 d-flex align-items-center">
                    <a href="#" class="nav-link text-body p-0 d-flex align-items-center gap-2" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">

                            @if(auth()->check() && auth()->user()->profile_photo_path) 
                                <img src="{{ asset('storage/'.auth()->user()->profile_photo_path) }}" width="38" height="38"  class="rounded-circle" alt="">
                            @else
                                <img src="{{ asset('front/auth/assets/img/user-img.png') }}" width="38" height="38"  class="rounded-circle" alt="">
                            @endif
                        <div>
                            <h6 class="mb-0" style="line-height: 14px;">
                                @if(auth()->check()) 
                                    {{ auth()->user()->username }}
                                @endif
                            </h6>
                            <small>
                                @if(auth()->check()) 
                                    {{ auth()->user()->email }}                    
                                @endif
                            </small>
                        </div>
                        <i class="fi fi-rr-angle-small-down"></i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton" style="width: 342px;">
                        {{-- <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">
                                                @if(auth()->check()) 
                                                    {{ auth()->user()->username }}                    
                                                @endif
                                            </span>
                                        </h6>
                                        <p class="text-xs text-secondary mb-0"><i
                                                class="fa fa-clock me-1"></i>
                                                @if(auth()->check()) 
                                                    {{ auth()->user()->email }}                    
                                                @endif
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li> --}}
                        <hr class="horizontal dark mt-0 mb-2">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{route('profile')}}">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{asset('front/auth/assets/img/icons/user.svg')}}" width="28px"
                                            alt="user" class=" me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">My Profile</span>
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{route('settings')}}">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{asset('front/auth/assets/img/icons/a-settings.svg')}}" width="28px"
                                            alt="user" class=" me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Account Settings</span>
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{route('change-password')}}">                                
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{asset('front/auth/assets/img/icons/change-password.svg')}}" width="28px"
                                            alt="user" class=" me-3 ">
                                    </div>

                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Change Password</span>
                                        </h6>
                                    </div>
                                </div>                               
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{route('logout')}}">                                
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{asset('front/auth/assets/img/icons/sign-out.svg')}}" width="28px"
                                            alt="user" class=" me-3 ">
                                    </div>

                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">Logout</span>
                                        </h6>
                                    </div>
                                </div>                               
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>