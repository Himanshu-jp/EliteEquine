@extends('frontauth.layouts.main')
<style>
        body { margin: 0; padding: 0; }
        .form-section .col-md-6 { position: relative; }
        .form-section .col-md-6 #map { position: absolute; top: 0; left: 0; width: 98%; border:0; border-radius: 14px; height:600px; }
    </style>
@section('title')
User Details
@endsection
@section('content')

<div class="container-fluid mt-4">
    <div class="ms-0 mt-4  d-flex align-items-center justify-content-between flex-wrap">
        <h3 class="h5 font-weight-bolder">Settings</h3>
        <div class="d-flex align-items-center gap-3 ">
            <a href="{{route('change-password')}}" class="btn btn-primary">Change Password</a>
        </div>
    </div>

    <form action="{{ route('settingUpdate') }}" method="post" class="row" id="settingForm">
        @csrf

        <div class="row">
            <h6>Account Details</h6>

            <div class="col-md-4 mt-3">
                <label for="exampleFormControlInput1" class="form-label">First name</label>
                <input type="text" class="inner-form form-control mb-0" placeholder="Enter first name" name="first_name" id="first_name" value="{{old('first_name',@$userDetails->first_name)}}">
                @if($errors->has('first_name'))
                    <span class="error text-danger">{{$errors->first('first_name')}}</span>
                @endif
            </div>
            <div class="col-md-4 mt-3">
                <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                <input type="text" class="inner-form form-control mb-0" placeholder="Enter last name" name="last_name" id="last_name" value="{{old('last_name',@$userDetails->last_name)}}">
                @if($errors->has('last_name'))
                    <span class="error text-danger">{{$errors->first('last_name')}}</span>
                @endif
            </div>
            <div class="col-md-4 mt-3">
                <label for="exampleFormControlInput1" class="form-label">Email</label>
                <input type="email" class="inner-form form-control mb-0" placeholder="Enter email address" name="email" id="email" value="{{old('email',@$userDetails->email)}}">
                @if($errors->has('email'))
                    <span class="error text-danger">{{$errors->first('email')}}</span>
                @endif
            </div>
            <div class="col-md-4 mt-3">
                <div class="d-flex align-items-center justify-content-between">
                    <label for="exampleFormControlInput1" class="form-label">Phone number</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="is_hide_phone" name="is_hide_phone" {{(old('is_hide_phone')==1||@$userDetails->is_hide_phone==1)?'checked':''}}>
                        <label class="form-check-label" for="is_hide_phone">Hide Phone?</label>
                    </div>
                </div>

                <input type="text" class="inner-form form-control mb-0" placeholder="eg. +91 9856965852" name="phone" id="phone" value="{{old('phone',@$userDetails->phone)}}">

                @if($errors->has('phone'))
                    <span class="error text-danger">{{$errors->first('phone')}}</span>
                @endif
            </div>

            <div class="col-md-4 mt-3">
                <label for="exampleFormControlInput1" class="form-label">Facebook</label>
                <input type="text" class="inner-form form-control mb-0" placeholder="https://www.facebook.com/..." name="facebook" id="facebook" value="{{old('facebook',@$userDetails->facebook)}}">
                @if($errors->has('facebook'))
                    <span class="error text-danger">{{$errors->first('facebook')}}</span>
                @endif
            </div>
            <div class="col-md-4 mt-3">
                <label for="exampleFormControlInput1" class="form-label">Twitter</label>
                <input type="text" class="inner-form form-control mb-0" placeholder="https://www.twitter.com/..." name="twitter" id="twitter" value="{{old('twitter',@$userDetails->twitter)}}">
                @if($errors->has('twitter'))
                    <span class="error text-danger">{{$errors->first('twitter')}}</span>
                @endif
            </div>
            <div class="col-md-4 mt-3">
                <label for="exampleFormControlInput1" class="form-label">YouTube</label>
                <input type="text" class="inner-form form-control mb-0" placeholder="https://www.YouTube.com/..." name="youtube" id="youtube" value="{{old('youtube',@$userDetails->youtube)}}">
                @if($errors->has('youtube'))
                    <span class="error text-danger">{{$errors->first('youtube')}}</span>
                @endif
            </div>
            <div class="col-md-4 mt-3">
                <label for="exampleFormControlInput1" class="form-label">Linkedin</label>
                <input type="text" class="inner-form form-control mb-0" placeholder="https://www.Linkedin.com/..." name="linkedin" id="linkedin" value="{{old('linkedin',@$userDetails->linkedin)}}">
                @if($errors->has('linkedin'))
                    <span class="error text-danger">{{$errors->first('linkedin')}}</span>
                @endif
            </div>
            <div class="col-md-4 mt-3">
                <label for="exampleFormControlInput1" class="form-label">Instagram</label>
                <input type="text" class="inner-form form-control mb-0" placeholder="https://www.Instagram.com/..." name="instagram" id="instagram" value="{{old('instagram',@$userDetails->instagram)}}">
                @if($errors->has('instagram'))
                    <span class="error text-danger">{{$errors->first('instagram')}}</span>
                @endif
            </div>
            <div class="col-md-4 mt-3">
                <label for="exampleFormControlInput1" class="form-label">Website</label>
                <input type="text" class="inner-form form-control mb-0" placeholder="Link to your site" name="website" id="website" value="{{old('website',@$userDetails->website)}}">
                @if($errors->has('website'))
                    <span class="error text-danger">{{$errors->first('website')}}</span>
                @endif
            </div>

        </div>

        <div class="mt-3">
            <label for="exampleFormControlInput1" class="form-label">Description </label>
            <textarea class="inner-form form-control" id="description" placeholder="Enter description here." rows="4" name="description">{{old('description',@$userDetails->description)}}</textarea>

            @if($errors->has('description'))
                <span class="error text-danger">{{$errors->first('description')}}</span>
            @endif
        </div>

        <div class="form-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="position-relative">
                        <label for="exampleFormControlInput1" class="form-label">Currency</label>
                        <select class="form-select pe-5 mb-2 inner-form form-control" name="currency" id="currency">
                            <option value="">Select an currency</option>
                            <option value="USD" <?php echo (old('currency') == 'USD' || (@$userDetails->currency && @$userDetails->currency == 'USD')) ? 'selected' : ''; ?>>USD</option>
                            <option value="AUD" <?php echo (old('currency') == 'AUD' || (@$userDetails->currency && @$userDetails->currency == 'AUD')) ? 'selected' : ''; ?>>AUD</option>
                        </select>
                        <i class="fi fi-rr-angle-small-down" style="position: absolute;
                                    top: 75%;
                                    right: 20px;
                                    transform: translateY(-50%);
                                    pointer-events: none;
                                    color: #555;"></i>

                        @if($errors->has('currency'))
                            <span class="error text-danger">{{$errors->first('currency')}}</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Precise Location</label>
                        <input type="text" class="inner-form form-control" placeholder="Enter location.." name="precise_location" id="precise_location" value={{old('precise_location',@$userDetails->precise_location)}}>
                        @if($errors->has('precise_location'))
                            <span class="error text-danger">{{$errors->first('precise_location')}}</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Country</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="country" id="country" value={{old('country',@$userDetails->country)}}>
                        @if($errors->has('country'))
                            <span class="error text-danger">{{$errors->first('country')}}</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <label class="form-label">State</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="state" id="state" value={{old('state',@$userDetails->state)}}>
                        @if($errors->has('state'))
                            <span class="error text-danger">{{$errors->first('state')}}</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <label class="form-label">City</label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="city" id="city" value={{old('city',@$userDetails->city)}}>
                        @if($errors->has('city'))
                            <span class="error text-danger">{{$errors->first('city')}}</span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <label class="form-label">Street </label>
                        <input type="text" class="inner-form form-control" placeholder="Populate on Google place select.." name="street" id="street" value={{old('street',@$userDetails->street)}}>
                        @if($errors->has('street'))
                            <span class="error text-danger">{{$errors->first('street')}}</span>
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

        <div class="card-body px-0 mt-4">
            <div class="table-responsive p-0" style="border: 1px solid #dee2e6; border-radius: 12px !important;">
                <table class="table align-items-center mb-0">
                    <thead style="border-bottom: 1px solid #dee2e6;">
                        <tr>
                            <th style="border: 1px solid #dee2e6;"
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alert Type</th>
                            <th style="border: 1px solid #dee2e6;"
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                            <th style="border: 1px solid #dee2e6;"
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">SMS
                            </th>
                            <th style="border: 1px solid #dee2e6;"
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                Mobile App</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border: 1px solid #dee2e6;" class="text fs-6">Subscription Expiring </td>
                            <td style="border: 1px solid #dee2e6;">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input mx-auto" type="checkbox" id="email1" value="1" name="subscription[email]" {{ old('subscription.email', @$alertDetails['subscription']['email']) == 1 ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td style="border: 1px solid #dee2e6;">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input mx-auto" type="checkbox" id="sms1" value="1" name="subscription[sms]" {{ old('subscription.sms', @$alertDetails['subscription']['sms']) == 1 ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td style="border: 1px solid #dee2e6;">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input mx-auto" type="checkbox" id="mobile1" value="1" name="subscription[mobile]" {{ old('subscription.mobile', @$alertDetails['subscription']['mobile']) == 1 ? 'checked' : '' }}>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #dee2e6;" class="text-sm">Payment Received</td>
                            <td style="border: 1px solid #dee2e6;">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input mx-auto" type="checkbox" id="email2" value="1" name="payment[email]" {{ old('payment.email', @$alertDetails['payment']['email']) == 1 ? 'checked' : '' }}>

                                </div>
                            </td>
                            <td style="border: 1px solid #dee2e6;">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input mx-auto" type="checkbox" id="sms2" value="1" name="payment[sms]" 
                                    {{ old('payment.sms', @$alertDetails['payment']['sms']) == 1 ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td style="border: 1px solid #dee2e6;">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input mx-auto" type="checkbox" id="mobile2" value="1" name="payment[mobile]" {{ old('payment.mobile', @$alertDetails['payment']['mobile']) == 1 ? 'checked' : '' }}>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #dee2e6;" class="text-sm">Auction Ending</td>
                            <td style="border: 1px solid #dee2e6;">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input mx-auto" type="checkbox" id="email3" value="1" name="auction[email]" {{ old('auction.email', @$alertDetails['auction']['email']) == 1 ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td style="border: 1px solid #dee2e6;">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input mx-auto" type="checkbox" id="sms3" value="1" name="auction[sms]" {{ old('auction.sms', @$alertDetails['auction']['sms']) == 1 ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td style="border: 1px solid #dee2e6;">
                                <div class="form-check d-flex justify-content-center">
                                    <input class="form-check-input mx-auto" type="checkbox" id="mobile3" value="1" name="auction[mobile]" {{ old('auction.mobile', @$alertDetails['auction']['mobile']) == 1 ? 'checked' : '' }}>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <hr class="horizontal dark mt-0 mt-5">

        {{-- <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap">
            <h6>Banners:</h6>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="banners" id="GreenEligibility" value="Green Eligibility" {{(old('banners')=='Green Eligibility' || @$userDetails->banners=='Green Eligibility')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="GreenEligibility">Green Eligibility</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="banners" id="Qualified_for" value="Qualified for" {{(old('banners')=='Qualified for' || @$userDetails->banners=='Qualified for')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="Qualified_for">Qualified for</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="banners" id="Negotiable" value="Negotiable" {{(old('banners')=='Negotiable' || @$userDetails->banners=='Negotiable')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="Negotiable">Negotiable</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="banners" id="Price_Reduced" value="Price Reduced" {{(old('banners')=='Price Reduced' || @$userDetails->banners=='Price Reduced')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="Price_Reduced">Price Reduced</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="banners" id="Motivated_Seller" value="Motivated Seller" {{(old('banners')=='Motivated Seller' || @$userDetails->banners=='Motivated Seller')?'checked':''}}>
                <label class="form-check-label fw-bold text-dark" for="Motivated_Seller">Motivated Seller</label>
            </div>
            @if($errors->has('banners'))
                <span class="error text-danger">{{$errors->first('banners')}}</span>
            @endif
        </div> --}}


        <div class="form-check pt-2">
            <input class="form-check-input" type="checkbox" name="agree" id="agree" value="1" {{(old('agree')==1 || @$userDetails->agree==1)?'checked':''}}>
            <label class="form-check-label fw-bold text-dark" for="agree" >I agree to <a href="{{route('cms.terms.condition')}}" target="_blank" style="color: #A19061;">Terms Of Use</a></label>
            @if($errors->has('agree'))
                <span class="error text-danger">{{$errors->first('agree')}}</span>
            @endif
        </div>

        <div class="text-start my-4">
            <button type="submit" class="btn btn-primary" id="setting-form-update">Update Account</button>
            <a href="{{route('dashboard')}}"><button type="button" class="btn btn-secondary">Cancel</button></a>
        </div>
    <form>
</div>
@endsection

@section('script')


<script>
    $(document).ready(function() {
        
    // Replace with your Mapbox access token
    mapboxgl.accessToken = 'pk.eyJ1IjoiZWxpdGVlcXVpbmVtYXJrZXRwbGFjZSIsImEiOiJjbWJyemJpbnUwZmo3MmtzZjhkcjEydjFpIn0.W8xnRIfKQOCpSdAlhAPSlA';

    // Create the map
    const map = new mapboxgl.Map({
        container: 'map', // ID of the container element
        style: 'mapbox://styles/mapbox/streets-v11', // Map style
        center: [77.2090, 28.6139], // Longitude, Latitude (Example: New Delhi, India)
        zoom: 10 // Zoom level
    });


        $("#settingForm").validate({
            rules: {
                first_name: {
                    required: true,
                    maxlength: 255
                },
                last_name:{
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 255
                },
                phone: {
                    required: true,
                    minlength: 10,
                    maxlength: 15,
                    pattern: /^[+]?[0-9]{10,15}$/  // Regular expression to match the phone number format
                },
                facebook:{
                    required: true,
                    url: true,
                    maxlength: 300
                },
                twitter:{
                    required: true,
                    url: true,
                    maxlength: 300
                },
                youtube:{
                    required: true,
                    url: true,
                    maxlength: 300
                },
                linkedin:{
                    required: true,
                    url: true,
                    maxlength: 300
                },
                instagram:{
                    required: true,
                    url: true,
                    maxlength: 300
                },
                website:{
                    required: true,
                    url: true,
                    maxlength: 300
                },
                description:{
                    required: true,
                    maxlength: 5000
                },
                currency:{
                    required: true,
                    maxlength: 300
                },
                precise_location:{
                    required: true,
                    maxlength: 300
                },
                country:{
                    required: true,
                    maxlength: 300
                },
                state:{
                    required: true,
                    maxlength: 300
                },
                city:{
                    required: true,
                    maxlength: 300
                },
                street:{
                    required: true,
                    maxlength: 300
                },
                agree:{
                    required: true
                },
                // banners:{
                //     required: true
                // }
            },
            messages: {
                first_name: {
                    required: "Please enter your first name",
                    maxlength: "First Name must not exceed 255 characters"
                },
                last_name: {
                    required: "Please enter your Last name",
                    maxlength: "Last Name must not exceed 255 characters"
                },
                email: {
                    required: "Please enter your email address",
                    email: "The email should be in the format: john@domain.tld",
                    maxlength: "Email must not exceed 255 characters"
                },
                phone: {
                    required: "Please enter your phone number",
                    minlength: "Phone number must be at least 10 digits",
                    maxlength: "Phone number cannot exceed 15 digits",
                    pattern: "Phone number must be between 10 and 15 digits, optionally starting with +"
                },
                facebook: {
                    required: "Please enter your facebook url",
                    url: "Please enter a valid URL (e.g., https://facebook.com/yourprofile)",
                    maxlength: "facebook must not exceed 3000 characters"
                },
                twitter: {
                    required: "Please enter your twitter url",
                    url: "Please enter a valid URL (e.g., https://twitter.com/yourprofile)",
                    maxlength: "twitter must not exceed 3000 characters"
                },
                youtube: {
                    required: "Please enter your youtube url",
                    url: "Please enter a valid URL (e.g., https://youtube.com/yourprofile)",
                    maxlength: "youtube must not exceed 3000 characters"
                },
                linkedin: {
                    required: "Please enter your linkedin url",
                    url: "Please enter a valid URL (e.g., https://linkedin.com/yourprofile)",
                    maxlength: "linkedin must not exceed 3000 characters"
                },
                instagram: {
                    required: "Please enter your instagram url",
                    url: "Please enter a valid URL (e.g., https://instagra,.com/yourprofile)",
                    maxlength: "instagram must not exceed 3000 characters"
                },
                website: {
                    required: "Please enter your website url",
                    url: "Please enter a valid URL (e.g., https://domain.com)",
                    maxlength: "website must not exceed 3000 characters"
                },
                description: {
                    required: "Please enter your description",
                    maxlength: "description must not exceed 5000 characters"
                },
                currency: {
                    required: "Please enter your currency",
                    maxlength: "currency must not exceed 300 characters"
                },
                precise_location: {
                    required: "Please enter your precise_location",
                    maxlength: "precise_location must not exceed 300 characters"
                },
                country: {
                    required: "Please enter your country",
                    maxlength: "country must not exceed 300 characters"
                },
                state: {
                    required: "Please enter your state",
                    maxlength: "state must not exceed 300 characters"
                },
                city: {
                    required: "Please enter your city",
                    maxlength: "city must not exceed 300 characters"
                },
                street: {
                    required: "Please enter your street",
                    maxlength: "street must not exceed 300 characters"
                },
                agree: {
                    required: "I agree to terms of use is required",
                },
                // banners: {
                //     required: "Banner is required",
                // }, 
                
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
                $('#setting-form-update').prop('disabled', true).text('Please wait...');
                form.submit();
            }
        });
    });
</script>

@endsection