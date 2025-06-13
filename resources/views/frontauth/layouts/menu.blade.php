<aside class="sidenav navbar navbar-vertical navbar-expand-xs fixed-start" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand px-4 py-3 m-0" href="{{route('home')}}">
            <img src="{{asset('front/auth/assets/img/logos/dark-logo.png')}}" class="navbar-brand-img" width="150"
                alt="new-logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            
            <li class="nav-item">
                <a class="nav-link {{ (Request::is('dashboard') || Request::is('dashboard')) ? 'active' : '' }}" href="{{route('dashboard')}}">
                    <i class="fi fi-rr-apps"></i>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link text-ligth" href="{{route('ads')}}">
                    <i class="fi fi-rr-ad"></i>
                    <span class="nav-link-text ms-1">popup Ads</span>
                </a>
            </li> --}}

           

            <li class="nav-item">
                <a class="nav-link text-ligth {{ (Request::is('subscription') || Request::is('subscription')) ? 'active' : '' }}" href="{{route('subscription')}}">
                    <i class="fi fi-rr-subscription-alt"></i>
                    <span class="nav-link-text ms-1">Subscription</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-ligth {{ (Request::is('settings') || Request::is('settings')) ? 'active' : '' }}" href="{{route('settings')}}">
                    <i class="fi fi-rr-operation"></i>
                    <span class="nav-link-text ms-1">Settings</span>
                </a>
            </li>           
            
            <li class="nav-item">
                <a class="nav-link text-ligth {{ (Request::is('profile*') || Request::is('profile')) ? 'active' : '' }}" href="{{route('profile')}}">
                    <i class="fi fi-rr-user"></i>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-ligth {{ (Request::is('productList*') || Request::is('product*') || Request::is('editProduct*') || Request::is('productList')) ? 'active' : '' }}" href="{{route('productList')}}">
                    <i class="fi fi-rr-shop"></i>
                    <span class="nav-link-text ms-1">Ad Listing</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link text-ligth {{ (Request::is('hjForum*') || Request::is('hjForum')) ? 'active' : '' }}" href="{{route('hjForum.index')}}">
                    <i class="fi fi-rr-tags"></i>
                    <span class="nav-link-text ms-1">HJ Form</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-ligth" href="{{route('favorite')}}">
                    <i class="fi fi-rr-star-comment-alt"></i>
                    <span class="nav-link-text ms-1">Favorite Ads</span>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link text-ligth" href="{{route('review')}}">
                    <i class="fi fi-rr-review"></i>
                    <span class="nav-link-text ms-1">Reviews</span>
                </a>
            </li> --}}
            

            <li class="nav-item">
                <a class="nav-link text-ligth" href="{{route('messages')}}">
                    <i class="fi fi-rr-messages-question"></i>
                    <span class="nav-link-text ms-1">Messages</span>
                </a>
            </li>

             <li class="nav-item">
                <a class="nav-link text-ligth {{ (Request::is('community*') || Request::is('community')) ? 'active' : '' }}" href="{{route('community.index')}}">
                    <i class="fi fi-rr-tags"></i>
                    <span class="nav-link-text ms-1">Community & Events</span>
                </a>
            </li>


            {{--<li class="nav-item">
                <a class="nav-link text-ligth" href="{{route('bidDetails')}}">
                    <i class="fi fi-rr-messages-question"></i>
                    <span class="nav-link-text ms-1">Bid Details</span>
                </a>
            </li>--}}

            <li class="nav-item"></li>
            <li class="nav-item"></li>
            <li class="nav-item"></li>
        </ul>
    </div>
    <div class="sidenav-footer position-absolute bottom-0 ">
        <div class="mx-3 pb-3 me-auto">
            <a class="text-white" href="{{route('logout')}}" type="button"><i class="fi fi-rr-exit"></i> Log Out</a>
        </div>
    </div>
</aside>