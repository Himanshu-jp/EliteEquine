@extends('admin.app')
@section('title', 'Category Edit')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Category Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Category List</a></li>
                        <li class="breadcrumb-item active">Category Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="d-flex justify-content-end mt-4 mr-4">
                            <a href="{{ route('categories.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <form id="category_edit" action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $category->name }}" placeholder="Enter name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Image -->
                                <div class="form-group">
                                    <label for="image">Category Image</label><br>
                                    <input type="hidden" name="old_image" value="{{ $category->image }}" />
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" width="80"><br><br>
                                    <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primarys" id="submitBtn">Submit</button>
                                <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(function () {
    // Save default data
    const defaultData = {
        name: @json($category->name)
    };

    // jQuery Validation
    $("#category_edit").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 100
            }
        },
        messages: {
            name: {
                required: "Please enter category name",
                minlength: "Category name must be at least 3 characters",
                maxlength: "Category name must not exceed 100 characters"
            }
        },
        errorElement: 'span',
        errorClass: 'text-danger',
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $('#submitBtn').attr('disabled', true).text('Updating...');
            form.submit();
        }
    });

    // Reset button behavior
    $('#resetBtn').on('click', function () {
        $('#name').val(defaultData.name);
        $('#image').val(null); // Clear file input
    });
});
</script>
