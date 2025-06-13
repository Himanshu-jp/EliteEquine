@extends('frontauth.layouts.main')
@section('title')
Profile
@endsection
@section('content')

<div class="container-fluid mt-4">
    <div class="ms-0 mt-4  d-flex align-items-center justify-content-between flex-wrap">
        <h3 class="h5 font-weight-bolder">Your Profile</h3>
        <div class="d-flex align-items-center gap-3 ">
            <a href="{{route('change-password')}}" class="btn btn-primary">Change Password</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="user-profile position-relative">
                <span>Profile Picture</span>
                <div class="profile mt-2">
                    <img src="{{(@$user->profile_photo_path)?asset('storage/'.@$user->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}" class="user-img" alt="">
                </div>
                <div class="text-center">
                {{-- <img src="{{asset('front/auth/assets/img/icons/edit-img.svg')}}" alt="edit-img"> --}}
                    <a href="{{route('profile-edit')}}" class="btn btn-primary mt-3">Edit Profile</a>
                </div>
            </div>
        </div>
        <div class="col-md-10">

            <div class="row">
                <div class="col-md-6 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Full name</label>
                    <input type="text" class="inner-form form-control mb-0" placeholder="{{@$user->name}}" disabled>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Email</label>
                    <input type="text" class="inner-form form-control mb-0" placeholder="{{@$user->email}}"
                        disabled>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Username</label>
                    <input type="text" class="inner-form form-control mb-0" placeholder="{{@$user->username}}" disabled>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Phone number</label>
                    <input type="number" class="inner-form form-control mb-0" placeholder="{{@$user->phone_no}}" disabled>
                </div>
                <div class="mt-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Bio</label>
                    <textarea class="inner-form form-control mb-0" id="exampleFormControlTextarea1" rows="5"
                        disabled>{{@$user->bio}}</textarea>
                </div>
                <h5 class="mt-4 mb-0">Address</h5>
                <div class="col-md-6 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Country</label>
                    <input type="text" class="inner-form form-control mb-0" placeholder="{{@$user->country}}" disabled>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">State</label>
                    <input type="text" class="inner-form form-control mb-0" placeholder="{{@$user->state}}"
                        disabled>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">City</label>
                    <input type="text" class="inner-form form-control mb-0" placeholder="{{@$user->city}}"
                        disabled>
                </div>
                <div class="col-md-6 mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Street</label>
                    <input type="text" class="inner-form form-control mb-0" placeholder="{{@$user->street}}"
                        disabled>
                </div>
                <div class="col-md-12 mt-6"></div>

            </div>

        </div>
    </div>
</div>

@endsection

@section('script')



@endsection