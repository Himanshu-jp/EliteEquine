@php
    $columnClass = $columnClass ?? 'col-lg-4';
@endphp

@if($viewMode=="grid")
    <div class="row">
        @foreach($data as $key=>$value)
            <div class="{{ $columnClass }} mb-3">
                <div class="feat_card_bx grid-view">
                    <a href="{{route('horseDetails',@$value->id)}}">
                        <div class="image">
                            <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="hourse-image">
                            @if(!empty(@$value->greenEligibilities))<span class="tag-img">{{@$value->greenEligibilities->commonMaster->name}} </span>@endif
                        </div>
                    </a>
                    <div class="content">
                        <a href="{{route('horseDetails',@$value->id)}}">
                        <h3>
                                {{@$value->title}} | {{@$value->productDetail->age}} | {{@$value->height->commonMaster->name}} <br />
                                {{ @$value->breeds->map(function($breed) {
                                    return optional($breed->commonMaster)->name;
                                })->filter()->implode(' | ') }}
                            </h3>
                        </a>

                        <!-- <h4>Call For Price</h4> -->
                          @if(@$value->sale_method == 'auction' && !empty(@$value->bid_expire_date))
                                    @if( @$value->product_status == 'live')
                                        <h4>Bid Now</h4>
                                    @elseif(@$value->product_status == 'closed' && auth()->check() == true && @$value->highestBid->user_id == auth()->user()->id)
                                        <h4>Checkout</h4>
                                    @else
                                        <h4>Bid Closed</h4>
                                    @endif
                                @elseif(@$value->sale_method == 'standard' && @$value->transaction_method == 'buyertoseller')
                                    <h4>Call for price</h4>
                                @elseif(@$value->sale_method == 'standard' && @$value->transaction_method == 'platform')
                                    @if( @$value->product_status == 'live')
                                   <h4>Buy Now</h4>
                                    @elseif( @$value->product_status == 'sold')
                                    <h4>Sold</h4>
                                    @endif
                                @endif
                           

                        {{-- <h4>Sale: $100,000 - $150,000</h4>
                        <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4> --}}

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

@else

    <div class="col-lg-7">
        <div class="map-info">
            <div>
                <div class="top-header-map">
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
            </div>
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
    </div>
    
    <div class="col-lg-5">
        @foreach($data as $key=>$value)
            <div class="feat_card_bx list-page-card">
                <a href="{{route('horseDetails',@$value->id)}}">
                    <div class="imagelist">
                        <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="hourse-image">
                        <span class="tag-img">{{@$value->greenEligibilities->commonMaster->name}} </span>
                    </div>
                </a>

                <div class="content">
                    <a href="{{route('horseDetails',@$value->id)}}">
                    <h3>
                            {{@$value->title}} | {{@$value->productDetail->age}} | {{@$value->height->commonMaster->name}} <br />
                            {{ @$value->breeds->map(function($breed) {
                                return optional($breed->commonMaster)->name;
                            })->filter()->implode(' | ') }}
                        </h3>
                    </a>

                    <h4>Call For Price</h4>

                    {{-- <h4>Sale: $100,000 - $150,000</h4>
                    <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4> --}}

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


                    <div class="foot">
                        <div class="bx">
                             <div class="imagee">
                                <img src="{{(@$value->user->profile_photo_path)?asset('storage/'.@$value->user->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}" class="user-img" alt="">
                            </div>
                            <div class="content">
                                    <h4>{{@$value->user->name}}</h4>
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
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
        @endforeach
    </div>

@endif



<script>
    // add favorite
    $('.favorite-btn').on('click', function(e) {
        e.preventDefault();

        let productId = $(this).data('product-id');
        let url = `{{ url('favorite') }}`+'/'+ productId;
        let $btn = $(this);

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // alert(response.message);
                if (response.favorited) {
                    $btn.addClass('favorited');  
                    $btn.find("i").addClass('fa-solid').removeClass('fa-regular favorited');
                } else {
                    $btn.removeClass('favorited');
                    $btn.find("i").addClass('fa-regular favorited').removeClass('fa-solid');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    Swal.fire({
                        title: "Elite Equine",
                        text: "Please login to add favorite.",
                        imageUrl: "{{ asset('front/home/assets/images/add-favorite.svg') }}",
                        imageWidth: 400,
                        imageHeight: 200,
                        imageAlt: "Elite Equine",
                        // This disables the default Swal styling for confirm button
                        customClass: {
                            confirmButton: 'commen_btn'
                        },
                        buttonsStyling: false, // <--- disables SweetAlert's built-in styling
                        confirmButtonText: "<a href='{{ route('login') }}' class='commen_btn'>Login</a>"
                    });
                } else {
                    alert('Something went wrong.');
                }
            }
        });
    });
</script>