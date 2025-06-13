@extends('admin.app')

@section('title', 'Edit Partnership Way')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Partnership Ways - Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('partner_ways.index') }}">Partnership Ways List</a></li>
                        <li class="breadcrumb-item active">Edit Way</li>
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
                            <a href="{{ route('partner_ways.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <form action="{{ route('partner_ways.update', $way->id) }}" id="partnership_way_edit" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title">Way Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{ old('title', $way->title) }}" placeholder="Enter way title">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4">{{ old('description', $way->description) }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Link -->
                                <div class="form-group">
                                    <label for="link">Link</label>
                                    <input type="url" class="form-control @error('link') is-invalid @enderror" name="link" id="link" value="{{ old('link', $way->link) }}" placeholder="Enter URL (e.g. https://example.com)">
                                    @error('link')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Image -->
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                                    @if($way->image)
                                        <div class="mt-2">
                                            <strong>Current:</strong><br>
                                            <img src="{{ asset('storage/' . $way->image) }}" alt="Current Image" width="100" height="100">
                                        </div>
                                    @endif
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
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

<!-- jQuery & CKEditor -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
    let editorInstance;

    $(document).ready(function () {
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
                'CKBox', 'CKFinder', 'CKFinderUploadAdapter'
            ]
        })
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => {
            console.error('CKEditor initialization failed:', error);
        });

        $("#partnership_way_edit").validate({
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
                link: {
                    url: true,
                    maxlength: 255
                },
                image: {
                    extension: "jpg|jpeg|png|svg|webp"
                }
            },
            messages: {
                title: {
                    required: "Please enter a way title",
                    minlength: "At least 3 characters required",
                    maxlength: "Cannot exceed 255 characters"
                },
                description: {
                    required: "Please enter a description",
                    minlength: "At least 10 characters required"
                },
                link: {
                    url: "Please enter a valid URL",
                    maxlength: "Cannot exceed 255 characters"
                },
                image: {
                    extension: "Only jpg, jpeg, png, svg, or webp formats allowed"
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

        // Reset form
        $('#resetBtn').click(function () {
            $('#partnership_way_edit')[0].reset();
            if (editorInstance) {
                editorInstance.setData(`{!! old('description', $way->description) !!}`);
            }
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').text('');
        });
    });
</script>
