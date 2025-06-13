@extends('front.layouts.main')
@section('title')
About us
@endsection
@section('content')
<section class="hero-content-wrapper section">
    <div class="container">
        <div class="simplebar-content">
            <div class="col-lg-7 col-md-10 mx-auto">
                <div class="about-title text-center">
                    <h1>{{ucfirst($termsData->name)}}</h1>
                    {!! $termsData->content !!}
                </div>
            </div>
            @if(!empty($termsData->image))
            <div class="col-lg-10 col-md-8 mx-auto">
                <div class="text-center">
                    <img src="{{asset('storage'. $termsData->image)}}" class="w-100" alt="{{$termsData->name}}">
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
