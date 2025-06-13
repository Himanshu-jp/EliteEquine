@extends('frontauth.layouts.main')
@section('title')
Community & Events
@endsection
@section('content')


@php
if(isset($community)) {
    $function = route('community.update', $community->id);
    $method = "POST";
    $button = "Update";
    $title = "Community & Events - Update Record";
}
else{
    $function = route('community.store');
    $method = "POST";
    $button = "Submit";
    $title = "Community & Events - Add Record";
}
@endphp
<div class="container-fluid mt-4">
    <div class="ms-0 d-flex align-items-center justify-content-between flex-wrap">
        <h4 class="h5 font-weight-bolder">{{$title}}</h4>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{$function}}" method="{{$method}}" enctype="multipart/form-data" id="communityEvents">
        @csrf
        @if(isset($community))
            @method('PUT')
        @endif
        <input type="hidden" name="id" value="{{@$community->id}}">

        <div class="row">
            <div class="col-md-6 mt-3 position-relative">
                <label for="title" class="form-label">Title</label>
                <input type="text" autocomplete="off" class="inner-form form-control mb-0" id="title" name="title"
                    value="{{old('title', @$community->title)}}" placeholder="Short and Sweet Name only is Preferred">
                @if($errors->has('title'))
                    <span class="error text-danger">{{$errors->first('title')}}</span>
                @endif
            </div>
            
            <div class="col-md-6 mt-3 position-relative">
                <label for="requirement" class="form-label">Requirements</label>
                <input type="text" autocomplete="off" class="inner-form form-control mb-0" id="requirement" name="requirement"
                    value="{{old('requirement', @$community->requirement)}}" placeholder="Enter requirement here">
                @if($errors->has('requirement'))
                    <span class="error text-danger">{{$errors->first('requirement')}}</span>
                @endif
            </div>

            <div class="col-md-4 mt-4">
                <label for="exampleFormControlInput1" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="inner-form form-control mb-0 datepicker" placeholder="Date" autocomplete="off" value="{{old('date', @$community->date)}}">
                @if($errors->has('date'))
                    <span class="error text-danger">{{$errors->first('date')}}</span>
                @endif
            </div>


            <div class="col-md-4 mt-3">
                <label for="exampleFormControlInput1" class="form-label">Time</label>
                <input type="time" class="inner-form form-control mb-0" name="time" id="time" placeholder="Time" value="{{old('time', @$community->time)}}" autocomplete="off">
                @if($errors->has('time'))
                    <span class="error text-danger">{{$errors->first('time')}}</span>
                @endif
            </div>
            
            <div class="col-md-4 mt-3">
                <label for="price" class="form-label">Price</label>
                <input type="price" class="inner-form form-control mb-0 numbervalid" name="price" id="price" placeholder="Enter Price" value="{{old('price', @$community->price)}}" autocomplete="off">
                @if($errors->has('price'))
                    <span class="error text-danger">{{$errors->first('price')}}</span>
                @endif
            </div>

            <div class="col-md-6 mt-3">
                <label for="exampleFormControlInput1" class="form-label">Event Around Horse Show: [user input horse hub]</label>
                <input type="text" name="event_around" id="event_around" class="inner-form form-control mb-0" placeholder="Enter your input here." value="{{old('event_around', @$community->event_around)}}" autocomplete="off">
                @if($errors->has('event_around'))
                    <span class="error text-danger">{{$errors->first('event_around')}}</span>
                @endif
            </div>
            
            <div class="col-md-6 mt-3">
                <label for="location" class="form-label">Event Location</label>
                <input type="text" name="location" id="location" class="inner-form form-control mb-0" placeholder="Enter location here." value="{{old('location', @$community->location)}}" autocomplete="off">
                @if($errors->has('location'))
                    <span class="error text-danger">{{$errors->first('location')}}</span>
                @endif
            </div>

             <div class="col-md-12 mt-3 mb-3">  
                <label for="image" class="form-label">Image</label>
                <div class="file-upload ">
                        <div class="profile mt-2">
                        <img src="{{(@$community->image)?asset('storage/'.@$community->image):asset('front/auth/assets/img/icons/image.svg')}}" class="user-img" alt="" id="editImg">
                    </div>
                    <input type="file" id="image" name="image" multiple style="display: none; cursor: pointer;"
                        onchange="handleImageUpload(event)" accept=".png, .jpg, .jpeg">

                    <h5 class="pt-3">Select Images </h5>
                    <a href="#" class="upload-image">
                        <h6 id="uploadTriggerImage">Browse File</h6>
                    </a>
                </div>

                @if($errors->has('image'))
                    <span class="error text-danger">{{$errors->first('image')}}</span>
                @endif
            </div>

        
        </div>

        {{-- <div class=" mt-3 d-flex align-items-center justify-content-start gap-2 flex-wrap">
            <h6>Banners:</h6>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="radioDefault" id="Around">
                <label class="form-check-label fw-bold text-dark" for="Around">Around</label>
            </div>
        </div> --}}

        {{-- <div class="form-check pt-3">
            <input class="form-check-input" type="checkbox" id="TermsUse" checked>
            <label class="form-check-label fw-5 text-dark" for="TermsUse">I agree to <u style="color: #A19061;">Terms Of Use</u></label>
        </div> --}}

        <hr class="horizontal dark mt-0 mt-3">
        {{-- <div class="text-end">
            <a href="#" class="btn btn-primary" type="Submit">Post</a>
        </div> --}}
        <div class="text-end my-3">
            <button type="submit" class="btn btn-primary" id="hj-form-submit">{{$button}}</button>
            @if(isset($community))
                <a href="{{ route('community.index') }}">
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

    $("#communityEvents").validate({
        rules: {
            title: {
                required: true,
                maxlength: 300
            },
            requirement: {
                required: true,
                maxlength: 500
            },
            date: {
                required: true
            },
            time: {
                required: true
            },
            price: {
                required: true,
                number:true
            },
            event_around: {
                required: true,
                maxlength: 1000
            },
            location: {
                required: true,
                maxlength: 1000
            },
            image: {
                required: true,
                // fileRequired: true,
                extension: "jpg|jpeg|png",
                filesize: 4 * 1024 * 1024 // 4 MB
            }
        },
        messages: {
            title: {
                required: "Please enter the event title.",
                maxlength: "Title must not exceed 300 characters."
            },
            requirement: {
                required: "Please enter the event requirements.",
                maxlength: "Requirements must not exceed 500 characters."
            },
            date: {
                required: "Please select the event date."
                
            },
            time: {
                required: "Please enter the event time."
            },
            price: {
                required: "Please enter the event price.",
                number: "Please enter a valid number."
            },
            event_around: {
                required: "Please describe what the event is about.",
                maxlength: "Event description must not exceed 1000 characters."
            },
            location: {
                required: "Please enter the event location.",
                maxlength: "Location must not exceed 1000 characters."
            },
            image: {
                required: "Please upload an image for the event.",
                extension: "Only JPG, JPEG, and PNG formats are allowed.",
                filesize: "Image size must not exceed 4 MB."
            }
        },

        // messages: {
        //     title: {
        //         required: "Title is required.",
        //         maxlength: "Title may not be greater than 500 characters."
        //     },
        //     image: {
        //         required: "Please upload image.",
        //         extension: "Images must be of type jpeg, png, or jpg.",
        //         filesize: "Each image must not exceed 4MB."
        //     },
        //     description: {
        //         required: "Description is required.",
        //         maxlength: "Description may not be greater than 5000 characters."
        //     }
        // },
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