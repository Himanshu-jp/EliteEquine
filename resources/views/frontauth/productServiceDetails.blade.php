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


    <form action="{{ route('productServiceDetails') }}" method="post" class="row" id="productDetailsForm" enctype="multipart/form-data">
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
                    <label for="exampleFormControlInput1" class="form-label">Job Listing Types</label>
                    <select class="form-control select2" id="job_listing_type" name="job_listing_type[]" multiple="multiple">
                        @foreach(__getJobListingTypeData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('job_listing_type', @$products->jobListingType->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('job_listing_type'))
                        <span class="error text-danger">{{$errors->first('job_listing_type')}}</span>
                    @endif
                </div>
                
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Service</label>
                    <select class="form-control select2" id="service" name="service[]" multiple="multiple">
                        @foreach(__getServicesData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('service', @$products->service->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('service'))
                        <span class="error text-danger">{{$errors->first('service')}}</span>
                    @endif
                </div>
               
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Contract Types</label>
                    <select class="form-control select2" id="contract_types" name="contract_types[]" multiple="multiple">
                        @foreach(__getContractTypesData() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('contract_types', @$products->contractTypes->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('contract_types'))
                        <span class="error text-danger">{{$errors->first('contract_types')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3 position-relative">
                    <label for="exampleFormControlInput1" class="form-label">Assistance at Upcoming Show</label>
                    <select class="form-control select2" id="assistance_upcoming_shows" name="assistance_upcoming_shows[]" multiple="multiple">
                        @foreach(__getAssistanceUpcomingShows() as $key=>$value)
                            <option value="{{$key}}" {{in_array($key,old('assistance_upcoming_shows', @$products->assistanceUpcomingShows->pluck('common_master_id')->toArray()))?'selected':''}} >{{$value}}</option>
                        @endforeach
                    </select>
                    <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if($errors->has('assistance_upcoming_shows'))
                        <span class="error text-danger">{{$errors->first('assistance_upcoming_shows')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3">
                    <label for="fromdate" class="form-label">Date Available From</label>
                    <input type="date" class="inner-form form-control mb-0" name="fromdate" id="fromdate" placeholder="abc" value="{{old('fromdate',@$products->productDetail->fromdate)}}">
                        @if($errors->has('fromdate'))
                        <span class="error text-danger">{{$errors->first('fromdate')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3">
                    <label for="todate" class="form-label">Date Available To</label>
                    <input type="date" class="inner-form form-control mb-0" name="todate" id="todate" placeholder="" value="{{old('todate',@$products->productDetail->todate)}}" >
                        @if($errors->has('todate'))
                        <span class="error text-danger">{{$errors->first('todate')}}</span>
                    @endif
                </div>                
                
                <div class="col-md-3 mt-3">
                    <label for="haulings_location_from" class="form-label">Haulings: From Location</label>
                    <input type="text" name="haulings_location_from" id="haulings_location_from" class="inner-form form-control mb-0" placeholder="Enter from location" value="{{old('haulings_location_from',@$products->productDetail->haulings_location_from)}}">
                    @if($errors->has('haulings_location_from'))
                    <span class="error text-danger">{{$errors->first('haulings_location_from')}}</span>
                    @endif
                </div>
               
                <div class="col-md-3 mt-3">
                    <label for="haulings_location_to" class="form-label">Haulings: To Location</label>
                    <input type="text" name="haulings_location_to" id="haulings_location_to" class="inner-form form-control mb-0" placeholder="Enter from location" value="{{old('haulings_location_to',@$products->productDetail->haulings_location_to)}}">
                    @if($errors->has('haulings_location_to'))
                    <span class="error text-danger">{{$errors->first('haulings_location_to')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3">
                    <label for="stalls_available_haulings" class="form-label">Stalls Available For Hauling or Show</label>
                    <input type="text" name="stalls_available_haulings" id="stalls_available_haulings" class="inner-form form-control mb-0 numbervalid" placeholder="Enter stalls count" value="{{old('stalls_available_haulings',@$products->productDetail->stalls_available_haulings)}}">
                    @if($errors->has('stalls_available_haulings'))
                        <span class="error text-danger">{{$errors->first('stalls_available_haulings')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3">
                    <label for="salary" class="form-label">Salary</label>
                    <input type="text" name="salary" id="salary" class="inner-form form-control mb-0 numbervalid" placeholder="Enter salary" value="{{old('salary',@$products->productDetail->salary)}}">
                    @if($errors->has('salary'))
                        <span class="error text-danger">{{$errors->first('salary')}}</span>
                    @endif
                </div>

                <div class="col-md-3 mt-3">
                    <label for="hourly_price" class="form-label">Hourly Pay</label>
                    <input type="text" name="hourly_price" id="hourly_price" class="inner-form form-control mb-0 numbervalid" placeholder="Enter hourly pay" value="{{old('hourly_price',@$products->productDetail->hourly_price)}}">
                    @if($errors->has('hourly_price'))
                        <span class="error text-danger">{{$errors->first('hourly_price')}}</span>
                    @endif
                </div>
                
                <div class="col-md-3 mt-3">
                    <label for="fixed_price" class="form-label">Fixed Pay</label>
                    <input type="text" name="fixed_price" id="fixed_price" class="inner-form form-control mb-0 numbervalid" placeholder="Enter fixed pay" value="{{old('fixed_price',@$products->productDetail->fixed_price)}}">
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

                     <div class="mt-2 position-relative">
                        <label class="form-label">Trial / Exchange Location</label>
                        <input type="text" class="inner-form form-control" placeholder="Enter trial / exchange location ..." name="trial_location" id="trial_location" value={{old('trial_location',@$products->productDetail->trial_location)}}>
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
        // Calculate date today days from today
        function fromdate() {
            let today = new Date();
            today.setDate(today.getDate());

            // Format date as yyyy-mm-dd
            let yyyy = today.getFullYear();
            let mm = String(today.getMonth() + 1).padStart(2, '0');
            let dd = String(today.getDate()).padStart(2, '0');
            let minDate = `${yyyy}-${mm}-${dd}`;

            // Set min attribute for fromdate
            $('#fromdate').attr('min', minDate);
            $('#fromdate-error').show().text('Please Enter valid date.');
        }
        fromdate();

        // Calculate date 1 days from today
        function todate() {
            let today = new Date();
            today.setDate(today.getDate() + 1);

            // Format date as yyyy-mm-dd
            let yyyy = today.getFullYear();
            let mm = String(today.getMonth() + 1).padStart(2, '0');
            let dd = String(today.getDate()).padStart(2, '0');
            let minDate = `${yyyy}-${mm}-${dd}`;

            // Set min attribute for todate
            $('#todate').attr('min', minDate);
            $('#todate-error').attr('min', minDate);
        }

        todate();
        
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
                'job_listing_type[]': { required: true },
                'service[]': { required: true },
                'contract_types[]': { required: true },
                'assistance_upcoming_shows[]': { required: true },                                    
                'fromdate': "required",
                'todate': "required",
                'haulings_location_from': "required",
                'haulings_location_to': "required",
                'stalls_available_haulings': "required",
                'salary': "required",
                'hourly_price': "required",
                'fixed_price': "required",
                'agree': "required",
                'banners': "required",
            },
            messages: {
                'job_listing_type[]': "Please select at least one job listing type.",
                'service[]': "Please select at least one service.",
                'contract_types[]': "Please select at least one contract type.",
                'assistance_upcoming_shows[]': "Please select at least one upcoming show.",
                'fromdate': "Please enter a valid 'Available From' date.",
                'todate': "Please enter a valid 'Available To' date.",
                'haulings_location_from': "Please enter the pickup location.",
                'haulings_location_to': "Please enter the drop-off location.",
                'stalls_available_haulings': "Please specify the number of stalls available.",
                'salary': "Please enter a salary amount.",
                'hourly_price': "Please enter the hourly price.",
                'fixed_price': "Please enter the fixed price.",
                'agree': "You must agree to the terms.",
                'banners': "Banner is required."
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