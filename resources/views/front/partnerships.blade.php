@extends('front.layouts.main')
@section('title')
Partnerships
@endsection
@section('content')

@if(!empty($partnerContent))
<section class="about-content-wrapper">
    <div class="container">
        <div class="about-content z-3 position-relative">
            <div class="col-lg-7 col-md-10 mx-auto">
                <div class="about-title text-center p-0">
                    <h1>Partnership with Elite Equine</h1>
                    {!! $partnerContent->description !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($partnershipCollaborate->isNotEmpty())
<section class="section">
    <div class="container">
        <div class="section-heading">
            <h2>Collaborations </h2>
        </div>
        <div class="tag-scrollers">
            <div class="tag-scroller scrolling">
                <ul class="tag-list" style="--duration: 35.32s;">
                    @foreach($partnershipCollaborate as $image)
                    <li>
                        <div class="greview">
                            <img src="{{asset('storage/'. $image->image)}}" alt="logo">
                        </div>
                    </li>
                    @endforeach
                </ul>
                <ul class="tag-list" style="--duration: 35.30s;">
                   @foreach($partnershipCollaborate as $image)
                    <li>
                        <div class="greview">
                            <img src="{{asset('storage/'. $image->image)}}" alt="logo">
                        </div>
                    </li>
                    @endforeach
                   
                </ul>
                <ul class="tag-list" style="--duration: 35.32s;">
                    @foreach($partnershipCollaborate as $image)
                    <li>
                        <div class="greview">
                            <img src="{{asset('storage/'. $image->image)}}" alt="logo">
                        </div>
                    </li>
                    @endforeach
                </ul>
                <ul class="tag-list" style="--duration: 35.32s;">
                    @foreach($partnershipCollaborate as $image)
                    <li>
                        <div class="greview">
                            <img src="{{asset('storage/'. $image->image)}}" alt="logo">
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endif

@if($partnerhipWay->isNotEmpty())
<section class="section our-partners-section pt-0">
    <div class="container">
        <!-- left-site -->
        <div class="col-lg-12 mx-auto">
            <div class="section-heading">
                <h2>Looking for Ways to Get Involved?</h2>
            </div>
            {{--<div class="row our-partners">
                <div class="col-md-3 text-center">
                    <img src="{{asset('front/home/assets/images/relationship01.svg')}}" alt="mobile-1.png">
                </div>
                <div class="col-md-8">
                    <h3>Affiliate Partners </h3>
                    <p>Showcase your brand to hunter-jumper equestrians across the globe by joining our affiliate program. Gain exposure across our platform and social media channels, reaching your target audience with ease.</p>
                    <h5>Ready to elevate your brand?</h5>
                    <button type="button" class="apply-flitter mt-3">Get in touch here</button>
                </div>
            </div>--}}
        </div>
        <!-- right-site -->
         @php
         
         @endphp
         @foreach($partnerhipWay as $key => $way)
        <div class="col-lg-12 mx-auto mb-5">
            <div class="row our-partners {{($key%2 != 0) ? 'align-items-center' : ''}}">

                <div class="col-md-3 text-center {{($key%2 != 0) ? ' p-0 order-1 order-md-2' : ''}}">
                    <img src="{{asset('storage/'.$way->image)}}" alt="mobile-1.png">
                </div>
                <div class="col-md-8 {{($key%2 != 0) ? 'text-start text-md-end order-2 order-md-1' : ''}}">
                    <h3>{{$way->title}} </h3>
                    {!! $way->description !!}
                    <h5>Ready to elevate your brand?</h5>
                    <button type="button" class="apply-flitter mt-3">Get in touch here</button>
                </div>

            </div>
        </div>
        @endforeach
        
    </div>
</section>
@endif
@endsection