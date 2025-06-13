@extends('admin.app')

@section('title', 'Create Partnership Collaborate')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Partnership Collaborate</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('partner_collaborate.index') }}">Collaborate List</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="d-flex justify-content-end mt-4 mr-4">
                    <a href="{{ route('partner_collaborate.index') }}" class="btn btn-success">Back</a>
                </div>

                <form action="{{ route('partner_collaborate.store') }}" method="POST" id="collaborate_create_form" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="image">Images</label>
                            <input type="file" name="image[]" id="image" multiple
                                   class="form-control-file @error('image') is-invalid @enderror @error('image.*') is-invalid @enderror" accept="image/*" required>
                            @error('image')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                            @error('image.*')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primarys" id="submitBtn">Create Collaborate</button>
                        <button type="reset" class="btn btn-secondary" id="resetBtn">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    // Custom validator for multiple file extensions
    $.validator.addMethod("multiExtension", function(value, element, param) {
        if (element.files.length === 0) return false; // no files selected

        for (let i = 0; i < element.files.length; i++) {
            const ext = element.files[i].name.split('.').pop().toLowerCase();
            if ($.inArray(ext, param.split('|')) === -1) {
                return false;
            }
        }
        return true;
    }, "Please upload valid image files (jpg, jpeg, png, gif, bmp).");

    // Form Validation
    $('#collaborate_create_form').validate({
        rules: {
            'image[]': {
                required: true,
                multiExtension: "jpg|jpeg|png|gif|bmp"
            }
        },
        messages: {
            'image[]': {
                required: "Please upload at least one image"
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

    // Reset form validation states
    $('#resetBtn').on('click', function (e) {
        e.preventDefault();
        $('#collaborate_create_form')[0].reset();
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').text('');
    });
});
</script>
