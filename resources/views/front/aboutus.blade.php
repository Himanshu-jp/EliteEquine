@extends('front.layouts.main')
@section('title')
About us
@endsection
@section('content')
<section class="hero-content-wrapper about-us-page">
    <div class="container">
        <div class="simplebar-content">
            <div class="row align-items-center">

                <div class="col-lg-5 mx-auto">
                    <div class="about-title text-start">
                        <h1>Mobile App On The Way!</h1>
                        <p>ELITE EQUINE is your One Stop Equestrian Shop and premier destination for high quality
                            hunter-jumper horses, equine, barn, and rider equipment, boarding barns and equestrian
                            properties, as well as equine services and jobs. How do we work?</p>
                    </div>
                </div>
                <div class="col-lg-7 ">
                    <div class="text-center">
                        <img src="{{asset('front/home/assets/images/about-banner.png')}}" class="w-100" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if(!empty($aboutData))
<section class="section story-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h2 class="title">For Sellers and Businesses: </h2>
            </div>
            <div class="col-lg-7 ms-auto">
                {!! $aboutData->description !!}
            </div>
        </div>
        <div class="story-img">
            <img src="{{asset('storage/'.$aboutData->image)}}" classs="w-100">
        </div>
    </div>
</section>
   
@endif
 <section class="about_for_buyers ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 my-auto">
                    <div class="about_area_inner">
                       <img src="{{asset('front/home/assets/images/mobile-fream-img.png')}}"  alt="">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="about_horses_img">
                          <img src="{{asset('front/home/assets/images/horse-image.png')}}"   alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
@if(!empty($aboutSellerBusinessData))
<section class="section services-opions-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="services-opions">
                    <div class="row">
                        @php
                            $sections = ['listing' => 'Listing', 'track' => 'Track', 'featured' => 'Featured', 'post' => 'Post'];
                        @endphp
                        @foreach ($sections as $key => $label) 
                        @php 
                            $title = $key.'_title'; 
                            $icon = $key.'_icon'; 
                            $content = $key.'_content'; 
                        @endphp
                        <div class="col-md-6">
                            <div class="opions-box">
                                <img src="{{asset('storage/'. $aboutSellerBusinessData->$icon)}}" alt="">
                                <h3>{{ $aboutSellerBusinessData->$title }}</h3>
                                {!! $aboutSellerBusinessData->$content !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <img src="{{asset('storage/'. $aboutSellerBusinessData->image)}}" class="horse-image" alt="">
        </div>
    </div>
</section>
@endif
<section class="section  pb-sm-0">
   <div class="container">
            <div class="row text-center py-5" >
                <div class="disc-info">
                    <p>When you choose Elite Equine, you’re joining an exclusive community of serious equestrians who share your commitment to excellence. We aim to give you the highest rate of success ranging from promoting your equine business, selling an old saddle, booking housing or stabling at an away horse show, comparing price rates for a local feed delivery service, to to finding the horse of your dreams.</p>
                    <p>Our mission is to revolutionize the equestrian industry by harnessing the power of modern technology to connect equestrians and equine businesses worldwide.</p>
                    <p>Together, we are building a global network where passion for horses meets cutting-edge technology. Thanks for being a part of our journey!</p>
                </div>
            </div>
              <div class="row">
                <div class="col-lg-6">
                    <div class="about-extrer-box">
                        <h5>Why Sign Up?</h5>
                        <p class="mb-3">Looking for something in particular? A safe new pony for your young child, a seasoned amateur-friendly hunter lease for the circuit, or a jumper import straight from the EU? A rental property near WEC including horse stabling, a last minute braider, or an additional stall on a trailer headed home for a horse you didn’t anticipate ending up with on the way back?  Look no further!
                            On our platform, you have the ability to:</p>
                    <p>– Utilize very specific filters, keywords, and map to suit your budgetary and regional requirements</p>
                    <p>– View, favorite, share, and compare ads .</p>
                    <p>– Receive alerts (via email and/or text) if a new ad pops up correlating to your specific search criteria</p>
                    <p>– Rate and comment on your experience with listers, promoting a credible community</p>
                    <p>– Access our community-driven forum to turn to for advice and support in your everyday equine encounters</p>
                     
                    </div>
                </div>
                 <div class="col-lg-6">
                    <div class="about-extrer-box">
                         <h5>Why List with Us?</h5>
                        <p class="mb-3">Looking for something in particular? A safe new pony for your young child, a seasoned amateur-friendly hunter lease for the circuit, or a jumper import straight from the EU? A rental property near WEC including horse stabling, a last minute braider, or an additional stall on a trailer headed home for a horse you didn’t anticipate ending up with on the way back?  Look no further!
                            On our platform, you have the ability to:</p>
                    <p>– Utilize very specific filters, keywords, and map to suit your budgetary and regional requirements</p>
                    <p>– View, favorite, share, and compare ads .</p>
                    <p>– Receive alerts (via email and/or text) if a new ad pops up correlating to your specific search criteria</p>
                    <p>– Rate and comment on your experience with listers, promoting a credible community</p>
                    <p>– Access our community-driven forum to turn to for advice and support in your everyday equine encounters</p>
                     
                    </div>
                </div>
              </div>
    </div>
</section>
<section class="section">
<div class="container-fluid mt-4">
   
    <div>
        <div class="col-xxl-8 mx-auto">
            <div class="section-heading">
                <h2 class="text-center fw-bold">Subscription Plans</h2>
            </div>
            <div class="pricing-switcher">
                <p class="fieldset">
                    <input type="radio" name="duration-1" value="standard" id="standard-1" checked="">
                    <label for="standard-1">Standard</label>

                    <input type="radio" name="duration-1" value="featured" id="featured-1">
                    <label for="featured-1">Featured</label>
                </p>
            </div>
            <!-- Standard section start -->
            <div id="standard-section" class="fade show">
                <div class="row">

                                            <div class="col-md-6 col-lg-6 col-xl-4 col-sm-12  mt-3">
                            <div class="bounce-invert">
                                <div class="exclusive">
                                    <div class="pricing-wrapper">
                                        <div data-type="yearly" class="is-hidden">
                                            <div class="pricing-header">
                                                <h4>Basic</h4>
                                                <span>Unlimited Monthly</span>
                                            </div>
                                            <div class="price">$14.99</div>
                                            <div class="pricing-body">
                                                <p>
                                                    </p><p>Post UNLIMITED. Listings will expire in 30 days(unless removed or Sold) without renewal. Includes auto social media promos or homepage showcase.</p>
                                                <p></p>
                                            </div>
                                            <hr class="horizontal dark mt-0 mb-2">
                                            <div class="pricing-footer">
                                                <p>Expires in 30 days </p>
                                                <a href="#" class="btn btn-primary w-100">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                            <div class="col-md-6 col-lg-6 col-xl-4 col-sm-12  mt-3">
                            <div class="bounce-invert">
                                <div class="exclusive">
                                    <div class="pricing-wrapper">
                                        <div data-type="yearly" class="is-hidden">
                                            <div class="pricing-header">
                                                <h4>Medium</h4>
                                                <span>Unlimited Quarterly</span>
                                            </div>
                                            <div class="price">$39.99</div>
                                            <div class="pricing-body">
                                                <p>
                                                    </p><p>Post UNLIMITED. Listings will expire in 90 days(unless removed or Sold) without renewal. Includes auto social media promos or homepage showcase.</p>
                                                <p></p>
                                            </div>
                                            <hr class="horizontal dark mt-0 mb-2">
                                            <div class="pricing-footer">
                                                <p>Expires in 90 days </p>
                                                <a href="#" class="btn btn-primary w-100">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                            <div class="col-md-6 col-lg-6 col-xl-4 col-sm-12  mt-3">
                            <div class="bounce-invert">
                                <div class="exclusive">
                                    <div class="pricing-wrapper">
                                        <div data-type="yearly" class="is-hidden">
                                            <div class="pricing-header">
                                                <h4>Premium</h4>
                                                <span>Unlimited Annual</span>
                                            </div>
                                            <div class="price">$152.99</div>
                                            <div class="pricing-body">
                                                <p>
                                                    </p><p>Post UNLIMITED. Listings will expire in 365 days (unless removed or Sold) without renewal. Includes auto social media promos or homepage showcase.</p>
                                                <p></p>
                                            </div>
                                            <hr class="horizontal dark mt-0 mb-2">
                                            <div class="pricing-footer">
                                                <p>Expires in 365 days </p>
                                                <a href="#" class="btn btn-primary w-100">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                </div>

                <div class="col-md-12 mt-4">
                    <div class="bounce-card">
                        <h4>Add Ons</h4>
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="boostAdCheckbox">
                                <label class="form-check-label" for="boostAdCheckbox">
                                    Boost Ad back to top of Homepage + Socials – $5/ad
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="customPostCheckbox">
                                <label class="form-check-label" for="customPostCheckbox">
                                    Custom post for Socials including "Swipe for Video" with 5 pictures and up to 2
                                    videos – $10/ad. Socials include Instagram, TikTok, + Facebook
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bannerSpaceCheckbox">
                                <label class="form-check-label" for="bannerSpaceCheckbox">
                                    Banner Space: $200 / year
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailBlastCheckbox">
                                <label class="form-check-label" for="emailBlastCheckbox">
                                    Email Blast Promotion to our Newsletter – $50 / blast
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="textBlastCheckbox">
                                <label class="form-check-label" for="textBlastCheckbox">
                                    Text Blast Promotion to our Community – $150 / blast
                                </label>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">$5 Pay Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4 mb-5">
                    <div class="bounce-card d-flex align-items-center flex-wrap justify-content-between">
                        <h6 class="mb-0">FULL SERVICE PACKAGE: Allow us to fully manage and promote all of your listings
                            for you</h6>
                        <a href="#" class="btn btn-primary">Contact us for Pricing</a>
                    </div>
                </div>
            </div>
            <!-- Standard section end -->

            <!-- Featured section start -->
            <div id="featured-section" style="display: none;" class="fade">
                <div class="row">

                                            <div class="col-md-6 col-lg-6 col-xl-4 col-sm-12  mt-3">
                            <div class="bounce-invert">
                                <div class="exclusive">
                                    <div class="pricing-wrapper">
                                        <div data-type="yearly" class="is-hidden">
                                            <div class="pricing-header">
                                                <h4>Basic</h4>
                                                <span>Unlimited Monthly</span>
                                            </div>
                                            <div class="price">$14.99</div>
                                            <div class="pricing-body">
                                                <p>
                                                    </p><p>Post UNLIMITED. Listings will expire in 30 days(unless removed or Sold) without renewal. Includes auto social media promos or homepage showcase.</p>
                                                <p></p>
                                            </div>
                                            <hr class="horizontal dark mt-0 mb-2">
                                            <div class="pricing-footer">
                                                <p>Expires in 30 days </p>
                                                <a href="#" class="btn btn-primary w-100">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                            <div class="col-md-6 col-lg-6 col-xl-4 col-sm-12  mt-3">
                            <div class="bounce-invert">
                                <div class="exclusive">
                                    <div class="pricing-wrapper">
                                        <div data-type="yearly" class="is-hidden">
                                            <div class="pricing-header">
                                                <h4>Medium</h4>
                                                <span>Unlimited Quarterly</span>
                                            </div>
                                            <div class="price">$39.99</div>
                                            <div class="pricing-body">
                                                <p>
                                                    </p><p>Post UNLIMITED. Listings will expire in 90 days(unless removed or Sold) without renewal. Includes auto social media promos or homepage showcase.</p>
                                                <p></p>
                                            </div>
                                            <hr class="horizontal dark mt-0 mb-2">
                                            <div class="pricing-footer">
                                                <p>Expires in 90 days </p>
                                                <a href="#" class="btn btn-primary w-100">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                            <div class="col-md-6 col-lg-6 col-xl-4 col-sm-12  mt-3">
                            <div class="bounce-invert">
                                <div class="exclusive">
                                    <div class="pricing-wrapper">
                                        <div data-type="yearly" class="is-hidden">
                                            <div class="pricing-header">
                                                <h4>Premium</h4>
                                                <span>Unlimited Annual</span>
                                            </div>
                                            <div class="price">$152.99</div>
                                            <div class="pricing-body">
                                                <p>
                                                    </p><p>Post UNLIMITED. Listings will expire in 365 days (unless removed or Sold) without renewal. Includes auto social media promos or homepage showcase.</p>
                                                <p></p>
                                            </div>
                                            <hr class="horizontal dark mt-0 mb-2">
                                            <div class="pricing-footer">
                                                <p>Expires in 365 days </p>
                                                <a href="#" class="btn btn-primary w-100">Purchase Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                </div>
                <div class="col-md-12 mt-4">
                    <div class="bounce-card text-center">
                        <h6 class="mb-0">Automatic Social Media Promos for “Featured” Packages include Instagram,
                            Facebook and TikTok. </h6>
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="bounce-card">
                        <h4>Add Ons</h4>
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="boostAdCheckbox">
                                <label class="form-check-label" for="boostAdCheckbox">
                                    Boost Ad back to top of Homepage + Socials – $5/ad
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="customPostCheckbox">
                                <label class="form-check-label" for="customPostCheckbox">
                                    Custom post for Socials including "Swipe for Video" with 5 pictures and up to 2
                                    videos – $10/ad. Socials include Instagram, TikTok, + Facebook
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bannerSpaceCheckbox">
                                <label class="form-check-label" for="bannerSpaceCheckbox">
                                    Banner Space: $200 / year
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailBlastCheckbox">
                                <label class="form-check-label" for="emailBlastCheckbox">
                                    Email Blast Promotion to our Newsletter – $50 / blast
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="textBlastCheckbox">
                                <label class="form-check-label" for="textBlastCheckbox">
                                    Text Blast Promotion to our Community – $150 / blast
                                </label>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">$5 Pay Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4 mb-5">
                    <div class="bounce-card d-flex align-items-center flex-wrap justify-content-between">
                        <h6 class="mb-0">FULL SERVICE PACKAGE: Allow us to fully manage and promote all of your listings
                            for you</h6>
                        <a href="#" class="btn btn-primary">Contact us for Pricing</a>
                    </div>
                </div>
            </div>
            <!-- Featured section end -->
        </div>
    </div>

</div>
</section>
<!-- @if(@$hjForumData->count() > 0)
<section class="section">
    <div class="container">
        <h2 class="fs-2">H/J Forum</h2>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    @for($i = 0; $i < 2; $i++) 
                    <div class="col-lg-6 mb-4">
                        <div class="blog-card">
                            <a  href="{{route('hj-forum-details', @$hjForumData[$i]->id)}}">
                                <img src="{{asset('storage/'.$hjForumData[$i]->image)}}" alt="" />
                            </a>
                            <div class="time-post"><span>{{@$hjForumData[$i]->created_at->format('d M Y h:m a')}}</span> <span>{{@$hjForumData[$i]->user->name ?? 'Unknown'}}</span></div>
                            <a  href="{{route('hj-forum-details', $hjForumData[$i]->id)}}">
                                <h3>{{ Str::limit(@$hjForumData[$i]->title, 40, '...') }}</h3>
                            </a>
                            <p>{{Str::limit(@$hjForumData[$i]->description, 200, '...')}}</p>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog-sitebar">
                    <div class="recent-posts-widget">
                        <ul>
                            @for($i; $i < count($hjForumData); $i++)
                            <li>
                                <div class="entry-image">
                                    <a href="{{route('hj-forum-details', $hjForumData[$i]->id)}}" class="thumb">
                                        <img src="{{asset('storage/'.$hjForumData[$i]->image)}}" width="120" height="100">
                                    </a>
                                </div>
                                <div class="entry-meta-wrapper">
                                    <div class="list-unstyled d-flex gap-3 mb-2">
                                        <span class="text-secondary">{{@$hjForumData[$i]->user->name ?? 'Unknown'}}</span>
                                        <span class="text-secondary">{{@$hjForumData[$i]->created_at->format('d M Y h:m a')}}</span>
                                    </div>
                                    <div class="entry-title">
                                        <a  href="{{route('hj-forum-details', $hjForumData[$i]->id)}}">
                                            <h4>{{ Str::limit(@$hjForumData[$i]->title, 40, '...') }}</h4>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            @endfor
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif -->

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
@endsection
<!-- jQuery & CKEditor -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
<script>
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
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const standardSection = document.getElementById('standard-section');
    const featuredSection = document.getElementById('featured-section');

    const radioButtons = document.querySelectorAll('input[name="duration-1"]');

    function showSection(sectionToShow, sectionToHide) {
        sectionToHide.classList.remove('show');
        setTimeout(() => {
            sectionToHide.style.display = 'none';
            sectionToShow.style.display = 'block';
            setTimeout(() => {
                sectionToShow.classList.add('show');
            }, 10); // thoda delay dena zaruri hota hai animation ke liye
        }, 300); // hide animation ke liye time
    }

    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'standard') {
                showSection(standardSection, featuredSection);
            } else if (this.value === 'featured') {
                showSection(featuredSection, standardSection);
            }
        });
    });

    // Initial setup
    standardSection.classList.add('fade', 'show');
    featuredSection.classList.add('fade');
});
</script>