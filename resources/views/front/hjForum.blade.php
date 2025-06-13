@extends('front.layouts.main')
@section('title')
Hj Forum
@endsection
@section('content')


<section class="single-banner">
    <img src="{{asset('front/home/assets/images/hj-forum-bg.jpg')}}" class="banner-bg w-100" alt="">
    <div class="container">
        <div class="banner-container">
            <h1 class="text-light">H/J Forum</h1>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="col-lg-5 mx-auto">

            {{-- <div class="top-form">
                <div class="search-box w-100 d-flex position-relative">
                    <input type="text" placeholder="Search for" class="form-control" />
                    <img class="icon-input" src="{{asset('front/home/assets/images/search-icon.svg')}}">
                    <div class="position-absolute top-0 end-0">
                        <button class="search-btn w-100 h-100">Search</button>
                    </div>
                </div>
            </div> --}}
            <form method="GET" action="{{ route('hj-forum') }}">
                <div class="top-form">
                    <div class="search-box w-100 d-flex position-relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for" class="form-control" />
                        <img class="icon-input" src="{{asset('front/home/assets/images/search-icon.svg')}}">
                        <div class="position-absolute top-0 end-0">
                            <button class="search-btn w-100 h-100" type="submit">Search</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="row">

            @if(!$forum->isEmpty())
                @foreach($forum as $key => $value)
                    <div class="col-lg-12 mb-4">
                        <div class="forum-card">
                            <div class="forum-content">
                                <div class="forum-img">
                                    <img src="{{(@$value->image)?asset('storage/'.@$value->image):asset('front/auth/assets/img/user-img.png')}}" class="w-100" alt="">
                                </div>
                                <div class="forum-discription">
                                    <h3 class="title">{{ Str::limit(@$value->title, 40, '...') }}</h3>
                                    <p>{{ Str::limit(@$value->description, 200, '...') }}</p>
                                    <ul>
                                        <span>
                                            <img src="{{asset('front/home/assets/images/location-icon.svg')}}"
                                                alt="">&nbsp;{{@$value->user->name ?? 'Unknown'}}
                                        </span>
                                    </li>
                                        <span>
                                        <img src="{{asset('front/home/assets/images/calendar-icon.svg')}}"
                                            alt="">&nbsp; {{@$value->created_at->format('d M Y h:m a')}} 
                                        </span>
                                    </ul>
                                </div>
                                <button type="button" class="apply-flitter ms-auto" onclick="window.location.href='{{route('hj-forum-details',$value->id)}}'">View Details</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else

                <div class="col-lg-12 mx-auto mt-4">
                    <nav aria-label="Page navigation example">
                        <div class="Page navigation example">
                            <ul class="pagination d-flex justify-content-center align-items-center">
                                <h3>Stay tuned! Hj forum will be added shortly...</h3>
                            </ul>
                        </div>
                    </nav>
                </div>
               
            @endif


        </div>

        <div class="col-lg-12 mx-auto mt-4">
            <nav aria-label="Page navigation example">
                    <div class="Page navigation example">
                    <ul class="pagination d-flex justify-content-center align-items-center">
                        {{ ($forum->count()>0) ? $forum->links('pagination::bootstrap-4'):''}}
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</section>


@endsection