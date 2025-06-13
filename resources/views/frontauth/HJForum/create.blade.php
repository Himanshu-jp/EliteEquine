@extends('frontauth.layouts.main')
@section('title')
Hj Forum
@endsection
@section('content')


@php
if(isset($forum)) {
    $function = route('hjForum.update', $forum->id);
    $method = "POST";
    $button = "Update";
    $title = "Hj Forum - Update Record";
}
else{
    $function = route('hjForum.store');
    $method = "POST";
    $button = "Submit";
    $title = "Hj Forum - Add Record";
}
@endphp


<div class="container-fluid mt-4">
    <div class="ms-0 mb-3  d-flex align-items-center justify-content-between flex-wrap">
        <h4 class="h5 font-weight-bolder">{{$title}}</h4>
    </div>

    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    <form action="{{$function}}" method="{{$method}}" enctype="multipart/form-data" id="hjForm">
        @csrf
        @if(isset($forum))
            @method('PUT')
        @endif
        <div class="row">
            <input type="hidden" name="id" value="{{@$forum->id}}">
            <div class="col-lg-12">

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" autocomplete="off" class="inner-form form-control mb-0" id="title" name="title"
                        value="{{old('title', @$forum->title)}}" placeholder="Short and Sweet Name only is Preferred">
                    @if($errors->has('title'))
                        <span class="error text-danger">{{$errors->first('title')}}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <div class="file-upload ">
                            <div class="profile mt-2">
                            <img src="{{(@$forum->image)?asset('storage/'.@$forum->image):asset('front/auth/assets/img/icons/image.svg')}}" class="user-img" alt="" id="editImg">
                        </div>
                        <input type="file" id="image" name="image" multiple style="display: none; cursor: pointer;"
                            onchange="handleImageUpload(event)" accept=".png, .jpg, .jpeg">

                        <h5 class="pt-3">Select Images </h5>
                        <a href="#" class="upload-image">
                            <h6 id="uploadTriggerImage">Browse File</h6>
                        </a>

                    </div>
                    {{-- @if (@$forum && @$forum->image)
                        <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap mt-2">
                            <div class="position-relative">
                                <a href="{{ asset('storage/' . $forum->image) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $forum->image) }}" alt="Image" class="img-thumbnail" style="width: 150px;">
                                </a>
                                <span class="close-icon">&times;</span>
                            </div>
                        </div>

                    @endif --}}
                    @if($errors->has('image'))
                        <span class="error text-danger">{{$errors->first('image')}}</span>
                    @endif
                </div>

                <div>
                    <label for="description" class="form-label">Description </label>
                    <textarea class="inner-form form-control" id="description" name="description" rows="8" placeholder="Enter product details here...">{{old('description', @$forum->description)}}</textarea>
                        @if($errors->has('description'))
                        <span class="error text-danger">{{$errors->first('description')}}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="text-end my-3">
            <button type="submit" class="btn btn-primary" id="hj-form-submit">{{$button}}</button>
            @if(isset($forum))
                <a href="{{ route('hjForum.index') }}">
                    <button type="button" class="btn btn-secondary" id="hj-form-submit">Cancel</button>
                </a>
            @else
                <button type="reset" class="btn btn-secondary" id="hj-form-submit">Reset</button>
            @endif
        </div>
    </form>


</div>
<style>
.upload-image {
    cursor: pointer;
}

/* .file-upload input[type="file"] {
    display: none;
} */

.file-upload input[type="file"] {
    position: absolute;
    opacity: 0;
    width: 1px;
    height: 1px;
    z-index: -1;
}


</style>

@endsection

@section('script')



<script>
// document.getElementById('plusIcon').addEventListener('click', function() {
//     // Yahan pe aap file upload ya koi bhi action likh sakte ho
//     alert('Plus icon clicked!');
// });

const uploadTriggerImage = document.getElementById('uploadTriggerImage');
const fileInputImage = document.getElementById('image');

uploadTriggerImage.addEventListener('click', () => {
    // alert('Image trigger clicked!');
    fileInputImage.click();
});

const uploadTriggerVideo = document.getElementById('uploadTriggerVideo');
const fileInputVideo = document.getElementById('video');

uploadTriggerVideo.addEventListener('click', () => {
    // alert('Video trigger clicked!');
    fileInputVideo.click();
});

const uploadTriggerDocument = document.getElementById('uploadTriggerDocument');
const fileInputDocument = document.getElementById('document');

uploadTriggerDocument.addEventListener('click', () => {
    // alert('Document trigger clicked!');
    fileInputDocument.click();
});


function handleImageUpload(event) {
    const file = event.target.files[0];
    if (file) {
        // Optional: Show preview
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('editImg').src = e.target.result;
        };
        reader.readAsDataURL(file);

        // You can also upload the file via AJAX or FormData here
        console.log("Image selected:", file.name);
    }
}

function handleVideoUpload(event) {
    const file = event.target.files[0];
    if (file) {
        // Optional: Show preview
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('editVideo').src = e.target.result;
        };
        reader.readAsDataURL(file);

        // You can also upload the file via AJAX or FormData here
        console.log("Video selected:", file.name);
    }
}

function handleVideoDocument(event) {
    const file = event.target.files[0];
    if (file) {
        // Optional: Show preview
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('editDocument').src = e.target.result;
        };
        reader.readAsDataURL(file);

        // You can also upload the file via AJAX or FormData here
        console.log("Document selected:", file.name);
    }
}

</script>

<script>
    $.validator.addMethod('filesize', function (value, element, param) {
        if (element.files.length === 0) return true;
        for (let i = 0; i < element.files.length; i++) {
            if (element.files[i].size > param) return false;
        }
        return true;
    }, 'File size must be less than specified.');

    $.validator.addMethod("fileRequired", function (value, element) {
        return element.files.length > 0;
    }, "Please upload at least one image.");

    $("#hjForm").validate({
        rules: {
            title: {
                required: true,
                maxlength: 500
            },
            image: {
                required: true,
                // fileRequired: true,
                extension: "jpg|jpeg|png",
                filesize: 4 * 1024 * 1024 // 4 MB
            },
            description: {
                required: true,
                maxlength: 5000
            }
        },
        messages: {
            title: {
                required: "Title is required.",
                maxlength: "Title may not be greater than 500 characters."
            },
            image: {
                required: "Please upload image.",
                extension: "Images must be of type jpeg, png, or jpg.",
                filesize: "Each image must not exceed 4MB."
            },
            description: {
                required: "Description is required.",
                maxlength: "Description may not be greater than 5000 characters."
            }
        },
        errorClass: 'error text-danger',
        errorElement: 'span',

        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $('#hj-form-submit').prop('disabled', true).text('Please wait...');
            form.submit();
        }
    });

</script>

@endsection