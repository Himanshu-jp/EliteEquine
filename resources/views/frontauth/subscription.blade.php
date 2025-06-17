@extends('frontauth.layouts.main')
@section('title')
Your Ads
@endsection
@section('content')

<div class="container-fluid mt-4">
    <div class="ms-0 mb-3  d-flex align-items-center justify-content-between flex-wrap">
        <h4 class="h5">Subscription</h4>
    </div>
    <div>
        <div class="col-xxl-8 mx-auto">
            <div class="section-heading">
                <h2 class="text-center fw-bold">Subscription Plans</h2>
            </div>
            <div class="pricing-switcher">
                <p class="fieldset">
                    <input type="radio" name="duration-1" value="standard" id="standard-1" checked>
                    <label for="standard-1">Standard</label>

                    <input type="radio" name="duration-1" value="featured" id="featured-1">
                    <label for="featured-1">Featured</label>
                </p>
            </div>
            <!-- Standard section start -->
            <div id="standard-section">
                <div class="row">

                    @foreach($subscription['standard'] as $key => $value)
                        <div class="col-md-6 col-lg-6 col-xl-4 col-sm-12  mt-3">
                            <div class="bounce-invert">
                                <div class="exclusive">
                                    <div class="pricing-wrapper">
                                        <div data-type="yearly" class="is-hidden">
                                            <header class="pricing-header">
                                                <h4>{{$value->title}}</h4>
                                                <span>{{$value->subtitle}}</span>
                                            </header>
                                            <div class="price">${{$value->price}}</div>
                                            <div class="pricing-body">
                                                <p>
                                                    {!! $value->description !!}
                                                </p>
                                            </div>
                                            <hr class="horizontal dark mt-0 mb-2">
                                            <footer class="pricing-footer">
                                                <p>Expires in {{$value->days}} days </p>
                                                <a href="{{ route('purchase_plan',base64_encode($value->id)) }}" class="btn btn-primary w-100">Purchase Now</a>
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="col-md-12 mt-4">
                    <div class="bounce-card">
                        <h4>Add Ons</h4>
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="boostAdCheckbox">
                                <label class="form-check-label" for="boostAdCheckbox">
                                    Boost Ad back to top of Homepage + Socials – $5/ad
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="customPostCheckbox">
                                <label class="form-check-label" for="customPostCheckbox">
                                    Custom post for Socials including "Swipe for Video" with 5 pictures and up to 2
                                    videos – $10/ad. Socials include Instagram, TikTok, + Facebook
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bannerSpaceCheckbox">
                                <label class="form-check-label" for="bannerSpaceCheckbox">
                                    Banner Space: $200 / year
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailBlastCheckbox">
                                <label class="form-check-label" for="emailBlastCheckbox">
                                    Email Blast Promotion to our Newsletter – $50 / blast
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="textBlastCheckbox">
                                <label class="form-check-label" for="textBlastCheckbox">
                                    Text Blast Promotion to our Community – $150 / blast
                                </label>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">$5 Pay Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4 mb-5">
                    <div class="bounce-card d-flex align-items-center flex-wrap justify-content-between">
                        <h6 class="mb-0">FULL SERVICE PACKAGE: Allow us to fully manage and promote all of your listings
                            for you</h6>
                        <a href="#" class="btn btn-primary">Contact us for Pricing</a>
                    </div>
                </div>
            </div>
            <!-- Standard section end -->

            <!-- Featured section start -->
            <div id="featured-section" style="display: none;">
                <div class="row">

                    @foreach($subscription['featured'] as $key => $value)
                        <div class="col-md-6 col-lg-6 col-xl-4 col-sm-12  mt-3">
                            <div class="bounce-invert">
                                <div class="exclusive">
                                    <div class="pricing-wrapper">
                                        <div data-type="yearly" class="is-hidden">
                                            <header class="pricing-header">
                                                <h4>{{$value->title}}</h4>
                                                <span>{{$value->subtitle}}</span>
                                            </header>
                                            <div class="price">${{$value->price}}</div>
                                            <div class="pricing-body">
                                                <p>
                                                    {!! $value->description !!}
                                                </p>
                                            </div>
                                            <hr class="horizontal dark mt-0 mb-2">
                                            <footer class="pricing-footer">
                                                <p>Expires in {{$value->days}} days </p>
                                                <a href="{{ route('purchase_plan',base64_encode($value->id)) }}" class="btn btn-primary w-100">Purchase Now</a>
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="col-md-12 mt-4">
                    <div class="bounce-card text-center">
                        <h6 class="mb-0">Automatic Social Media Promos for “Featured” Packages include Instagram,
                            Facebook and TikTok. </h6>
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <div class="bounce-card">
                        <h4>Add Ons</h4>
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="boostAdCheckbox">
                                <label class="form-check-label" for="boostAdCheckbox">
                                    Boost Ad back to top of Homepage + Socials – $5/ad
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="customPostCheckbox">
                                <label class="form-check-label" for="customPostCheckbox">
                                    Custom post for Socials including "Swipe for Video" with 5 pictures and up to 2
                                    videos – $10/ad. Socials include Instagram, TikTok, + Facebook
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bannerSpaceCheckbox">
                                <label class="form-check-label" for="bannerSpaceCheckbox">
                                    Banner Space: $200 / year
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="emailBlastCheckbox">
                                <label class="form-check-label" for="emailBlastCheckbox">
                                    Email Blast Promotion to our Newsletter – $50 / blast
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="textBlastCheckbox">
                                <label class="form-check-label" for="textBlastCheckbox">
                                    Text Blast Promotion to our Community – $150 / blast
                                </label>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-primary">$5 Pay Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4 mb-5">
                    <div class="bounce-card d-flex align-items-center flex-wrap justify-content-between">
                        <h6 class="mb-0">FULL SERVICE PACKAGE: Allow us to fully manage and promote all of your listings
                            for you</h6>
                        <a href="#" class="btn btn-primary">Contact us for Pricing</a>
                    </div>
                </div>
            </div>
            <!-- Featured section end -->
        </div>
    </div>

</div>
@endsection


@section('script')

<script>
document.addEventListener('DOMContentLoaded', function() {
    const standardSection = document.getElementById('standard-section');
    const featuredSection = document.getElementById('featured-section');

    const radioButtons = document.querySelectorAll('input[name="duration-1"]');

    function showSection(sectionToShow, sectionToHide) {
        sectionToHide.classList.remove('show');
        setTimeout(() => {
            sectionToHide.style.display = 'none';
            sectionToShow.style.display = 'block';
            setTimeout(() => {
                sectionToShow.classList.add('show');
            }, 10); // thoda delay dena zaruri hota hai animation ke liye
        }, 300); // hide animation ke liye time
    }

    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'standard') {
                showSection(standardSection, featuredSection);
            } else if (this.value === 'featured') {
                showSection(featuredSection, standardSection);
            }
        });
    });

    // Initial setup
    standardSection.classList.add('fade', 'show');
    featuredSection.classList.add('fade');
});
</script>



@endsection