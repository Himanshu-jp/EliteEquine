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
                            <h1>About Us</h1>
                            <b>Elite Equine Marketplace is shaping the future of equestrian e-commerce.</b>
                            <p>Built specifically for the competitive hunter/jumper community, our platform brings together
                                everything you need in one modern, easy-to-use space—from premium horses, high-end
                                equipment, and apparel to expert services, job listings, exclusive barns, properties, and
                                industry events.Whether you’re buying, selling, promoting your business, hiring, or job
                                hunting, Elite Equine equips you with powerful tools and direct connections to help you move
                                faster, smarter, and with confidence. How do we work?</p>
                        </div>
                    </div>
                    <div class="col-lg-7 ">
                        <div class="text-center">
                            <img src="{{ asset('front/home/assets/images/about-banner.png') }}" class="w-100" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-------------------------------- forseller_area ------------------------------------>
    @if (!empty($sellerBusinessData))
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
                                $sections = [
                                    'listing' => 'Listing',
                                    'track' => 'Track',
                                    'featured' => 'Featured',
                                    'post' => 'Post',
                                ];
                            @endphp
                            @foreach ($sections as $key => $label)
                                @php
                                    $title = $key . '_title';
                                    $icon = $key . '_icon';
                                    $content = $key . '_content';
                                @endphp

                                <div class="bx1">
                                    <img src="{{ asset('storage/' . $sellerBusinessData->$icon) }}" alt="" />
                                    <h3>{{ $sellerBusinessData->$title }}</h3>
                                    {{ $sellerBusinessData->$content }}
                                </div>
                            @endforeach
                            <div class="bx1">
                                <img src="https://v1.checkprojectstatus.com/elite-quaine-marketplace/web/public/storage/seller_business/icons/K9TTHnnVkRHDwQm0R19sqmkKXHs3708kygNNDVBP.svg"
                                    alt="">
                                <h3>Flexible Selling: Auctions & Secure Payments</h3>
                                Sell equipment, apparel, and services your way—use our built-in auction tool for competitive
                                bidding or opt for direct sales through our secure, Stripe-powered payment system.
                            </div>
                            <div class="bx1">
                                <img src="https://v1.checkprojectstatus.com/elite-quaine-marketplace/web/public/storage/seller_business/icons/K9TTHnnVkRHDwQm0R19sqmkKXHs3708kygNNDVBP.svg"
                                    alt="">
                                <h3>Real-Time Messaging & Instant Alerts</h3>
                                Connect with buyers directly through our secure in-platform messaging, and stay informed
                                with real-time notifications for new messages, payment updates, subscription reminders, and
                                more.
                            </div>
                        </div>
                        {{-- <div class="forseller_area_inner3">
                        {!! $sellerBusinessData->description !!}
                    </div> --}}
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-------------------------------- forbuyer_area ------------------------------------>
    @if (!empty($buyerBrowserData) || !empty($buyerFaqData))
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
                        <img class="img-fluid" src="{{ asset('storage/' . $buyerBrowserData->image) }}" alt="" />
                    </div>
                    <div class="col-lg-6">
                        <div class="accordion my-4" id="simpleAccordion">
                            @foreach ($buyerFaqData as $index => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $index }}">
                                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                                            {{ $faq->questions }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $index }}"
                                        class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                        aria-labelledby="heading{{ $index }}" data-bs-parent="#simpleAccordion">
                                        <div class="accordion-body">
                                            {!! $faq->answers !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- <div class="row">
                <div class="desic">
                    {!! $buyerBrowserData->description !!}
                </div>
            </div> --}}
            </div>
        </section>
    @endif
    @if (!empty($aboutData))
        <section class="section story-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <h2 class="title">Join the <br /> Movement </h2>
                    </div>
                    <div class="col-lg-7 ms-auto">
                        {!! $aboutData->description !!}
                    </div>
                </div>
                <div class="story-img">
                    <img src="{{ asset('storage/' . $aboutData->image) }}" classs="w-100">
                </div>
            </div>
        </section>
    @endif
    <section class="about_for_buyers ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 my-auto">
                    <div class="about_area_inner">
                        <img src="{{ asset('front/home/assets/images/mobile-fream-img.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="about_horses_img">
                        <img src="{{ asset('front/home/assets/images/horse-image.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (!empty($aboutSellerBusinessData))
        <section class="section services-opions-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="services-opions">
                            <div class="row">
                                @php
                                    $sections = [
                                        'listing' => 'Listing',
                                        'track' => 'Track',
                                        'featured' => 'Featured',
                                        'post' => 'Post',
                                    ];
                                @endphp
                                @foreach ($sections as $key => $label)
                                    @php
                                        $title = $key . '_title';
                                        $icon = $key . '_icon';
                                        $content = $key . '_content';
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="opions-box">
                                            <img src="{{ asset('storage/' . $aboutSellerBusinessData->$icon) }}"
                                                alt="">
                                            <h3>{{ $aboutSellerBusinessData->$title }}</h3>
                                            {!! $aboutSellerBusinessData->$content !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <img src="{{ asset('storage/' . $aboutSellerBusinessData->image) }}" class="horse-image" alt="">
                </div>
            </div>
        </section>
    @endif
    {{-- <section class="section  pb-sm-0">
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
</section> --}}

    <section class="section">
        <div class="container-fluid mt-4">

            <div>
                <div class="col-xxl-8 mx-auto">
                    <div class="section-heading">
                        <h2 class="text-center fw-bold">Subscription Plans</h2>
                    </div>


                    <div class="pricing-switcher">
                        <p class="fieldset">
                            <input type="radio" name="duration-1" value="standard" id="standard-1" checked>
                            <label for="standard-1">Standard</label>

                            <input type="radio" name="duration-1" value="featured" id="featured-1">
                            <label for="featured-1">Featured</label>
                        </p>
                    </div>
                    <!-- Standard section start -->
                      <div >
                <div class="row " id="standard-section">

                    @foreach($subscription['standard'] as $key => $value)
                        <div class="col-md-6 col-lg-6 col-xl-4 col-sm-12  mt-3">
                            <div class="bounce-invert">
                                <div class="exclusive">
                                    <div class="pricing-wrapper">
                                        <div data-type="yearly" class="is-hidden">
                                            <div class="pricing-header">
                                                <h4>{{$value->title}}</h4>
                                                <span>{{$value->subtitle}}</span>
                                            </div>
                                            <div class="price">${{$value->price}}</div>
                                            <div class="pricing-body">
                                                <p>
                                                    {!! $value->description !!}
                                                </p>
                                            </div>
                                            <hr class="horizontal dark mt-0 mb-2">
                                            <div class="pricing-footer">
                                                <p>Expires in {{$value->days}} days </p>
                                                @if(Auth::check())

                                                         @if(Auth::user()->is_subscribed == '1' && Auth::user()->plan_id == $value->id)
                                                <a href="{{ route('cancel_subscription',base64_encode($value->id)) }}" class="btn btn-primary w-100">Cancel Subscription</a>
                                                @else
                                                <a href="{{ route('purchase_plan',base64_encode($value->id)) }}" class="btn btn-primary w-100">Purchase Now</a>
                                           
                                                @endif
                                                    @else
                                                <a href="{{ route('login') }}" class="btn btn-primary w-100">Login</a>

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

              
                <div class="row" id="featured-section" style="display: none;">

                    @foreach($subscription['featured'] as $key => $value)
                        <div class="col-md-6 col-lg-6 col-xl-4 col-sm-12  mt-3">
                            <div class="bounce-invert">
                                <div class="exclusive">
                                    <div class="pricing-wrapper">
                                        <div data-type="yearly" class="is-hidden">
                                            <div class="pricing-header">
                                                <h4>{{$value->title}}</h4>
                                                <span>{{$value->subtitle}}</span>
                                            </div>
                                            <div class="price">${{$value->price}}</div>
                                            <div class="pricing-body">
                                                <p>
                                                    {!! $value->description !!}
                                                </p>
                                            </div>
                                            <hr class="horizontal dark mt-0 mb-2">
                                            <div class="pricing-footer">
                                                <p>Expires in {{$value->days}} days </p>

                                           @if(Auth::check())

                                                         @if(Auth::user()->is_subscribed == '1' && Auth::user()->plan_id == $value->id)
                                                <a href="{{ route('cancel_subscription',base64_encode($value->id)) }}" class="btn btn-primary w-100">Cancel Subscription</a>
                                                @else
                                                <a href="{{ route('purchase_plan',base64_encode($value->id)) }}" class="btn btn-primary w-100">Purchase Now</a>
                                           
                                                @endif
                                                    @else
                                                <a href="{{ route('login') }}" class="btn btn-primary w-100">Login</a>

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                          <div class="row">
                         <div class="col-md-12 mt-4">
                    <div class="bounce-card text-center">
                        <h6 class="mb-0">Automatic Social Media Promos for “Featured” Packages include Instagram,
                            Facebook and TikTok. </h6>
                    </div>
                </div>
                </div>
           
          

             
                </div>

                <div class="row">
                       <div class="col-md-12 mt-4">
                    <form action="{{ route('charge_add_ons') }}" method="post" >
                        @csrf

                    <div class="bounce-card">
                        <h4>Add Ons</h4>
                        <div class="">

                            @foreach ($addon as $addonitem)
                                  <div class="form-check">
                                <input class="form-check-input main_addon_price_adds" name="addon_prices[]" data-price="{{ $addonitem->price }}"  type="checkbox" id="boostAddCheckbox{{ $loop->iteration }}" value="{{ $addonitem->id }}">
                                <label class="form-check-label" for="boostAddCheckbox{{ $loop->iteration }}" >
                                 
                                     {{ $addonitem->type }} – ${{ $addonitem->price }}/ad

                                </label>
                            </div>
                            @endforeach
                          
                         
                        </div>
                        <div class="text-center price_include_btn" style="display: none;">
                            <button  type="submit"  class="btn btn-primary">$<span class="price-in">0</span> Pay Now</button>
                        </div>
                    </div>
                    </form>

                </div>
                <div class="col-md-12 mt-4 mb-5">
                    <div class="bounce-card d-flex align-items-center flex-wrap justify-content-between">
                        <h6 class="mb-0">FULL SERVICE PACKAGE: Allow us to fully manage and promote all of your listings
                            for you</h6>
                        <a href="{{ route('contact.form') }}"  class="btn btn-primary">Contact us for Pricing</a>
                    </div>
                </div>
                </div>
            </div>
                </div>
            </div>

        </div>
    </section>
    <!-- @if (@$hjForumData->count() > 0)
    <section class="section">
        <div class="container">
            <h2 class="fs-2">H/J Forum</h2>
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @for ($i = 0; $i < 2; $i++)
    <div class="col-lg-6 mb-4">
                            <div class="blog-card">
                                <a  href="{{ route('hj-forum-details', @$hjForumData[$i]->id) }}">
                                    <img src="{{ asset('storage/' . $hjForumData[$i]->image) }}" alt="" />
                                </a>
                                <div class="time-post"><span>{{ @$hjForumData[$i]->created_at->format('d M Y h:m a') }}</span> <span>{{ @$hjForumData[$i]->user->name ?? 'Unknown' }}</span></div>
                                <a  href="{{ route('hj-forum-details', $hjForumData[$i]->id) }}">
                                    <h3>{{ Str::limit(@$hjForumData[$i]->title, 40, '...') }}</h3>
                                </a>
                                <p>{{ Str::limit(@$hjForumData[$i]->description, 200, '...') }}</p>
                            </div>
                        </div>
    @endfor
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-sitebar">
                        <div class="recent-posts-widget">
                            <ul>
                                @for ($i; $i < count($hjForumData); $i++)
    <li>
                                    <div class="entry-image">
                                        <a href="{{ route('hj-forum-details', $hjForumData[$i]->id) }}" class="thumb">
                                            <img src="{{ asset('storage/' . $hjForumData[$i]->image) }}" width="120" height="100">
                                        </a>
                                    </div>
                                    <div class="entry-meta-wrapper">
                                        <div class="list-unstyled d-flex gap-3 mb-2">
                                            <span class="text-secondary">{{ @$hjForumData[$i]->user->name ?? 'Unknown' }}</span>
                                            <span class="text-secondary">{{ @$hjForumData[$i]->created_at->format('d M Y h:m a') }}</span>
                                        </div>
                                        <div class="entry-title">
                                            <a  href="{{ route('hj-forum-details', $hjForumData[$i]->id) }}">
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
                    <img src="{{ asset('front/home/assets/images/newsletter-img.png') }}" width="100%"
                        alt="Newsletter Image">
                </div>
                <div class="col-lg-5 ms-auto">
                    <div class="newsletter-box">
                        <h2>Subscribe to our Newsletter!</h2>
                        {{-- Success message --}}
                        @if (session('success'))
                            <div class="alert alert-success mt-2">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Error message --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        <form action="{{ route('newsletter.subscribe') }}" id="newsletterForm" method="POST"
                            class="subscribe-form position-relative">
                            @csrf
                            <input type="email" name="email" placeholder="Enter your email" class="form-control"
                                required aria-label="Email address for newsletter subscription" />
                            <img class="icon-input" src="{{ asset('front/home/assets/images/search-icon.svg') }}"
                                alt="Search Icon">
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
    $(document).ready(function() {
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
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                $('#subscribeBtn').attr('disabled', true).text('Subscribing...');
                form.submit();
            }
        });
    });

   
$(document).ready(function () {
    const $standardSection = $('#standard-section');
    const $featuredSection = $('#featured-section');
    const $radioButtons = $('input[name="duration-1"]');

    function showSection($sectionToShow, $sectionToHide) {
        $sectionToHide.removeClass('show');
        setTimeout(function () {
            $sectionToHide.css('display', 'none');
            $sectionToShow.css('display', 'flex');
            setTimeout(function () {
                $sectionToShow.addClass('show');
            }, 10); // thoda delay dena zaruri hota hai animation ke liye
        }, 300); // hide animation ke liye time
    }

    $radioButtons.on('change', function () {
        if (this.value === 'standard') {
            showSection($standardSection, $featuredSection);
        } else if (this.value === 'featured') {
            showSection($featuredSection, $standardSection);
        }
    });

    // Initial setup
    $standardSection.addClass('fade show');
    $featuredSection.addClass('fade');


     $('body').on('click','.main_addon_price_adds',function(){
        var priceAdd=0;
       $('.main_addon_price_adds:checked').each(function(){
      priceAdd+=parseFloat($(this).attr('data-price'));
       })
       $('.price-in').html(priceAdd)
     if(priceAdd > 0){
       $('.price_include_btn').show()

     }else{
       $('.price_include_btn').hide()

     }
    })

});


</script>
