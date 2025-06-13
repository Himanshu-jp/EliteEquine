@if($viewMode=="grid")
<div class="row">
    @foreach($data as $key=>$value)
        <div class="col-lg-4 mb-3">
            <div class="feat_card_bx grid-view">
                <a href="{{route('serviceDetails',@$value->id)}}">
                    <div class="image">
                        <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="hourse-image">
                        {{-- <span class="tag-img">{{@$value->greenEligibilities->commonMaster->name}} </span> --}}
                    </div>
                </a>
                <div class="content">
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

                    {{-- <span class="sp1"></span> --}}
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
                        </span>
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

                            {{--<button>
                                <img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}" alt="" />
                            </button>--}}
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

    <div class="col-lg-8">
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
    
    <div class="col-lg-4">
        @foreach($data as $key=>$value)
            <div class="feat_card_bx list-page-card">
                <a href="{{route('serviceDetails',@$value->id)}}">
                    <div class="imagelist">
                        <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="hourse-image">
                    </div>
                </a>

                <div class="content">
                    <a href="{{route('serviceDetails',@$value->id)}}">
                        <h3>
                            {{@$value->title}}
                        </h3>
                    </a>

                    <h4>Houlry Pay: ${{number_format(@$value->productDetail->hourly_price)}} </h4>
                    <h4>Fixed Pay: ${{number_format(@$value->productDetail->fixed_price)}} </h4>
                    <h4>Salary Price: ${{number_format(@$value->productDetail->salary)}} </h4>

                    {{-- <span class="sp1"></span> --}}
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
                        </span>
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