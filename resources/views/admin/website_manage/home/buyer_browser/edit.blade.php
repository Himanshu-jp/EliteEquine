@extends('admin.app')

@section('title', 'Edit Buyer Browser')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Buyer Browser</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="d-flex justify-content-end mt-4 mr-4">
                    <a href="{{ route('buyers.show', $buyer->id) }}" class="btn btn-success">Back</a>
                </div>

                <form action="{{ route('buyers.update', $buyer->id) }}" id="buyer_edit_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $buyer->title) }}" placeholder="Enter title">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Enter description">{{ old('description', $buyer->description) }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            @if($buyer->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $buyer->image) }}" width="150" alt="Current Image">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primarys" id="submitBtn">Update</button>
                        <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

<!-- jQuery, CKEditor, Validation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
    let buyerEditor;

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
            buyerEditor = editor;
        })
        .catch(error => {
            console.error('CKEditor initialization failed:', error);
        });

        $('#buyer_edit_form').validate({
            ignore: [],
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
                image: {
                    extension: "jpg|jpeg|png|webp"
                }
            },
            messages: {
                title: {
                    required: "Please enter a title",
                    minlength: "Title must be at least 3 characters",
                    maxlength: "Title must not exceed 255 characters"
                },
                description: {
                    required: "Please enter a description",
                    minlength: "Description must be at least 10 characters"
                },
                image: {
                    extension: "Only jpg, jpeg, png, or webp files allowed"
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
                $('#description').val(buyerEditor.getData());
                $('#submitBtn').attr('disabled', true).text('Updating...');
                form.submit();
            }
        });

        $('#resetBtn').on('click', function () {
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').text('');
            if (buyerEditor) {
                buyerEditor.setData(`{!! old('description', $buyer->description) !!}`);
            }
        });
    });
</script>
