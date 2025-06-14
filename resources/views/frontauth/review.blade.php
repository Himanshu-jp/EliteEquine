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
            <div class="col-lg-4">

                <div class="rating-card">
                    <div class="user-info modl-view-rating">
                        <div>
                            <img src="http://192.168.5.81/EliteEquine/public/front/auth/assets/img/user-img.png" height="49"
                                alt="">

                            <h5>Himanshu Jain</h5>

                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                        </div>
                        <div>
                            <div class="text-box">
                                <div class="text-container">
                                    <p>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s with
                                        the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                                        with desktop publishing software like Aldus PageMaker including versions of Lorem
                                        Ipsum.
                                    </p>
                                </div>
                                <span class="toggle-btn">Show more</span>
                            </div>
                            <img src="http://192.168.5.81/EliteEquine/public/storage/reviews/4zkhoxLrO0y80QhgH1Xqr1RCnCS9PqW2FetfsU7Q.jpg"
                                class="rating-img-usr mt-2" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">

                <div class="rating-card">
                    <div class="user-info modl-view-rating">
                        <div>
                            <img src="http://192.168.5.81/EliteEquine/public/front/auth/assets/img/user-img.png" height="49"
                                alt="">

                            <h5>Himanshu Jain</h5>

                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                        </div>
                        <div>
                            <div class="text-box">
                                <div class="text-container">
                                    <p>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s with
                                        the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                                        with desktop publishing software like Aldus PageMaker including versions of Lorem
                                        Ipsum.
                                    </p>
                                </div>
                                <span class="toggle-btn">Show more</span>
                            </div>
                            <img src="http://192.168.5.81/EliteEquine/public/storage/reviews/4zkhoxLrO0y80QhgH1Xqr1RCnCS9PqW2FetfsU7Q.jpg"
                                class="rating-img-usr mt-2" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">

                <div class="rating-card">
                    <div class="user-info modl-view-rating">
                        <div>
                            <img src="http://192.168.5.81/EliteEquine/public/front/auth/assets/img/user-img.png" height="49"
                                alt="">

                            <h5>Himanshu Jain</h5>

                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                            <i class="bi bi-star-fill text-secondary"></i>
                        </div>
                        <div>
                            <div class="text-box">
                                <div class="text-container">
                                    <p>
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                        unknown printer took a galley of type and scrambled it to make a type specimen book.
                                        It has survived not only five centuries, but also the leap into electronic
                                        typesetting, remaining essentially unchanged. It was popularised in the 1960s with
                                        the release of Letraset sheets containing Lorem Ipsum passages, and more recently
                                        with desktop publishing software like Aldus PageMaker including versions of Lorem
                                        Ipsum.
                                    </p>
                                </div>
                                <span class="toggle-btn">Show more</span>
                            </div>
                            <img src="http://192.168.5.81/EliteEquine/public/storage/reviews/4zkhoxLrO0y80QhgH1Xqr1RCnCS9PqW2FetfsU7Q.jpg"
                                class="rating-img-usr mt-2" alt="">
                        </div>
                    </div>
                </div>
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