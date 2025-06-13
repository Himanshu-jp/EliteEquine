@extends('admin.app')
@section('title', 'Category Create')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Category Create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Category List</a></li>
                        <li class="breadcrumb-item active">Category Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Form Column -->
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="d-flex justify-content-end mt-4 mr-4">
                            <a href="{{ route('categories.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <form action="{{ route('categories.store') }}" id="category_create" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Image -->
                                <div class="form-group">
                                    <label for="image">Category Image</label>
                                    <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                                    @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Footer Buttons -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primarys" id="submitBtn">Submit</button>
                                <button type="reset" class="btn btn-secondary" id="resetBtn">Reset</button>
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
    $("#category_create").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            image: {
                required: true,
                extension: "jpg|jpeg|png|webp"
            }
        },
        messages: {
            name: {
                required: "Please enter category name",
                minlength: "Category name must be at least 3 characters",
                maxlength: "Category name must not exceed 100 characters"
            },
            image: {
                required: "Please upload a category image",
                extension: "Only jpg, jpeg, png, or webp images are allowed"
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

    // Reset button clears file input display
    $('#resetBtn').click(function () {
        $('#image').val('');
    });
});
</script>
