@extends('front.layouts.main')
@section('title')
Sold
@endsection
@section('content')

<style>
    .nav-link{
        color: #000;
    }

       .nav-link.active{
        color: #ff9100;
    }
</style>
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
<div class="row">
    <div class="col-md-12 text-center d-flex justify-content-center mt-2 mb-3">
              <nav class="nav">
  <a class="nav-link active changeTabs" data-tab="Horses"  href="javascript:;">Horses</a>
  <a class="nav-link changeTabs" data-tab="Equipment" href="javascript:;">Equipment & Apparel</a>
  <a class="nav-link changeTabs" data-tab="Housing" href="javascript:;">Barns & Housing</a>
  <a class="nav-link changeTabs " data-tab="Services"  href="javascript:;">Services & Jobs
</a>
</nav>
    </div>
</div>
            <div id="productsold-list" class="row">
             
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
    function loadHorses(page = 1,type=null) {   
    $('.preloader').show();
    $.ajax({
        url: '{{ route("product.sold.datatable") }}',
        type: 'get',
        data: {
            page: page,
            type: type,
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
    loadHorses(1,$('.changeTabs.active').attr('data-tab'));
    // Optional: click on pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        loadHorses(page,$('.changeTabs.active').attr('data-tab'));
    });
});


function loadHorsesAndScroll() {
    // Scroll to top smoothly
    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Call your original function
    loadHorses(1,$('.changeTabs.active').attr('data-tab'));
}

$('body').on('click','.changeTabs',function(){
    $('.changeTabs').removeClass('active')
    $(this).addClass('active')
    loadHorses(1,$(this).attr('data-tab'));

})
</script>
@endsection