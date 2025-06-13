@extends('admin.app')

@section('title', 'Blog Edit')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Blog Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Blogs List</a></li>
                        <li class="breadcrumb-item active">Blog Edit</li>
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
                            <a href="{{ route('blogs.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <form action="{{ route('blogs.update', $blog->id) }}" id="blog_edit" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title"
                                           value="{{ old('title', $blog->title) }}"
                                           placeholder="Enter blog title">
                                    @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <!-- Category -->
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" id="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <!-- Content -->
                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                              id="content" name="content" rows="5">{{ old('content', $blog->content) }}</textarea>
                                    @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>

                                <!-- Image -->
                                <div class="form-group">
                                    <label for="image">Blog Image</label>
                                    <input type="file" name="image" id="image"
                                           class="form-control-file @error('image') is-invalid @enderror">
                                    @if ($blog->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" width="150">
                                        </div>
                                    @endif
                                    @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <!-- Buttons -->
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
let blogEditor;
const defaultData = {
    title: @json(old('title', $blog->title)),
    category_id: @json(old('category_id', $blog->category_id)),
    content: @json(old('content', $blog->content))
};

$(document).ready(function () {
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
        blogEditor = editor;
    })
    .catch(error => {
        console.error('CKEditor initialization failed:', error);
    });

    // jQuery Validation
    $("#blog_edit").validate({
        rules: {
            title: { required: true, minlength: 3, maxlength: 255 },
            category_id: { required: true },
            content: { required: true, minlength: 10 },
            image: { extension: "jpg|jpeg|png|webp" }
        },
        messages: {
            title: {
                required: "Please enter the blog title",
                minlength: "Title must be at least 3 characters",
                maxlength: "Title cannot exceed 255 characters"
            },
            category_id: { required: "Please select a category" },
            content: {
                required: "Please enter blog content",
                minlength: "Content must be at least 10 characters"
            },
            image: { extension: "Only jpg, jpeg, png, or webp allowed" }
        },
        errorElement: 'span',
        errorClass: 'text-danger',
        highlight: function (element) { $(element).addClass('is-invalid'); },
        unhighlight: function (element) { $(element).removeClass('is-invalid'); },
        submitHandler: function (form) {
            if (blogEditor) {
                $('#content').val(blogEditor.getData());
            }

            // Disable submit button after first click
            $('#submitBtn').attr('disabled', true).text('Updating...');
            form.submit();
        }
    });

    // Reset button functionality
    $('#resetBtn').click(function () {
        // Reset form fields to defaultData values
        $('#title').val(defaultData.title);
        $('#category_id').val(defaultData.category_id);

        if (blogEditor) {
            blogEditor.setData(defaultData.content);
        }

        // Clear validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').text('');
    });
});
</script>
