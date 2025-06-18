@extends('frontauth.layouts.main')
@section('title')
Your Ads
@endsection
@section('content')


<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-7">
            <div class="my-3">
                <h3>{{@$product->title}}</h3>
            </div>
            <div class="left-side-deatils">
                <div class="gallery">
                        <!-- Main Slider -->
                        <div class="swiper gallery-slider">
                            <div class="swiper-wrapper">

                                @foreach(@$product->image as $key=>$image)
                                    <div class="swiper-slide"><img src="{{asset('storage/'.$image->image)}}" alt=""></div>
                                @endforeach

                                @foreach(@$product->video as $key=>$video)
                                    <div class="swiper-slide">
                                        <video width="" height="" controls>
                                            <source src="{{asset('storage/'.$video->video_url)}}" type="video/mp4">
                                            <source src="{{asset('storage/'.$video->video_url)}}" type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @endforeach
                            </div>
                            <!-- Navigation Arrows -->

                        </div>

                        <!-- Thumbnails -->
                        <div class="swiper gallery-thumbs">
                            <div class="swiper-wrapper">

                                @foreach(@$product->image as $key=>$image)
                                    <div class="swiper-slide"><img src="{{asset('storage/'.$image->image)}}" alt=""></div>
                                @endforeach


                                @foreach(@$product->video as $key=>$video)
                                    <div class="swiper-slide"><img src="{{asset('storage/'.$video->thumbnail)}}" alt=""></div>
                                @endforeach

                                
                            </div>
                            <div class="btnprev"><svg xmlns="http://www.w3.org/2000/svg')}}" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path d="M15.75 4.5L8.25 12L15.75 19.5" stroke="black" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg></div>
                            <div class="btnnext"><svg xmlns="http://www.w3.org/2000/svg')}}" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path d="M8.25 4.5L15.75 12L8.25 19.5" stroke="black" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg></div>
                        </div>
                    </div>

                    <div class="info-desc">
                        <h3 class="horse-info-heading">More Details</h3>
                        <div class="horse-info-box">

                            @if($product->sale_method == 'auction' && $product->product_status == 'live')
                                <div class="horse-info-row"><span class="horse-label">Auction End Date :</span> {{ \Carbon\Carbon::parse(@$product->bid_expire_date)->format('d M Y') }}</div>
                            @endif

                            <div class="horse-info-row"><span class="horse-label">Horse Apparel:</span>
                                {{ @$product->horseApparels->map(function($horse_apparel) {
                                    return optional($horse_apparel->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>

                            <div class="horse-info-row"><span class="horse-label">Rider Apparel:</span>
                                {{ @$product->riderApparels->map(function($rider_apparel) {
                                    return optional($rider_apparel->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>

                            <div class="horse-info-row"><span class="horse-label">Horse Tack:</span>
                                {{ @$product->horseTacks->map(function($horse_tack) {
                                    return optional($horse_tack->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>

                            <div class="horse-info-row"><span class="horse-label">Trailer Trucks:</span>
                                {{ @$product->trailerTrucks->map(function($trailer_trucks) {
                                    return optional($trailer_trucks->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>

                            <div class="horse-info-row"><span class="horse-label">For Barns:</span>
                                {{@$product->forBarns->map(function($for_barns) {
                                    return optional($for_barns->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            
                            <div class="horse-info-row"><span class="horse-label">Equine Supplements:</span>
                                {{@$product->equineSupplements->map(function($equine_supplements) {
                                    return optional($equine_supplements->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            
                            <div class="horse-info-row"><span class="horse-label">Conditions:</span>
                                {{@$product->conditions->map(function($conditions) {
                                    return optional($conditions->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>

                            <div class="horse-info-row"><span class="horse-label">Brands:</span>
                                {{@$product->brands->map(function($brands) {
                                    return optional($brands->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            
                            <div class="horse-info-row"><span class="horse-label">Horse Sizes:</span>
                                {{@$product->horseSizes->map(function($horse_sizes) {
                                    return optional($horse_sizes->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            
                            <div class="horse-info-row"><span class="horse-label">Rider Sizes:</span>
                                {{@$product->riderSizes->map(function($rider_sizes) {
                                    return optional($rider_sizes->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            
                            <div class="horse-info-row"><span class="horse-label">Exchanged Upcoming Horse Shows:</span>
                                {{@$product->equineSupplements->map(function($equine_supplements) {
                                    return optional($equine_supplements->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>

                            <div class="horse-info-row"><span class="horse-label">Hourly Price :</span> {{@$product->productDetail->hourly_price}}</div>
                            <div class="horse-info-row"><span class="horse-label">Fixed Price:</span> 
                                {{ @$product->productDetail->fixed_price }}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Precise Location:</span> 
                                {{ @$product->productDetail->precise_location }}
                            </div>

                            <div class="horse-info-row"><span class="horse-label">Street:</span> {{@$product->productDetail->street}}</div>
                            
                            <div class="horse-info-row"><span class="horse-label">City:</span> {{@$product->productDetail->city}}</div>
                            <div class="horse-info-row"><span class="horse-label">State:</span> 
                                {{ @$product->productDetail->state }}
                            </div>

                            <div class="horse-info-row"><span class="horse-label">Country:</span> 
                                {{@$product->productDetail->country}}
                            </div>
                            
                        </div>
                        <h3 class="horse-info-heading">Listing Description</h3>
                        
                        <div class="listing-desc">
                            <p class="my-4">
                                {{@$product->description}}
                            </p>
                        </div>
                        @if(@$product->productDetail->pedigree_chart)
                        
                        <div class="info-desc-footer">
                            <ul>
                                <li><span> <img src="{{asset('front/home/assets/images/location-icon.svg')}}" alt="" /></span> {{@$product->productDetail->city}}, {{@$product->productDetail->state}}, {{@$product->productDetail->country}}</li>
                                <li><span> <img src="{{asset('front/home/assets/images/show-icon.svg')}}" alt="" /></span> 30 #11223</li>
                                <li>
                                    <span> <img src="{{asset('front/home/assets/images/calendar-icon.svg')}}" alt="" /></span>
                                    {{ \Carbon\Carbon::parse($product->created_at)->format('M d, Y') }}                                
                                </li>
                            </ul>
                        </div>
                        @endif
                    </div>

                
                    <div class="info-desc mt-4">
                        <h3 class="horse-info-heading">More Details</h3>
                        <ul class="list-unstyled d-flex gap-3">
                            @foreach(@$product->document as $key=>$document)
                                <li><a href="{{asset('storage/'.$document->file)}}" target="_blank"><img src="{{asset('front/home/assets/images/pdf-icon.svg')}}" alt="" /></a></li>
                            @endforeach
                        </ul>
                    </div>
                    @if(@$product->external_link)
                    <div class="info-desc mt-4">
                        <h3 class="horse-info-heading">External Links</h3>
                        <div class="links-box">
                            <a href="{{@$product->external_link}}" target="_blank">
                                <img src="{{asset('front/home/assets/images/link-icon.svg')}}" alt="" />
                                <span>{{@$product->external_link}}</span>
                            </a>                            
                        </div>
                    </div>
                    @endif

            </div>
        </div>

        <div class="col-lg-5">
            <div class="bidders-box">
                <h4 class="mb-3">Bidders</h4>
                @if($product->productBids->isNotEmpty())
                    @foreach(@$product->productBids as $bidder)
                    <hr class="horizontal dark my-1">
                    <div class="bidders-card d-flex align-items-center justify-content-between flex-wrap py-2">
                        <div class="d-flex align-items-center gap-3">
                            @php
                                $image = (@$bidder->user->profile_photo_path) ? '<img src="'.asset('storage/'.$bidder->user->profile_photo_path).'" width="50" height="50"
                                class="rounded-circle" alt="img-12">' : '<img src="'.asset('images/default-user.png').'" width="50" height="50"
                                class="rounded-circle" alt="img-12">';
                            @endphp
                            {!! $image !!}
                            <div class="fst-normal text-dark">{{ucfirst(@$bidder->user->name)}}</div>
                        </div>
                        <div class="price" style="font-size: 18px;">{{'$'. number_format(@$bidder->amount, 2, '.', ',') }}</div>
                    </div>
                    @endforeach
                @else
                    <p>Data not found.</p>
                @endif
            </div>

            <div class="bidders-box mt-4">
                <h4>Ad Action</h4>
                <ul class="act-icon">
                    <li><a href="javascript:void(0)" id="shareBtn"><img src="{{asset('front/auth/assets/img/icons/share-icon.svg')}}" alt=""></a></li>
                    <li><a href="javascript:window.print()"><img src="{{asset('front/auth/assets/img/icons/printer-icon.svg')}}" alt=""></a></li>
                    {{--<li><a href=""><img src="{{asset('front/auth/assets/img/icons/heart-icon.svg')}}" alt=""></a></li>
                    <li><a href=""><img src="{{asset('front/auth/assets/img/icons/plag-icon.svg')}}" alt=""></a></li>
                    <li><span><img src="{{asset('front/auth/assets/img/icons/return-icon.svg')}}" alt=""></span></li>--}}
                </ul>
            </div>
            <div class="mt-4">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113874.30006216935!2d75.70815698269863!3d26.885339964960874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396c4adf4c57e281%3A0xce1c63a0cf22e09!2sJaipur%2C%20Rajasthan!5e0!3m2!1sen!2sin!4v1745577629079!5m2!1sen!2sin"
                    width="100%" height="400" style="border:0; border-radius:15px;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            {{--<div class="card-boxleft feat_card_bx bidders-box mt-4">
                <h4 class="title">More Ads From This User</h4>
                <div class="adsfromcrd">
                    <div class="adsimg">
                        <img src="{{asset('front/auth/assets/img/slider-img.png')}}" alt="">
                    </div>
                    <div class="adsfromcrd-cont">
                        <h5>2015 KWPN gelding winning</h5>
                        <div class="btn-cont">
                            <a class=""><img src="{{asset('front/auth/assets/img/icons/call-icon-br.svg')}}" alt="">
                                Call for
                                price</a>
                            <div class="bx2">
                                <button>
                                    <img src="{{asset('front/auth/assets/img/icons/re_icn.svg')}}" alt="">
                                </button>
                                <button>
                                    <img src="{{asset('front/auth/assets/img/icons/like_icn.svg')}}" alt="">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>--}}

        </div>
    </div>
</div>

@endsection


@section('script')

<script>
    // Thumbnail slider
var thumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 10,
    slidesPerView: 'auto',
    centeredSlides: true,
    loop: true,
    slideToClickedSlide: true,
});

// Main image slider
var slider = new Swiper('.gallery-slider', {
    spaceBetween: 10,
    centeredSlides: true,
    loop: true,
    loopedSlides: 6, // match number of slides
    navigation: {
        nextEl: '.btnnext',
        prevEl: '.btnprev',
    },
    thumbs: {
        swiper: thumbs,
    },
});

// share
document.getElementById('shareBtn').addEventListener('click', function(event) {
    event.preventDefault();
    if (navigator.share) {
      navigator.share({
        title: document.title,
        text: 'Check out this page!',
        url: window.location.href
      })
      .then(() => console.log('Successful share'))
      .catch((error) => console.log('Error sharing:', error));
    } else {
      alert('Sorry, your browser does not support the share feature.');
    }
  });

var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
        damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}
</script>


@endsection