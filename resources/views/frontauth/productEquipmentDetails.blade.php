@extends('frontauth.layouts.main')
<style>
        /* body { margin: 0; padding: 0; } */
        .form-section .col-md-6 { position: relative; }
        .form-section .col-md-6 #map { position: absolute; top: 0; left: 0; width: 98%; border:0; border-radius: 14px; height:600px; }
        

    .custom-map-marker {
        background-image: url("{{asset('images/location-user-mkr.svg')}}");
        background-size: contain;
        width: 32px;
        height: 39px;
        cursor: pointer;
    }

    .highlighted {
        background-color: #f0f0f0;
    }

  
    #secondmap-location-list li, #map-location-list li,.autocomplete-list-from li,.autocomplete-list-to li {
        padding: 5px 10px;
        cursor: pointer;
    }

    #map-location-list, #secondmap-location-list,.autocomplete-list-from ,.autocomplete-list-to{
        border: 1px solid #ccc;
        max-height: 200px;
        overflow-y: auto;
        display: none;
        position: absolute;
        z-index: 999;
        background: white;
        width: 100%;
    }
    </style>
@section('title')
Your Ads
@endsection
@section('content')

<style>
    .category-fields {
        display: none;
    }    
</style>

   

<div class="container-fluid mt-4">
    <div class="ms-0 d-flex align-items-center justify-content-between flex-wrap">
        <h4 class="h5 font-weight-bolder">Post Ad</h4>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('productEquipmentDetails') }}" method="post" class="row" id="productDetailsForm" enctype="multipart/form-data">
        @csrf
        <!----horse product fields--------->

        <div class="row">
            <input type="hidden" name="productId" value="{{$productId}}">
            <input type="hidden" name="productDetailId" value="{{@$products->productDetail->id}}">
            
            @if(@$products->category_id)
                <div class="col-md-3 mt-3 position-relative">
                    <label for="category" class="form-label">Category : &nbsp;&nbsp;<span class="h5 font-weight-bolder">{{@$products->category->name}}</span></label>                    
                </div>
            @endif

            <div class="row align-items-baseline cusmt-form-mb">

                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Horse Apparel</label>
                    <select class="form-control select2" id="horse_apparel" name="horse_apparel[]" multiple="multiple">
                        @foreach(__getHorseApparealsData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('horse_apparel', @$products->horseApparels->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('horse_apparel'))
                        <span class="error text-danger">{{$errors->first('horse_apparel')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Rider Apparel</label>
                    <select class="form-control select2" id="rider_apparel" name="rider_apparel[]" multiple="multiple">
                        @foreach(__getRiderApparealsData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('rider_apparel', @$products->riderApparels->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('rider_apparel'))
                        <span class="error text-danger">{{$errors->first('rider_apparel')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Horse Tack</label>
                    <select class="form-control select2" id="horse_tack" name="horse_tack[]" multiple="multiple">
                        @foreach(__getHorseTacksData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('horse_tack', @$products->horseTacks->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('horse_tack'))
                        <span class="error text-danger">{{$errors->first('horse_tack')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Horse Trailers (& Trucks)</label>
                    <select class="form-control select2" id="trailer_trucks" name="trailer_trucks[]" multiple="multiple">
                        @foreach(__getTrailerTrucksData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('trailer_trucks', @$products->trailerTrucks->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('trailer_trucks'))
                        <span class="error text-danger">{{$errors->first('trailer_trucks')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">For the Barn</label>
                    <select class="form-control select2" id="for_barns" name="for_barns[]" multiple="multiple">
                        @foreach(__getForBarnsData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('for_barns', @$products->forBarns->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('for_barns'))
                        <span class="error text-danger">{{$errors->first('for_barns')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Equine Supplements & Treats</label>
                    <select class="form-control select2" id="equine_supplements" name="equine_supplements[]" multiple="multiple">
                        @foreach(__getEquineSupplementsData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('equine_supplements', @$products->equineSupplements->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('equine_supplements'))
                        <span class="error text-danger">{{$errors->first('equine_supplements')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Condition</label>
                    <select class="form-control select2" id="conditions" name="conditions[]" multiple="multiple">
                        @foreach(__getConditionsData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('conditions', @$products->conditions->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('conditions'))
                        <span class="error text-danger">{{$errors->first('conditions')}}</span>
                    @endif
                </div>
                
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Brands</label>
                    <select class="form-control select2" id="brands" name="brands[]" multiple="multiple">
                        @foreach(__getBrandsData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('brands', @$products->brands->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('brands'))
                        <span class="error text-danger">{{$errors->first('brands')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Horse Sizes</label>
                    <select class="form-control select2" id="horse_sizes" name="horse_sizes[]" multiple="multiple">
                        @foreach(__getHorseSizesData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('horse_sizes', @$products->horseSizes->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('horse_sizes'))
                        <span class="error text-danger">{{$errors->first('horse_sizes')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Rider Sizes</label>
                    <select class="form-control select2" id="rider_sizes" name="rider_sizes[]" multiple="multiple">
                        @foreach(__getRiderSizesData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('rider_sizes', @$products->riderSizes->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('rider_sizes'))
                        <span class="error text-danger">{{$errors->first('rider_sizes')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Can be Exchanged at Upcoming Horse Show</label>
                    <select class="form-control select2" id="exchanged_upcoming_horse_shows" name="exchanged_upcoming_horse_shows[]" multiple="multiple">
                        @foreach(__getExchangedUpcomingHorseShows() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('exchanged_upcoming_horse_shows', @$products->exchangedUpcomingHorseShows->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('exchanged_upcoming_horse_shows'))
                        <span class="error text-danger">{{$errors->first('exchanged_upcoming_horse_shows')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" id="price" class="inner-form form-control mb-0 numbervalid" placeholder="Enter sale price" value="{{old('price',@$products->productDetail->price)}}">
                    @if($errors->has('price'))
                        <span class="error text-danger">{{$errors->first('price')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3 position-relative">
                    <label for="hourly_price" class="form-label">Hourly Rental Price</label>
                    <input type="text" name="hourly_price" id="hourly_price" class="inner-form form-control mb-0 numbervalid" placeholder="Enter lease price" value="{{old('hourly_price',@$products->productDetail->hourly_price)}}">
                    @if($errors->has('hourly_price'))
                        <span class="error text-danger">{{$errors->first('hourly_price')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="fixed_price" class="form-label">Fixed Rental Prie</label>
                    <input type="text" name="fixed_price" id="fixed_price" class="inner-form form-control mb-0 numbervalid" placeholder="Enter lease price" value="{{old('fixed_price',@$products->productDetail->fixed_price)}}">
                    @if($errors->has('fixed_price'))
                        <span class="error text-danger">{{$errors->first('fixed_price')}}</span>
                    @endif
                </div>

            </div>
        </div>

        <!---locaiton & phone fields---------->
        <div class="pt-5">

            <!-- Checkbox to toggle phone fields -->
            @if(!@$products->productDetail->phone)
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="contactSet" name="contactSet" value="1" {{(old('contactSet')=='1')?'checked':''}} >
                    <label class="form-check-label fw-bold text-dark" for="contactSet">
                        Use contact set in profile section 
                    </label>
                </div>
            @endif


            <!-- Checkbox to toggle address fields -->
            @if(!@$products->productDetail->country)
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="addressSet" name="addressSet"  value="1" {{(old('addressSet')=='1')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="addressSet">
                    Use address set in profile section 
                </label>
            </div>
            @endif

        </div>

        <!-- phone fields (hidden/shown based on checkbox) -->
        <div class="col-md-3 mt-3 position-relative" id="contactFields" style="display: none;">
            <label for="phone" class="form-label">Phone number</label>
            <input type="text" class="inner-form form-control mb-0" placeholder="eg. +91 9856965852" name="phone" id="phone" value="{{old('phone',@$products->productDetail->phone)}}">
            @if($errors->has('phone'))
                <span class="error text-danger">{{$errors->first('phone')}}</span>
            @endif
        </div>


        <!-- Address fields (hidden/shown based on checkbox) -->
        <div class="form-section" id="addressFields" style="display: none;">
            <div class="row">
                <div class="col-md-6">
                    
                    <div class="mb-4 position-relative">
                        <label class="form-label">Precise Location</label>
                        <input type="text" class="inner-form form-control" placeholder="Enter location.." name="precise_location" onkeyup="initializeLocationAutocomplete()" id="precise_location" value={{old('precise_location',@$products->productDetail->precise_location)}}>
                        <span id="map-location-message" class="text-danger" style="display: none; font-size: 12px;"></span>
                            <ul id="map-location-list" style="display: none;">
                                <!-- Location suggestions will appear here -->
                            </ul>
                            <input type="hidden" id="map-latitude" name="latitude" value="{{ request()->query('latitude')}}">
                            <input type="hidden" id="map-longitude" name="longitude" value="{{ request()->query('longitude')}}">
                        @if($errors->has('precise_location'))
                            <span class="error text-danger">{{$errors->first('precise_location')}}</span>
                        @endif
                    </div>
                    <div class="mb-4 position-relative">
                        <label class="form-label">Country</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="country" id="country" value={{old('country',@$products->productDetail->country)}}>
                        @if($errors->has('country'))
                            <span class="error text-danger">{{$errors->first('country')}}</span>
                        @endif
                    </div>
                    <div class="mb-4 position-relative">
                        <label class="form-label">State</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="state" id="state" value={{old('state',@$products->productDetail->state)}}>
                        @if($errors->has('state'))
                            <span class="error text-danger">{{$errors->first('state')}}</span>
                        @endif
                    </div>
                    <div class="mb-4 position-relative">
                        <label class="form-label">City</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="city" id="city" value={{old('city',@$products->productDetail->city)}}>
                        @if($errors->has('city'))
                            <span class="error text-danger">{{$errors->first('city')}}</span>
                        @endif
                    </div>
                    <div class="mb-4 position-relative">
                        <label class="form-label">Street </label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="street" id="street" value={{old('street',@$products->productDetail->street)}}>
                        @if($errors->has('street'))
                            <span class="error text-danger">{{$errors->first('street')}}</span>
                        @endif
                    </div>

                      <div class="mb-4 position-relative">
                        <label class="form-label">Trial / Exchange Location</label>
                        <input type="text" class="inner-form form-control" placeholder="Enter trial / exchange location ..." name="trial_location" onkeyup="SecondAutocomplete()" id="secondprecise_location" value={{old('trial_location',@$products->productDetail->trial_location)}}>
                        <span id="secondmap-location-message" class="text-danger" style="display: none; font-size: 12px;"></span>
                            <ul id="secondmap-location-list" style="display: none;">
                                <!-- Location suggestions will appear here -->
                            </ul>
                            <input type="hidden" id="secondmap-latitude" name="trail_latitude" value="{{old('trail_latitude',@$products->productDetail->trail_latitude)}}">
                            <input type="hidden" id="secondmap-longitude" name="trail_longitude" value="{{old('trail_longitude',@$products->productDetail->trail_longitude)}}">
                        @if($errors->has('trial_location'))
                            <span class="error text-danger">{{$errors->first('trial_location')}}</span>
                            
                        @endif
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="map" id="map">
                        <!-- <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113874.30006216935!2d75.70815698269863!3d26.88533996496087!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396c4adf4c57e281%3A0xce1c63a0cf22e09!2sJaipur%2C%20Rajasthan!5e0!3m2!1sen!2sin!4v1745411421280!5m2!1sen!2sin"
                            width="100%" height="600px" style="border:0; border-radius: 14px;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
                    </div>
                </div>
            </div>
        </div>

        <!-----banner section-------->
        <hr class="horizontal dark mt-0 mt-5">
        <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap">
            <h6>Banners:</h6>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="banners" id="ExchangeableAtDevon" value="Exchangeable At Devon" {{(old('banners')=='Exchangeable At Devon' || @$products->productDetail->banner=='Exchangeable At Devon')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="ExchangeableAtDevon">Exchangeable At Devon</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="radio" name="banners" id="Negotiable" value="Negotiable" {{(old('banners')=='Negotiable' || @$products->productDetail->banner=='Negotiable')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="Negotiable">Negotiable</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="banners" id="Price_Reduced" value="Price Reduced" {{(old('banners')=='Price Reduced' || @$products->productDetail->banner=='Price Reduced')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="Price_Reduced">Price Reduced</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="banners" id="Motivated_Seller" value="Motivated Seller" {{(old('banners')=='Motivated Seller' || @$products->productDetail->banner=='Motivated Seller')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="Motivated_Seller">Motivated Seller</label>
            </div>
            @if($errors->has('banners'))
                <span class="error text-danger">{{$errors->first('banners')}}</span>
            @endif
        </div>

        <!-----terms & conditions section-------->
        <div class="form-check pt-2 mt-3 position-relative">
            <input class="form-check-input" type="checkbox" name="agree" id="agree" value="1" {{(old('agree')==1 || @$products->productDetail->agree==1)?'checked':''}}>
            <label class="form-check-label fw-bold text-dark" for="agree" >I agree to <a href="{{route('cms.terms.condition')}}" target="_blank" style="color: #A19061;">Terms Of Use</a></label>

            @if($errors->has('agree'))
                <span class="error text-danger">{{$errors->first('agree')}}</span>
            @endif
        </div>

        <div class="text-start my-4">
            <button type="button" class="btn btn-primary" id="back" onclick="window.location.href='{{route('editProduct',$productId)}}'">Back</button>
            <button type="submit" class="btn btn-primary" id="productDetails-form-submit">Submit Ad</button>
        </div>

    </form>
</div>

@endsection


@section('script')
<script>
      let mapboxAccessToken = '{{ config('config.map_box_access_token') }}';
        mapboxgl.accessToken = mapboxAccessToken;

        // Initialize the map
        /* const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [77.2090, 28.6139],
            zoom: 10
        }); */

        let currentMarker = null;

        let map;
        let mainMarker = null;
        let secondMarker = null;

        function reverseGeocode(lat, lng) {
            const url =
                `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxAccessToken}`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.features?.length > 0) {
                        const placeName = data.features[0].place_name;
                        const locationInput = document.getElementById('map-location');
                        if (locationInput) locationInput.value = placeName;
                    }
                })
                .catch(error => {
                    console.error('Reverse geocoding error:', error);
                });
        }

        const MAP_PUBLIC = "{{ env('MAP_PUBLIC') }}"; // Blade variable rendered properly

        function addMapMarker(lat, lng, target = 'main', fly = false) {
            // Clear previous marker of that type
            if (target === 'main' && typeof mainMarker !== 'undefined' && mainMarker) {
                mainMarker.remove();
            } else if (target === 'second' && typeof secondMarker !== 'undefined' && secondMarker) {
                secondMarker.remove();
            }

            // Create custom marker element
            const el = document.createElement('div');
            el.className = 'custom-marker';
            el.style.width = '100px';
            el.style.height = '100px';
            el.style.backgroundSize = 'contain';
            el.style.backgroundRepeat = 'no-repeat';
            el.style.backgroundPosition = 'center';

            const markerImage = target === 'main' ?
                `${MAP_PUBLIC}/images/Equipment Red.png` :
                `${MAP_PUBLIC}/images/Equipment Blue.png`;

            el.style.backgroundImage = `url('${markerImage}')`;

            const marker = new mapboxgl.Marker(el)
                .setLngLat([lng, lat])
                .addTo(map);

            if (target === 'main') {
                mainMarker = marker;
            } else if (target === 'second') {
                secondMarker = marker;
            }

            if (fly && map) {
                map.flyTo({
                    center: [lng, lat],
                    zoom: 14,
                    speed: 1.2
                });
            }
        }

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
        window.onload = () => {
            const urlParams = new URLSearchParams(window.location.search);

            let lat1 = parseFloat('{{ @$products->productDetail->trail_latitude }}') || 26.8467;
            let lng1 = parseFloat('{{ @$products->productDetail->trail_longitude }}') || 75.7647;

            let lat2 = parseFloat(urlParams.get('latitude')) || parseFloat(
                '{{ @$products->productDetail->lattitude }}') || 26.8467;
            let lng2 = parseFloat(urlParams.get('longitude')) || parseFloat(
                '{{ @$products->productDetail->longitude }}') || 75.7647;

            const latInput = document.getElementById('map-latitude');
            const lngInput = document.getElementById('map-longitude');

            const updateLocation = () => {
                if (latInput) latInput.value = lat1.toFixed(6);
                if (lngInput) lngInput.value = lng1.toFixed(6);

                reverseGeocode(lat1, lng1);
                initializeMap(lat1, lng1); // Init map once
                addMapMarker(lat1, lng1, 'second', true); // Marker 1
                addMapMarker(lat2, lng2, 'main', true); // Marker 2 + flyTo
            };

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        lat1 = position.coords.latitude;
                        lng1 = position.coords.longitude;
                        updateLocation();
                    },
                    () => updateLocation(), {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                );
            } else {
                updateLocation();
            }

            initializeLocationAutocomplete();
            SecondAutocomplete();
        };



        function initializeLocationAutocomplete() {
            const locationInput = document.getElementById('precise_location');
            const locationList = document.getElementById('map-location-list');
            const locationMessage = document.getElementById('map-location-message');
            const latitudeInput = document.getElementById('map-latitude');
            const longitudeInput = document.getElementById('map-longitude');
            const countryInput = document.getElementById('country');
            const stateInput = document.getElementById('state');
            const cityInput = document.getElementById('city');
            const streetInput = document.getElementById('street');

            const sessionToken = Math.random().toString(36).substring(2, 15);
            const cache = {};
            let selectedIndex = -1;
            let suggestions = [];
            let debounceTimer;

            function clearSuggestions() {
                locationList.innerHTML = '';
                locationList.style.display = 'none';
                locationMessage.style.display = 'none';
                selectedIndex = -1;
                suggestions = [];
            }

            function highlightSuggestion(index) {
                const items = locationList.querySelectorAll('li');
                items.forEach((li, i) => {
                    li.classList.toggle('highlighted', i === index);
                    if (i === index) li.scrollIntoView({
                        block: 'nearest'
                    });
                });
            }

            function parseContext(context) {
                let state = '',
                    country = '',
                    city = '',
                    street = '';

                if (Array.isArray(context)) {
                    context.forEach(ctx => {
                        const id = ctx.id || '';
                        if (id.startsWith('region')) state = ctx.text || ctx.name || '';
                        else if (id.startsWith('country')) country = ctx.text || ctx.name || '';
                        else if (id.startsWith('place') || id.startsWith('district')) city = ctx.text || ctx.name ||
                            '';
                        else if (id.startsWith('locality') && !city) city = ctx.text || ctx.name || '';
                        else if (id.startsWith('address') || id.startsWith('street')) street = ctx.text || ctx
                            .name || '';
                    });
                } else if (typeof context === 'object' && context !== null) {
                    if (context.region) state = context.region.text || context.region.name || '';
                    if (context.country) country = context.country.text || context.country.name || '';
                    if (context.place) city = context.place.text || context.place.name || '';
                    if (!city && context.district) city = context.district.text || context.district.name || '';
                    if (!city && context.locality) city = context.locality.text || context.locality.name || '';
                    if (context.address) street = context.address.text || context.address.name || '';
                    if (!street && context.street) street = context.street.text || context.street.name || '';
                }

                return {
                    state,
                    country,
                    city,
                    street
                };
            }

            function selectSuggestion(index) {
                if (index < 0 || index >= suggestions.length) return;
                const suggestion = suggestions[index];
                const name = suggestion.name || '';

                const {
                    state,
                    country,
                    city,
                    street
                } = parseContext(suggestion.context);
                let finalStreet = street || (suggestion.place_type?.includes('address') ? name : '');
                let finalCity = city || (suggestion.place_type?.includes('place') ? name : '');

                locationInput.value = [name, state, country].filter(Boolean).join(', ');
                countryInput.value = country;
                stateInput.value = state;
                cityInput.value = finalCity;
                streetInput.value = finalStreet;

                clearSuggestions();

                const mapbox_id = suggestion.mapbox_id;
                fetch(
                        `https://api.mapbox.com/search/searchbox/v1/retrieve/${mapbox_id}?session_token=${sessionToken}&access_token=${mapboxAccessToken}`
                        )
                    .then(response => response.json())
                    .then(data => {
                        const feature = data.features?.[0];
                        if (!feature) return;

                        const coords = feature.geometry.coordinates;
                        if (coords) {
                            const lat = coords[1];
                            const lng = coords[0];
                            latitudeInput.value = lat;
                            longitudeInput.value = lng;
                            addMapMarker(lat, lng, 'main', true); // true to flyTo this location
                            if (typeof fetchVenues === 'function') fetchVenues(lat, lng);
                        }

                        let {
                            state: rState,
                            country: rCountry,
                            city: rCity,
                            street: rStreet
                        } = parseContext(feature.context);
                        if (feature.properties?.address && !rStreet) {
                            rStreet = feature.properties.address;
                        }

                        if (!countryInput.value) countryInput.value = rCountry;
                        if (!stateInput.value) stateInput.value = rState;
                        if (!cityInput.value) cityInput.value = rCity;
                        if (!streetInput.value) streetInput.value = rStreet;
                    })
                    .catch(err => console.error('Error fetching coordinates:', err));
            }

            function fetchSuggestions(query) {
                if (cache[query]) {
                    renderSuggestions(cache[query]);
                    return;
                }

                fetch(
                        `https://api.mapbox.com/search/searchbox/v1/suggest?q=${encodeURIComponent(query)}&language=en&limit=5&session_token=${sessionToken}&access_token=${mapboxAccessToken}`
                        )
                    .then(response => response.json())
                    .then(data => {
                        cache[query] = data;
                        renderSuggestions(data);
                    })
                    .catch(error => {
                        console.error('Error fetching location data:', error);
                        locationMessage.style.display = 'block';
                        locationMessage.textContent = 'Failed to fetch location data';
                        locationList.style.display = 'none';
                    });
            }

            function renderSuggestions(data) {
                locationList.innerHTML = '';
                suggestions = data.suggestions || [];

                if (suggestions.length > 0) {
                    suggestions.forEach((suggestion, i) => {
                        const li = document.createElement('li');
                        const name = suggestion.name || '';
                        const {
                            state,
                            country
                        } = parseContext(suggestion.context);
                        const fullAddress = [name, state, country].filter(Boolean).join(', ');

                        li.textContent = fullAddress;
                        li.setAttribute('data-index', i);
                        li.addEventListener('click', () => selectSuggestion(i));
                        locationList.appendChild(li);
                    });

                    locationList.style.display = 'block';
                    locationMessage.style.display = 'none';
                    selectedIndex = -1;
                } else {
                    locationMessage.style.display = 'block';
                    locationMessage.textContent = 'No locations found';
                    locationList.style.display = 'none';
                }
            }

            locationInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const query = locationInput.value.trim();
                    if (query.length > 2) {
                        fetchSuggestions(query);
                    } else {
                        clearSuggestions();
                    }
                }, 600);
            });

            locationInput.addEventListener('keydown', function(e) {
                const items = locationList.querySelectorAll('li');
                if (locationList.style.display === 'block' && items.length > 0) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        selectedIndex = (selectedIndex + 1) % items.length;
                        highlightSuggestion(selectedIndex);
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                        highlightSuggestion(selectedIndex);
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (selectedIndex >= 0) selectSuggestion(selectedIndex);
                    } else if (e.key === 'Escape') {
                        clearSuggestions();
                    }
                }
            });

            document.addEventListener('click', function(e) {
                if (!locationInput.contains(e.target) && !locationList.contains(e.target)) {
                    clearSuggestions();
                }
            });
        }


        function SecondAutocomplete() {
            const secondlocationInput = document.getElementById('secondprecise_location');
            const secondlocationList = document.getElementById('secondmap-location-list');
            const secondlocationMessage = document.getElementById('secondmap-location-message');
            const secondlatitudeInput = document.getElementById('secondmap-latitude');
            const secondlongitudeInput = document.getElementById('secondmap-longitude');
            // const secondcountryInput = document.getElementById('secondcountry');
            // const secondstateInput = document.getElementById('secondstate');
            // const secondcityInput = document.getElementById('secondcity');
            // const secondstreetInput = document.getElementById('secondstreet');

            const secondsessionToken = Math.random().toString(36).substring(2, 15);
            const secondcache = {};
            let secondselectedIndex = -1;
            let secondsuggestions = [];
            let seconddebounceTimer;

            function secondclearSuggestions() {
                secondlocationList.innerHTML = '';
                secondlocationList.style.display = 'none';
                secondlocationMessage.style.display = 'none';
                secondselectedIndex = -1;
                secondsuggestions = [];
            }

            function highlightSuggestion(index) {
                const seconditems = secondlocationList.querySelectorAll('li');
                seconditems.forEach((li, i) => {
                    li.classList.toggle('highlighted', i === index);
                    if (i === index) li.scrollIntoView({
                        block: 'nearest'
                    });
                });
            }

            function parseContext(context) {
                let secondstate = '',
                    secondcountry = '',
                    secondcity = '',
                    secondstreet = '';

                if (Array.isArray(context)) {
                    context.forEach(ctx => {
                        const id = ctx.id || '';
                        if (id.startsWith('region')) secondstate = ctx.text || ctx.name || '';
                        else if (id.startsWith('country')) secondcountry = ctx.text || ctx.name || '';
                        else if (id.startsWith('place') || id.startsWith('district')) secondcity = ctx.text || ctx
                            .name || '';
                        else if (id.startsWith('locality') && !secondcity) secondcity = ctx.text || ctx.name || '';
                        else if (id.startsWith('address') || id.startsWith('street')) secondstreet = ctx.text || ctx
                            .name || '';
                    });
                } else if (typeof context === 'object' && context !== null) {
                    if (context.region) secondstate = context.region.text || context.region.name || '';
                    if (context.country) secondcountry = context.country.text || context.country.name || '';
                    if (context.place) secondcity = context.place.text || context.place.name || '';
                    if (!secondcity && context.district) secondcity = context.district.text || context.district.name || '';
                    if (!secondcity && context.locality) secondcity = context.locality.text || context.locality.name || '';
                    if (context.address) secondstreet = context.address.text || context.address.name || '';
                    if (!secondstreet && context.street) secondstreet = context.street.text || context.street.name || '';
                }

                return {
                    secondstate,
                    secondcountry,
                    secondcity,
                    secondstreet
                };
            }

            function selectSuggestion(index) {
                if (index < 0 || index >= secondsuggestions.length) return;

                const suggestion = secondsuggestions[index];
                const secondname = suggestion.name || '';
                const mapbox_id = suggestion.mapbox_id;

                const {
                    secondstate,
                    secondcountry,
                    secondcity,
                    secondstreet
                } = parseContext(suggestion.context);
                const secondfinalStreet = secondstreet || (suggestion.place_type?.includes('address') ? secondname : '');
                const secondfinalCity = secondcity || (suggestion.place_type?.includes('place') ? secondname : '');

                secondlocationInput.value = [secondname, secondstate, secondcountry].filter(Boolean).join(', ');
                // secondcountryInput.value = secondcountry;
                // secondstateInput.value = secondstate;
                // secondcityInput.value = secondfinalCity;
                // secondstreetInput.value = secondfinalStreet;

                secondclearSuggestions();

                fetch(
                        `https://api.mapbox.com/search/searchbox/v1/retrieve/${mapbox_id}?session_token=${secondsessionToken}&access_token=${mapboxAccessToken}`
                        )
                    .then(response => response.json())
                    .then(data => {
                        const feature = data.features?.[0];
                        if (!feature) return;

                        const coords = feature.geometry?.coordinates;
                        if (coords) {
                            const lat = coords[1];
                            const lng = coords[0];
                            secondlatitudeInput.value = lat;
                            secondlongitudeInput.value = lng;

                            if (typeof addMapMarker === 'function') addMapMarker(lat, lng, 'second', true);
                            if (typeof fetchVenues === 'function') fetchVenues(lat, lng);
                        }

                        let {
                            secondstate: rState,
                            secondcountry: rCountry,
                            secondcity: rCity,
                            secondstreet: rStreet
                        } = parseContext(feature.context);

                        if (feature.properties?.address && !rStreet) {
                            rStreet = feature.properties.address;
                        }

                        // if (!secondcountryInput.value) secondcountryInput.value = rCountry;
                        // if (!secondstateInput.value) secondstateInput.value = rState;
                        // if (!secondcityInput.value) secondcityInput.value = rCity;
                        // if (!secondstreetInput.value) secondstreetInput.value = rStreet;
                    })
                    .catch(err => console.error('Error fetching coordinates:', err));
            }

            function fetchSuggestions(query) {
                if (secondcache[query]) {
                    renderSuggestions(secondcache[query]);
                    return;
                }

                fetch(
                        `https://api.mapbox.com/search/searchbox/v1/suggest?q=${encodeURIComponent(query)}&language=en&limit=5&session_token=${secondsessionToken}&access_token=${mapboxAccessToken}`
                        )
                    .then(response => response.json())
                    .then(data => {
                        secondcache[query] = data;
                        renderSuggestions(data);
                    })
                    .catch(error => {
                        console.error('Error fetching location data:', error);
                        secondlocationMessage.style.display = 'block';
                        secondlocationMessage.textContent = 'Failed to fetch location data';
                        secondlocationList.style.display = 'none';
                    });
            }

            function renderSuggestions(data) {
                secondlocationList.innerHTML = '';
                secondsuggestions = data.suggestions || [];

                if (secondsuggestions.length > 0) {
                    secondsuggestions.forEach((suggestion, i) => {
                        const li = document.createElement('li');
                        const secondname = suggestion.name || '';
                        const {
                            secondstate,
                            secondcountry
                        } = parseContext(suggestion.context);
                        const secondfullAddress = [secondname, secondstate, secondcountry].filter(Boolean).join(
                            ', ');

                        li.textContent = secondfullAddress;
                        li.setAttribute('data-index', i);
                        li.addEventListener('click', () => selectSuggestion(i));
                        secondlocationList.appendChild(li);
                    });

                    secondlocationList.style.display = 'block';
                    secondlocationMessage.style.display = 'none';
                    secondselectedIndex = -1;
                } else {
                    secondlocationMessage.style.display = 'block';
                    secondlocationMessage.textContent = 'No locations found';
                    secondlocationList.style.display = 'none';
                }
            }

            secondlocationInput.addEventListener('input', function() {
                clearTimeout(seconddebounceTimer);
                seconddebounceTimer = setTimeout(() => {
                    const query = secondlocationInput.value.trim();
                    if (query.length > 2) {
                        fetchSuggestions(query);
                    } else {
                        secondclearSuggestions();
                    }
                }, 600);
            });

            secondlocationInput.addEventListener('keydown', function(e) {
                const seconditems = secondlocationList.querySelectorAll('li');
                if (secondlocationList.style.display === 'block' && seconditems.length > 0) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        secondselectedIndex = (secondselectedIndex + 1) % seconditems.length;
                        highlightSuggestion(secondselectedIndex);
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        secondselectedIndex = (secondselectedIndex - 1 + seconditems.length) % seconditems.length;
                        highlightSuggestion(secondselectedIndex);
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (secondselectedIndex >= 0) selectSuggestion(secondselectedIndex);
                    } else if (e.key === 'Escape') {
                        secondclearSuggestions();
                    }
                }
            });

            document.addEventListener('click', function(e) {
                if (!secondlocationInput.contains(e.target) && !secondlocationList.contains(e.target)) {
                    secondclearSuggestions();
                }
            });
        }
   
</script>

<script>
    $(document).ready(function () {
        function toggleAddressFields() {
            if ($('#addressSet').is(':checked')) {
                $('#addressFields').hide();
                $("#addressFields").find("input").val('');
            } else {
                $('#addressFields').show();
                if(`{{!@$products->productDetail->country}}`)
                {
                    $("#addressFields").find("input").val('');
                }                
            }
        }

        // Run on page load
        toggleAddressFields();

        // Toggle on checkbox change
        $('#addressSet').change(function () {
            toggleAddressFields();
        });
    });
   
    $(document).ready(function () {
        function toggleContactFields() {
        if ($('#contactSet').is(':checked')) {
                $('#contactFields').hide();
                $("#contactFields").find("input").val('');
            } 
            else {
                $('#contactFields').show();
                if(`{{!@$products->productDetail->phone}}`)
                {
                    $("#contactFields").find("input").val('');
                }
            }
        }

        // Run on page load
        toggleContactFields();

        // Toggle on checkbox change
        $('#contactSet').change(function () {
            toggleContactFields();
        });
    });
</script>

<script>
 
    $(document).ready(function () {
        // $.validator.setDefaults({ ignore: [] }); // allow hidden fields like checkboxes

        $('#productDetailsForm').validate({
            rules: {
                'horse_apparel[]': { required: true },
                'rider_apparel[]': { required: true },
                'horse_tack[]': { required: true },
                'trailer_trucks[]': { required: true },
                'for_barns[]': { required: true },
                'equine_supplements[]': { required: true },
                'conditions[]': { required: true },
                'brands[]': { required: true },
                'horse_sizes[]': { required: true },
                'rider_sizes[]': { required: true },
                'exchanged_upcoming_horse_shows[]': { required: true },
                'price': "required",
                'hourly_price': "required",
                'fixed_price': "required",                
                'agree': "required",
                'banners': "required",
            },
            messages: {
                'horse_apparel[]': "Please select at least one item.",
                'rider_apparel[]': "Please select at least one item.",
                'horse_tack[]': "Please select at least one item.",
                'trailer_trucks[]': "Please select at least one item.",
                'for_barns[]': "Please select at least one option.",
                'equine_supplements[]': "Please select at least one item.",
                'conditions[]': "Please select at least one condition.",
                'brands[]': "Please select at least one brand.",
                'horse_sizes[]': "Please select at least one item.",
                'rider_sizes[]': "Please select at least one item.",
                'exchanged_upcoming_horse_shows[]': "Please select at least one item.",
                'price': "Price is required.",
                'hourly_price': "Hourly price is required.",
                'fixed_price': "Fixed price is required.",
                'agree': "You must accept the terms.",
                'banners': "Banner is required"
            },
            errorClass: 'error text-danger custom-error',
            errorElement: 'span',

            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                $('#productDetails-form-submit').prop('disabled', true).text('Please wait...');
                form.submit();
            }
        });

        $('select[multiple]').on('change', function () {
            $(this).valid();
        });

        // Custom regex validator for age
        $.validator.addMethod("regex", function (value, element, regex) {
            return this.optional(element) || regex.test(value);
        });

        // Conditional rules
        function toggleConditionalRules() {
            const addressSet = $('#addressSet').is(':checked');
            const contactSet = $('#contactSet').is(':checked');

            if (!addressSet) {
                $('#precise_location, #country, #state, #city').each(function () {
                    $(this).rules('add', { required: true, maxlength: 300 });
                });
            } else {
                $('#precise_location, #country, #state, #city').each(function () {
                    $(this).rules('remove', 'required');
                });
            }

            if (!contactSet) {
                $('#phone').rules('add', {
                    required: true,
                    regex: /^\+?[0-9]{10,15}$/,
                    messages: {
                        required: "Phone number is required",
                        regex: "Phone number format is invalid"
                    }
                });
            } else {
                $('#phone').rules('remove', 'required');
            }
        }

        // Trigger conditional logic on load and change
        toggleConditionalRules();
        $('#addressSet, #contactSet').on('change', toggleConditionalRules);


        $.validator.addMethod("filesize", function (value, element, param) {
            if (element.files.length === 0) return true;
            return element.files[0].size <= param;
        }, "File size must be less than {0} bytes.");

    });


        

</script>



@endsection