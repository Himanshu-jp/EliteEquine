@extends('admin.app')

@section('title', 'Create Subscription Plan')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create Subscription Plan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('subscription_plans.index') }}">Subscription Plans List</a></li>
              <li class="breadcrumb-item active">Create Subscription Plan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="d-flex justify-content-end mt-4 mr-4">
                    <a href="{{ route('subscription_plans.index') }}" class="btn btn-success">Back</a>
                </div>
              <!-- form start -->
              <form action="{{ route('subscription_plans.store') }}" id="subscription_create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <!-- Title -->
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Enter plan title">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Subtitle -->
                    <div class="form-group">
                        <label for="subtitle">Subtitle</label>
                        <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle') }}" placeholder="Enter plan subtitle (Optional)">
                        @error('subtitle')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" placeholder="Enter plan price" step="0.01">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Days -->
                    <div class="form-group">
                        <label for="days">Duration (Days)</label>
                        <input type="number" class="form-control @error('days') is-invalid @enderror" id="days" name="days" value="{{ old('days') }}" placeholder="Enter duration in days">
                        @error('days')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Enter description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="">Select Type</option>
                            <option value="standard" {{ old('type') == 'standard' ? 'selected' : '' }}>Standard</option>
                            <option value="featured" {{ old('type') == 'featured' ? 'selected' : '' }}>Featured</option>
                        </select>
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Post Limit -->
                    {{-- <div class="form-group">
                        <label for="post_limit">Post Limit</label>
                        <input type="text" class="form-control @error('post_limit') is-invalid @enderror" id="post_limit" name="post_limit" value="{{ old('post_limit') }}" placeholder="Enter post limit">
                        @error('post_limit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <!-- Image (Optional) -->
                    {{-- <div class="form-group">
                        <label for="image">Plan Image (Optional)</label>
                        <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div> --}}
                </div>
                <!-- /.card-body -->

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
    <!-- /.content -->
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(function () {
    // Form validation
    $("#subscription_create").validate({
        rules: {
            title: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            subtitle: {
                maxlength: 255
            },
            description: {
                required: true,
                minlength: 10
            },
            price: {
                required: true,
                number: true,
                min: 0
            },
            days: {
                required: true,
                number: true,
                min: 1
            },
            type: {
                required: true
            },
            post_limit: {
                required: true,
                digits: true,
                min: 1
            },
            image: {
                extension: "jpg|jpeg|png|webp"
            }
        },
        messages: {
            title: {
                required: "Please enter the plan title",
                minlength: "Title must be at least 3 characters long",
                maxlength: "Title cannot exceed 255 characters"
            },
            subtitle: {
                maxlength: "Subtitle cannot exceed 255 characters"
            },
            description: {
                required: "Please enter the plan description",
                minlength: "Description must be at least 10 characters"
            },
            price: {
                required: "Please enter the plan price",
                number: "Price must be a valid number",
                min: "Price cannot be negative"
            },
            days: {
                required: "Please enter the duration in days",
                number: "Duration must be a valid number",
                min: "Duration must be at least 1 day"
            },
            type: {
                required: "Please select the plan type"
            },
            post_limit: {
                required: "Please enter the post limit",
                digits: "Post limit must be a whole number",
                min: "Post limit must be at least 1"
            },
            image: {
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
            $('#submitBtn').prop('disabled', true).text('Submitting...');
            form.submit();
        }
    });
});

$(document).ready(function() {
    let editorInstance;

    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'undo', 'redo'
            ]
        })
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // Reset button functionality
    $('#resetBtn').click(function () {
        $('#subscription_create')[0].reset();

        if (editorInstance) {
            editorInstance.setData(`{!! old('description') ? old('description') : '' !!}`);
        }

        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').text('');
    });

    // Cancel button (if used)
    $('#cancelBtn').click(function (e) {
        e.preventDefault();
        window.location.href = "{{ route('subscription_plans.index') }}";
    });
});
</script>
