@extends('admin.app')

@section('title', 'Create Buyer FAQ')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Buyer FAQ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('buyer-faqs.index') }}">FAQ List</a></li>
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
                    <a href="{{ route('buyer-faqs.index') }}" class="btn btn-success">Back</a>
                </div>

                <form action="{{ route('buyer-faqs.store') }}" method="POST" id="buyer_create_form">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="question">Question</label>
                            <input type="text" name="question" id="question" class="form-control @error('question') is-invalid @enderror"
                                   value="{{ old('question') }}" placeholder="Enter question" required>
                            @error('question')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="answer">Answer</label>
                            <textarea name="answer" id="answer" rows="5" class="form-control @error('answer') is-invalid @enderror"
                                      placeholder="Enter answer" required>{{ old('answer') }}</textarea>
                            @error('answer')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primarys" id="submitBtn">Create FAQ</button>
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
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
    let buyerEditor;

    $(document).ready(function () {
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#answer'), {
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
                console.error('CKEditor error:', error);
            });

        // Form Validation
        $('#buyer_create_form').validate({
            ignore: [],
            rules: {
                question: {
                    required: true,
                    minlength: 5,
                    maxlength: 255
                },
                answer: {
                    required: function () {
                        return buyerEditor.getData().trim() === '';
                    },
                    minlength: 10
                }
            },
            messages: {
                question: {
                    required: "Please enter a question",
                    minlength: "Minimum 5 characters",
                    maxlength: "Maximum 255 characters"
                },
                answer: {
                    required: "Please enter an answer",
                    minlength: "Answer must be at least 10 characters"
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
                $('#answer').val(buyerEditor.getData()); // sync CKEditor data
                $('#submitBtn').attr('disabled', true).text('Submitting...');
                form.submit();
            }
        });

        // Reset form and CKEditor
        $('#resetBtn').on('click', function (e) {
            e.preventDefault();
            $('#buyer_create_form')[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('.text-danger').text('');
            if (buyerEditor) {
                buyerEditor.setData('');
            }
        });
    });
</script>
