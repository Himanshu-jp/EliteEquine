@extends('frontauth.layouts.main')
@section('title') Your Ads @endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between">
        <h4 class="h5 mb-2 mb-md-0">Your Favorite Ads</h4>
         <div class="d-flex gap-2">
            <div class="d-flex flex-wrap gap-2">
                <!-- Filter Ads -->
                <!-- <div class="position-relative">
                    <select class="form-select pe-5">
                        <option selected>Filter ads</option>
                        <option value="active">Active Ads</option>
                        <option value="expired">Expired Ads</option>
                    </select>
                    <i class="fi fi-rr-angle-small-down position-absolute"
                        style="top: 50%; right: 15px; transform: translateY(-50%); pointer-events: none;"></i>
                </div> -->

                <!-- Sort By Expire -->
                <!-- <div class="position-relative">
                    <select class="form-select pe-5">
                        <option selected>Sort By Expire</option>
                        <option value="soon">Expiring Soon</option>
                        <option value="latest">Recently Expired</option>
                    </select>
                    <i class="fi fi-rr-angle-small-down position-absolute"
                        style="top: 50%; right: 15px; transform: translateY(-50%); pointer-events: none;"></i>
                </div> -->

                <!-- Descending -->
                <div class="position-relative">
                    <select class="form-select pe-5" id="orderSelect">
                        <option value="" selected>Please select</option>
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                    <i class="fi fi-rr-angle-small-down position-absolute"
                        style="top: 50%; right: 15px; transform: translateY(-50%); pointer-events: none;"></i>
                </div>

                <!-- All Types -->
                <div class="position-relative">
                    <select class="form-select pe-5" id="categorySelect">
                        <option value="" selected>All Categories</option>
                        @if($categories->isNotEmpty())
                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                        @endif
                    </select>
                    <i class="fi fi-rr-angle-small-down position-absolute"
                        style="top: 50%; right: 15px; transform: translateY(-50%); pointer-events: none;"></i>
                </div>
            </div>

        </div>
    </div>
<style>
    select.form-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: none !important;
        /* Bootstrap ke background arrow ko bhi remove */
    }

    /* Select box styling (optional - aur achha look dene ke liye) */
    select.form-select {
        padding-right: 2.5rem;
        /* Icon ke liye space */
    }

    .form-select {
        background-color: #fff;
        padding: 0.5rem 1.2rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        border: 1px solid #EEEEEE;
        box-shadow: none;
        border-radius: 50px;
    }

    .form-select:hover {
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.08);
    }
    </style>
    <!-- Filter Tabs -->
    <div class="table-switcher mt-4">
        <p class="fieldset mb-0">
            <input type="radio" name="status-filter" value="all" id="all" checked>
            <label for="all">All</label>

            <input type="radio" name="status-filter" value="live" id="live">
            <label for="live">Live</label>

            <input type="radio" name="status-filter" value="expire" id="expired">
            <label for="expired">Expired</label>

            <input type="radio" name="status-filter" value="sold" id="sold">
            <label for="sold">Sold</label>
        </p>
    </div>
    <hr class="horizontal dark mt-0 mb-2">

    <!-- Data Table -->
    <div class="row mb-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card border-0">
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="adTable">
                                @include('frontauth.partials.favorite-products', ['favProducts' => $favProducts])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
let currentFilter = 'all';
let currentOrder = 'desc';
let currentCategory = '';

// Main fetch function
function loadFavorites(type = 'all', page = 1, order = 'desc', category_id = '') {
    currentFilter = type;
    currentOrder = order;
    currentCategory = category_id;

    if (!$('#loadingIndicator').length) {
        $('#adTable').html(
            `<tr id="loadingIndicator"><td colspan="8" class="text-center">Loading... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></td></tr>`
        );
    }

    $.ajax({
        url: '{{ route("favorite") }}',
        method: 'GET',
        data: {
            type: type,
            page: page,
            order_by: order,
            category_id: category_id
        },
        success: function (response) {
            if (response.status === 200) {
                $('#adTable').fadeOut(150, function () {
                    $(this).html(response.html).fadeIn(150);
                });
            } else {
                $('#adTable').html('<tr><td colspan="8" class="text-center">Failed to load data.</td></tr>');
            }
        },
        error: function () {
            $('#adTable').html('<tr><td colspan="8" class="text-center">Error occurred while loading data.</td></tr>');
        }
    });
}

// Triggered on filter radio change
$('input[name="status-filter"]').on('change', function () {
    const selected = $(this).val();
    loadFavorites(selected, 1, currentOrder, currentCategory);
});

// Triggered on order dropdown change
$('#orderSelect').on('change', function () {
    const order = $(this).val();
    loadFavorites(currentFilter, 1, order, currentCategory);
});

// Triggered on category dropdown change
$('#categorySelect').on('change', function () {
    const categoryId = $(this).val();
    loadFavorites(currentFilter, 1, currentOrder, categoryId);
});

// Favorite / Unfavorite button click - delegated to catch dynamically loaded content
$(document).on('click', '.favorite-btn', function(e) {
    e.preventDefault();

    let productId = $(this).data('product-id');
    let url = `{{ url('favorite') }}/${productId}`;
    let $btn = $(this);

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.favorited) {
                $btn.addClass('favorited');  
                $btn.find("i").addClass('fi-ss-heart').removeClass('fi-rr-heart');
            } else {
                $btn.removeClass('favorited');
                $btn.find("i").addClass('fi-rr-heart').removeClass('fi-ss-heart');

                // Remove the row immediately on unfavorite (only if filtered by 'all' or matches currentFilter)
                // You may adjust this logic based on your backend filtering
                let $row = $btn.closest('tr');
                $row.fadeOut(300, function() {
                    $(this).remove();

                    // If after removing row no more rows present, reload list (e.g., new page or empty)
                    if ($('#adTable tr').length === 0) {
                        loadFavorites(currentFilter, 1);
                    }
                });
                return; // no need to reload whole table for unfavorite remove
            }

            // For favorite, reload list (usually won't happen here because they are favorites already)
            loadFavorites(currentFilter, 1);
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                Swal.fire("EliteQuine", "Please login to add favorite.", "error");
            } else {
                alert('Something went wrong.');
            }
        }
    });
});


// Handle pagination link clicks (dynamic content)
$(document).on('click', '#pagination-links .pagination a', function (e) {
    e.preventDefault();
    const url = new URL($(this).attr('href'));
    const page = url.searchParams.get('page');
    loadFavorites(currentFilter, page);
});
</script>
@endsection

@section('style')
<style>
.spinner-border {
    width: 1.5rem;
    height: 1.5rem;
    border-width: 0.2em;
    vertical-align: middle;
    margin-left: 0.5rem;
}

#favorite-content tr {
    transition: all 0.3s ease-in-out;
}

.page-link.active, .active>.page-link {
    z-index: 3;
    color: var(--pagination-active-color);
    background-color: #A19061!important;
    border-color: var(--pagination-active-border-color);
}

.page-item .page-link, .page-item span {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #737373;
    padding: 0;
    margin: 0 3px;
    border-radius: none !important;
    width: 36px;
    height: 36px;
    font-size: 0.875rem;
}

select.form-select {
    appearance: none;
    background-image: none !important;
    padding-right: 2.5rem;
    background-color: #fff;
    padding: 0.5rem 1.2rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    border: 1px solid #EEEEEE;
    /* border-radius: 50px; */
}

.form-select:hover {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.08);
}
</style>
@endsection
