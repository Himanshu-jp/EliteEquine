@extends('front.layouts.main')
@section('title')
About us
@endsection
@section('content')
<section class="hero-content-wrapper">
    <div class="container">
        <div class="simplebar-content">
            <div class="col-lg-7 col-md-10 mx-auto">
                <div class="about-title text-center">
                    <h1>Mobile App On The Way!</h1>
                    <p>ELITE EQUINE is your One Stop Equestrian Shop and premier destination for high quality
                        hunter-jumper horses, equine, barn, and rider equipment, boarding barns and equestrian
                        properties, as well as equine services and jobs. How do we work?</p>
                </div>
            </div>
            <div class="col-lg-10 col-md-8 mx-auto">
                <div class="text-center">
                    <img src="{{asset('front/home/assets/images/about-banner.png')}}" class="w-100" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
@if(!empty($aboutData))
<section class="section story-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h2 class="title">Our Story</h2>
            </div>
            <div class="col-lg-7 ms-auto">
                {!! $aboutData->description !!}
            </div>
        </div>
        <div class="story-img">
            <img src="{{asset('storage/'.$aboutData->image)}}" classs="w-100">
        </div>
    </div>
</section>
@endif

@if(!empty($aboutSellerBusinessData))
<section class="section services-opions-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="services-opions">
                    <div class="row">
                        @php
                            $sections = ['listing' => 'Listing', 'track' => 'Track', 'featured' => 'Featured', 'post' => 'Post'];
                        @endphp
                        @foreach ($sections as $key => $label) 
                        @php 
                            $title = $key.'_title'; 
                            $icon = $key.'_icon'; 
                            $content = $key.'_content'; 
                        @endphp
                        <div class="col-md-6">
                            <div class="opions-box">
                                <img src="{{asset('storage/'. $aboutSellerBusinessData->$icon)}}" alt="">
                                <h3>{{ $aboutSellerBusinessData->$title }}</h3>
                                {!! $aboutSellerBusinessData->$content !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <img src="{{asset('storage/'. $aboutSellerBusinessData->image)}}" class="horse-image" alt="">
        </div>
    </div>
</section>
@endif

@if(@$hjForumData->count() > 0)
<section class="section">
    <div class="container">
        <h2 class="fs-2">H/J Forum</h2>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    @for($i = 0; $i < 2; $i++) 
                    <div class="col-lg-6 mb-4">
                        <div class="blog-card">
                            <a  href="{{route('hj-forum-details', @$hjForumData[$i]->id)}}">
                                <img src="{{asset('storage/'.$hjForumData[$i]->image)}}" alt="" />
                            </a>
                            <div class="time-post"><span>{{@$hjForumData[$i]->created_at->format('d M Y h:m a')}}</span> <span>{{@$hjForumData[$i]->user->name ?? 'Unknown'}}</span></div>
                            <a  href="{{route('hj-forum-details', $hjForumData[$i]->id)}}">
                                <h3>{{ Str::limit(@$hjForumData[$i]->title, 40, '...') }}</h3>
                            </a>
                            <p>{{Str::limit(@$hjForumData[$i]->description, 200, '...')}}</p>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog-sitebar">
                    <div class="recent-posts-widget">
                        <ul>
                            @for($i; $i < count($hjForumData); $i++)
                            <li>
                                <div class="entry-image">
                                    <a href="{{route('hj-forum-details', $hjForumData[$i]->id)}}" class="thumb">
                                        <img src="{{asset('storage/'.$hjForumData[$i]->image)}}" width="120" height="100">
                                    </a>
                                </div>
                                <div class="entry-meta-wrapper">
                                    <div class="list-unstyled d-flex gap-3 mb-2">
                                        <span class="text-secondary">{{@$hjForumData[$i]->user->name ?? 'Unknown'}}</span>
                                        <span class="text-secondary">{{@$hjForumData[$i]->created_at->format('d M Y h:m a')}}</span>
                                    </div>
                                    <div class="entry-title">
                                        <a  href="{{route('hj-forum-details', $hjForumData[$i]->id)}}">
                                            <h4>{{ Str::limit(@$hjForumData[$i]->title, 40, '...') }}</h4>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            @endfor
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<section class="section" style="background-color: #D8C07E;">
    <div class="container pb-5">
        <div class="row align-items-center">
            <div class="col-lg-5 me-auto text-center">
                <img src="{{ asset('front/home/assets/images/newsletter-img.png') }}" width="100%" alt="Newsletter Image">
            </div>
            <div class="col-lg-5 ms-auto">
                <div class="newsletter-box">
                    <h2>Subscribe to our Newsletter!</h2>
                    {{-- Success message --}}
                    @if(session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Error message --}}
                    @if($errors->any())
                        <div class="alert alert-danger mt-2">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <form action="{{ route('newsletter.subscribe') }}" id="newsletterForm" method="POST" class="subscribe-form position-relative">
                        @csrf
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="Enter your email" 
                            class="form-control" 
                            required
                            aria-label="Email address for newsletter subscription"
                        />
                        <img class="icon-input" src="{{ asset('front/home/assets/images/search-icon.svg') }}" alt="Search Icon">
                        <button type="submit" class="apply-flitter mt-3 w-100">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<!-- jQuery & CKEditor -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $("#newsletterForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                }
            },
            errorElement: 'span',
            errorClass: 'text-danger',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                $('#subscribeBtn').attr('disabled', true).text('Subscribing...');
                form.submit();
            }
        });
    });
</script>
