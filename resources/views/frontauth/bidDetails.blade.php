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
                            <div class="horse-info-row"><span class="horse-label">Subcategory :</span> {{@$product->subcategory->name}}</div>
                            <div class="horse-info-row"><span class="horse-label">Discipline:</span> 
                                {{ @$product->disciplines->map(function($disciplines) {
                                    return optional($disciplines->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Age:</span> 
                                {{ (@$product->productDetail->age)?\Carbon\Carbon::parse("01-01-".@$product->productDetail->age)->age:0}} Years
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Height in hands:</span> 
                                {{@$product->height->commonMaster->name}}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Breed:</span> 
                                {{ @$product->breeds->map(function($breeds) {
                                    return optional($breeds->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Sex:</span> {{@$product->sex->commonMaster->name}}</div>
                            <div class="horse-info-row"><span class="horse-label">Colors:</span>
                                {{ @$product->colors->map(function($colors) {
                                    return optional($colors->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Training & Show Experience:</span>
                                {{ @$product->trainingShowExperiences->map(function($show) {
                                    return optional($show->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>

                            <div class="horse-info-row"><span class="horse-label">Green Eligibility:</span> {{@$product->greenEligibilities->commonMaster->name}}</div>

                            <div class="horse-info-row"><span class="horse-label">Qualified For:</span>
                                {{ @$product->qualifies->map(function($height) {
                                    return optional($height->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Current Fence Height:</span>
                                {{ @$product->currentFenceHeight->map(function($height) {
                                    return optional($height->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Potential Fence Height:</span>
                                {{ @$product->potentialFenceHeight->map(function($height) {
                                    return optional($height->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Can Be Tried at Upcoming Show :</span>
                                {{ @$product->triedUpcomingShows->map(function($height) {
                                    return optional($height->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>

                            <div class="horse-info-row"><span class="horse-label">Trial Dates Available:</span>
                                {{ \Carbon\Carbon::parse(@$product->productDetail->fromdate)->format('d M Y') }} - {{ \Carbon\Carbon::parse(@$product->productDetail->todate)->format('d M Y') }}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Trainer:</span>
                                {{@$product->productDetail->trainer}}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Facility:</span>
                                {{@$product->productDetail->facility}}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Sire Bloodlines:</span>
                                {{@$product->productDetail->sirebloodline}}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Dam Bloodlines:</span>
                                {{@$product->productDetail->dambloodline}}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">USEF:</span>
                                {{@$product->productDetail->usef}}
                            </div>
                        </div>
                        <h3 class="horse-info-heading">Listing Description</h3>
                        
                        <div class="listing-desc">
                            <p class="my-4">
                                {{@$product->description}}
                            </p>
                        </div>
                        @if(@$product->productDetail->pedigree_chart)
                        <h3 class="horse-info-heading">Pedigree Chart</h3>
                        <img class="pedigreechart" src="{{asset('storage/'.@$product->productDetail->pedigree_chart)}}" alt="" />
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