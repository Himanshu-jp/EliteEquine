@extends('front.layouts.main')
@section('title')
Blogs Details
@endsection
@section('content')

<section class="single-banner">
    <img src="{{asset('front/home/assets/images/blog-bg.jpg')}}" class="banner-bg w-100" alt="">
    <div class="container">
        <div class="banner-container">
            <h1 class="text-light">Blog Details</h1>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="blog-header">
                    <h2 class="blog-heading">{{@$blogs->title}}</h2>
                    <ul class="list-unstyled d-flex gap-3">
                        <li class="text-secondary">{{@$blogs->category->name}}</li>
                        <li class="text-secondary">{{ @$blogs->created_at->format('d-m-Y') }}</li>
                    </ul>
                </div>
                <div class="blog-image">
                    <img src="{{(@$blogs->image)?asset('storage/'.@$blogs->image):asset('front/auth/assets/img/logos/logo.png')}}" class="w-10" alt="blog-image">
                </div>
                <div class="blog-content">
                    <p>{!! @$blogs->content !!}</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="blog-sitebar">
                    <div class="recent-posts-widget">
                        <ul>

                            @if(!$latestBlogs->isEmpty())
                                @foreach($latestBlogs as $key => $blog)
                                     <li>
                                        <div class="entry-image">
                                            <a href="{{ route('blog-details', @$blog->id) }}" class="thumb">
                                                <img src="{{(@$blog->image)?asset('storage/'.@$blog->image):asset('front/auth/assets/img/logos/logo.png')}}" width="120" height="100">
                                            </a>
                                        </div>
                                        <div class="entry-meta-wrapper">
                                            <a href="{{ route('blog-details', @$blog->id) }}" class="thumb">
                                                <div class="list-unstyled d-flex gap-3 mb-2">
                                                    <span class="text-secondary">{{@$blog->category->name}}</span>
                                                    <span class="text-secondary">{{ @$blog->created_at->format('d-m-Y') }}</span>
                                                </div>
                                                <div class="entry-title">
                                                    <h4>{{ Str::limit(@$blog->title, 40, '...') }}</h4>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                

                        </ul>
                    </div>

                </div>
                {{-- <div class="tagcloud">
                    <h3>Tags</h3>
                    <a href="#" class="tag-btn">Tom’s Butler</a>
                    <a href="#" class="tag-btn">Silver King</a>
                    <a href="#" class="tag-btn">Kerzi</a>
                    <a href="#" class="tag-btn">Petes Star</a>
                    <a href="#" class="tag-btn">Morning Dash</a>
                    <a href="#" class="tag-btn">Royal King</a>
                </div> --}}
            </div>
        </div>
    </div>
</section>

@endsection