<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('front/home/assets/images/logo/logo.svg') }}" alt="Elight Equine Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">ELITeQUINE</span>
    </a>

    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Manage Categories --}}
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>Manage Categories</p>
                    </a>
                </li>

                {{-- Manage Sub-Categories --}}
                <li class="nav-item">
                    <a href="{{ route('sub-categories.index') }}" class="nav-link {{ request()->routeIs('sub-categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-stream"></i>
                        <p>Manage Sub-Categories</p>
                    </a>
                </li>

                {{-- Manage Users --}}
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>Manage Users</p>
                    </a>
                </li>

                {{-- Manage Blogs --}}
                <li class="nav-item">
                    <a href="{{ route('blogs.index') }}" class="nav-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-blog"></i>
                        <p>Manage Blogs</p>
                    </a>
                </li>

                {{-- Manage CMS Pages --}}
                <li class="nav-item">
                    <a href="{{ route('cms_pages.index') }}" class="nav-link {{ request()->routeIs('cms_pages.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Manage CMS Pages</p>
                    </a>
                </li>

                {{-- Subscription Plans --}}
                <li class="nav-item">
                    <a href="{{ route('subscription_plans.index') }}" class="nav-link {{ request()->routeIs('subscription_plans.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Subscription Plans</p>
                    </a>
                </li>

                {{-- Subscription Addons --}}
                <li class="nav-item">
                    <a href="{{ route('subscription-addons.index') }}" class="nav-link {{ request()->routeIs('subscription-addons.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-puzzle-piece"></i>
                        <p>Subscription Addons</p>
                    </a>
                </li>

                {{-- Common Masters --}}
                <li class="nav-item">
                    <a href="{{ route('common-masters.index') }}" class="nav-link {{ request()->routeIs('common-masters.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p>Common Masters</p>
                    </a>
                </li>

                {{-- Manage Products --}}
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-horse-head"></i>
                        <p>Manage Products</p>
                    </a>
                </li>

                {{-- Manage Enquiries --}}
                <li class="nav-item">
                    <a href="{{ route('enquiries.index') }}" class="nav-link {{ request()->routeIs('enquiries.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Manage Enquiries</p>
                    </a>
                </li>

                {{-- Newsletter Subscribers --}}
                <li class="nav-item">
                    <a href="{{ route('newsletters.index') }}" class="nav-link {{ request()->routeIs('newsletters.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope-open-text"></i>
                        <p>Newsletter Subscribers</p>
                    </a>
                </li>

                {{-- Social Links --}}
                <li class="nav-item">
                    <a href="{{ route('social.link') }}" class="nav-link {{ request()->routeIs('social-links.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-share-alt"></i>
                        <p>Social Links</p>
                    </a>
                </li>

                {{-- Website Manage --}}
                @php
                    $websiteManageActive = request()->is('admin/industry_metrics*') 
                        || request()->is('admin/home_about*') 
                        || request()->is('admin/seller-business*') 
                        || request()->is('admin/buyers*') 
                        || request()->is('admin/about*') 
                        || request()->is('admin/about-seller-business*') 
                        || request()->is('admin/partner_content*') 
                        || request()->is('admin/partner_collaborate*') 
                        || request()->is('admin/partner_ways*');
                @endphp
                <li class="nav-item has-treeview {{ $websiteManageActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $websiteManageActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>
                            Website Manage
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        {{-- Home Manage --}}
                        @php
                            $homeManageActive = request()->is('admin/industry_metrics*') 
                                || request()->is('admin/home_about*') 
                                || request()->is('admin/seller-business*') 
                                || request()->is('admin/buyers*');
                        @endphp
                        <li class="nav-item has-treeview {{ $homeManageActive ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ $homeManageActive ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Home Manage
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('industry_metrics.index') }}" class="nav-link {{ request()->routeIs('industry_metrics.*') ? 'active' : '' }}">
                                        <i class="fas fa-industry nav-icon"></i>
                                        <p>Industry Metrics</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('home_about.show') }}" class="nav-link {{ request()->routeIs('home_about.*') ? 'active' : '' }}">
                                        <i class="fas fa-info-circle nav-icon"></i>
                                        <p>Home About Us</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('seller-business.show') }}" class="nav-link {{ request()->routeIs('seller-business.*') ? 'active' : '' }}">
                                        <i class="fas fa-store nav-icon"></i>
                                        <p>Home Seller & Business</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('buyers.show') }}" class="nav-link {{ request()->routeIs('buyers.*') ? 'active' : '' }}">
                                        <i class="fas fa-users nav-icon"></i>
                                        <p>Buyer & Browser</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- About Us Manage --}}
                        @php
                            $aboutUsActive = request()->is('admin/about*') || request()->is('admin/about-seller-business*');
                        @endphp
                        <li class="nav-item has-treeview {{ $aboutUsActive ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ $aboutUsActive ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    About Us Manage
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('about.show') }}" class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}">
                                        <i class="fas fa-info-circle nav-icon"></i>
                                        <p>About Us</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('about-seller-business.show') }}" class="nav-link {{ request()->routeIs('about-seller-business.*') ? 'active' : '' }}">
                                        <i class="fas fa-store-alt nav-icon"></i>
                                        <p>About Seller & Business</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- Partnership Manage --}}
                        @php
                            $partnershipActive = request()->is('admin/partner_content*') 
                                || request()->is('admin/partner_collaborate*') 
                                || request()->is('admin/partner_ways*');
                        @endphp
                        <li class="nav-item has-treeview {{ $partnershipActive ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ $partnershipActive ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Partnership Manage
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('partner_content.show') }}" class="nav-link {{ request()->routeIs('partner_content.*') ? 'active' : '' }}">
                                        <i class="fas fa-file-alt nav-icon"></i>
                                        <p>Partner Ship Content</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('partner_collaborate.index') }}" class="nav-link {{ request()->routeIs('partner_collaborate.*') ? 'active' : '' }}">
                                        <i class="fas fa-handshake nav-icon"></i>
                                        <p>Partner Ship Collaborate</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('partner_ways.index') }}" class="nav-link {{ request()->routeIs('partner_ways.*') ? 'active' : '' }}">
                                        <i class="fas fa-route nav-icon"></i>
                                        <p>Partner Ship Ways</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>
