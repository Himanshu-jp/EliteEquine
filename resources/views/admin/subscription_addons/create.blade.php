@extends('admin.app')

@section('title', 'Create Subscription Plan Addon')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Addon</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('subscription-addons.index') }}">Addon List</a></li>
                        <li class="breadcrumb-item active">Create Addon</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="d-flex justify-content-end mt-4 mr-4">
                            <a href="{{ route('subscription-addons.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <form action="{{ route('subscription-addons.store') }}" id="addon_create_form" method="POST">
                            @csrf
                            <div class="card-body">
                                <!-- Type -->
                                <div class="form-group">
                                    <label for="type">Addon Type</label>
                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                        <option value="">Select Type</option>
                                        @foreach(['boostAd','socialPost','banner','emailPromotion','communityPromotion'] as $option)
                                            <option value="{{ $option }}" {{ old('type') == $option ? 'selected' : '' }}>
                                                {{ ucfirst($option) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Price -->
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" id="price" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Days -->
                                <div class="form-group">
                                    <label for="days">Duration (Days)</label>
                                    <input type="number" name="days" id="days" class="form-control @error('days') is-invalid @enderror" value="{{ old('days') }}">
                                    @error('days') <span class="text-danger">{{ $message }}</span> @enderror
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    let descriptionEditor;

    ClassicEditor.create(document.querySelector('#description'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'link', '|',
            'bulletedList', 'numberedList', '|',
            'blockQuote', 'undo', 'redo'
        ],
        removePlugins: [
            'Image', 'ImageUpload', 'ImageToolbar', 'ImageCaption',
            'MediaEmbed', 'EasyImage', 'ImageInsert',
            'CKBox', 'CKFinder', 'CKFinderUploadAdapter',
            'Video', 'VideoEmbed'
        ]
    })
    .then(editor => {
        descriptionEditor = editor;
    })
    .catch(error => console.error(error));

    // jQuery Validation Setup
    $('#addon_create_form').validate({
        rules: {
            type: { required: true },
            description: { required: true, minlength: 10 },
            price: { required: true, number: true, min: 0 },
            days: { required: true, digits: true, min: 1 }
        },
        messages: {
            type: { required: "Please select an addon type" },
            description: { required: "Enter a description", minlength: "At least 10 characters" },
            price: { required: "Enter a price", number: "Must be numeric", min: "Must be >= 0" },
            days: { required: "Enter duration", digits: "Only whole numbers", min: "Minimum 1 day" }
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
            // Sync CKEditor data to textarea before submit
            $('#description').val(descriptionEditor.getData());

            // Disable the submit button to prevent multiple submits
            $('#submitBtn').prop('disabled', true).text('Submitting...');
            form.submit();
        }
    });

    // Reset Button functionality: reset form and CKEditor content
    $('#resetBtn').click(function () {
        $('#addon_create_form')[0].reset();

        // Clear validation errors and messages
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').text('');

        if (descriptionEditor) {
            descriptionEditor.setData('');
        }
    });
});
</script>
