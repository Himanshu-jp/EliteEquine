@extends('admin.app')

@section('title', 'Edit Subscription Addon')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Addon</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('subscription-addons.index') }}">Addon List</a></li>
                        <li class="breadcrumb-item active">Edit Addon</li>
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
                            <a href="{{ route('subscription-addons.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <form action="{{ route('subscription-addons.update', $addon->id) }}" id="addon_edit" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                <!-- Type -->
                                <div class="form-group">
                                    <label for="type">Addon Type</label>
                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                        <option value="">Select Type</option>
                                        @foreach(['boostAd','socialPost','banner','emailPromotion','communityPromotion'] as $option)
                                            <option value="{{ $option }}" {{ old('type', $addon->type) == $option ? 'selected' : '' }}>
                                                {{ ucfirst($option) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description', $addon->description) }}</textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Price -->
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" id="price" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $addon->price) }}">
                                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <!-- Days -->
                                <div class="form-group">
                                    <label for="days">Duration (Days)</label>
                                    <input type="number" name="days" id="days" class="form-control @error('days') is-invalid @enderror" value="{{ old('days', $addon->days) }}">
                                    @error('days') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    let descriptionEditor;

    ClassicEditor.create(document.querySelector('#descriptions'), {
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

    $('#addon_edit').validate({
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
            // Sync CKEditor content before submit
            $('#description').val(descriptionEditor.getData());

            // Disable submit button to avoid multiple clicks
            $('#submitBtn').prop('disabled', true).text('Updating...');
            form.submit();
        }
    });

    $('#resetBtn').click(function () {
        // Reset form fields to original values (preserve old inputs from server)
        $('#addon_edit')[0].reset();

        // Clear validation error classes and messages
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').text('');

        // Reset CKEditor content to original description
        if (descriptionEditor) {
            descriptionEditor.setData(@json(old('description', $addon->description)));
        }
    });
});
</script>
