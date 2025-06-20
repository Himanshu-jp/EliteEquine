@extends('front.layouts.main')

@section('title')
Checkout
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="heading-page mb-4">
            <h3>Checkout</h3>
        </div>
        <div class="row">
            <!-- Left: Address Forms -->
            <div class="col-lg-8 mb-4">
                <form method="POST" action="{{ route('product.checkout.process', $products->id) }}" id="checkout-form">
                    @csrf

                    {{-- <h4>Shipping Address</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="shipping_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="shipping_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="shipping_phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="shipping_phone" required>
                        </div>
                        <div class="col-12">
                            <label for="shipping_address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="shipping_address" required>
                        </div>
                        <div class="col-md-4">
                            <label for="shipping_city" class="form-label">City</label>
                            <input type="text" class="form-control" name="shipping_city" required>
                        </div>
                        <div class="col-md-4">
                            <label for="shipping_state" class="form-label">State</label>
                            <input type="text" class="form-control" name="shipping_state" required>
                        </div>
                        <div class="col-md-4">
                            <label for="shipping_zip" class="form-label">ZIP</label>
                            <input type="text" class="form-control" name="shipping_zip" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="sameAsShipping">
                        <label class="form-check-label" for="sameAsShipping">
                            Billing address same as shipping
                        </label>
                    </div>

                    <h4>Billing Address</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="billing_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="billing_name" id="billing_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="billing_phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="billing_phone" id="billing_phone" required>
                        </div>
                        <div class="col-12">
                            <label for="billing_address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="billing_address" id="billing_address" required>
                        </div>
                        <div class="col-md-4">
                            <label for="billing_city" class="form-label">City</label>
                            <input type="text" class="form-control" name="billing_city" id="billing_city" required>
                        </div>
                        <div class="col-md-4">
                            <label for="billing_state" class="form-label">State</label>
                            <input type="text" class="form-control" name="billing_state" id="billing_state" required>
                        </div>
                        <div class="col-md-4">
                            <label for="billing_zip" class="form-label">ZIP</label>
                            <input type="text" class="form-control" name="billing_zip" id="billing_zip" required>
                        </div>
                    </div> --}}

                    <h5 class="mb-3">Product Summary</h5>
                    <div class="d-flex align-items-center mb-3">

                        @if(@$products->image->first())
                        <img src="{{  @$products->image->first()->image }}" class="me-3" width="80" height="80" alt="">
                        @endif
                        <div>
                            <h6>{{ @$products->title }}</h6>
                            @php $price = 0; @endphp
                            @if(@$products->sale_method == 'auction')
                                @php $price = (@$products->highestBid->amount) ?? @$products->productDetail->bid_min_price; @endphp
                            @else
                                @php $price = @$products->price; @endphp
                            @endif
                            <p class="mb-0"><strong>Price:</strong> ${{ number_format((float) @$price, 2, '.', ',') }}</p>
                            <p class="mb-0"><strong>Category:</strong> {{ @$products->category->name }}</p>
                            <p class="mb-0"><strong>Location:</strong> {{ @$products->productDetail->city }}, {{ @$products->productDetail->state }}</p>
                        </div>
                    </div>
                    <hr>
                    <p><strong>Listing Date:</strong> {{ \Carbon\Carbon::parse($products->created_at)->format('M d, Y') }}</p>
                    <p>{{ \Illuminate\Support\Str::limit(@$products->description, 100) }}</p>

                    <div class="mt-4">
                        <button type="submit" class="commen_btn btn-lg w-100">Proceed to Checkout</button>
                    </div>
                </form>
            </div>

            <!-- Right: Product Summary -->
            {{-- <div class="col-lg-4">
                <div class="card shadow-sm p-3">
                    <h5 class="mb-3">Product Summary</h5>
                    <div class="d-flex align-items-center mb-3">

                        @if(@$products->image->first())
                        <img src="{{ asset('storage/' . @$products->image->first()->image) }}" class="me-3" width="80" height="80" alt="">
                        @endif
                        <div>
                            <h6>{{ @$products->title }}</h6>
                            @php $price = 0; @endphp
                            @if(@$products->sale_method == 'auction')
                                @php $price = (@$products->highestBid->amount) ?? @$products->productDetail->bid_min_price; @endphp
                            @else
                                @php $price = @$products->price; @endphp
                            @endif
                            <p class="mb-0"><strong>Price:</strong> ${{ number_format((float) @$price, 2, '.', ',') }}</p>
                            <p class="mb-0"><strong>Category:</strong> {{ @$products->subcategory->name }}</p>
                            <p class="mb-0"><strong>Location:</strong> {{ @$products->productDetail->city }}, {{ @$products->productDetail->state }}</p>
                        </div>
                    </div>
                    <hr>
                    <p><strong>Listing Date:</strong> {{ \Carbon\Carbon::parse($products->created_at)->format('M d, Y') }}</p>
                    <p>{{ \Illuminate\Support\Str::limit(@$products->description, 100) }}</p>
                </div>
            </div> --}}
        </div>
    </div>
</section>

<!-- Autofill Script -->
<script>
document.getElementById('sameAsShipping').addEventListener('change', function () {
    if (this.checked) {
        document.getElementById('billing_name').value = document.querySelector('input[name="shipping_name"]').value;
        document.getElementById('billing_phone').value = document.querySelector('input[name="shipping_phone"]').value;
        document.getElementById('billing_address').value = document.querySelector('input[name="shipping_address"]').value;
        document.getElementById('billing_city').value = document.querySelector('input[name="shipping_city"]').value;
        document.getElementById('billing_state').value = document.querySelector('input[name="shipping_state"]').value;
        document.getElementById('billing_zip').value = document.querySelector('input[name="shipping_zip"]').value;
    } else {
        document.getElementById('billing_name').value = '';
        document.getElementById('billing_phone').value = '';
        document.getElementById('billing_address').value = '';
        document.getElementById('billing_city').value = '';
        document.getElementById('billing_state').value = '';
        document.getElementById('billing_zip').value = '';
    }
});
</script>

<!-- jQuery & jQuery Validate Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $("#checkout-form").validate({
        rules: {
            shipping_name: {
                required: true,
                maxlength: 100
            },
            shipping_phone: {
                required: true,
                digits: true,
                minlength: 7,
                maxlength: 15
            },
            shipping_address: {
                required: true,
                maxlength: 255
            },
            shipping_city: {
                required: true,
                maxlength: 100
            },
            shipping_state: {
                required: true,
                maxlength: 100
            },
            shipping_zip: {
                required: true,
                maxlength: 20
            },
            billing_name: {
                required: true,
                maxlength: 100
            },
            billing_phone: {
                required: true,
                digits: true,
                minlength: 7,
                maxlength: 15
            },
            billing_address: {
                required: true,
                maxlength: 255
            },
            billing_city: {
                required: true,
                maxlength: 100
            },
            billing_state: {
                required: true,
                maxlength: 100
            },
            billing_zip: {
                required: true,
                maxlength: 20
            }
        },
        messages: {
            shipping_name: {
                required: "Please enter your name",
                maxlength: "Maximum 100 characters allowed"
            },
            shipping_phone: {
                required: "Please enter your phone number",
                digits: "Phone number must be digits only",
                minlength: "At least 7 digits required",
                maxlength: "No more than 15 digits"
            },
            shipping_address: {
                required: "Enter your address",
                maxlength: "Max 255 characters allowed"
            },
            shipping_city: {
                required: "Enter your city",
                maxlength: "Max 100 characters allowed"
            },
            shipping_state: {
                required: "Enter your state",
                maxlength: "Max 100 characters allowed"
            },
            shipping_zip: {
                required: "Enter ZIP code",
                maxlength: "Max 20 characters allowed"
            },
            billing_name: {
                required: "Please enter billing name",
                maxlength: "Maximum 100 characters allowed"
            },
            billing_phone: {
                required: "Enter billing phone number",
                digits: "Only digits are allowed",
                minlength: "At least 7 digits required",
                maxlength: "No more than 15 digits"
            },
            billing_address: {
                required: "Enter billing address",
                maxlength: "Max 255 characters allowed"
            },
            billing_city: {
                required: "Enter billing city",
                maxlength: "Max 100 characters allowed"
            },
            billing_state: {
                required: "Enter billing state",
                maxlength: "Max 100 characters allowed"
            },
            billing_zip: {
                required: "Enter billing ZIP code",
                maxlength: "Max 20 characters allowed"
            }
        },
        errorClass: 'error text-danger',
        errorElement: 'span',
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
</script>
@endsection
