@extends('frontauth.layouts.main')
@section('title')
Your Ads
@endsection
@section('content')

<div class="container-fluid mt-4">
    <div class="ms-0 mb-3  d-flex align-items-center justify-content-between flex-wrap">
        <h4 class="h5 font-weight-bolder">Dashboard</h4>
        <div class="d-flex align-items-center gap-3 ">
            <a href="create-ads.html" class="btn btn-primary">New Ad</a>
        </div>
    </div>
    <div class="col-md-5 mx-auto">
        <div class="empty-box">
            <a href="create-ads.html"> <img src="{{asset('front/auth/assets/img/icons/pluse.svg')}}" alt="question"></a>
            <h6>Your subscription has expired, please renew it </h6>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection