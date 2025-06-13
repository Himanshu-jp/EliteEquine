@extends('admin.app')

@section('title', 'Edit About Seller Business')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">About Seller Business - Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit About Seller Business</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('about-seller-business.update', $business->id) }}" id="sellers_business_edit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card card-primary">
                    <div class="card-body">
                        <!-- title -->
                        {{--<div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $business->title) }}"
                                   class="form-control @error('title') is-invalid @enderror" placeholder="Enter title">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Main Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $business->description) }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>--}}
                        <!-- Image -->
                        <div class="form-group">
                            <label for="image">Main Image</label><br>
                            @if($business->image)
                                <img src="{{ asset('storage/'.$business->image) }}" alt="Main Image" style="max-width: 200px; margin-bottom: 10px;">
                            @endif
                            <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        @php
                            $sections = ['listing' => 'Listing', 'track' => 'Track', 'featured' => 'Featured', 'post' => 'Post'];
                        @endphp

                        @foreach ($sections as $key => $label)
                            <hr>
                            <h5>{{ $label }} Section</h5>

                            <div class="form-group">
                                <label for="{{ $key }}_icon">Icon</label><br>
                                @if($business->{$key.'_icon'})
                                    <img src="{{ asset('storage/'.$business->{$key.'_icon'}) }}" alt="{{ $label }} Icon" style="max-width: 100px; margin-bottom: 10px;">
                                @endif
                                <input type="file" name="{{ $key }}_icon" id="{{ $key }}_icon" class="form-control-file @error($key.'_icon') is-invalid @enderror">
                                @error($key.'_icon')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="{{ $key }}_title">Title</label>
                                <input type="text" name="{{ $key }}_title" id="{{ $key }}_title" value="{{ old($key.'_title', $business->{$key.'_title'}) }}"
                                       class="form-control @error($key.'_title') is-invalid @enderror" placeholder="Enter {{ $label }} title">
                                @error($key.'_title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="{{ $key }}_content">Content</label>
                                <textarea name="{{ $key }}_content" id="{{ $key }}_content" rows="3" class="form-control @error($key.'_content') is-invalid @enderror">{{ old($key.'_content', $business->{$key.'_content'}) }}</textarea>
                                @error($key.'_content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primarys" id="submitBtn">Update</button>
                        <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

<!-- Scripts -->
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

        // Custom validator for CKEditor content required check
        $.validator.addMethod("ckeditorRequired", function(value, element) {
            if (editorInstance) {
                const data = editorInstance.getData().replace(/<[^>]*>/gi, '').trim();
                return data.length !== 0;
            }
            return value.trim().length !== 0;
        }, "This field is required");

        $("#sellers_business_edit").validate({
            ignore: [], // Validate hidden fields like CKEditor textarea
            rules: {
                image: { extension: "jpg|jpeg|png|svg|webp" },
                description: { ckeditorRequired: true, minlength: 10 },
                @foreach ($sections as $key => $label)
                    "{{ $key }}_title": { required: true, maxlength: 255 },
                    "{{ $key }}_content": { required: true, minlength: 5 },
                    "{{ $key }}_icon": { extension: "jpg|jpeg|png|svg|webp" },
                @endforeach
            },
            messages: {
                image: { extension: "Accepted formats: jpg, jpeg, png, svg, webp" },
                description: { 
                    ckeditorRequired: "Description is required",
                    minlength: "Minimum 10 characters"
                },
                @foreach ($sections as $key => $label)
                    "{{ $key }}_title": {
                        required: "{{ $label }} title is required",
                        maxlength: "Maximum 255 characters"
                    },
                    "{{ $key }}_content": {
                        required: "{{ $label }} content is required",
                        minlength: "Minimum 5 characters"
                    },
                    "{{ $key }}_icon": {
                        extension: "Accepted formats: jpg, jpeg, png, svg, webp"
                    },
                @endforeach
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
                if (editorInstance) {
                    editorInstance.updateSourceElement();
                }
                $('#submitBtn').attr('disabled', true).text('Updating...');
                form.submit();
            }
        });

        $('#resetBtn').click(function () {
            $('#sellers_business_edit')[0].reset();

            if (editorInstance) {
                // Safely escape description value for JS string
                const desc = @json(old('description', $business->description));
                editorInstance.setData(desc);
            }

            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').text('');
        });
    });
</script>
