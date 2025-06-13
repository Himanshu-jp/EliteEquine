@if($viewMode=="grid")
<div class="row">
    @foreach($data as $key=>$value)
        <div class="col-lg-4 mb-3">
            <div class="feat_card_bx grid-view">
                <a href="{{route('communityDetails',@$value->id)}}">
                    <div class="image">
                        <img src="{{(@$value->image)?asset('storage/'.@$value->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="hourse-image">
                        {{-- <span class="tag-img">{{@$value->greenEligibilities->commonMaster->name}} </span> --}}
                    </div>
                </a>
                <div class="content">
                    <a href="{{route('communityDetails',@$value->id)}}">
                        <h3>
                            {{@$value->title}}
                        </h3>
                    </a>

                    <h4>Price : ${{number_format(@$value->price)}} </h4>
                    <span class="sp1"></span>
                    <div class="location">
                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}" alt="location-icon" />
                        <span>{{@$value->location}} <br />
                            Event Date : {{ format_date(@$value->date)}}
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

                {{-- <a href="{{route('horseDetails',@$value->id)}}">
                    <div class="imagelist">
                        <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="hourse-image">
                        <span class="tag-img">{{@$value->greenEligibilities->commonMaster->name}} </span>
                    </div>
                </a> --}}

                <a href="{{route('communityDetails',@$value->id)}}">
                    <div class="imagelist">
                        <img src="{{(@$value->image)?asset('storage/'.@$value->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="hourse-image">
                    </div>
                </a>

                <div class="content">
                    <a href="{{route('communityDetails',@$value->id)}}">
                        <h3>
                            {{@$value->title}}
                        </h3>
                    </a>

                    <h4>Price : ${{number_format(@$value->price)}} </h4>
                    <span class="sp1"></span>
                    <div class="location">
                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}" alt="location-icon" />
                        <span>{{@$value->location}} <br />
                            Event Date : {{ format_date(@$value->date)}}
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
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endif