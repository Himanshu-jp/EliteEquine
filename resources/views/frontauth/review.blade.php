@extends('frontauth.layouts.main')
@section('title')
Your Ads
@endsection
@section('content')

<div class="container-fluid mt-4">
    <div class="ms-0 mb-3  d-flex align-items-center justify-content-between flex-wrap">
        <h4 class="h5 font-weight-bolder">Dashboard</h4>
        <div class="d-flex align-items-center gap-3 ">
            <a href="create-ads.html" class="btn btn-primary">Add Reviews</a>
        </div>
    </div>
    <div class="text-center">
        <img src="{{asset('front/auth/assets/img/no-img.webp')}}" alt="no-img" class="">
    </div>
</div>
@endsection

@section('script')



@endsection