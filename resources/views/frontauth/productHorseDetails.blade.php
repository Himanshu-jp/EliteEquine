@extends('frontauth.layouts.main')
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


    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}


    <form action="{{ route('productHorseDetails') }}" method="post" class="row" id="productDetailsForm" enctype="multipart/form-data">
        @csrf
        <!----horse product fields--------->

        <div class="row">
            <input type="hidden" name="productId" value="{{$productId}}">
            <input type="hidden" name="productDetailId" value="{{@$products->productDetail->id}}">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            
            @if(@$products->category_id)
                <div class="col-md-3 mt-3 position-relative">
                    <label for="category" class="form-label">Category : &nbsp;&nbsp;<span class="h5 font-weight-bolder">{{@$products->category->name}}</span></label>                    
                </div>
            @endif

            <div class="row align-items-baseline cusmt-form-mb">

                <div class="col-md-3 mt-3 position-relative">
                    <label for="sub_category" class="form-label">Sub Category *</label>
                    <select class="form-select pe-5 mb-2 inner-form form-control" name="sub_category" id="sub_category" >
                        <option value="">-- Select Category --</option>
                        @foreach ($subcategories as $key=>$value)
                            <option value="{{$key}}" {{(old('category',@$products->sub_category)==$key)?'selected':''}}>{{$value}}</option>    
                        @endforeach
                    </select>

                    @if($errors->has('sub_category'))
                        <span class="error text-danger">{{$errors->first('sub_category')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Disciplines</label>
                    <select class="form-control select2" id="disciplines" name="disciplines[]" multiple="multiple">
                        @foreach(__disciplinesData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('disciplines', @$products->disciplines->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                    @if($errors->has('disciplines'))
                        <span class="error text-danger">{{$errors->first('disciplines')}}</span>
                    @endif
                </div>


                <div class="col-md-3 mt-3 position-relative">
                    <label for="age" class="form-label">Born Year</label>
                    <input type="text" name="age" class="inner-form form-control mb-0 numbervalid" placeholder="eg. 1990" value="{{@$products->productDetail->age}}">
                    @if($errors->has('age'))
                        <span class="error text-danger">{{$errors->first('age')}}</span>
                    @endif     
                </div>

                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Height in hands</label>
                    <select class="form-select pe-5 mb-2 inner-form form-control" id="height_id" name="height_id">
                        <option value="">Select an option</option>
                        @foreach(__heightsData() as $key=>$value)
                            <option value="{{$key}}" {{old('height_id',@$products->productDetail->height_id)==$key?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('height_id'))
                        <span class="error text-danger">{{$errors->first('height_id')}}</span>
                    @endif
                </div>


                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Sex</label>
                    <select class="form-select pe-5 mb-2 inner-form form-control" id="sex_id" name="sex_id">
                        <option value="">Select an option</option>
                        @foreach(__sexesData() as $key=>$value)
                            <option value="{{$key}}" {{old('sex_id',@$products->productDetail->sex_id)==$key?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('sex_id'))
                        <span class="error text-danger">{{$errors->first('sex_id')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Breed</label>
                    <select class="form-control select2" id="breeds" name="breeds[]" multiple="multiple">
                        @foreach(__breedsData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('breeds', @$products->breeds->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('breeds'))
                        <span class="error text-danger">{{$errors->first('breeds')}}</span>
                    @endif
                </div>


                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Color</label>
                    <select class="form-control select2" id="colors" name="colors[]" multiple="multiple">                            
                        @foreach(__colorsData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('colors', @$products->colors->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('colors'))
                        <span class="error text-danger">{{$errors->first('colors')}}</span>
                    @endif
                </div>


                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Training & Show Experience</label>
                    <select class="form-control select2" id="training_show_experiences" name="training_show_experiences[]" multiple="multiple">
                        @foreach(__trainingShowExperiencesData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('training_show_experiences', @$products->trainingShowExperiences->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('training_show_experiences'))
                        <span class="error text-danger">{{$errors->first('training_show_experiences')}}</span>
                    @endif
                </div>


                    <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Green Eligibility</label>
                    <select class="form-select pe-5 mb-2 inner-form form-control" id="green_eligibilitie_id" name="green_eligibilitie_id">
                        <option value="">Select an option</option>
                        @foreach(__greenEligibilitiesData() as $key=>$value)
                            <option value="{{$key}}" {{old('green_eligibilitie_id',@$products->productDetail->green_eligibilitie_id)==$key?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('green_eligibilitie_id'))
                        <span class="error text-danger">{{$errors->first('green_eligibilitie_id')}}</span>
                    @endif
                </div>



                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Qualified For</label>
                    <select class="form-control select2" id="qualifies" name="qualifies[]" multiple="multiple">
                        @foreach(__qualifiesData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('qualifies', @$products->qualifies->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('qualifies'))
                        <span class="error text-danger">{{$errors->first('qualifies')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Current Fence Height</label>
                    <select class="form-control select2" id="current_fence_heights" name="current_fence_heights[]" multiple="multiple">
                        @foreach(__currentFenceHeightData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('current_fence_heights', @$products->currentFenceHeight->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('current_fence_heights'))
                        <span class="error text-danger">{{$errors->first('current_fence_heights')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Potential Fence Height</label>
                    <select class="form-control select2" id="potential_fence_heights" name="potential_fence_heights[]" multiple="multiple">
                        @foreach(__potentialFenceHeightData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('potential_fence_heights', @$products->potentialFenceHeight->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('potential_fence_heights'))
                        <span class="error text-danger">{{$errors->first('potential_fence_heights')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Can Be Tried at Upcoming
                            Show</label>
                    <select class="form-control select2" id="tried_upcoming_shows" name="tried_upcoming_shows[]" multiple="multiple">
                        @foreach(__triedUpcomingShowsData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('tried_upcoming_shows', @$products->triedUpcomingShows->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                    @if($errors->has('tried_upcoming_shows'))
                        <span class="error text-danger">{{$errors->first('tried_upcoming_shows')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3 position-relative">
                    <label for="fromdate" class="form-label">Trial Dates Available From</label>
                    <input type="date" class="inner-form form-control mb-0" name="fromdate" id="fromdate" placeholder="date" value="{{old('fromdate',@$products->productDetail->fromdate)}}">
                        @if($errors->has('fromdate'))
                        <span class="error text-danger">{{$errors->first('fromdate')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3 position-relative">
                    <label for="todate" class="form-label">Trial Dates To</label>
                    <input type="date" class="inner-form form-control mb-0" name="todate" id="todate" placeholder="" value="{{old('todate',@$products->productDetail->todate)}}">
                        @if($errors->has('todate'))
                        <span class="error text-danger">{{$errors->first('todate')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3 position-relative">
                    <label for="bid_min_price" class="form-label">Bid Minimum Price</label>
                    <input type="text" name="bid_min_price" id="bid_min_price" class="inner-form form-control mb-0 numbervalid" placeholder="Enter bid minimum price" value="{{old('bid_min_price',@$products->productDetail->bid_min_price)}}">
                    @if($errors->has('bid_min_price'))
                        <span class="error text-danger">{{$errors->first('bid_min_price')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="sale_price" class="form-label">Sale Price Range</label>
                    <input type="text" name="sale_price" id="sale_price" class="inner-form form-control mb-0 numbervalid" placeholder="Enter sale price" value="{{old('sale_price',@$products->productDetail->sale_price)}}">
                    @if($errors->has('sale_price'))
                        <span class="error text-danger">{{$errors->first('sale_price')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3 position-relative">
                    <label for="lease_price" class="form-label">Lease Price Range</label>
                    <input type="text" name="lease_price" id="lease_price" class="inner-form form-control mb-0 numbervalid" placeholder="Enter lease price" value="{{old('lease_price',@$products->productDetail->lease_price)}}">
                    @if($errors->has('lease_price'))
                        <span class="error text-danger">{{$errors->first('lease_price')}}</span>
                    @endif
                </div>


                <div class="col-md-3 mt-3 position-relative">
                    <label for="trainer" class="form-label">Trainer</label>
                    <input type="text" name="trainer" id="trainer" class="inner-form form-control mb-0" placeholder="Enter trainer" value="{{old('trainer',@$products->productDetail->trainer)}}">
                    @if($errors->has('trainer'))
                        <span class="error text-danger">{{$errors->first('trainer')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="facility" class="form-label">Facility</label>
                    <input type="text" name="facility" id="facility" class="inner-form form-control mb-0" placeholder="Enter facility" value="{{old('facility',@$products->productDetail->facility)}}">
                    @if($errors->has('facility'))
                        <span class="error text-danger">{{$errors->first('facility')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="sirebloodline" class="form-label">Sire Bloodlines</label>
                    <input type="text" name="sirebloodline" id="sirebloodline" class="inner-form form-control mb-0" placeholder="Enter sire bloodline" value="{{old('sirebloodline',@$products->productDetail->sirebloodline)}}">
                    @if($errors->has('sirebloodline'))
                        <span class="error text-danger">{{$errors->first('sirebloodline')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="dambloodline" class="form-label">Dam Bloodlines</label>
                    <input type="text" name="dambloodline" id="dambloodline" class="inner-form form-control mb-0" placeholder="Enter dam bloodline" value="{{old('dambloodline',@$products->productDetail->dambloodline)}}">
                    @if($errors->has('dambloodline'))
                        <span class="error text-danger">{{$errors->first('dambloodline')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="usef" class="form-label">USEF #</label>
                    <input type="text" name="usef" id="usef" class="inner-form form-control mb-0" placeholder="Enter USEF#" value="{{old('usef',@$products->productDetail->usef)}}">
                    @if($errors->has('usef'))
                        <span class="error text-danger">{{$errors->first('usef')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3 position-relative">
                    <label for="pedigree_chart" class="form-label">Upload Pedigree Chart</label>
                    @if(@$products->productDetail->pedigree_chart)
                        <img src="{{asset('storage/'.@$products->productDetail->pedigree_chart)}}" class="upload-image w-100" id="uploadTrigger"
                    alt="Click to upload" style="cursor: pointer;" />
                    @else
                        <img src="{{asset('front/auth/assets/img/icons/upload-img.svg')}}" class="upload-image w-100" id="uploadTrigger"
                    alt="Click to upload" style="cursor: pointer;" />
                    @endif

                    <input type="file" id="fileInput" style="display: none;" name="pedigree_chart" id="pedigree_chart">

                    @if($errors->has('pedigree_chart'))
                        <span class="error text-danger">{{$errors->first('pedigree_chart')}}</span>
                    @endif
                </div>

            </div>
        </div>

        <!---locaiton & phone fields---------->
        <div class="pt-5">

            <!-- Checkbox to toggle phone fields -->
            @if(!@$products->productDetail->phone)
                <div class="form-check mb-3 position-relative">
                    <input class="form-check-input" type="checkbox" id="contactSet" name="contactSet" value="1" {{(old('contactSet')=='1')?'checked':''}} >
                    <label class="form-check-label fw-bold text-dark" for="contactSet">
                        Use contact set in profile section 
                    </label>
                </div>
            @endif


            <!-- Checkbox to toggle address fields -->
            @if(!@$products->productDetail->country)
            <div class="form-check mb-3 position-relative">
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
            <div class="row cusmt-form-mb">
                <div class="col-md-6">
                    
                    <div class="mt-4 position-relative">
                        <label class="form-label">Precise Location</label>
                        <input type="text" class="inner-form form-control" placeholder="Enter location.." name="precise_location" id="precise_location" onkeyup="initializeLocationAutocomplete()" value={{old('precise_location',@$products->productDetail->precise_location)}}>
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

                    <div class="mt-4 position-relative">
                        <label class="form-label">Country</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="country" id="country" value={{old('country',@$products->productDetail->country)}}>
                        @if($errors->has('country'))
                            <span class="error text-danger">{{$errors->first('country')}}</span>
                        @endif
                    </div>
                    <div class="mt-4 position-relative">
                        <label class="form-label">State</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="state" id="state" value={{old('state',@$products->productDetail->state)}}>
                        @if($errors->has('state'))
                            <span class="error text-danger">{{$errors->first('state')}}</span>
                        @endif
                    </div>
                    <div class="mt-4 position-relative">
                        <label class="form-label">City</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="city" id="city" value={{old('city',@$products->productDetail->city)}}>
                        @if($errors->has('city'))
                            <span class="error text-danger">{{$errors->first('city')}}</span>
                        @endif
                    </div>
                    <div class="mt-4 position-relative">
                        <label class="form-label">Street </label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="street" id="street" value={{old('street',@$products->productDetail->street)}}>
                        @if($errors->has('street'))
                            <span class="error text-danger">{{$errors->first('street')}}</span>
                        @endif
                    </div>

                    <div class="mt-4 position-relative">
                        <label class="form-label">Trial / Exchange Location</label>
                        <input type="text" class="inner-form form-control" placeholder="Enter trial / exchange location..." name="trial_location" id="trial_location" value={{old('trial_location',@$products->productDetail->trial_location)}}>
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
        <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap  ">
            <h6>Banners:</h6>
            <div class="form-check position-relative">
                <input class="form-check-input" type="radio" name="banners" id="GreenEligibility" value="Green Eligibility" {{(old('banners')=='Green Eligibility' || @$products->productDetail->banner=='Green Eligibility')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="GreenEligibility">Green Eligibility</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="banners" id="Qualified_for" value="Qualified for" {{(old('banners')=='Qualified for' || @$products->productDetail->banner=='Qualified for')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="Qualified_for">Qualified for</label>
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
        <div class="form-check pt-2 mt-3">
            <input class="form-check-input" type="checkbox" name="agree" id="agree" value="1" {{(old('agree')==1 || @$products->productDetail->agree==1)?'checked':''}}>
            <label class="form-check-label fw-bold text-dark" for="agree" >I agree to <a href="{{route('cms.terms.condition')}}" target="_blank" style="color: #A19061;">Terms Of Use</a></label>

            @if($errors->has('agree'))
                <span class="error text-danger">{{$errors->first('agree')}}</span>
            @endif
        </div>

        <div class="text-start my-4">
            <button type="submit" class="btn btn-primary" id="productDetails-form-submit">Submit Ad</button>
        </div>

    </form>
</div>

@endsection


@section('script')

<script>
    let mapboxAccessToken = '{{ config("config.map_box_access_token") }}';
    mapboxgl.accessToken = mapboxAccessToken;

    // Initialize the map
    /* const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [77.2090, 28.6139],
        zoom: 10
    }); */

    let currentMarker = null;

    function addMapMarker(lat, lng) {
        if (currentMarker) currentMarker.remove();

        const el = document.createElement('div');
        el.className = 'custom-map-marker';

        currentMarker = new mapboxgl.Marker(el)
            .setLngLat([lng, lat])
            .addTo(map);

        map.flyTo({ center: [lng, lat], zoom: 14 });
    }

    function reverseGeocode(lat, lng) {
        const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxAccessToken}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data.features && data.features.length > 0) {
                    const placeName = data.features[0].place_name;
                    const locationInput = document.getElementById('map-location');
                    if (locationInput) locationInput.value = placeName;
                }
            })
            .catch(error => {
                console.error('Reverse geocoding error:', error);
            });
    }

    window.onload = () => {
        const urlParams = new URLSearchParams(window.location.search);
        let lat = parseFloat(urlParams.get('latitude')) || 26.8467;
        let lng = parseFloat(urlParams.get('longitude')) || 75.7647;

        const latInput = document.getElementById('map-latitude');
        const lngInput = document.getElementById('map-longitude');

        const updateLocation = () => {
            if (latInput) latInput.value = lat.toFixed(6);
            if (lngInput) lngInput.value = lng.toFixed(6);
            reverseGeocode(lat, lng);
            initializeMap(lat, lng);
            addMapMarker(lat, lng);
        };

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    lat = position.coords.latitude;
                    lng = position.coords.longitude;
                    updateLocation();
                },
                () => updateLocation(),
                { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
            );
        } else {
            updateLocation();
        }

        initializeLocationAutocomplete();
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
                if (i === index) li.scrollIntoView({ block: 'nearest' });
            });
        }

        function parseContext(context) {
            let state = '', country = '', city = '', street = '';

            if (Array.isArray(context)) {
            context.forEach(ctx => {
                const id = ctx.id || '';
                if (id.startsWith('region')) state = ctx.text || ctx.name || '';
                else if (id.startsWith('country')) country = ctx.text || ctx.name || '';
                else if (id.startsWith('place') || id.startsWith('district')) city = ctx.text || ctx.name || '';
                else if (id.startsWith('locality') && !city) city = ctx.text || ctx.name || '';
                else if (id.startsWith('address') || id.startsWith('street')) street = ctx.text || ctx.name || '';
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

            return { state, country, city, street };
        }

        function selectSuggestion(index) {
            if (index < 0 || index >= suggestions.length) return;
            const suggestion = suggestions[index];
            const name = suggestion.name || '';

            const { state, country, city, street } = parseContext(suggestion.context);
            let finalStreet = street || (suggestion.place_type?.includes('address') ? name : '');
            let finalCity = city || (suggestion.place_type?.includes('place') ? name : '');

            locationInput.value = [name, state, country].filter(Boolean).join(', ');
            countryInput.value = country;
            stateInput.value = state;
            cityInput.value = finalCity;
            streetInput.value = finalStreet;

            clearSuggestions();

            const mapbox_id = suggestion.mapbox_id;
            fetch(`https://api.mapbox.com/search/searchbox/v1/retrieve/${mapbox_id}?session_token=${sessionToken}&access_token=${mapboxAccessToken}`)
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
                        addMapMarker(lat, lng);
                        if (typeof fetchVenues === 'function') fetchVenues(lat, lng);
                    }

                    let { state: rState, country: rCountry, city: rCity, street: rStreet } = parseContext(feature.context);
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

            fetch(`https://api.mapbox.com/search/searchbox/v1/suggest?q=${encodeURIComponent(query)}&language=en&limit=5&session_token=${sessionToken}&access_token=${mapboxAccessToken}`)
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
                    const { state, country } = parseContext(suggestion.context);
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

        locationInput.addEventListener('input', function () {
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

        locationInput.addEventListener('keydown', function (e) {
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

        document.addEventListener('click', function (e) {
            if (!locationInput.contains(e.target) && !locationList.contains(e.target)) {
                clearSuggestions();
            }
        });
    }

</script>
<script>
    $(window).on('load', function () {
    if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const latitude = position.coords.latitude.toFixed(6);
                const longitude = position.coords.longitude.toFixed(6);

                console.log("Latitude:", latitude);
                console.log("Longitude:", longitude);

                // Optional: Set values into hidden inputs if needed
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);
            },
            function (error) {
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        console.error("User denied the request for Geolocation.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        console.error("Location information is unavailable.");
                        break;
                    case error.TIMEOUT:
                        console.error("The request to get user location timed out.");
                        break;
                    default:
                        console.error("An unknown error occurred.");
                        break;
                }
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    } else {
        console.error("Geolocation is not supported by this browser.");
    }
});


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
        $.validator.setDefaults({ ignore: [] }); // allow hidden fields like checkboxes

        $('#productDetailsForm').validate({
            rules: {
                // category: "required",
                sub_category: "required",
                'disciplines[]': { required: true },
                age: {
                    required: true,
                    regex: /^\d{4}$/,
                    max: new Date().getFullYear()
                },
                height_id: "required",
                sex_id: "required",
                'breeds[]': { required: true },
                'colors[]': { required: true },
                'training_show_experiences[]': { required: true },
                green_eligibilitie_id: "required",
                'qualifies[]': { required: true },
                'current_fence_heights[]': { required: true },
                'potential_fence_heights[]': { required: true },
                'tried_upcoming_shows[]': { required: true },
                fromdate: "required",
                todate: "required",
                bid_min_price: "required",
                sale_price: "required",
                lease_price: "required",
                trainer: "required",
                facility: "required",
                sirebloodline: "required",
                dambloodline: "required",
                usef: "required",
                pedigree_chart: {
                    // required: true,
                    extension: "jpeg|jpg|png|gif|webp|svg",
                    filesize: 2 * 1024 * 1024 // 2MB
                },
                agree: "required",
                banners: "required"
            },
            messages: {
                category: "Category is required.",
                sub_category: "Sub-category is required.",
                'disciplines[]': "Please select at least one discipline.",
                age: {
                    required: "Year of birth is required.",
                    regex: "Please enter a valid 4-digit year.",
                    max: "Year cannot be greater than the current year."
                },
                height_id: "Height is required.",
                sex_id: "Sex is required.",
                'breeds[]': "Please select at least one breed.",
                'colors[]': "Please select at least one color.",
                'training_show_experiences[]': "Please select at least one training/show experience.",
                green_eligibilitie_id: "Green eligibility is required.",
                'qualifies[]': "Please select at least one qualification.",
                'current_fence_heights[]': "Please select at least one current fence height.",
                'potential_fence_heights[]': "Please select at least one potential fence height.",
                'tried_upcoming_shows[]': "Please select at least one upcoming show.",
                fromdate: "Start date is required.",
                todate: "End date is required.",
                bid_min_price: "Minimum bid price is required.",
                sale_price: "Sale price is required.",
                lease_price: "Lease price is required.",
                trainer: "Trainer name is required.",
                facility: "Facility name is required.",
                sirebloodline: "Sire bloodline is required.",
                dambloodline: "Dam bloodline is required.",
                usef: "USEF is required.",
                pedigree_chart: {
                    required: "Please upload a pedigree chart.",
                    extension: "Accepted formats: jpeg, jpg, png, gif, webp, svg.",
                    filesize: "Pedigree chart must not exceed 2MB."
                },
                agree: "You must accept the terms.",
                banners: "Please upload at least one banner image."
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
                $('#precise_location, #country, #state, #city, #street').each(function () {
                    $(this).rules('add', { required: true, maxlength: 300 });
                });
            } else {
                $('#precise_location, #country, #state, #city, #street').each(function () {
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