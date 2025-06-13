@extends('front.layouts.main')
@section('title')
Sold
@endsection
@section('content')


<section class="single-banner">
    <img src="{{asset('front/home/assets/images/single-banner-bg.jpg')}}" class="banner-bg w-100" alt="">
    <div class="container">
        <div class="banner-container">
            <h1 class="text-light">Sold</h1>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        {{--<div class="row">
            <div class="col-lg-3 mb-3">
                <div class="feat_card_bx">
                    <div class="image">
                        <img src="{{asset('front/home/assets/images/featured_hource3.png')}}" alt="hource-image" />
                    </div>
                    <div class="content">
                        <h3 onclick="window.location.href='{{route('sale')}}'">Synergy | 2019 | 16.2h <br />Westphalian
                            | Gelding</h3>
                        <h4>Sale: $100,000 - $150,000</h4>
                        <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4>
                        <span class="sp1">Hunter, Jumper, Equitation</span>
                        <div class="location">
                            <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}" alt="location-icon" />
                            <span>Ocala, FL <br />Trial: World Equestrian Center - Ocala (1/22/25 - 3/15/25)</span>
                        </div>
                        <div class="foot">
                            <div class="bx">
                                <div class="imagee">
                                    <img src="{{asset('front/home/assets/images/profile_feture.svg')}}" alt="Featured-profiles" />
                                </div>
                                <div class="content">
                                    <h4>Martin Douzant</h4>
                                    <div class="stars">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="bx2">
                                <button><img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}" alt="" /></button>
                                <button><img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}" alt="" /></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  --}}
            <div id="productsold-list" class="row">
                {{-- Horse cards will be injected here --}}
                
            </div>

            <div class="col-lg-12 mx-auto mt-4" id="noDataFound" style="display:none;">
                <nav aria-label="Page navigation example">
                    <div class="Page navigation example">
                        <ul class="pagination d-flex justify-content-center align-items-center">
                            <h3>Nothing here yet. Stay tuned — more content coming shortly...</h3>
                        </ul>
                    </div>
                </nav>
            </div>
            
            <!-- <div class="col-lg-4 mx-auto mt-4">
                <nav aria-label="Page navigation example">
                    <ul class="pagination d-flex justify-content-center align-items-center">
                        <li class="page-item"><a class="page-link" href="#"><img
                                    src="{{asset('front/home/assets/images/icons/arrow_left.png')}}" width="24" alt=""></a></li>
                        <li class="page-item"><a class="page-link active" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#"><img
                                    src="{{asset('front/home/assets/images/icons/arrow_right.png')}}" width="24" alt=""></a></li>
                    </ul>
                </nav>
            </div> -->
            <div class="col-lg-12 mx-auto mt-4">
                <nav aria-label="Page navigation example">
                        <div class="Page navigation example">
                        <ul class="pagination d-flex justify-content-center align-items-center">
                            <div id="pagination-links" class="mt-4 text-center"></div>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>


@endsection
@section('script')
<script>
    function loadHorses(page = 1) {   
    $('.preloader').show();
    $.ajax({
        url: '{{ route("product.sold.datatable") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            page: page,
        },
        success: function(response) { 
            window.scrollTo({ top: 0, behavior: 'smooth' });    
            $("#total").html(response.total);       
            if(response.total==0){
                $('#noDataFound').show();
            }else{
                $('#noDataFound').hide();
            }
            $('.preloader').hide();
            $('#productsold-list').html(response.html); // Inject rendered HTML
            $('#pagination-links').html(response.pagination); // Optional pagination
        }
    });
}
 // Initial load
$(document).ready(function () {
    loadHorses();
    // Optional: click on pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        loadHorses(page);
    });
});


function loadHorsesAndScroll() {
    // Scroll to top smoothly
    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Call your original function
    loadHorses();
}
</script>
@endsection