@extends('front.layouts.main')
@section('title')
    About us
@endsection
@section('content')
    <section class="content-page section">
        <div class="container">
            <div class="simplebar-content">
                <div class="col-lg-12 col-md-12 mx-auto">
                    <div class="about-title pb-0">
                       <h1 class="mb-0 pb-0">{{ucfirst($policyData->name)}}</h1>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="data-sections mt-4">
                {!! $policyData->content !!}
            </div>
            @if(!empty($policyData->image))
                <div class="col-lg-12 col-md-12 mx-auto">
                    <div class="text-center">
                        <img src="{{asset('storage' . $policyData->image)}}" class="w-100" alt="{{$policyData->name}}">
                    </div>
                </div>
            @endif
        </div>
    </section>


@endsection