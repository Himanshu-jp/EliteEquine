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


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('productBarnsDetails') }}" method="post" class="row" id="productDetailsForm" enctype="multipart/form-data">
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

            <div class="row">

                <div class="col-md-3 mt-3 position-relative">
                    <label for="sub_category" class="form-label">Sub Category *</label>
                    <select class="form-select pe-5 mb-2 inner-form form-control" name="sub_category" id="sub_category" >
                        <option value="">-- Select Sub Category --</option>
                        @foreach ($subcategories as $key=>$value)
                            <option value="{{$key}}" {{(old('sub_category',@$products->sub_category)==$key)?'selected':''}}>{{$value}}</option>    
                        @endforeach
                    </select>

                    @if($errors->has('sub_category'))
                        <span class="error text-danger">{{$errors->first('sub_category')}}</span>
                    @endif
                </div>


                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Property Types</label>
                    <select class="form-control select2" id="property_types" name="property_types[]" multiple="multiple">
                        @foreach(__getPropertytypesData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('property_types', @$products->propertyTypes->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('property_types'))
                        <span class="error text-danger">{{$errors->first('property_types')}}</span>
                    @endif
                </div>


                <div class="col-md-3 mt-3">
                    <label for="stalls_available" class="form-label">Stalls Available</label>
                    <input type="text" name="stalls_available" id="stalls_available" class="inner-form form-control mb-0 numbervalid" placeholder="Enter available stalls count" value="{{old('stalls_available',@$products->productDetail->stalls_available)}}">
                    @if($errors->has('stalls_available'))
                        <span class="error text-danger">{{$errors->first('stalls_available')}}</span>
                    @endif
                </div>


                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Stable Amenities</label>
                    <select class="form-control select2" id="stable_amenities" name="stable_amenities[]" multiple="multiple">
                        @foreach(__getStableAmenitiesData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('stable_amenities', @$products->stableAmenities->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('stable_amenities'))
                        <span class="error text-danger">{{$errors->first('stable_amenities')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Housing or Stables around Horse Show</label>
                    <select class="form-control select2" id="housing_stables_around_horse_shows" name="housing_stables_around_horse_shows[]" multiple="multiple">
                        @foreach(__getHousingStable() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('housing_stables_around_horse_shows', @$products->housingStablesAroundHorseShows->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('housing_stables_around_horse_shows'))
                        <span class="error text-danger">{{$errors->first('housing_stables_around_horse_shows')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3">
                    <label for="fromdate" class="form-label">Trial Dates Available From</label>
                    <input type="date" class="inner-form form-control mb-0" name="fromdate" id="fromdate" placeholder="abc" value="{{old('fromdate',@$products->productDetail->fromdate)}}">
                        @if($errors->has('fromdate'))
                        <span class="error text-danger">{{$errors->first('fromdate')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3">
                    <label for="todate" class="form-label">Trial Dates To</label>
                    <input type="date" class="inner-form form-control mb-0" name="todate" id="todate" placeholder="" value="{{old('todate',@$products->productDetail->todate)}}" >
                        @if($errors->has('todate'))
                        <span class="error text-danger">{{$errors->first('todate')}}</span>
                    @endif
                </div>                
                
                <div class="col-md-3 mt-3">
                    <label for="sleeps" class="form-label">Sleeps</label>
                    <input type="text" name="sleeps" id="sleeps" class="inner-form form-control mb-0 numbervalid" placeholder="Enter sleeps" value="{{old('sleeps',@$products->productDetail->sleeps)}}">
                    @if($errors->has('sleeps'))
                    <span class="error text-danger">{{$errors->first('sleeps')}}</span>
                    @endif
                </div>


                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Housing Amenities</label>
                    <select class="form-control select2" id="housing_amenities" name="housing_amenities[]" multiple="multiple">
                        @foreach(__getHousingAmenitiesData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('housing_amenities', @$products->housingAmenities->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('housing_amenities'))
                        <span class="error text-danger">{{$errors->first('housing_amenities')}}</span>
                    @endif
                </div>

                {{-- -------------------------------------------------------------- --}}
                
                <div class="col-md-3 mt-3">
                    <label for="daily_board_rental_rate" class="form-label">Daily Board or Rental Rate</label>
                    <input type="text" name="daily_board_rental_rate" id="daily_board_rental_rate" class="inner-form form-control mb-0 numbervalid" placeholder="Enter daily board rental rate" value="{{old('daily_board_rental_rate',@$products->productDetail->daily_board_rental_rate)}}">
                    @if($errors->has('daily_board_rental_rate'))
                        <span class="error text-danger">{{$errors->first('daily_board_rental_rate')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3">
                    <label for="weekly_board_rental_rate" class="form-label">Weekly Board or Rental Rate</label>
                    <input type="text" name="weekly_board_rental_rate" id="weekly_board_rental_rate" class="inner-form form-control mb-0 numbervalid" placeholder="Enter weekly board rental rate" value="{{old('weekly_board_rental_rate',@$products->productDetail->weekly_board_rental_rate)}}">
                    @if($errors->has('weekly_board_rental_rate'))
                        <span class="error text-danger">{{$errors->first('weekly_board_rental_rate')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3">
                    <label for="monthly_board_rental_rate" class="form-label">Monthly Board or Rental Rate</label>
                    <input type="text" name="monthly_board_rental_rate" id="monthly_board_rental_rate" class="inner-form form-control mb-0 numbervalid" placeholder="Enter monthly borad rental rate" value="{{old('monthly_board_rental_rate',@$products->productDetail->monthly_board_rental_rate)}}">
                    @if($errors->has('monthly_board_rental_rate'))
                        <span class="error text-danger">{{$errors->first('monthly_board_rental_rate')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3">
                    <label for="sale_cost" class="form-label">Sale Cost</label>
                    <input type="text" name="sale_cost" id="sale_cost" class="inner-form form-control mb-0 numbervalid" placeholder="Enter sale cost" value="{{old('sale_cost',@$products->productDetail->sale_cost)}}">
                    @if($errors->has('sale_cost'))
                        <span class="error text-danger">{{$errors->first('sale_cost')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3">
                    <label for="realtor" class="form-label">Realtor</label>
                    <input type="text" name="realtor" id="realtor" class="inner-form form-control mb-0" placeholder="Enter realtor name" value="{{old('realtor',@$products->productDetail->realtor)}}">
                    @if($errors->has('realtor'))
                        <span class="error text-danger">{{$errors->first('realtor')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3">
                    <label for="property_manager" class="form-label">Property Managers</label>
                    <input type="text" name="property_manager" id="property_manager" class="inner-form form-control mb-0" placeholder="Enter property managers name here" value="{{old('property_manager',@$products->productDetail->property_manager)}}">
                    @if($errors->has('property_manager'))
                        <span class="error text-danger">{{$errors->first('property_manager')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3">
                    <label for="bid_min_price" class="form-label">Bid Minimum Price</label>
                    <input type="text" name="bid_min_price" id="bid_min_price" class="inner-form form-control mb-0 numbervalid" placeholder="Enter bid minimum price" value="{{old('bid_min_price',@$products->productDetail->bid_min_price)}}">
                    @if($errors->has('bid_min_price'))
                        <span class="error text-danger">{{$errors->first('bid_min_price')}}</span>
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
        <div class="col-md-3 mt-3" id="contactFields" style="display: none;">
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
                    
                    <div class="mt-2">
                        <label class="form-label">Precise Location</label>
                        <input type="text" class="inner-form form-control" placeholder="Enter location.." name="precise_location" id="precise_location" value={{old('precise_location',@$products->productDetail->precise_location)}}>
                        @if($errors->has('precise_location'))
                            <span class="error text-danger">{{$errors->first('precise_location')}}</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Country</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="country" id="country" value={{old('country',@$products->productDetail->country)}}>
                        @if($errors->has('country'))
                            <span class="error text-danger">{{$errors->first('country')}}</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <label class="form-label">State</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="state" id="state" value={{old('state',@$products->productDetail->state)}}>
                        @if($errors->has('state'))
                            <span class="error text-danger">{{$errors->first('state')}}</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <label class="form-label">City</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="city" id="city" value={{old('city',@$products->productDetail->city)}}>
                        @if($errors->has('city'))
                            <span class="error text-danger">{{$errors->first('city')}}</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Street </label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="street" id="street" value={{old('street',@$products->productDetail->street)}}>
                        @if($errors->has('street'))
                            <span class="error text-danger">{{$errors->first('street')}}</span>
                        @endif
                    </div>

                     <div class="mt-2 position-relative">
                        <label class="form-label">Trial / Exchange Location</label>
                        <input type="text" class="inner-form form-control" placeholder="Enter trial / exchange location..." name="trial_location" id="trial_location" value={{old('trial_location',@$products->productDetail->trial_location)}}>
                        @if($errors->has('trial_location'))
                            <span class="error text-danger">{{$errors->first('trial_location')}}</span>
                        @endif
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113874.30006216935!2d75.70815698269863!3d26.88533996496087!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396c4adf4c57e281%3A0xce1c63a0cf22e09!2sJaipur%2C%20Rajasthan!5e0!3m2!1sen!2sin!4v1745411421280!5m2!1sen!2sin"
                            width="100%" height="600px" style="border:0; border-radius: 14px;" allowfullscreen=""
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-----banner section-------->
        <hr class="horizontal dark mt-0 mt-5">
        <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap">
            <h6>Banners:</h6>
            <div class="form-check">
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
        <div class="form-check pt-2">
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
                'sub_category': "required",
                'property_types[]': { required: true },
                'stalls_available': "required",
                'stable_amenities[]': { required: true },
                'housing_stables_around_horse_shows[]': { required: true },
                'fromdate': "required",
                'todate': "required",
                'sleeps': "required",
                'housing_amenities[]': { required: true },
                'daily_board_rental_rate': "required",
                'monthly_board_rental_rate': "required",
                'weekly_board_rental_rate': "required",
                'sale_cost': "required",
                'realtor': "required",
                'property_manager': "required",                         
                'agree': "required",
                'banners': "required",
            },
            messages: {
                'sub_category': "Sub category is required.",
                'property_types[]': { required: "Please select at least one property type." },
                'stalls_available': "Please enter the number of stalls available.",
                'stable_amenities[]': { required: "Please select at least one stable amenity." },
                'housing_stables_around_horse_shows[]': { required: "Please select at least one housing option around horse shows." },
                'fromdate': "Please select the starting date.",
                'todate': "Please select the ending date.",
                'sleeps': "Please specify how many it sleeps.",
                'housing_amenities[]': { required: "Please select at least one housing amenity." },
                'daily_board_rental_rate': "Please enter the daily board rental rate.",
                'monthly_board_rental_rate': "Please enter the monthly board rental rate.",
                'weekly_board_rental_rate': "Please enter the weekly board rental rate.",
                'sale_cost': "Please enter the sale cost.",
                'realtor': "Please enter the realtor's name.",
                'property_manager': "Please enter the property manager's name.",
                'agree': "You must agree to the terms.",
                'banners': "Banner is required"
            },
            errorClass: 'error text-danger',
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