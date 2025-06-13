@extends('frontauth.layouts.main')
@section('title')
Product Listing
@endsection
@section('content')

<div class="container-fluid mt-4">
    <!-- <div class="ms-0 mb-3  d-flex align-items-center justify-content-between flex-wrap">
        <h4 class="h5 font-weight-bolder">Product Listing</h4>
            <form method="GET" action="{{ route('productList') }}">
                <div class="row">

                        <div class="mb-3">
                            <input type="text" autocomplete="off" class="inner-form form-control mb-0" id="search" name="search"
                            value="{{request('search')}}" placeholder="Search by product name...">


                            <select name="category" id="category" name="category">
                                <option value="">Select Category</option>
                                @foreach(__categoryData() as $key=>$val)
                                    <option value="{{$key}}" {{(request('category')==$key)?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                            
                        </div>            

                        <div class="mb-3">                       
                            <button class="btn btn-primary" type="submit">Search</button>
                            <a href="{{route('productList')}}"><button class="btn btn-secondary" type="button">Reset</button></a>
                        </div>
                </div>
            </form>


        <div class="d-flex align-items-center gap-3 ">
            <a href="{{route('product')}}" class="btn btn-primary">Submit Ad</a>
        </div>

    </div> -->

    <div class="mb-4">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <h4 class="h5 fw-bold mb-3 mb-md-0">Product Listing</h4>
            <a href="{{ route('product') }}" class="btn btn-primary">Submit Ad</a>
        </div>
        <div class="col-lg-6 ms-auto">
            <form method="GET" action="{{ route('productList') }}">
                <div class="row gy-3 gx-3 align-items-end">
                    <div class="col-12 col-md-4">
                        <label for="search" class="form-label mb-1">Search</label>
                        <input type="text" autocomplete="off" class="form-control inner-form mb-0" id="search"
                            name="search" value="{{ request('search') }}" placeholder="Search by product name...">
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="category" class="form-label mb-1">Category</label>
                        <select name="category" id="category" class="form-select inner-form mb-0">
                            <option value="">Select Category</option>
                            @foreach (__categoryData() as $key => $val)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $val }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4 d-flex gap-2">
                        <button class="btn btn-primary w-100" type="submit">Search</button>
                        <a href="{{ route('productList') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!--Data table-->
    <div class="row mb-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card border-0">
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Title</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Category</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Transaction Method</th>
                                    <!--  <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Change Status</th> -->
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    {{-- <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Age</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Height</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sex</th> --}}
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$products->isEmpty())
                                @foreach($products as $key=>$value)
                                @php
                                    $status = @$value->product_status;
                                    $method = @$value->transaction_method;
                                    $sale = @$value->sale_method;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}"
                                                    width="80" class="avatar avatar-sm me-3" alt="image-1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{@$value->title}}</h6>
                                            </div>
                                        </div>

                                    </td>
                                    <td><span class="text-xs font-weight-bold">$ {{number_format(@$value->price,2)}}
                                            ({{@$value->currency}})</span></td>
                                    <td class="align-middle text-sm">
                                        {{-- <span class="text-xs font-weight-bold" style="color:#A19061;">
                                                {{ @$value->disciplines->map(function($disciplines) {
                                                    return optional($disciplines->commonMaster)->name;
                                                })->filter()->implode(' ,') }}
                                        </span> --}}
                                        <span class="text-xs font-weight-bold" style="color:#A19061;">
                                            {{@$value->category->name}}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if(@$value->transaction_method=='platform')
                                        <span class="badge"
                                            style="background-color:#00A591;">{{(@$value->transaction_method)?@$value->transaction_method:'N/A'}}</span>
                                        @else
                                        <span class="badge"
                                            style="background-color:red;">{{(@$value->transaction_method)?@$value->transaction_method:'N/A'}}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center text-sm" id="record_{{$value->id}}">
                                        @if($sale == 'standard')
                                        @if($status == 'live' && $method == 'platform')
                                        <span class="badge" style="background-color:#00A591;">{{$status}}</span>
                                        @elseif($status == 'sold' && $method == 'platform')
                                        <span class="badge" style="background-color:green;">{{ $status }}</span>
                                        @elseif($status == 'expire' && $method == 'platform')
                                        <span class="badge" style="background-color:red;">{{ $status }}</span>

                                        @elseif(($status == 'live' || $status == 'closed') && $method == 'buyertoseller')
                                        <select name="manual_change" data-id="{{@$value->id}}" id="manual_change">
                                            <option value="live" {{($status == 'live') ? 'selected' : ''}}>Live</option>
                                            <option value="sold">Sold</option>
                                        </select>
                                        @elseif($status == 'sold' && $method == 'buyertoseller')
                                        <span class="badge" style="background-color:green;">{{ $status }}</span>
                                        @elseif($status == 'expire' && $method == 'buyertoseller')
                                        <span class="badge" style="background-color:red;">{{ $status }}</span>
                                        @endif
                                        @elseif($sale == 'auction')
                                        @if(($status == 'live' || $status == 'closed') && $method == 'platform')
                                        <select name="manual_change" data-id="{{ @$value->id }}" id="manual_change">
                                            <option value="live" {{ ($status == 'live') ? 'selected' : '' }} {{ ($status == 'closed') ? 'hidden' : '' }}>Live</option>
                                            <option value="closed" {{ ($status == 'closed') ? 'selected' : '' }}>Closed</option>
                                            <option value="sold" {{ ($status == 'sold') ? 'selected' : '' }}>Sold</option>
                                        </select>
                                        @elseif($status == 'sold' && $method == 'platform')
                                        <span class="badge" style="background-color:green;">{{ $status }}</span>
                                        @elseif($status == 'expire' && $method == 'platform')
                                        <span class="badge" style="background-color:red;">{{ $status }}</span>

                                        @elseif(($status == 'live' || $status == 'closed') && $method == 'buyertoseller')
                                        <select name="manual_change" data-id="{{ @$value->id }}" id="manual_change">
                                            <option value="live" {{ ($status == 'live') ? 'selected' : '' }} {{ ($status == 'closed') ? 'hidden' : '' }}>Live</option>
                                            <option value="closed" {{ ($status == 'closed') ? 'selected' : '' }}>Closed</option>
                                            <option value="sold" {{ ($status == 'sold') ? 'selected' : '' }}>Sold</option>
                                        </select>
                                        @elseif($status == 'sold' && $method == 'buyertoseller')
                                        <span class="badge" style="background-color:green;">{{ $status }}</span>
                                        @elseif($status == 'expire' && $method == 'buyertoseller')
                                        <span class="badge" style="background-color:red;">{{ $status }}</span>
                                        @endif
                                        @endif
                                    </td>

                                    {{--<td class="align-middle text-center text-sm">
                                            @if(@$value->product_status=='live')
                                                <span class="badge" style="background-color:#00A591;">{{(@$value->product_status)?@$value->product_status:'N/A'}}</span>
                                    @elseif(@$value->product_status=='expire')
                                    <span class="badge" style="background-color:red;">{{@$value->product_status}}</span>
                                    @elseif(@$value->product_status=='sold')
                                    <span class="badge"
                                        style="background-color:green;">{{@$value->product_status}}</span>
                                    @else
                                    <span class="badge" style="background-color:gray;">N/A</span>
                                    @endif
                                    </td>--}}
                                    {{-- <td class="align-middle text-center">
                                            <span class="text-xs font-weight-bold">{{ (@$value->productDetail->age)?\Carbon\Carbon::parse("01-01-".@$value->productDetail->age)->age:0}}
                                    Years</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span
                                            class="text-xs font-weight-bold">{{@$value->height->commonMaster->name}}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span
                                            class="text-xs font-weight-bold">{{@$value->sex->commonMaster->name}}</span>
                                    </td> --}}
                                    <td class="align-middle text-center">
                                        @if($sale == 'auction')
                                            @if($status == 'live' && $method == 'platform')
                                                <a href="{{ route('product.bid-detail',@$value->id)}}" class="text-dark me-2" data-toggle="tooltip" data-placement="top" title="Bid Detail"><i class="fi fi-rr-eye"></i></a>                       
                                            @elseif($status == 'live' && $method == 'buyertoseller')
                                                <a href="{{ route('product.bid-detail',@$value->id)}}" class="text-dark me-2" data-toggle="tooltip" data-placement="top" title="Bid Detail"><i class="fi fi-rr-eye"></i></a>
                                            @endif
                                        @endif
                                        <a href="{{ route('editProduct',@$value->id)}}" class="text-dark me-2"><i
                                                class="fi fi-rr-pencil"></i></a>
                                        <span class="text-dark confirm-button"
                                            data-href="{{route('product/delete',$value->id)}}">
                                            <i class="fi fi-rr-trash"></i>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8">


                                        <div class="col-lg-12 mx-auto mt-4">
                                            <nav aria-label="Page navigation example">
                                                <div class="Page navigation example">
                                                    <ul
                                                        class="pagination d-flex justify-content-center align-items-center">
                                                        <h4>No produt found...</h4>
                                                    </ul>
                                                </div>
                                            </nav>
                                        </div>
                                    </td>
                                </tr>

                                @endif
                            </tbody>
                        </table>

                        <div class="col-lg-12 mx-auto mt-4">
                            <nav aria-label="Page navigation example">
                                <div class="Page navigation example">
                                    <ul class="pagination d-flex justify-content-center align-items-center">
                                        {{ ($products->count()>0) ? $products->links('pagination::bootstrap-4'):''}}
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).on('change', '#manual_change', function(e) {
    var $select = $(this);
    var newStatus = $select.val();
    var productId = $select.data('id');
    var previousStatus = $select.data('previous') || $select.find('option[selected]').val(); // Save previously selected option

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with AJAX only if status is sold or closed/live (adjust as needed)
            $.ajax({
                url: '{{route("update.product.status")}}',
                method: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    product_id: productId,
                    product_status: newStatus
                },
                success: function(response) {
                    Swal.fire("Elite Equine", "Product status updated successfully", "success");
                    $("#record_" + productId).html(
                        `<span class='badge' style='background-color:green;'>${newStatus}</span>`
                    );

                    // Update previous status data attribute
                    $select.data('previous', newStatus);

                    // If you want to hide/show options based on selection, do it here:
                    if(newStatus === 'closed'){
                        // For example, hide live option
                        $select.find('option[value="live"]').hide();
                    } else {
                        $select.find('option[value="live"]').show();
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong while updating.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                    console.log(xhr.responseText);

                    // Revert selection back on error
                    $select.val(previousStatus);
                }
            });
        } else {
            // User cancelled, revert to previous selection
            $select.val(previousStatus);
        }
    });
});

$(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>