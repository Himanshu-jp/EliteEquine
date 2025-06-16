@extends('frontauth.layouts.main')

@section('title')
    Reviews
@endsection
@section('content')


    <div class="container-fluid mt-4">
        <div class="ms-0 mb-3  d-flex align-items-center justify-content-between flex-wrap">
            <h4 class="h5 font-weight-bolder">Reviews</h4>
            {{-- <div class="d-flex align-items-center gap-3 ">
                <a href="create-ads.html" class="btn btn-primary">Add Reviews</a>
            </div> --}}
        </div>
        <div class="row">

            @if(!$review->isEmpty())
                @foreach($review as $key=>$value)     
                 <div class="col-lg-4">
                    <div class="rating-card">
                        <div class="user-info modl-view-rating">
                            <div>
                                <img src="{{(@$value->ownerUser->profile_photo_path)?asset('storage/'.$value->ownerUser->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}" height="49" alt="" class="user-img" >

                                <h5>{{ $value->ownerUser->name }}</h5>
                                <div class="content">
                                    <div class="stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star-fill {{ $i <= $value->rating ? 'text-warning' : 'text-secondary' }}"> </i>
                                        @endfor
                                    </div>
                                </div>

                            </div>
                            <div>
                                <div class="text-box">
                                    <div class="text-container">
                                        <p>
                                            {{ $value->message }}
                                        </p>
                                         @if($value->image)
                                            <img src="{{asset('storage/'.$value->image)}}" class="rating-img-usr mt-2" alt="">      
                                        @endif
                                    </div>
                                    @if(strlen($value->message) > 105)
                                        <span class="toggle-btn">Show more</span>
                                    @else
                                        <span class="toggle-btn" style="display: none;">Show more</span>
                                    @endif
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif


            <div class="col-lg-12 mx-auto mt-4">
                <nav aria-label="Page navigation example">
                    <div class="Page navigation example">
                        <ul class="pagination d-flex justify-content-center align-items-center">
                            {{ ($review->count()>0) ? $review->links('pagination::bootstrap-4'):''}}
                        </ul>
                    </div>
                </nav>
            </div>

        </div>
@endsection

@section('script')
    <script>
        document.querySelectorAll('.text-box').forEach(function (box) {
            const textContainer = box.querySelector('.text-container');
            const toggleBtn = box.querySelector('.toggle-btn');

            toggleBtn.addEventListener('click', function () {
                textContainer.classList.toggle('expanded');
                toggleBtn.textContent = textContainer.classList.contains('expanded') ? 'Show less' : 'Show more';
            });
        });
    </script>


@endsection