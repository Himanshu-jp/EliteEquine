@extends('admin.app')

@section('title', 'CMS Page Edit')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CMS Page Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cms_pages.index') }}">CMS Pages List</a></li>
                        <li class="breadcrumb-item active">CMS Page Edit</li>
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
                            <a href="{{ route('cms_pages.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <form action="{{ route('cms_pages.update', $page->id) }}" id="page_edit" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Title</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name', $page->name) }}"
                                           placeholder="Enter page title">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                              id="content" name="content" rows="6"
                                              placeholder="Enter page content">{{ old('content', $page->content) }}</textarea>
                                    @error('content')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- <div class="form-group">
                                    <label for="image">Page Image (Optional)</label>
                                    <input type="file" name="image" id="image"
                                           class="form-control-file @error('image') is-invalid @enderror">
                                    @if ($page->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $page->image) }}" alt="Page Image" width="150">
                                        </div>
                                    @endif
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div> --}}
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
    let pageEditor;

    $(document).ready(function () {
        // Initialize CKEditor
       ClassicEditor.create(document.querySelector('#content'), {
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
    pageEditor = editor;
})
.catch(error => {
    console.error('CKEditor initialization failed:', error);
});


        // jQuery Validation
        $('#page_edit').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                content: {
                    required: true,
                    minlength: 10
                },
                image: {
                    extension: "jpg|jpeg|png|webp"
                }
            },
            messages: {
                name: {
                    required: "Please enter the page title",
                    minlength: "Title must be at least 3 characters",
                    maxlength: "Title cannot exceed 255 characters"
                },
                content: {
                    required: "Please enter the page content",
                    minlength: "Content must be at least 10 characters"
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
                if (pageEditor) {
                    $('#content').val(pageEditor.getData());
                }
                $('#submitBtn').attr('disabled', true).text('Updating...');
                form.submit();
            }
        });

        // Reset Form
        $('#resetBtn').click(function () {
            $('#page_edit')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').text('');

            if (pageEditor) {
                pageEditor.setData(`{!! old('content', $page->content) !!}`);
            }
        });
    });
</script>
