@extends('frontauth.layouts.main')
<style>
    /* body { margin: 0; padding: 0; } */
    .form-section .col-md-6 {
        position: relative;
    }

    .form-section .col-md-6 #map {
        position: absolute;
        top: 0;
        left: 0;
        width: 98%;
        border: 0;
        border-radius: 14px;
        height: 600px;
    }


    .custom-map-marker {
        background-image: url("{{ asset('images/location-user-mkr.svg') }}");
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

        #calendar strong {
            color: #a19061;
        }

        .border-top-custom {
            border-top: 4px solid #a19061;
            border-radius: 4px;
            padding-top: 4px;
        }

        .time-box-brder {
            border-right: 1px solid #cccccc73;
        }

        .btn-close-time {
            background: #a19061;
            width: 20px;
            height: 20px;
            text-align: center;
            padding: 0px;
            flex: 0 0 20px;
            color: #fff;
            margin-bottom: 0px;
        }

        .form-select-time {
            width: 100px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        #calendar .row.text-center {
            gap: 8px;
            flex-wrap: nowrap;
        }

        .row.box-time-slot-clnder {
            flex-wrap: nowrap;
        }

        .btn-black-box {
            background: #000;
            color: #fff;
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


        <form action="{{ route('productServiceDetails') }}" method="post" class="row" id="productDetailsForm"
            enctype="multipart/form-data">
            @csrf
            <!----horse product fields--------->

            <div class="row">
                <input type="hidden" name="productId" value="{{ $productId }}">
                <input type="hidden" name="productDetailId" value="{{ @$products->productDetail->id }}">

                @if (@$products->category_id)
                    <div class="col-md-3 mt-3 position-relative">
                        <label for="category" class="form-label">Category : &nbsp;&nbsp;<span
                                class="h5 font-weight-bolder">{{ @$products->category->name }}</span></label>
                    </div>
                @endif

                <div class="row align-items-baseline cusmt-form-mb">

                    <div class="col-md-3 mt-3 position-relative">
                        <label for="exampleFormControlInput1" class="form-label">Job Listing Types</label>
                        <select class="form-control select2" id="job_listing_type" name="job_listing_type[]"
                            multiple="multiple">
                            @foreach (__getJobListingTypeData() as $key => $value)
                                <option value="{{ $key }}"
                                    {{ in_array($key, old('job_listing_type', @$products->jobListingType->pluck('common_master_id')->toArray())) ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                        <i class="fi fi-rr-angle-small-down"
                            style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if ($errors->has('job_listing_type'))
                            <span class="error text-danger">{{ $errors->first('job_listing_type') }}</span>
                        @endif
                    </div>


                    <div class="col-md-3 mt-3 position-relative">
                        <label for="exampleFormControlInput1" class="form-label">Service</label>
                        <select class="form-control select2" id="service" name="service[]" multiple="multiple">
                            @foreach (__getServicesData() as $key => $value)
                                <option value="{{ $key }}"
                                    {{ in_array($key, old('service', @$products->service->pluck('common_master_id')->toArray())) ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                        <i class="fi fi-rr-angle-small-down"
                            style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if ($errors->has('service'))
                            <span class="error text-danger">{{ $errors->first('service') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3 mt-3 position-relative">
                        <label for="exampleFormControlInput1" class="form-label">Contract Types</label>
                        <select class="form-control select2" id="contract_types" name="contract_types[]"
                            multiple="multiple">
                            @foreach (__getContractTypesData() as $key => $value)
                                <option value="{{ $key }}"
                                    {{ in_array($key, old('contract_types', @$products->contractTypes->pluck('common_master_id')->toArray())) ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                        <i class="fi fi-rr-angle-small-down"
                            style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if ($errors->has('contract_types'))
                            <span class="error text-danger">{{ $errors->first('contract_types') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3 mt-3 position-relative">
                        <label for="exampleFormControlInput1" class="form-label">Assistance at Upcoming Show</label>
                        <select class="form-control select2" id="assistance_upcoming_shows"
                            name="assistance_upcoming_shows[]" multiple="multiple">
                            @foreach (__getAssistanceUpcomingShows() as $key => $value)
                                <option value="{{ $key }}"
                                    {{ in_array($key, old('assistance_upcoming_shows', @$products->assistanceUpcomingShows->pluck('common_master_id')->toArray())) ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                        <i class="fi fi-rr-angle-small-down"
                            style="position: absolute;
                                top: 63%;
                                right: 30px;
                                transform: translateY(-50%);
                                pointer-events: none;
                                color: #555;"></i>
                        @if ($errors->has('assistance_upcoming_shows'))
                            <span class="error text-danger">{{ $errors->first('assistance_upcoming_shows') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3 mt-3 position-relative">
                        <label for="fromdate" class="form-label">Date Available From</label>
                        <input type="date" class="inner-form form-control mb-0" name="fromdate" id="fromdate"
                            placeholder="abc" value="{{ old('fromdate', @$products->productDetail->fromdate) }}">
                        @if ($errors->has('fromdate'))
                            <span class="error text-danger">{{ $errors->first('fromdate') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3 mt-3 position-relative">
                        <label for="todate" class="form-label">Date Available To</label>
                        <input type="date" class="inner-form form-control mb-0" name="todate" id="todate"
                            placeholder="" value="{{ old('todate', @$products->productDetail->todate) }}">
                        @if ($errors->has('todate'))
                            <span class="error text-danger">{{ $errors->first('todate') }}</span>
                        @endif
                    </div>



                  <div class="col-md-3 mt-3 position-relative">
    <label for="haulings_location_from" class="form-label">Haulings: From Location</label>
    <input type="text" name="haulings_location_from" id="haulings_location_from"
        class="inner-form form-control mb-0 hauling-from-input" placeholder="Enter from location"
        value="{{ old('haulings_location_from', @$products->productDetail->haulings_location_from) }}">
    <ul class="autocomplete-list-from position-absolute bg-white border w-100 list-unstyled mt-1" style="display:none; max-height:150px; overflow:auto;"></ul>
    <span class="autocomplete-msg-from text-danger" style="display:none; font-size:12px;"></span>
    <input type="hidden" name="haulings_location_from_lat" class="lat-from">
    <input type="hidden" name="haulings_location_from_lng" class="lng-from">
    @if ($errors->has('haulings_location_from'))
        <span class="error text-danger">{{ $errors->first('haulings_location_from') }}</span>
    @endif
</div>

<div class="col-md-3 mt-3 position-relative">
    <label for="haulings_location_to" class="form-label">Haulings: To Location</label>
    <input type="text" name="haulings_location_to" id="haulings_location_to"
        class="inner-form form-control mb-0 hauling-to-input" placeholder="Enter to location"
        value="{{ old('haulings_location_to', @$products->productDetail->haulings_location_to) }}">
    <ul class="autocomplete-list-to position-absolute bg-white border w-100 list-unstyled mt-1" style="display:none; max-height:150px; overflow:auto;"></ul>
    <span class="autocomplete-msg-to text-danger" style="display:none; font-size:12px;"></span>
    <input type="hidden" name="haulings_location_to_lat" class="lat-to">
    <input type="hidden" name="haulings_location_to_lng" class="lng-to">
    @if ($errors->has('haulings_location_to'))
        <span class="error text-danger">{{ $errors->first('haulings_location_to') }}</span>
    @endif
</div>


                    <div class="col-md-3 mt-3 position-relative">
                        <label for="stalls_available_haulings" class="form-label">Stalls Available For Hauling or
                            Show</label>
                        <input type="text" name="stalls_available_haulings" id="stalls_available_haulings"
                            class="inner-form form-control mb-0 numbervalid" placeholder="Enter stalls count"
                            value="{{ old('stalls_available_haulings', @$products->productDetail->stalls_available_haulings) }}">
                        @if ($errors->has('stalls_available_haulings'))
                            <span class="error text-danger">{{ $errors->first('stalls_available_haulings') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3 mt-3 position-relative">
                        <label for="salary" class="form-label">Salary</label>
                        <input type="text" name="salary" id="salary"
                            class="inner-form form-control mb-0 numbervalid" placeholder="Enter salary"
                            value="{{ old('salary', @$products->productDetail->salary) }}">
                        @if ($errors->has('salary'))
                            <span class="error text-danger">{{ $errors->first('salary') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3 mt-3 position-relative">
                        <label for="hourly_price" class="form-label">Hourly Pay</label>
                        <input type="text" name="hourly_price" id="hourly_price"
                            class="inner-form form-control mb-0 numbervalid" placeholder="Enter hourly pay"
                            value="{{ old('hourly_price', @$products->productDetail->hourly_price) }}">
                        @if ($errors->has('hourly_price'))
                            <span class="error text-danger">{{ $errors->first('hourly_price') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3 mt-3 position-relative">
                        <label for="fixed_price" class="form-label">Fixed Pay</label>
                        <input type="text" name="fixed_price" id="fixed_price"
                            class="inner-form form-control mb-0 numbervalid" placeholder="Enter fixed pay"
                            value="{{ old('fixed_price', @$products->productDetail->fixed_price) }}">
                        @if ($errors->has('fixed_price'))
                            <span class="error text-danger">{{ $errors->first('fixed_price') }}</span>
                        @endif
                    </div>
                    <div class="col-md-3 mt-3 position-relative">
                        <label for="todate" class="form-label"></label>
                        <button type="button" class="btn d-flex btn-primary " id="timeSlot" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"><i class="fi fi-rr-calendar me-2 mt-1 "></i> Schedule Your Time
                            Slot</button>
                        <!-- Hidden input to store selected slots as JSON -->
                        <input type="hidden" id="time_slot" name="time_slot"
                            value="{{ @$products->productDetail->time_slot ?? '' }}">
                    </div>
                </div>
            </div>

            <!---locaiton & phone fields---------->
            <div class="pt-5">

                <!-- Checkbox to toggle phone fields -->
                @if (!@$products->productDetail->phone)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="contactSet" name="contactSet"
                            value="1" {{ old('contactSet') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="contactSet">
                            Use contact set in profile section
                        </label>
                    </div>
                @endif


                <!-- Checkbox to toggle address fields -->
                @if (!@$products->productDetail->country)
                    <div class="form-check mb-3 ">
                        <input class="form-check-input" type="checkbox" id="addressSet" name="addressSet"
                            value="1" {{ old('addressSet') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="addressSet">
                            Use address set in profile section
                        </label>
                    </div>
                @endif

            </div>

            <!-- phone fields (hidden/shown based on checkbox) -->
            <div class="col-md-3 mt-3 position-relative" id="contactFields" style="display: none;">
                <label for="phone" class="form-label">Phone number</label>
                <input type="text" class="inner-form form-control mb-0" placeholder="eg. +91 9856965852"
                    name="phone" id="phone" value="{{ old('phone', @$products->productDetail->phone) }}">
                @if ($errors->has('phone'))
                    <span class="error text-danger">{{ $errors->first('phone') }}</span>
                @endif
            </div>


            <!-- Address fields (hidden/shown based on checkbox) -->
            <div class="form-section" id="addressFields" style="display: none;">
                <div class="row">
                    <div class="col-md-6">

                        <div class="mb-4 position-relative">
                            <label class="form-label">Precise Location</label>
                            <input type="text" class="inner-form form-control" placeholder="Enter location.."
                                name="precise_location" onkeyup="initializeLocationAutocomplete()" id="precise_location"
                                value={{ old('precise_location', @$products->productDetail->precise_location) }}>
                            <span id="map-location-message" class="text-danger"
                                style="display: none; font-size: 12px;"></span>
                            <ul id="map-location-list" style="display: none;">
                                <!-- Location suggestions will appear here -->
                            </ul>
                            <input type="hidden" id="map-latitude" name="latitude"
                                value="{{ request()->query('latitude') }}">
                            <input type="hidden" id="map-longitude" name="longitude"
                                value="{{ request()->query('longitude') }}">
                            @if ($errors->has('precise_location'))
                                <span class="error text-danger">{{ $errors->first('precise_location') }}</span>
                            @endif
                        </div>
                        <div class="mb-4 position-relative">
                            <label class="form-label">Country</label>
                            <input type="text" class="inner-form form-control"
                                placeholder="Populate on Google place select.." name="country" id="country"
                                value={{ old('country', @$products->productDetail->country) }}>
                            @if ($errors->has('country'))
                                <span class="error text-danger">{{ $errors->first('country') }}</span>
                            @endif
                        </div>
                        <div class="mb-4 position-relative">
                            <label class="form-label">State</label>
                            <input type="text" class="inner-form form-control"
                                placeholder="Populate on Google place select.." name="state" id="state"
                                value={{ old('state', @$products->productDetail->state) }}>
                            @if ($errors->has('state'))
                                <span class="error text-danger">{{ $errors->first('state') }}</span>
                            @endif
                        </div>
                        <div class="mb-4 position-relative">
                            <label class="form-label">City</label>
                            <input type="text" class="inner-form form-control"
                                placeholder="Populate on Google place select.." name="city" id="city"
                                value={{ old('city', @$products->productDetail->city) }}>
                            @if ($errors->has('city'))
                                <span class="error text-danger">{{ $errors->first('city') }}</span>
                            @endif
                        </div>
                        <div class="mb-4 position-relative">
                            <label class="form-label">Street </label>
                            <input type="text" class="inner-form form-control"
                                placeholder="Populate on Google place select.." name="street" id="street"
                                value={{ old('street', @$products->productDetail->street) }}>
                            @if ($errors->has('street'))
                                <span class="error text-danger">{{ $errors->first('street') }}</span>
                            @endif
                        </div>



                        <div class="mb-4 position-relative">
                            <label class="form-label">Trial / Exchange Location</label>
                            <input type="text" class="inner-form form-control"
                                placeholder="Enter trial / exchange location ..." name="trial_location"
                                onkeyup="SecondAutocomplete()" id="secondprecise_location"
                                value={{ old('trial_location', @$products->productDetail->trial_location) }}>
                            <span id="secondmap-location-message" class="text-danger"
                                style="display: none; font-size: 12px;"></span>
                            <ul id="secondmap-location-list" style="display: none;">
                                <!-- Location suggestions will appear here -->
                            </ul>
                            <input type="hidden" id="secondmap-latitude" name="trail_latitude"
                                value="{{ old('trail_latitude', @$products->productDetail->trail_latitude) }}">
                            <input type="hidden" id="secondmap-longitude" name="trail_longitude"
                                value="{{ old('trail_longitude', @$products->productDetail->trail_longitude) }}">
                            @if ($errors->has('trial_location'))
                                <span class="error text-danger">{{ $errors->first('trial_location') }}</span>
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
                    <input class="form-check-input" type="radio" name="banners" id="Around" value="Around"
                        {{ old('banners') == 'Around' || @$products->productDetail->banner == 'Around' ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold text-dark" for="Around">Around</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="banners" id="Hiring" value="Hiring"
                        {{ old('banners') == 'Hiring' || @$products->productDetail->banner == 'Hiring' ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold text-dark" for="Hiring">Hiring</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="banners" id="Seeking Employment"
                        value="Seeking Employment"
                        {{ old('banners') == 'Seeking Employment' || @$products->productDetail->banner == 'Seeking Employment' ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold text-dark" for="Seeking Employment">Seeking Employment</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="banners" id="Negotiable" value="Negotiable"
                        {{ old('banners') == 'Negotiable' || @$products->productDetail->banner == 'Negotiable' ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold text-dark" for="Negotiable">Negotiable</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="banners" id="Price_Reduced"
                        value="Price Reduced"
                        {{ old('banners') == 'Price Reduced' || @$products->productDetail->banner == 'Price Reduced' ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold text-dark" for="Price_Reduced">Price Reduced</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="banners" id="Motivated_Seller"
                        value="Motivated Seller"
                        {{ old('banners') == 'Motivated Seller' || @$products->productDetail->banner == 'Motivated Seller' ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold text-dark" for="Motivated_Seller">Motivated Seller</label>
                </div>
                @if ($errors->has('banners'))
                    <span class="error text-danger">{{ $errors->first('banners') }}</span>
                @endif
            </div>

            <!-----terms & conditions section-------->
            <div class="form-check pt-2 mt-3">
                <input class="form-check-input" type="checkbox" name="agree" id="agree" value="1"
                    {{ old('agree') == 1 || @$products->productDetail->agree == 1 ? 'checked' : '' }}>
                <label class="form-check-label fw-bold text-dark" for="agree">I agree to <a
                        href="{{ route('cms.terms.condition') }}" target="_blank" style="color: #A19061;">Terms Of
                        Use</a></label>

                @if ($errors->has('agree'))
                    <span class="error text-danger">{{ $errors->first('agree') }}</span>
                @endif
            </div>

            <div class="text-start my-4">
                <button type="button" class="btn btn-primary" id="back"
                    onclick="window.location.href='{{ route('editProduct', $productId) }}'">Back</button>
                <button type="submit" class="btn btn-primary" id="productDetails-form-submit">Submit Ad</button>
            </div>

        </form>
    </div>

    <!-- time slot model -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                        <h3>Book Service</h3>
                        <button class="btn bg-light rounded-pill px-4 mt-2 mt-md-0" data-bs-dismiss="modal"
                            aria-label="Close">X</button>
                    </div>

                    <div class="header-popup mb-3">
                        <div>
                            <label class="form-label">Select Time Slot</label><br>
                            <select id="monthSelect" class="form-select custom-dropdown w-auto d-inline-block">
                                <!-- Populated by JS -->
                            </select>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button id="prevWeek" class="custom-dropdown bg-white px-3"><img
                                    src="{{ asset('front/home/assets/images/icons/arrow-left.svg') }}" alt=""
                                    width="24" /></button>
                            <div id="dateRange" class="custom-dropdown date-range">9 Feb - 15 Feb</div>
                            <button id="nextWeek" class="custom-dropdown bg-white px-3"><img
                                    src="{{ asset('front/home/assets/images/icons/arrow-right.svg') }}" alt=""
                                    width="24" /></button>
                        </div>
                    </div>
                    <div id="calendar" class="row gx-1 text-center" style="overflow: scroll; height:300px;">
                        <!-- Week header and time slots will be populated here -->
                    </div>

                    <div class="text-end mt-4">
                        <button class="apply-flitter btn btn-sm btn-primary mt-2" id="continue_btn">Set</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let fromdateStr = document.getElementById('fromdate').value;
            let todateStr = document.getElementById('todate').value;

            // Load previously saved slots if exist
            let selectedSlots = {};
            const hiddenInput = document.getElementById('time_slot');
            if (hiddenInput && hiddenInput.value) {
                try {
                    selectedSlots = JSON.parse(hiddenInput.value);
                } catch (e) {
                    console.error('Invalid JSON in time_slot input', e);
                    selectedSlots = {};
                }
            }

            document.getElementById('fromdate').addEventListener('change', function() {
                fromdateStr = this.value;
                resetCalendar();
            });

            document.getElementById('todate').addEventListener('change', function() {
                todateStr = this.value;
                resetCalendar();
            });

            const calendar = document.getElementById('calendar');
            const dateRange = document.getElementById('dateRange');
            const monthSelect = document.getElementById('monthSelect');
            const prevWeek = document.getElementById('prevWeek');
            const nextWeek = document.getElementById('nextWeek');

            const slots = generateTimeSlots("00:00", "23:00", 30); // 30-minute intervals
            let currentDate = null;

            function generateTimeSlots(start, end, interval) {
                const result = [];
                let [startHour, startMin] = start.split(':').map(Number);
                let [endHour, endMin] = end.split(':').map(Number);
                let startTime = new Date(0, 0, 0, startHour, startMin);
                const endTime = new Date(0, 0, 0, endHour, endMin);

                while (startTime <= endTime) {
                    let label = startTime.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    });
                    result.push(label);
                    startTime.setMinutes(startTime.getMinutes() + interval);
                }
                return result;
            }

            function resetCalendar() {
                if (!fromdateStr || !todateStr) {
                    calendar.innerHTML = '<div class="text-muted">Please select both From Date and To Date.</div>';
                    monthSelect.innerHTML = '';
                    dateRange.textContent = '';
                    currentDate = null;
                    return;
                }
                const fromdate = new Date(fromdateStr);
                const todate = new Date(todateStr);
                if (isNaN(fromdate) || isNaN(todate) || fromdate > todate) {
                    calendar.innerHTML = '<div class="text-danger">Invalid date range.</div>';
                    monthSelect.innerHTML = '';
                    dateRange.textContent = '';
                    currentDate = null;
                    return;
                }
                currentDate = new Date(fromdate);
                updateMonthOptions(fromdate, todate);
                renderCalendar(currentDate, fromdate, todate);
            }

            function updateMonthOptions(fromdate, todate) {
                monthSelect.innerHTML = '';
                const startMonth = fromdate.getMonth();
                const endMonth = todate.getMonth();
                const startYear = fromdate.getFullYear();
                const endYear = todate.getFullYear();

                for (let year = startYear; year <= endYear; year++) {
                    const mStart = (year === startYear) ? startMonth : 0;
                    const mEnd = (year === endYear) ? endMonth : 11;
                    for (let m = mStart; m <= mEnd; m++) {
                        const option = document.createElement('option');
                        option.value = `${year}-${m}`;
                        option.textContent = new Date(year, m).toLocaleString('default', {
                            month: 'long',
                            year: 'numeric'
                        });
                        monthSelect.appendChild(option);
                    }
                }

                // Set current month select to currentDate
                monthSelect.value = `${currentDate.getFullYear()}-${currentDate.getMonth()}`;
            }

            function isWithinRange(date, fromdate, todate) {
                return date >= fromdate && date <= todate;
            }

            function getWeekDates(date, fromdate, todate) {
                const start = new Date(date);
                start.setDate(date.getDate() - date.getDay()); // Sunday
                return Array.from({
                    length: 7
                }, (_, i) => {
                    const d = new Date(start);
                    d.setDate(start.getDate() + i);
                    return isWithinRange(d, fromdate, todate) ? d : null;
                });
            }

            function renderCalendar(date, fromdate, todate) {
                currentDate = new Date(date);
                calendar.innerHTML = '';

                const week = getWeekDates(currentDate, fromdate, todate);
                if (!week.some(Boolean)) {
                    calendar.innerHTML = '<div class="text-muted">No valid dates in this week.</div>';
                    dateRange.textContent = '';
                    prevWeek.disabled = true;
                    nextWeek.disabled = true;
                    return;
                }

                prevWeek.disabled = week[0] && week[0] <= fromdate;
                nextWeek.disabled = week[6] && week[6] >= todate;

                // Render header
                const headerRow = document.createElement('div');
                headerRow.classList.add('row', 'text-center', 'mb-2');
                week.forEach(d => {
                    const col = document.createElement('div');
                    col.className = 'col day-header';
                    if (d) {
                        col.innerHTML =
                            `${d.toLocaleDateString('en-GB', { weekday: 'short' })}<br><strong>${d.getDate()}</strong>`;
                    } else {
                        col.classList.add('text-muted');
                        col.style.opacity = 0.4;
                        col.textContent = 'N/A';
                    }
                    headerRow.appendChild(col);
                });
                calendar.appendChild(headerRow);

                // Render slots
                const slotRow = document.createElement('div');
                slotRow.className = 'row box-time-slot-clnder';

                week.forEach(day => {
                    const col = document.createElement('div');
                    col.className = 'col time-box-brder p-2';

                    if (day) {
                        const dayKey = day.toISOString().split('T')[0];
                        const container = document.createElement('div');
                        container.className = 'slot-container';
                        container.dataset.day = dayKey;

                        if (selectedSlots[dayKey]) {
                            selectedSlots[dayKey].forEach(([from, to]) => addSlotRow(container, dayKey,
                                from, to));
                        }

                        const addBtn = document.createElement('button');
                        addBtn.textContent = 'Add Slot';
                        addBtn.className = 'btn btn-sm btn-black-box mb-2';
                        addBtn.onclick = () => {
                            addSlotRow(container, dayKey);
                            saveSelectedSlots(dayKey, container);
                        };

                        col.appendChild(container);
                        col.appendChild(addBtn);
                    } else {
                        col.innerHTML = '<div class="text-muted text-center">Out of Range</div>';
                    }

                    slotRow.appendChild(col);
                });
                calendar.appendChild(slotRow);

                // Update dateRange text
                const validDates = week.filter(Boolean);
                const start = validDates[0].toLocaleDateString('en-GB', {
                    day: 'numeric',
                    month: 'short'
                });
                const end = validDates[validDates.length - 1].toLocaleDateString('en-GB', {
                    day: 'numeric',
                    month: 'short'
                });
                dateRange.textContent = `${start} - ${end}`;
            }

            function addSlotRow(container, dayKey, fromVal = '', toVal = '') {
                const row = document.createElement('div');
                row.className = 'd-flex align-items-center gap-2 mb-2 time-box-main';

                const fromSelect = createTimeSelect('from', fromVal);
                const toSelect = createTimeSelect('to', toVal);

                const removeBtn = document.createElement('button');
                removeBtn.textContent = '×';
                removeBtn.className = 'btn btn-close-time';
                removeBtn.onclick = () => {
                    row.remove();
                    saveSelectedSlots(dayKey, container);
                };

                fromSelect.addEventListener('change', () => {
                    validateSlot(fromSelect, toSelect);
                    saveSelectedSlots(dayKey, container);
                });

                toSelect.addEventListener('change', () => {
                    validateSlot(fromSelect, toSelect);
                    saveSelectedSlots(dayKey, container);
                });

                row.appendChild(fromSelect);
                row.appendChild(toSelect);
                row.appendChild(removeBtn);
                container.appendChild(row);
            }

            function createTimeSelect(type, selectedVal = '') {
                const select = document.createElement('select');
                select.className = 'form-select form-select-sm form-select-time';
                select.innerHTML = `<option value="">${type === 'from' ? 'From Time' : 'To Time'}</option>`;
                slots.forEach(slot => {
                    const option = document.createElement('option');
                    option.value = slot;
                    option.textContent = slot;
                    if (slot === selectedVal) option.selected = true;
                    select.appendChild(option);
                });
                return select;
            }

            function saveSelectedSlots(dayKey, container) {
                const rows = container.querySelectorAll('.d-flex');
                selectedSlots[dayKey] = [];
                rows.forEach(row => {
                    const selects = row.querySelectorAll('select');
                    const from = selects[0].value;
                    const to = selects[1].value;
                    if (from && to) {
                        selectedSlots[dayKey].push([from, to]);
                    }
                });
            }

            function validateSlot(fromSelect, toSelect) {
                const fromIndex = slots.indexOf(fromSelect.value);
                const toIndex = slots.indexOf(toSelect.value);
                if (fromSelect.value && toSelect.value && fromIndex >= toIndex) {
                    alert('"To Time" must be after "From Time"');
                    toSelect.value = '';
                }
            }

            prevWeek.onclick = () => {
                if (!currentDate || !fromdateStr || !todateStr) return;
                const fromdate = new Date(fromdateStr);
                const todate = new Date(todateStr);

                const newDate = new Date(currentDate);
                newDate.setDate(currentDate.getDate() - 7);
                if (newDate >= fromdate) {
                    currentDate = newDate;
                    renderCalendar(currentDate, fromdate, todate);
                    monthSelect.value = `${currentDate.getFullYear()}-${currentDate.getMonth()}`;
                }
            };

            nextWeek.onclick = () => {
                if (!currentDate || !fromdateStr || !todateStr) return;
                const fromdate = new Date(fromdateStr);
                const todate = new Date(todateStr);

                const newDate = new Date(currentDate);
                newDate.setDate(currentDate.getDate() + 7);
                if (newDate <= todate) {
                    currentDate = newDate;
                    renderCalendar(currentDate, fromdate, todate);
                    monthSelect.value = `${currentDate.getFullYear()}-${currentDate.getMonth()}`;
                }
            };

            monthSelect.onchange = () => {
                if (!fromdateStr || !todateStr) return;
                const [year, month] = monthSelect.value.split('-').map(Number);
                currentDate = new Date(year, month, 1);
                renderCalendar(currentDate, new Date(fromdateStr), new Date(todateStr));
            };

            // Set button click - save all selected slots JSON into hidden input
            document.getElementById('continue_btn').addEventListener('click', function() {
                const hiddenInput = document.getElementById('time_slot');
                const filteredSlots = {};
                for (const day in selectedSlots) {
                    if (selectedSlots[day] && selectedSlots[day].length > 0) {
                        filteredSlots[day] = selectedSlots[day];
                    }
                }
                hiddenInput.value = JSON.stringify(filteredSlots);
                console.log('Selected Slots JSON:', hiddenInput.value);

                // Optional: close modal or submit form here
                $('#exampleModal').modal('hide');
            });

            // Initialize calendar if dates are already set
            resetCalendar();
        });
    </script>


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
                `${MAP_PUBLIC}/images/Services Jobs Red.png` :
                `${MAP_PUBLIC}/images/Services Jobs Blue.png`;

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
   
   
   

    function setupSimpleMapboxAutocomplete(options) {
        const {
            inputSelector,
            latitudeSelector,
            longitudeSelector,
            resultListSelector,
            messageSelector
        } = options;

        const $input = $(inputSelector);
        const $latitude = $(latitudeSelector);
        const $longitude = $(longitudeSelector);
        const $list = $(resultListSelector);
        const $message = $(messageSelector);

        const sessionToken = Math.random().toString(36).substring(2, 15);
        const cache = {};
        let selectedIndex = -1;
        let suggestions = [];
        let debounceTimer;

        function clearSuggestions() {
            $list.empty().hide();
            $message.hide();
            selectedIndex = -1;
            suggestions = [];
        }

        function highlightSuggestion(index) {
            $list.children('li').removeClass('highlighted')
                .eq(index).addClass('highlighted')[0]?.scrollIntoView({ block: 'nearest' });
        }

        function selectSuggestion(index) {
            if (index < 0 || index >= suggestions.length) return;
            const suggestion = suggestions[index];
            const address = suggestion.name || '';

            $input.val(address);
            clearSuggestions();

            const mapbox_id = suggestion.mapbox_id;
            fetch(`https://api.mapbox.com/search/searchbox/v1/retrieve/${mapbox_id}?session_token=${sessionToken}&access_token=${mapboxAccessToken}`)
                .then(response => response.json())
                .then(data => {
                    const feature = data.features?.[0];
                    if (!feature) return;

                    const coords = feature.geometry.coordinates;
                    if (coords) {
                        $latitude.val(coords[1]); // latitude
                        $longitude.val(coords[0]); // longitude
                    }
                })
                .catch(err => console.error('Mapbox fetch error:', err));
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
                    console.error('Fetch error:', error);
                    $message.text('Failed to fetch suggestions').show();
                    $list.hide();
                });
        }

        function renderSuggestions(data) {
            $list.empty();
            suggestions = data.suggestions || [];

            if (suggestions.length > 0) {
                suggestions.forEach((sugg, i) => {
                    const address = sugg.name || '';
                    const $li = $('<li>').text(address).attr('data-index', i).on('click', () => selectSuggestion(i));
                    $list.append($li);
                });
                $list.show();
                $message.hide();
                selectedIndex = -1;
            } else {
                $message.text('No results found').show();
                $list.hide();
            }
        }

        $input.on('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                const query = $input.val().trim();
                if (query.length > 2) {
                    fetchSuggestions(query);
                } else {
                    clearSuggestions();
                }
            }, 500);
        });

        $input.on('keydown', function (e) {
            const items = $list.children('li');
            if ($list.is(':visible') && items.length > 0) {
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

        $(document).on('click', function (e) {
            if (!$(e.target).closest($input).length && !$(e.target).closest($list).length) {
                clearSuggestions();
            }
        });
    }
</script>

    <script>
        $(document).ready(function() {
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
                    if (`{{ !@$products->productDetail->country }}`) {
                        $("#addressFields").find("input").val('');
                    }
                }
            }

            // Run on page load
            toggleAddressFields();

            // Toggle on checkbox change
            $('#addressSet').change(function() {
                toggleAddressFields();
            });
        });

        $(document).ready(function() {
            function toggleContactFields() {
                if ($('#contactSet').is(':checked')) {
                    $('#contactFields').hide();
                    $("#contactFields").find("input").val('');
                } else {
                    $('#contactFields').show();
                    if (`{{ !@$products->productDetail->phone }}`) {
                        $("#contactFields").find("input").val('');
                    }
                }
            }

            // Run on page load
            toggleContactFields();

            // Toggle on checkbox change
            $('#contactSet').change(function() {
                toggleContactFields();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.validator.setDefaults({
                ignore: []
            }); // allow hidden fields like checkboxes

            $('#productDetailsForm').validate({
                rules: {
                    'job_listing_type[]': {
                        required: true
                    },
                    'service[]': {
                        required: true
                    },
                    'contract_types[]': {
                        required: true
                    },
                    'assistance_upcoming_shows[]': {
                        required: true
                    },
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
                    'time_slot': "required",
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
                    'banners': "Banner is required.",
                    'time_slot': "Time slot is required.",
                },
                errorClass: 'error text-danger custom-error',
                errorElement: 'span',

                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    $('#productDetails-form-submit').prop('disabled', true).text('Please wait...');
                    form.submit();
                }
            });

            $('select[multiple]').on('change', function() {
                $(this).valid();
            });

            // Custom regex validator for age
            $.validator.addMethod("regex", function(value, element, regex) {
                return this.optional(element) || regex.test(value);
            });

            // Conditional rules
            function toggleConditionalRules() {
                const addressSet = $('#addressSet').is(':checked');
                const contactSet = $('#contactSet').is(':checked');

                if (!addressSet) {
                    $('#precise_location, #country, #state, #city').each(function() {
                        $(this).rules('add', {
                            required: true,
                            maxlength: 300
                        });
                    });
                } else {
                    $('#precise_location, #country, #state, #city').each(function() {
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


            $.validator.addMethod("filesize", function(value, element, param) {
                if (element.files.length === 0) return true;
                return element.files[0].size <= param;
            }, "File size must be less than {0} bytes.");

        });
    </script>
    <script>
    $(document).ready(function () {
        setupSimpleMapboxAutocomplete({
            inputSelector: '.hauling-from-input',
            latitudeSelector: '.lat-from',
            longitudeSelector: '.lng-from',
            resultListSelector: '.autocomplete-list-from',
            messageSelector: '.autocomplete-msg-from'
        });

        setupSimpleMapboxAutocomplete({
            inputSelector: '.hauling-to-input',
            latitudeSelector: '.lat-to',
            longitudeSelector: '.lng-to',
            resultListSelector: '.autocomplete-list-to',
            messageSelector: '.autocomplete-msg-to'
        });
    });
</script>


     <script>
        document.addEventListener("DOMContentLoaded", function () {
            const fromDateInput = document.getElementById('fromdate');
            const toDateInput = document.getElementById('todate');

            // When 'fromdate' changes, update 'todate' min attribute
            fromDateInput.addEventListener('change', function () {
                const fromDate = this.value;
                toDateInput.min = fromDate;

                // Optional: reset todate if it's earlier than new fromdate
                if (toDateInput.value < fromDate) {
                    toDateInput.value = fromDate;
                }
            });

            // Trigger once on load to handle pre-filled values
            if (fromDateInput.value) {
                toDateInput.min = fromDateInput.value;
            }
        });
    </script>

@endsection
