@extends('admin.app')

@section('title', 'Product List')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Product List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Product List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('products.index') }}" class="mb-3">
                                <div class="form-row align-items-center">
                                    <!-- Category Filter -->
                                    <div class="col-auto mb-2">
                                        <select name="category_id" id="categorySelect" class="form-control form-control-sm">
                                            <option value="">Filter by Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Subcategory Filter -->
                                    <div class="col-auto mb-2">
                                        <select name="subcategory_id" id="subcategorySelect" class="form-control form-control-sm {{ request()->subcategory_id ? '' : 'd-none' }}" style="min-width:180px;">
                                            <option value="">Filter by Subcategory</option>
                                            @foreach($subcategories as $subcategory) 
                                                <option value="{{ $subcategory->id }}" {{ request('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                                    {{ $subcategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- User Filter -->
                                    <div class="col-auto mb-2">
                                        <select name="user_id" class="form-control form-control-sm select2" style="min-width:180px;">
                                            <option value="">Filter by User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Feature Filter -->
                                    <div class="col-auto mb-2">
                                        <select name="feature" class="form-control form-control-sm" style="min-width:100px;">
                                            <option value="" >Filter by Feature</option>
                                            <option value="0" {{ request('feature') == '0' ? 'selected' : '' }}>Not Featured</option>
                                            <option value="1" {{ request('feature') == '1' ? 'selected' : '' }}>Featured</option>
                                        </select>
                                    </div>

                                    <!-- Status Filter -->
                                    <div class="col-auto mb-2">
                                        <select name="status" class="form-control form-control-sm" style="min-width:80px;">
                                            <option value="">Filter by Status</option>
                                            <option value="live" {{ request('status') == 'live' ? 'selected' : '' }}>Live</option>
                                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                                            <option value="expire" {{ request('status') == 'expire' ? 'selected' : '' }}>Expired</option>
                                        </select>
                                    </div>

                                    <!-- Title Search -->
                                    <div class="col-auto mb-2">
                                        <input type="text" name="title" value="{{ request('title') }}" class="form-control form-control-sm" placeholder="Search by Title" style="width: 200px;">
                                    </div>

                                    <!-- Buttons -->
                                    <div class="col-auto mb-2">
                                        <button type="submit" class="btn btn-primarys btn-sm mr-1">Filter</button>
                                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <!-- Product Table -->
                            <table id="productTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>User</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Subcategory</th>
                                        <th>Feature</th>
                                        <th>Price</th>
                                        <th>Currency</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $key => $product)
                                        <tr>
                                            <td>{{ $products->firstItem() + $key }}</td>
                                            <td>{{ optional($product->user)->name ?? 'N/A' }}</td>
                                            <td>{{ $product->title }}</td>
                                            <td>{{ optional($product->category)->name ?? 'N/A' }}</td>
                                            <td>{{ optional($product->subcategory)->name ?? 'N/A' }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="toggle-status" data-id="{{ $product->id }}" data-category-id="{{$product->category_id}}"
                                                    data-url="{{ route('products.toggleStatus', [$product->id, $product->category_id]) }}"
                                                    {{ $product->feature ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->currency }}</td>
                                            <td>{{ $product->product_status ? ucfirst($product->product_status) : 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>  
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="10" class="text-center">No products found</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- Pagination -->
                            <div class="d-flex mt-3 justify-content-end">
                                {{ $products->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Uncomment below if you want Select2 functionality -->
<!-- 
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
-->

<script>
$(document).ready(function () {
    // Initialize Select2 if needed
    // $('.select2').select2({ placeholder: 'Select User', allowClear: true });

    $('#productTable').DataTable({
        paging: false,
        lengthChange: false,
        searching: false,
        ordering: true,
        columnDefs: [{ orderable: false, targets: [5,8,9] }],
        info: true,
        autoWidth: false,
        responsive: true
    });
    $(".dataTables_info").html(
        'Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries'
    );
    // Load subcategories based on category selection
    $('#categorySelect').on('change', function () {
        let categoryId = $(this).val();

        if (categoryId === '') {
            $("#subcategorySelect").addClass('d-none').empty().append('<option value="">Filter by Subcategory</option>');
            return;
        }

        let url = '{{ url("admin/products/subcategory") }}/' + categoryId;

        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                let $subcategorySelect = $('#subcategorySelect');
                $subcategorySelect.removeClass('d-none').css('display', 'block');
                $subcategorySelect.empty();
                $subcategorySelect.append('<option value="">Filter by Subcategory</option>');

                data.subcategories.forEach(function (subcategory) {
                    $subcategorySelect.append(
                        '<option value="' + subcategory.id + '">' +
                        subcategory.name +
                        '</option>'
                    );
                });
            },
            error: function () {
                alert('Failed to fetch Subcategory');
            }
        });
    });

    $(window).on('load', function() {
        let categoryId = $('#categorySelect').val();

        if (categoryId === '') {
            $("#subcategorySelect").addClass('d-none').empty().append('<option value="">Filter by Subcategory</option>');
            return;
        }

        let url = '{{ url("admin/products/subcategory") }}/' + categoryId;

        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                let $subcategorySelect = $('#subcategorySelect');
                $subcategorySelect.removeClass('d-none').css('display', 'block');
                $subcategorySelect.empty();
                $subcategorySelect.append('<option value="">Filter by Subcategory</option>');

                data.subcategories.forEach(function (subcategory) {
                    let selected = '';
                    if(subcategory.id == '{{request()->subcategory_id}}')
                    {
                        selected = 'selected';
                    }
                    $subcategorySelect.append(
                        '<option value="' + subcategory.id + '" '+selected+'>' +
                        subcategory.name +
                        '</option>'
                    );
                });
            },
            error: function () {
                alert('Failed to fetch Subcategory');
            }
        });
    });

    // Toggle feature status with limit check
    $('.toggle-status').on('change', function () {
        const isChecked = $(this).is(':checked');
        const productId = $(this).data('id');
        const categoryId = $(this).data('category-id');
        const toggleUrl = $(this).data('url');
        const $thisCheckbox = $(this);

        if (isChecked) {
            // Check count of currently featured products
            $.ajax({
                url: "{{ url('admin/products/count-feature') }}/"+categoryId,
                method: 'GET',
                success: function (res) {
                    if (res.count >= 10) {
                        Swal.fire("EliteQuine", "You can only feature a maximum of 10 products.", "error");
                        $thisCheckbox.prop('checked', false); // revert change
                    } else {
                        toggleFeature(toggleUrl);
                    }
                }
            });
        } else {
            toggleFeature(toggleUrl);
        }

        function toggleFeature(url) {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if(response.success == false)
                    {
                        Swal.fire("EliteQuine", response.message, "error");
                    }

                    if(response.success == true)
                    {
                        Swal.fire("EliteQuine", response.message, "success");
                    }

                },
                error: function () {
                    alert('Failed to update feature status.');
                }
            });
        }
    });
});
</script>
