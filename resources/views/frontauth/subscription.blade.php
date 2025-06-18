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
            <div >
                <div class="row " id="standard-section">

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

                                                         @if(Auth::user()->is_subscribed == '1' && Auth::user()->plan_id == $value->id)
                                                <a href="{{ route('cancel_subscription',base64_encode($value->id)) }}" class="btn btn-primary w-100">Cancel Subscription</a>
                                                @else
                                                <a href="{{ route('purchase_plan',base64_encode($value->id)) }}" class="btn btn-primary w-100">Purchase Now</a>
                                                @endif
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

              
                <div class="row" id="featured-section" style="display: none;">

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

                                                @if(Auth::user()->is_subscribed == '1' && Auth::user()->plan_id == $value->id)
                                                <a href="{{ route('cancel_subscription',base64_encode($value->id)) }}" class="btn btn-primary w-100">Cancel Subscription</a>
                                                @else
                                                <a href="{{ route('purchase_plan',base64_encode($value->id)) }}" class="btn btn-primary w-100">Purchase Now</a>
                                                @endif
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                          <div class="row">
                         <div class="col-md-12 mt-4">
                    <div class="bounce-card text-center">
                        <h6 class="mb-0">Automatic Social Media Promos for “Featured” Packages include Instagram,
                            Facebook and TikTok. </h6>
                    </div>
                </div>
                </div>
           
          

             
                </div>

                <div class="row">
                       <div class="col-md-12 mt-4">
                    <form action="{{ route('charge_add_ons') }}" method="post" >
                        @csrf

                    <div class="bounce-card">
                        <h4>Add Ons</h4>
                        <div class="">

                            @foreach ($addon as $addonitem)
                                  <div class="form-check">
                                <input class="form-check-input main_addon_price_adds" name="addon_prices[]" data-price="{{ $addonitem->price }}"  type="checkbox" id="boostAdCheckbox{{ $loop->iteration }}" value="{{ $addonitem->id }}">
                                <label class="form-check-label" for="boostAdCheckbox{{ $loop->iteration }}" >
                                 
                                     {{ $addonitem->description }} 

                                </label>
                            </div>
                            @endforeach
                          
                         
                        </div>
                        <div class="text-center price_include_btn" style="display: none;">
                            <button  type="submit"  class="btn btn-primary">$<span class="price-in">0</span> Pay Now</button>
                        </div>
                    </div>
                    </form>

                </div>
                <div class="col-md-12 mt-4 mb-5">
                    <div class="bounce-card d-flex align-items-center flex-wrap justify-content-between">
                        <h6 class="mb-0">FULL SERVICE PACKAGE: Allow us to fully manage and promote all of your listings
                            for you</h6>
                        <a href="{{ route('contact.form') }}"  class="btn btn-primary">Contact us for Pricing</a>
                    </div>
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
    $('body').on('click','.main_addon_price_adds',function(){
        var priceAdd=0;
       $('.main_addon_price_adds:checked').each(function(){
      priceAdd+=parseFloat($(this).attr('data-price'));
       })
       $('.price-in').html(priceAdd)
     if(priceAdd > 0){
       $('.price_include_btn').show()

     }else{
       $('.price_include_btn').hide()

     }
    })
</script>
<script>
$(document).ready(function () {
    const $standardSection = $('#standard-section');
    const $featuredSection = $('#featured-section');
    const $radioButtons = $('input[name="duration-1"]');

    function showSection($sectionToShow, $sectionToHide) {
        $sectionToHide.removeClass('show');
        setTimeout(function () {
            $sectionToHide.css('display', 'none');
            $sectionToShow.css('display', 'flex');
            setTimeout(function () {
                $sectionToShow.addClass('show');
            }, 10); // thoda delay dena zaruri hota hai animation ke liye
        }, 300); // hide animation ke liye time
    }

    $radioButtons.on('change', function () {
        if (this.value === 'standard') {
            showSection($standardSection, $featuredSection);
        } else if (this.value === 'featured') {
            showSection($featuredSection, $standardSection);
        }
    });

    // Initial setup
    $standardSection.addClass('fade show');
    $featuredSection.addClass('fade');
});

</script>


@endsection