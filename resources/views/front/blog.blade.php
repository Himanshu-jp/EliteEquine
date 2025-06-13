@extends('front.layouts.main')
@section('title')
Blogs
@endsection
@section('content')

<section class="single-banner">
    <img src="{{asset('front/home/assets/images/blog-bg.jpg')}}" class="banner-bg w-100" alt="">
    <div class="container">
        <div class="banner-container">
            <h1 class="text-light">Blog</h1>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="col-lg-5 mx-auto">
            <form method="GET" action="{{ route('blog') }}">
                <div class="top-form">
                    <div class="search-box w-100 d-flex position-relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search blogs..." class="form-control" />
                        <img class="icon-input" src="{{asset('front/home/assets/images/search-icon.svg')}}">
                        <div class="position-absolute top-0 end-0">
                            <button class="search-btn w-100 h-100" type="submit">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">

            @if(!$blogs->isEmpty())
                @foreach($blogs as $key => $blog)
                <div class="col-lg-4 mb-4">
                    <div class="blog-card">
                        <a href="{{ route('blog-details', $blog->id) }}">
                            @php
                                $imagePath = 'storage/' . ($blog->image ?? '');
                            @endphp

                            @if($blog->image && file_exists(public_path($imagePath)))
                                <img src="{{ asset($imagePath) }}" alt="Blog Image">
                            @else
                                <img src="{{ asset('images/default-blog.png') }}" alt="Default Image">
                            @endif
                            
                            <div class="time-post">
                                <span>{{ @$blog->created_at->format('d-m-Y') }}</span> 
                                <span>{{@$blog->category->name}}</span>
                            </div>
                            <h3>{{ Str::limit(@$blog->title, 40, '...') }}</h3>
                            <p>{!! Str::limit(@$blog->content, 250, ' ...')  !!}</p>
                        </a>
                    </div>
                </div>
                @endforeach
            @else

                <div class="col-lg-12 mx-auto mt-4">
                    <nav aria-label="Page navigation example">
                        <div class="Page navigation example">
                            <ul class="pagination d-flex justify-content-center align-items-center">
                                <h3>Stay tuned! Blogs will be added shortly...</h3>
                            </ul>
                        </div>
                    </nav>
                </div>
               
            @endif

            <div class="col-lg-12 mx-auto mt-4">
                <nav aria-label="Page navigation example">
                     <div class="Page navigation example">
                        <ul class="pagination d-flex justify-content-center align-items-center">
                            {{ ($blogs->count()>0) ? $blogs->links('pagination::bootstrap-4'):''}}
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>

@endsection