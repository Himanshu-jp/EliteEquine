@extends('front.layouts.main')
<style>
        /* body { margin: 0; padding: 0; }
        .map-locations .col-md-6 { position: relative; }
        .map-locations .col-md-6 #map { position: absolute; top: 0; left: 0; width: 98%; border:0; border-radius: 14px; height:120vh; } */
        .category-scroll button {border: none;}
        .category-scroll button.active .card-list {background: #d6b868;}
    </style>
@section('title')
Home
@endsection
@section('content')

<!-------------------------------- banner_area ------------------------------------>
<section class="banner_area">
    <div class="container">
        <div class="banner_area_inner">
            <div class="image_bx">
                <img src="{{asset('front/home/assets/images/hource_img_banner.png')}}" alt="" />
            </div>
            <div class="banner_area_inner1">
                <h1>
                    Your One Stop <span>Hunter/Jumper</span>
                    <span>Equestrian</span> Shop
                </h1>
                <div class="banner_area_inner1_fir">
                    <img src="{{asset('front/home/assets/images/vactors/hource_sm_vactor.png')}}" alt="" />
                    Driven by technology. united by passion elevated by elite
                    equestrians
                </div>

                <form action="{{route('universalSearch')}}" id="universalSearchForm">
                    <div class="banner_area_inner_search">
                        <div class="form_bx">
                            <img src="{{asset('front/home/assets/images/icons/search.svg')}}" alt="search-icon"
                                class="icon" />
                            <input type="text" placeholder="Search for" name="search" id="search" autocomplete="off" />
                        </div>
                        <div class="form_bx">
                            <img src="{{asset('front/home/assets/images/icons/search.svg')}}" alt="search-icon"
                                class="icon" />
                            <input type="text" autocomplete="off" placeholder="Located in" name="location" id="location" />
                        </div>
                        <div class="form_bx">
                            <img src="{{asset('front/home/assets/images/icons/search.svg')}}" alt="search-icon"
                                class="icon" />
                            <select name="category" id="category" class="form-control">
                                <option value="">Category</option>
                                @foreach(__categoryData() as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form_bx1">
                            <button type="submit" class="commen_btn" id="universalSearchButton">Search</button>
                        </div>
                    </div>
                </form>
                <div class="banner_download_app">
                    <h2>Download App and Connect Today</h2>
                    <div class="links">
                         @if($ios_app = social_links('ios_app'))
                        <a href="{{$ios_app}}" target="_blank" rel="noopener noreferrer">
                            <img src="{{asset('front/home/assets/images/vactors/app_store.svg')}}" alt="" />
                        </a>
                        @endif

                        @if($android_app = social_links('android_app'))
                        <a href="{{$android_app}}" target="_blank" rel="noopener noreferrer">
                            <img src="{{asset('front/home/assets/images/vactors/paly_store.svg')}}" alt="" />
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- map location --}}
<section class="map-locations">
    <div class="top-header-map">

        <div class="top-form">
            <form action="{{route('universalSearch')}}" id="universalSearchFormAgain">
                <div class="banner_area_inner_search">
                    <div class="form_bx">
                        <img src="{{asset('front/home/assets/images/icons/search.svg')}}" alt="search-icon"
                            class="icon" />
                        <input type="text" placeholder="Search for" name="search" id="search" autocomplete="off" />
                    </div>
                    <div class="form_bx wow zoomIn location-manage-add" data-wow-delay="0.6s">
                        <img src="{{asset('front/home/assets/images/icons/search.svg')}}" alt="search-icon"
                            class="icon" />
                        <input type="text" autocomplete="off" placeholder="Located in" name="location" id="location" value="{{ request()->query('location') }}" onkeypress="initializeLocationAutocomplete()" autocomplete="off" />
                        <span id="location-message" class="text-danger" style="display: none; font-size: 12px;"></span>
                            <ul id="location-list" style="display: none;">
                                <!-- Location suggestions will appear here -->
                            </ul>
                            <input type="hidden" id="latitude" name="latitude" value="{{ request()->query('latitude')}}">
                            <input type="hidden" id="longitude" name="longitude" value="{{ request()->query('longitude')}}">
                    </div>
                    <div class="form_bx">
                        <img src="{{asset('front/home/assets/images/icons/search.svg')}}" alt="search-icon"
                            class="icon" />
                        <select name="category" id="category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach(__categoryData() as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form_bx1">
                        <button type="submit" class="commen_btn" id="universalSearchButtonAgain">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="category-scroll">
            <button data-id="1">
                <div class="card-list">
                    <img src="{{asset('front/home/assets/images/map-list-1.png')}}">
                    <span>Horses</span>
                </div>
            </button>
            <button data-id="2">
                <div class="card-list">
                    <img src="{{asset('front/home/assets/images/map-list-2.png')}}">
                    <span>Equipment & Apparel </span>
                </div>
            </button>
            <button  data-id="3">
                <div class="card-list">
                    <img src="{{asset('front/home/assets/images/map-list-3.png')}}">
                    <span>Barns & Housing</span>
                </div>
            </button>
            <button  data-id="4">
                <div class="card-list">
                    <img src="{{asset('front/home/assets/images/map-list-4.png')}}">
                    <span>Services & Jobs</span>
                </div>
            </button>
            <button data-id="5">
                <div class="card-list">
                    <img src="{{asset('front/home/assets/images/map-list-5.png')}}">
                    <span>Community & Events</span>
                </div>
            </button>

        </div>
        <div class="map-locainfo">
            <div class="tag-loacinfo">
                <span class="blue"></span>
                Location
            </div>
            <div class="tag-loacinfo">
                <span class="red"></span>
                Trial / Exchange Location
            </div>
            <div class="tag-loacinfo">
                <span class="black"></span>
                Transportation
            </div>
        </div>
    </div>

    <div class="map-info">
        <div id="map">
            <div class="onlinebox"><span class="online"></span> Online</div>
        </div>
        <!-- Card INSIDE MAP container -->
        <div class="horsescard-popup" id="popupCard">
            <div class="inner-box">

                <img src="{{asset('front/home/assets/images/featured_hource1.png')}}" id="popupImage" />
                <div class="info" id="popupInfo"></div>
            </div>
            <span class="close-btn" onclick="closePopup()">×</span>
        </div>
    </div>
</section>

<!-------------------------------- featured_area ------------------------------------>
@if(count($featuredData)>0)
    <section class="featured_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="featured_area_inner">
                        <h2>Featured</h2>
                        <div class="bx1">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">

                            
                               @foreach(__categoryData() as $key => $value)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $key == 1 ? 'active' : '' }}" 
                                                id="{{ $key }}-tab" 
                                                data-bs-toggle="tab"
                                                data-bs-target="#{{ $key }}-tab-pane" 
                                                type="button" 
                                                role="tab"
                                                aria-controls="{{ $key }}-tab-pane" 
                                                aria-selected="{{ $key == 1 ? 'true' : 'false' }}">
                                            {{ $value }}
                                        </button>
                                    </li>
                                @endforeach

                            </ul>
                            <ul class="controal_btns">
                                <li>
                                    <button id="slider-prev">
                                        <img src="{{asset('front/home/assets/images/icons/left_arrow.svg')}}"
                                            alt="left-arrow" />
                                    </button>
                                </li>
                                <li>
                                    <button id="slider-next" class="active">
                                        <img src="{{asset('front/home/assets/images/icons/right_arrow.svg')}}"
                                            alt="right-arrow" />
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="featured_area_inner2">
                        <div class="tab-content" id="myTabContent">
                            @foreach(__categoryData() as $key001=>$value)
                                @if(@$featuredData[$key001] && count(@$featuredData[$key001])>0)
                                    <div class="{{$key001==1?'tab-pane fade active show':'tab-pane fade'}}" id="{{$key001}}-tab-pane" role="tabpanel" aria-labelledby="{{$key001}}-tab" tabindex="{{$key001==1?'1':'0'}}">
                                        <div class="swiper mySwiper">
                                            <div class="swiper-wrapper">
                                                @foreach (@$featuredData[$key001] as $key => $value)                                        
                                                    <div class="swiper-slide">
                                                        <div class="feat_card_bx">
                                                            @if($value->category_id==1)
                                                                <a href="{{route('horseDetails',@$value->id)}}">
                                                            @elseif($value->category_id==2)
                                                                <a href="{{route('equipmentDetails',@$value->id)}}">
                                                            @elseif($value->category_id==3)
                                                                <a href="{{route('barnsDetails',@$value->id)}}">
                                                            @elseif($value->category_id==4)
                                                                <a href="{{route('serviceDetails',@$value->id)}}">
                                                            @endif
                                                                <div class="image">
                                                                    <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="hourse-image">
                                                                    <span class="tag-img">{{@$value->greenEligibilities->commonMaster->name}} </span>
                                                                </div>
                                                            </a>
                                                            <div class="content">
                                                                @if($value->category_id==1)
                                                                    <a href="{{route('horseDetails',@$value->id)}}">
                                                                        <h3>
                                                                            {{@$value->title}} | {{@$value->productDetail->age}} | {{@$value->height->commonMaster->name}} <br />
                                                                            {{ @$value->breeds->map(function($breed) {
                                                                                return optional($breed->commonMaster)->name;
                                                                            })->filter()->implode(' | ') }}

                                                                            
                                                                        </h3>
                                                                    </a>

                                                                    <h4 onclick="window.location.href='{{route('sale')}}'">Call For Price</h4>

                                                                    <span class="sp1">
                                                                        {{ @$value->disciplines->map(function($disciplines) {
                                                                            return optional($disciplines->commonMaster)->name;
                                                                        })->filter()->implode(' | ') }}
                                                                    </span>
                                                                    <div class="location">
                                                                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}" alt="location-icon" />
                                                                        <span>{{@$value->productDetail->city}}, {{@$value->productDetail->state}}, {{@$value->productDetail->country}} <br />
                                                                            Trial: {{ @$value->triedUpcomingShows->map(function($upcoming) {
                                                                                        return optional($upcoming->commonMaster)->name;
                                                                                    })->filter()->implode(' | ') }}
                                                                        @if(@$value->productDetail->fromdate)
                                                                            <br/>
                                                                            ({{ format_date(@$value->productDetail->fromdate).' - '.format_date(@$value->productDetail->todate)}})
                                                                        @endif
                                                                    </div>
                                                                @elseif($value->category_id==2)
                                                                    <a href="{{route('equipmentDetails',@$value->id)}}">
                                                                        <h3>
                                                                            {{@$value->title}}
                                                                        </h3>
                                                                    </a>

                                                                    {{-- <h4>Call For Price</h4> --}}

                                                                    <h4>Price: ${{number_format(@$value->productDetail->price)}} </h4>
                                                                    {{-- <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4> --}}

                                                                    <span class="sp1">
                                                                        {{ @$value->disciplines->map(function($disciplines) {
                                                                            return optional($disciplines->commonMaster)->name;
                                                                        })->filter()->implode(' | ') }}
                                                                        </span>
                                                                    <div class="location">
                                                                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}" alt="location-icon" />
                                                                        <span>{{@$value->productDetail->city}}, {{@$value->productDetail->state}}, {{@$value->productDetail->country}} </span>                                                                       
                                                                    </div>
                                                                @elseif($value->category_id==3)
                                                                    <a href="{{route('barnsDetails',@$value->id)}}">
                                                                        <h3>
                                                                            {{@$value->title}}
                                                                            {{-- {{@$value->title}} | {{@$value->productDetail->age}} | {{@$value->height->commonMaster->name}} <br />
                                                                            {{ @$value->breeds->map(function($breed) {
                                                                                return optional($breed->commonMaster)->name;
                                                                            })->filter()->implode(' | ') }} --}}
                                                                        </h3>
                                                                    </a>

                                                                    {{-- <h4>Call For Price</h4> --}}
                                                                    <h4>Daily Rent Price: ${{number_format(@$value->productDetail->daily_board_rental_rate)}} </h4>
                                                                    <h4>Weekly Rent Price: ${{number_format(@$value->productDetail->weekly_board_rental_rate)}} </h4>
                                                                    <h4>Monthly Rent Price: ${{number_format(@$value->productDetail->monthly_board_rental_rate)}} </h4>
                                                                    <h4>Sale Price: ${{number_format(@$value->productDetail->sale_cost)}} </h4>
                                                                    {{-- <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4> --}}

                                                                    <span class="sp1">
                                                                        {{ @$value->disciplines->map(function($disciplines) {
                                                                            return optional($disciplines->commonMaster)->name;
                                                                        })->filter()->implode(' | ') }}
                                                                        </span>
                                                                    <div class="location">
                                                                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}" alt="location-icon" />
                                                                        <span>{{@$value->productDetail->city}}, {{@$value->productDetail->state}}, {{@$value->productDetail->country}} <br />
                                                                            Trial: {{ @$value->triedUpcomingShows->map(function($upcoming) {
                                                                                        return optional($upcoming->commonMaster)->name;
                                                                                    })->filter()->implode(' | ') }}
                                                                        @if(@$value->productDetail->fromdate)
                                                                            <br/>
                                                                            ({{ format_date(@$value->productDetail->fromdate).' - '.format_date(@$value->productDetail->todate)}})
                                                                        @endif
                                                                    </div>
                                                                @elseif($value->category_id==4)
                                                                    <a href="{{route('serviceDetails',@$value->id)}}">
                                                                        <h3>
                                                                            {{@$value->title}}
                                                                            {{-- {{@$value->title}} | {{@$value->productDetail->age}} | {{@$value->height->commonMaster->name}} <br />
                                                                            {{ @$value->breeds->map(function($breed) {
                                                                                return optional($breed->commonMaster)->name;
                                                                            })->filter()->implode(' | ') }} --}}
                                                                        </h3>
                                                                    </a>

                                                                    {{-- <h4>Call For Price</h4> --}}
                                                                    <h4>Houlry Pay: ${{number_format(@$value->productDetail->hourly_price)}} </h4>
                                                                    <h4>Fixed Pay: ${{number_format(@$value->productDetail->fixed_price)}} </h4>
                                                                    <h4>Salary Price: ${{number_format(@$value->productDetail->salary)}} </h4>

                                                                    <span class="sp1">
                                                                        {{ @$value->disciplines->map(function($disciplines) {
                                                                            return optional($disciplines->commonMaster)->name;
                                                                        })->filter()->implode(' | ') }}
                                                                        </span>
                                                                    <div class="location">
                                                                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}" alt="location-icon" />
                                                                        <span>{{@$value->productDetail->city}}, {{@$value->productDetail->state}}, {{@$value->productDetail->country}} <br />
                                                                            Dates Available : {{ @$value->triedUpcomingShows->map(function($upcoming) {
                                                                                        return optional($upcoming->commonMaster)->name;
                                                                                    })->filter()->implode(' | ') }}
                                                                        @if(@$value->productDetail->fromdate)
                                                                            <br/>
                                                                            ({{ format_date(@$value->productDetail->fromdate).' - '.format_date(@$value->productDetail->todate)}})
                                                                        @endif
                                                                    </div>
                                                                @endif

                                                                <!----fixed for all category --->
                                                                <div class="foot">
                                                                    <div class="bx">
                                                                        <div class="imagee">
                                                                            <img src="{{(@$value->user->profile_photo_path)?asset('storage/'.@$value->user->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}" class="user-img" alt="">
                                                                        </div>
                                                                        <div class="content">
                                                                            <h4>{{@$value->user->name}}</h4>
                                                                            <div class="stars">
                                                                                @php
                                                                                    $averageRating = round(optional(@$value->user->reviews)->avg('rating'), 1);
                                                                                    $totalReviews  = optional(@$value->user->reviews)->count();
                                                                                @endphp 
                                                                                @for ($i = 1; $i <= 5; $i++)
                                                                                    <i class="bi bi-star-fill {{ $i <= $averageRating ? 'text-warning' : 'text-secondary' }}"></i>
                                                                                @endfor
                                                                                <!-- <i class="fa-solid fa-star"></i>
                                                                                <i class="fa-solid fa-star"></i>
                                                                                <i class="fa-solid fa-star"></i>
                                                                                <i class="fa-solid fa-star"></i>
                                                                                <i class="fa-solid fa-star"></i> -->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="bx2">
                                                                        <button class="compare-add-button" data-id="{{$value->id}}">
                                                                            <img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}" alt="" />
                                                                        </button>
                                                                        <button class="favorite-btn {{ $value->favorites->where('user_id', auth()->id())->count() ? 'favorited' : '' }}" data-product-id="{{ $value->id }}">
                                                                            @if($value->favorites->where('user_id', auth()->id())->count() > 0)
                                                                                <i class="fa-solid fa-heart"></i>
                                                                            @else
                                                                            <i class="fa-regular fa-heart favorited"></i>
                                                                            @endif
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else

                                    {{--<div class="{{$key==1?'tab-pane fade active show':'tab-pane fade'}}" id="{{$key001}}-tab-pane" role="tabpanel" aria-labelledby="{{$key001}}-tab" tabindex="{{$key==1?'1':'0'}}">
                                        <div class="swiper mySwiper">
                                            <div class="swiper-wrapper">     
                                                <h4>We're updating our featured section. Check back later!</h4> 
                                            </div>
                                        </div>
                                    </div>--}}
                                    
                                @endif
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-------------------------------- industry_area ------------------------------------>
@if($industryMatricData->isNotEmpty())
<section class="industry_area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="industry_area_inner">
                    <h2>Industry Metrics</h2> 
                    <div class="industry_slider_controal">
                        <button id="slider-prev1">
                            <i class="fa-solid fa-arrow-left-long"></i>
                        </button>
                        <button id="slider-next1">
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="industry_area_inner2">
                    <div thumbsSlider="" class="swiper mySwiper1">
                        <div class="swiper-wrapper">
                            @foreach($industryMatricData as $matric)
                            <div class="swiper-slide">
                                <div class="industry_area_sld_bx">
                                    <div class="content">
                                        <h3>{{$matric->title}}</h3>
                                        <button class="commen_btn">Read More</button>
                                    </div>
                                    <img src="{{ asset('storage/' . $matric->image) }}" alt="" />
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div style="
                --swiper-navigation-color: #fff;
                --swiper-pagination-color: #fff;
                " class="swiper mySwiper2">
                        <div class="swiper-wrapper">
                            @foreach($industryMatricData as $matric)
                            <div class="swiper-slide">
                                <div class="industry_area_sld_bx1">
                                    <p>
                                        {!! $matric->description !!}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </section>
@endif

<!-------------------------------- about_area ------------------------------------>
@if(!empty($homeAboutData))
    <section class="about_area">
        <div class="container z-11">
            <div class="row">
                <div class="col-lg-6 my-auto">
                    <div class="about_area_inner">
                        <h2>About Us</h2>
                        {!! $homeAboutData->description !!}
                        <a href="{{url('/aboutus')}}"><span>Read More</span><i class="fa-solid fa-arrow-up"></i></a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="about_area_inner1">
                        <img src="{{  asset('storage/' . $homeAboutData->image) }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-------------------------------- forseller_area ------------------------------------>
@if(!empty($sellerBusinessData))
    <section class="forseller_area">
        <div class="container-fluid ps-lg-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="forseller_area_head">
                        <h2>For Sellers and Businesses</h2>
                    </div>
                </div>
                <div class="col-lg-6 ps-0 my-auto">
                    <div class="forseller_area_inner">
                        <img src="{{ asset('storage/' . $sellerBusinessData->image) }}" alt="" />
                    </div>
                </div>
                <div class="col-xxl-5 col-lg-6">
                    <div class="forseller_area_inner2">
                        @php
                            $sections = ['listing' => 'Listing', 'track' => 'Track', 'featured' => 'Featured', 'post' => 'Post'];
                        @endphp
                        @foreach ($sections as $key => $label) 
                        @php 
                            $title = $key.'_title'; 
                            $icon = $key.'_icon'; 
                            $content = $key.'_content'; 
                        @endphp
                        
                        <div class="bx1">
                            <img src="{{asset('storage/'. $sellerBusinessData->$icon)}}" alt="" />
                            <h3>{{$sellerBusinessData->$title}}</h3>
                            {{$sellerBusinessData->$content}}
                        </div>
                        @endforeach
                        
                    </div>
                    <div class="forseller_area_inner3">
                        {!! $sellerBusinessData->description !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

<!-------------------------------- forbuyer_area ------------------------------------>
@if(!empty($buyerBrowserData) && !empty($buyerFaqData))
    <section class="forbuyer_area">
        <div class="container z-11">
            <div class="row">
                <div class="col-lg-12">
                    <div class="forbuyer_area_inner">
                        <h2>For Buyers and Browsers</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-5 align-items-center">
                <div class="col-lg-6">
                    <img src="{{asset('storage/'.$buyerBrowserData->image)}}" alt="" />
                </div>
                <div class="col-lg-6">
                    <div class="accordion my-4" id="simpleAccordion">
                        @foreach($buyerFaqData as $index => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{$index}}">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$index}}">
                                    {{$faq->questions}}
                                </button>
                            </h2>
                            <div id="collapse{{$index}}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}"
                                data-bs-parent="#simpleAccordion">
                                <div class="accordion-body">
                                    {!! $faq->answers !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="desic">
                    {!! $buyerBrowserData->description !!}
                </div>
            </div>
        </div>
    </section>
@endif




<!-------------------------------- Blogs_area ------------------------------------>
<?php /*
@if($blogs->count() > 0)
    <section class="blog py-5">
        <div class="container">

            <div class="row">
                <div class="col-lg-8">
                    <h1>Latest Posts</h1>
                </div>
                <div class="col-lg-4">
                    <div class="button-all">
                        <a href="{{route('blog')}}">
                            <button class="commen_btn">
                                See All Posts
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">

                        @for($i=0; $i<2; $i++)
                            <div class="col-lg-6">
                                <div class="blog-card">
                                    <a href="{{ route('blog-details', @$blogs[$i]->id) }}" class="thumb">
                                        {{-- <img src="{{asset('front/home/assets/images/blog-s-img-1.png')}}" alt="" /> --}}
                                        <img src="{{(@$blogs[$i]->image)?asset('storage/'.@$blogs[$i]->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="{{@$blogs[$i]->title}}">                                    
                                        <div class="time-post"><span>{{ @$blogs[$i]->created_at->format('d-m-Y') }}</span> <span>{{@$blogs[$i]->category->name}}</span></div>
                                        <h3>{{ Str::limit(@$blogs[$i]->title, 40, '...') }}</h3>
                                        <p>{!! Str::limit(@$blogs[$i]->content, 250, '...')  !!}</p>
                                    </a>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-list-post">

                        @for($i=2; $i<$blogs->count(); $i++)
                            <div class="list-blog">
                                {{-- <img src="{{asset('front/home/assets/images/blog-s-img-1.png')}}" alt="" /> --}}
                                <img src="{{(@$blogs[$i]->image)?asset('storage/'.@$blogs[$i]->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="{{@$blogs[$i]->title}}">
                                <a href="{{ route('blog-details', @$blogs[$i]->id) }}" class="thumb">
                                    <div class="blog-info">
                                        <div class="time-post"><span>{{ @$blogs[$i]->created_at->format('d-m-Y') }}</span> <span>{{@$blogs[$i]->category->name}}</span></div>
                                        <h3>{{ Str::limit(@$blogs[$i]->title, 40, '...') }}</h3>
                                    </div>
                                </a>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
*/ ?>

<!--------------------------------  H/J Forum area  ------------------------------------>
{{-- @if(count($hjForumData)>0)
    <section class="industry_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 d-flex justify-content-between align-items-center flex-wrap ">
                    <div class="industry_area_inner">
                        <h2>H/J Forum</h2>
                    </div>
                    <button class="commen_btn border-0">See All Posts</button>
                </div>

                <div thumbsSlider="" class="swiper mySwiper1">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="forum-box">
                                    <img src="{{asset('front/home/assets/images/blog-s-img-1.png')}}" class="image" alt="logo">
                                    <div class="forum-content">
                                        <div class="card-meta">08-11-2021 &nbsp; &nbsp; Category</div>
                                        <div class="card-title">Partiality on or continuing in particular principles</div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="forum-box">
                                    <img src="{{asset('front/home/assets/images/blog-s-img-2.png')}}" class="image" alt="logo">
                                    <div class="forum-content">
                                        <div class="card-meta">08-11-2021 &nbsp; &nbsp; Category</div>
                                        <div class="card-title">Do believing oh disposing to supported allowance we.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="forum-box">
                                    <img src="{{asset('front/home/assets/images/blog-s-img-3.png')}}" class="image" alt="logo">
                                    <div class="forum-content">
                                        <div class="card-meta">08-11-2021 &nbsp; &nbsp; Category</div>
                                        <div class="card-title">Village did removed enjoyed explain nor ham saw.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="forum-box">
                                    <img src="{{asset('front/home/assets/images/blog-s-img-4.png')}}" class="image" alt="logo">
                                    <div class="forum-content">
                                        <div class="card-meta">08-11-2021 &nbsp; &nbsp; Category</div>
                                        <div class="card-title">Partiality on or continuing in particular principles</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="industry_slider_controal justify-content-center mt-4">
                    <button id="slider-prev1" tabindex="0" aria-label="Previous slide" aria-controls="swiper-wrapper-212c6328bee8fed5">
                        <i class="fa-solid fa-arrow-left-long"></i>
                    </button>
                    <button id="slider-next1" tabindex="0" aria-label="Next slide" aria-controls="swiper-wrapper-212c6328bee8fed5">
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
@endif --}}

<!--------------------------------  H/J Forum area end  ------------------------------------>

<!--------------------------------  Collaborations area  ------------------------------------>


@if($partnershipCollaborate->isNotEmpty())
<section class="section pt-0">
    <div class="container">
        <div class="section-heading">
            <h2>Collaborations</h2>
        </div>
        <div class="tag-scrollers">
            <div class="tag-scroller scrolling">
                <ul class="tag-list" style="--duration: 35.32s;">
                     @foreach($partnershipCollaborate as $image)
                    <li>
                        <div class="greview">
                            <img src="{{asset('storage/'. $image->image)}}" alt="logo">
                        </div>
                    </li>
                    @endforeach
                </ul>
                <ul class="tag-list" style="--duration: 35.30s;">
                     @foreach($partnershipCollaborate as $image)
                    <li>
                        <div class="greview">
                            <img src="{{asset('storage/'. $image->image)}}" alt="logo">
                        </div>
                    </li>
                    @endforeach
                </ul>
                <ul class="tag-list" style="--duration: 35.32s;">
                     @foreach($partnershipCollaborate as $image)
                    <li>
                        <div class="greview">
                            <img src="{{asset('storage/'. $image->image)}}" alt="logo">
                        </div>
                    </li>
                    @endforeach
                </ul>
                <ul class="tag-list" style="--duration: 35.32s;">
                     @foreach($partnershipCollaborate as $image)
                    <li>
                        <div class="greview">
                            <img src="{{asset('storage/'. $image->image)}}" alt="logo">
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endif

<!-------------------------------- Newsletter / Subscribe area  ------------------------------------>
<section class="section" style="background-color: #D8C07E;">
    <div class="container pb-5">
        <div class="row align-items-center">
            <div class="col-lg-5 me-auto text-center">
                <img src="{{ asset('front/home/assets/images/newsletter-img.png') }}" width="100%" alt="Newsletter Image">
            </div>
            <div class="col-lg-5 ms-auto">
                <div class="newsletter-box">
                    <h2>Subscribe to our Newsletter!</h2>
                    {{-- Success message --}}
                    @if(session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Error message --}}
                    @if($errors->any())
                        <div class="alert alert-danger mt-2">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <form action="{{ route('newsletter.subscribe') }}" id="newsletterForm" method="POST" class="subscribe-form position-relative">
                        @csrf
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="Enter your email" 
                            class="form-control" 
                            required
                            aria-label="Email address for newsletter subscription"
                        />
                        <img class="icon-input" src="{{ asset('front/home/assets/images/search-icon.svg') }}" alt="Search Icon">
                        <button type="submit" class="apply-flitter mt-3 w-100">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- jQuery & CKEditor -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/v3.9.0/mapbox-gl.js"></script>
<!-- map box -->
     <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />
<script>
    $(window).on('load', function(){
    $($("#myTab .nav-item .nav-link")[0]).addClass('active');
});
    $(document).ready(function () {
        $("#newsletterForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                }
            },
            errorElement: 'span',
            errorClass: 'text-danger',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                $('#subscribeBtn').attr('disabled', true).text('Subscribing...');
                form.submit();
            }
        });
        
        $("#universalSearchForm").validate({
            rules: {
                category: {
                    required: true
                }
            },
            messages: {
                category: {
                    required: "Please select an option in the list",
                }
            },
            errorElement: 'span',
            errorClass: 'text-danger',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                $('#universalSearchButton').attr('disabled', true).text('Search...');
                form.submit();
            }
        });
        
        $("#universalSearchFormAgain").validate({
            rules: {
                category: {
                    required: true
                }
            },
            messages: {
                category: {
                    required: "Please select an option in the list",
                }
            },
            errorElement: 'span',
            errorClass: 'text-danger',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                $('#universalSearchButtonAgain').attr('disabled', true).text('Search...');
                form.submit();
            }
        });
    });
</script>
<script src="https://api.mapbox.com/mapbox-gl-js/v3.9.0/mapbox-gl.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-supported/v1.0.0/mapbox-gl-supported.js"></script>
<script>
let mapboxAccessToken = '{{ config("config.map_box_access_token") }}';
mapboxgl.accessToken = mapboxAccessToken;

let map; // global map reference
let currentPopup = null; // to keep track of the currently opened popup

window.onload = () => {
    const urlParams = new URLSearchParams(window.location.search);
    const lat = urlParams.get('latitude') || 26.8467;
    const lng = urlParams.get('longitude') || 75.7647;
    const selectedCategory = urlParams.get('category') || '1';

    initializeMap(parseFloat(lat), parseFloat(lng));

    // Set active category button
    const buttons = document.querySelectorAll('.category-scroll button[data-id]');
    let activeButton = document.querySelector(`.category-scroll button[data-id="${selectedCategory}"]`);
    if (!activeButton) {
        activeButton = document.querySelector('.category-scroll button[data-id="1"]');
    }
    if (activeButton) {
        activeButton.classList.add('active');
        fetchEventsByCategory(selectedCategory);
    }

    // Handle category click
    document.querySelector('.category-scroll').addEventListener('click', function (e) {
        const btn = e.target.closest('button[data-id]');
        if (!btn) return;

        document.querySelectorAll('.category-scroll button[data-id]').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const catId = btn.getAttribute('data-id');
        const url = new URL(window.location);
        url.searchParams.set('category', catId);
        window.history.replaceState({}, '', url);

        // Close any open popup before fetching new markers
        if (currentPopup) {
            currentPopup.remove();
            currentPopup = null;
        }

        fetchEventsByCategory(catId);
    });
};

function initializeMap(latitude, longitude) {
    map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [longitude, latitude],
        zoom: 10,
        pitch: 60,
        bearing: -20
    });

    map.addControl(new mapboxgl.NavigationControl(), 'top-right');
}

function fetchEventsByCategory(categoryId) {
    if (!map) return;

    // Remove all existing markers
    const oldMarkers = document.querySelectorAll('.mapboxgl-marker');
    oldMarkers.forEach(m => m.remove());

    // Close any open popup
    if (currentPopup) {
        currentPopup.remove();
        currentPopup = null;
    }

    let apiUrl = '{{ url("/api/v1/product/mapbox-list?category=") }}' + categoryId;
    fetch(apiUrl)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            updateMapMarkers(data);
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
}

function updateMapMarkers(events) {
    if (!map) return;

    if (!events.length) {
        // Optionally clear markers or show “no results” message
        return;
    }

    const eventGroups = {};

    events.forEach(event => {
        const lat = parseFloat(event.product_detail?.latitude);
        const lng = parseFloat(event.product_detail?.longitude);
        if (!isNaN(lat) && !isNaN(lng)) {
            const key = `${lat},${lng}`;
            if (!eventGroups[key]) eventGroups[key] = [];
            eventGroups[key].push(event);
        }
    });

    const venueDetailRoute = "{{ route('horseDetails', ':id') }}";
    const activeClass = 'active-marker';

    for (const latLng in eventGroups) {
        const [lat, lng] = latLng.split(',').map(Number);
        const markerEl = document.createElement('div');
        markerEl.className = 'red-circle-marker';

        const img = document.createElement('img');
        img.src = "{{ asset('images/marker_map_icon.svg') }}";
        img.className = 'marker-image';
        markerEl.appendChild(img);

        const firstProduct = eventGroups[latLng][0];
        const venueName = document.createElement('span');
        venueName.className = 'marker-venue-name';
        venueName.innerText = firstProduct.title || 'No Title';
        markerEl.appendChild(venueName);

        const marker = new mapboxgl.Marker(markerEl).setLngLat([lng, lat]).addTo(map);

        const popupHTML = eventGroups[latLng].map(product => {
            const title = product.title || 'Untitled';
            const desc = product.description || '';
            const truncated = desc.length > 40 ? desc.slice(0, 40) + '...' : desc;
            const imgUrl = product.image?.[0]?.image ? `/storage/${product.image[0].image}` : '';
            const price = product.price || product.product_detail?.sale_price || 'N/A';
            const fullAddr = [product.product_detail?.street, product.product_detail?.city, product.product_detail?.state, product.product_detail?.country].filter(Boolean).join(', ');
            const detailUrl = venueDetailRoute.replace(':id', product.id);

            return `
                <div class="map-pp-main">
                    <div class="evn-dte-ll">
                        <div class="ent-emg">
                            ${imgUrl ? `<img src="${imgUrl}" style="width:60px;height:60px;" alt="${title}">` : ''}
                            <div>
                                <h3><a href="${detailUrl}" target="_blank">${title}</a></h3>
                                <p>${truncated}</p>
                            </div>
                        </div>
                        <div class="venue-name-new-ic">
                            <img src="{{ asset('images/marker_map_icon.svg') }}" alt="Location icon" />
                            ${fullAddr}
                        </div>
                        <div class="loc-meta">
                            <div><strong>Price:</strong> $${price}</div>
                            <div class="loc-metabutton">
                                <a href="${detailUrl}" target="_blank" class="meta-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(popupHTML);

        marker.setPopup(popup);

        markerEl.addEventListener('click', () => {
            // Close previously opened popup if different
            if (currentPopup && currentPopup !== popup) {
                currentPopup.remove();
            }
            // Toggle the clicked popup
            popup.toggle();
            currentPopup = popup;

            document.querySelectorAll('.red-circle-marker').forEach(el => el.classList.remove(activeClass));
            markerEl.classList.add(activeClass);
        });
    }
}
</script>



@endsection