@extends('admin.app')
@section('title', 'Sub-Category Create')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sub-Category Create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sub-categories.index') }}">Sub-Category List</a></li>
                        <li class="breadcrumb-item active">Sub-Category Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="d-flex justify-content-end mt-4 mr-4">
                            <a href="{{ route('sub-categories.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <form action="{{ route('sub-categories.store') }}" id="subcategory_create" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" placeholder="Enter name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

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
$(document).ready(function () {
    // Save initial form state
    const defaultData = {
        name: @json(old('name')),
        category_id: @json(old('category_id'))
    };

    // jQuery Validation
    $("#subcategory_create").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            category_id: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter sub-category name",
                minlength: "Sub-category name must be at least 3 characters",
                maxlength: "Sub-category name must not exceed 100 characters"
            },
            category_id: {
                required: "Please select a category"
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
            $('#submitBtn').attr('disabled', true).text('Submitting...');
            form.submit();
        }
    });

    // Reset form to default values
    $('#resetBtn').click(function () {
        $('#name').val(defaultData.name);
        $('#category_id').val(defaultData.category_id);
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').text('');
    });
});
</script>
