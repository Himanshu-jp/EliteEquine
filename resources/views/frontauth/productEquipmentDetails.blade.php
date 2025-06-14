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

            <div class="row">

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
                
                <div class="col-md-3 mt-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" id="price" class="inner-form form-control mb-0 numbervalid" placeholder="Enter sale price" value="{{old('price',@$products->productDetail->price)}}">
                    @if($errors->has('price'))
                        <span class="error text-danger">{{$errors->first('price')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3">
                    <label for="hourly_price" class="form-label">Hourly Rental Price</label>
                    <input type="text" name="hourly_price" id="hourly_price" class="inner-form form-control mb-0 numbervalid" placeholder="Enter lease price" value="{{old('hourly_price',@$products->productDetail->hourly_price)}}">
                    @if($errors->has('hourly_price'))
                        <span class="error text-danger">{{$errors->first('hourly_price')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3">
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