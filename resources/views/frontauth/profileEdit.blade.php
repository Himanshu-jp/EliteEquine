@extends('frontauth.layouts.main')
@section('title')
Update profile
@endsection
@section('content')

<div class="container-fluid mt-4">
    <div class="ms-0 mt-4  d-flex align-items-center justify-content-between flex-wrap">
        <h3 class="h5 font-weight-bolder">Your Profile</h3>
    </div>
    
    <form action="{{ route('profileUpdate') }}" method="post" class="row" id="profileForm" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-2">
                <div class="user-profile position-relative">
                    <span>Profile Picture</span>
                    <div class="profile mt-2">
                        <img src="{{(@$user->profile_photo_path)?asset('storage/'.@$user->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}" class="user-img" alt=""  id="editImg" onclick="triggerFileUpload()">
                    </div>
                    <div class="edit">
                        <img src="{{asset('front/auth/assets/img/icons/edit-img.svg')}}" alt="edit-img">
                    </div>

                    <input type="file" id="fileInput" name="profile_photo_path" style="display: none; cursor: pointer;"
                        onchange="handleImageUpload(event)">

                    @if($errors->has('profile_photo_path'))
                        <span class="error text-danger">{{$errors->first('profile_photo_path')}}</span>
                    @endif
                </div>
            </div>
            
            <div class="col-md-10"> 
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="exampleFormControlInput1" class="form-label">Full name</label>
                        <input type="text" class="inner-form form-control mb-0" id="name" name="name" value="{{ old('name', @$user->name) }}">
                        @if($errors->has('name'))
                            <span class="error text-danger">{{$errors->first('name')}}</span>
                        @endif
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="text" class="inner-form form-control mb-0" value="{{ @$user->email }}" readonly>
                        @if($errors->has('email'))
                            <span class="error text-danger">{{$errors->first('email')}}</span>
                        @endif
                    </div>
                </div>               
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="exampleFormControlInput1" class="form-label">Username</label>
                        <input type="text" class="inner-form form-control mb-0" readonly id="username" name="username" value="{{ old('username',@$user->username)}}">
                        @if($errors->has('username'))
                            <span class="error text-danger">{{$errors->first('username')}}</span>
                        @endif
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="exampleFormControlInput1" class="form-label">Phone number</label>
                        <input type="text" class="inner-form form-control mb-0" id="phone_no" name="phone_no" value="{{ old('phone_no',@$user->phone_no) }}" >
                        @if($errors->has('phone_no'))
                            <span class="error text-danger">{{$errors->first('phone_no')}}</span>
                        @endif
                    </div>
                </div>

                <div class="mt-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Bio</label>
                    <textarea class="inner-form form-control mb-0" name="bio" id="bio"
                        rows="5">{{ old('bio',@$user->bio)}}</textarea>

                    @if($errors->has('bio'))
                        <span class="error text-danger">{{$errors->first('bio')}}</span>
                    @endif
                </div>
                <h5 class="mt-4 mb-0">Address</h5>
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="exampleFormControlInput1" class="form-label">Country</label>
                        <input type="text" class="inner-form form-control mb-0" name="country" value="{{ old('country',@$user->country)}}"  id="country">
                        @if($errors->has('country'))
                            <span class="error text-danger">{{$errors->first('country')}}</span>
                        @endif
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="exampleFormControlInput1" class="form-label">State</label>
                        <input type="text" class="inner-form form-control mb-0" name="state" value="{{old('state',@$user->state)}}"
                            id="state">
                        @if($errors->has('state'))
                            <span class="error text-danger">{{$errors->first('state')}}</span>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="exampleFormControlInput1" class="form-label">City</label>
                        <input type="text" class="inner-form form-control mb-0" name="city" value="{{ old('city',@$user->city)}}"
                             id="city">
                            @if($errors->has('city'))
                            <span class="error text-danger">{{$errors->first('city')}}</span>
                        @endif
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="exampleFormControlInput1" class="form-label">Street</label>
                        <input type="text" class="inner-form form-control mb-0" name="street" value="{{ old('street',@$user->street)}}"
                            id="street">
                        @if($errors->has('street'))
                            <span class="error text-danger">{{$errors->first('street')}}</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex align-items-center gap-4 mt-3">
                    <button type="submit" class="btn btn-primary" id="profile-form-submit">Update Profile</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
                <div class="col-md-12 mt-3"></div>
            </div>
            
        </div>
    </form>
</div>
@endsection

@section('script')


<script>
$(document).ready(function() {

    $("#profileForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 255
            },
            username:{
                required: true,
                maxlength: 255
            },
            phone_no: {
                required: true,
                minlength: 10,
                maxlength: 15,
                pattern: /^[+]?[0-9]{10,15}$/  // Regular expression to match the phone number format
            },
            bio:{
                required: true,
                maxlength: 3000
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
            }
        },
        messages: {
            name: {
                required: "Please enter your name",
                maxlength: "Name must not exceed 255 characters"
            },
            username: {
                required: "Please enter your username",
                maxlength: "username must not exceed 255 characters"
            },
            phone_no: {
                required: "Please enter your phone number",
                minlength: "Phone number must be at least 10 digits",
                maxlength: "Phone number cannot exceed 15 digits",
                pattern: "Phone number must be between 10 and 15 digits, optionally starting with +"
            },
            bio: {
                required: "Please enter your bio",
                maxlength: "bio must not exceed 3000 characters"
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
            $('#profile-form-submit').prop('disabled', true).text('Please wait...');
            form.submit();
        }
    });
});
</script>

<script>
    function triggerFileUpload() {
        document.getElementById('fileInput').click();
    }

    function handleImageUpload(event) {
        const file = event.target.files[0];
        if (file) {
            // Optional: Show preview
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('editImg').src = e.target.result;
            };
            reader.readAsDataURL(file);

            // You can also upload the file via AJAX or FormData here
            console.log("Image selected:", file.name);
        }
    }

</script>
@endsection