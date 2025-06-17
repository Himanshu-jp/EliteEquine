@extends('admin.app')

@section('title', 'Edit Subscription Plan')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Subscription Plan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('subscription_plans.index') }}">Subscription Plans List</a></li>
              <li class="breadcrumb-item active">Edit Subscription Plan</li>
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
                    <a href="{{ route('subscription_plans.index') }}" class="btn btn-success">Back</a>
                </div>
              <form action="{{ route('subscription_plans.update', $subscriptionPlan->id) }}" id="subscription_edit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <!-- Title -->
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $subscriptionPlan->title) }}" placeholder="Enter subscription plan title">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Subtitle -->
                    <div class="form-group">
                        <label for="subtitle">Subtitle</label>
                        <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle', $subscriptionPlan->subtitle) }}" placeholder="Enter subscription plan subtitle (Optional)">
                        @error('subtitle')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $subscriptionPlan->price) }}" placeholder="Enter subscription plan price" step="0.01">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Duration (Days) -->
                    <div class="form-group">
                        <label for="days">Duration (Days)</label>
                        <input type="number" class="form-control @error('days') is-invalid @enderror" id="days" name="days" value="{{ old('days', $subscriptionPlan->days) }}" placeholder="Enter subscription plan duration in days">
                        @error('days')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Enter description">{{ old('description', $subscriptionPlan->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                            <option value="">Select Type</option>
                            <option value="standard" {{ old('type', $subscriptionPlan->type) == 'standard' ? 'selected' : '' }}>Standard</option>
                            <option value="featured" {{ old('type', $subscriptionPlan->type) == 'featured' ? 'selected' : '' }}>Featured</option>
                        </select>
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Post Limit -->
                    {{-- <div class="form-group">
                        <label for="post_limit">Post Limit</label>
                        <input type="text" class="form-control @error('post_limit') is-invalid @enderror" id="post_limit" name="post_limit" value="{{ old('post_limit', $subscriptionPlan->post_limit) }}" placeholder="Enter post limit">
                        @error('post_limit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}

                    <!-- Image (Optional) -->
                    <div class="form-group">
                        <label for="image">Plan Image (Optional)</label>
                        <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                        @if ($subscriptionPlan->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $subscriptionPlan->image) }}" alt="Plan Image" width="150">
                            </div>
                        @endif
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primarys" id="submitBtn">Update</button>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(function () {
    let descriptionEditor;

    // jQuery Validation
    $("#subscription_edit").validate({
        rules: {
            title: {
                required: true,
                minlength: 3,
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
            post_limit: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            image: {
                extension: "jpg|jpeg|png|webp"
            }
        },
        messages: {
            title: {
                required: "Please enter the subscription plan title",
                minlength: "Title must be at least 3 characters long",
                maxlength: "Title cannot exceed 255 characters"
            },
            description: {
                required: "Please enter the subscription plan description",
                minlength: "Description must be at least 10 characters"
            },
            price: {
                required: "Please enter the subscription plan price",
                number: "Price must be a valid number",
                min: "Price cannot be negative"
            },
            days: {
                required: "Please enter the duration in days",
                number: "Duration must be a valid number",
                min: "Duration must be at least 1 day"
            },
            post_limit: {
                required: "Please enter the post limit",
                minlength: "Post limit must be at least 3 characters long",
                maxlength: "Post limit cannot exceed 255 characters"
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
        submitHandler: function(form) {
            // Sync CKEditor data before submit
            if (descriptionEditor) {
                $('#description').val(descriptionEditor.getData());
            }
            $('#submitBtn').attr('disabled', true).text('Updating...');
            form.submit();
        }
    });

    // Initialize CKEditor with image/video/media plugins disabled
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'undo', 'redo'
            ],
            removePlugins: [
                'Image', 'ImageUpload', 'ImageToolbar', 'ImageCaption',
                'MediaEmbed', 'EasyImage', 'ImageInsert',
                'CKBox', 'CKFinder', 'CKFinderUploadAdapter'
            ]
        })
        .then(editor => {
            descriptionEditor = editor;
        })
        .catch(error => {
            console.error('CKEditor initialization error:', error);
        });

    // Store original data for reset
    const defaultData = {
        title: @json(old('title', $subscriptionPlan->title)),
        subtitle: @json(old('subtitle', $subscriptionPlan->subtitle)),
        price: @json(old('price', $subscriptionPlan->price)),
        days: @json(old('days', $subscriptionPlan->days)),
        description: @json(old('description', $subscriptionPlan->description)),
        type: @json(old('type', $subscriptionPlan->type)),
        post_limit: @json(old('post_limit', $subscriptionPlan->post_limit))
    };

    // Reset Button: Reset form and CKEditor to original values
    $('#resetBtn').click(function() {
        // Reset form fields except file inputs
        $('#subscription_edit')[0].reset();

        // Reset selects manually
        $('#type').val(defaultData.type);

        // Reset CKEditor content
        if (descriptionEditor) {
            descriptionEditor.setData(defaultData.description);
        }

        // Remove validation error messages and classes
        $('#subscription_edit')
            .find('.is-invalid').removeClass('is-invalid').end()
            .find('span.text-danger').text('');
    });

    // Optional: Disable submit button on submit to prevent multiple submissions
    $("#subscription_edit").on('submit', function() {
        $('#submitBtn').attr('disabled', true).text('Updating...');
    });
});
</script>

