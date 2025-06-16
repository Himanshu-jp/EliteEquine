@extends('front.layouts.main')

@section('title', 'Contact Us')

@section('content')
<section class="about-content-wrapper">
    <div class="container">
        <div class="about-content z-3 position-relative">
            <div class="col-lg-7 col-md-10 mx-auto">
                <div class="about-title text-center p-0">
                    <h1 class="mb-0 pb-0">Contact Us</h1>
                    <!-- <p>ELITE EQUINE is your One Stop Equestrian Shop and premier destination for high quality hunter-jumper horses, equine, barn, and rider equipment, boarding barns and equestrian properties, as well as equine services and jobs.</p> -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section mb-5">
    <div class="container">
        <div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form id="contactForm" method="POST" action="{{ route('contact.submit') }}">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-4 mt-3">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" value="{{ old('name') }}">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-3">
                        <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 col-md-4 mt-3">
                        <input type="text" name="phone" class="form-control"  placeholder="Phone Number (optional)" value="{{ old('phone') }}">
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- <div class="col-12 col-md-4">
                        <label>Subject</label>
                        <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                        @error('subject') <small class="text-danger">{{ $message }}</small> @enderror
                    </div> -->
                </div>
                <div class="col-12 mt-3">
                        <textarea name="message" placeholder="Message" class="form-control" rows="5">{{ old('message') }}</textarea>
                        @error('message') <small class="text-danger">{{ $message }}</small> @enderror
                    </div> 

                <div class="text-center">
                    <button type="submit" id="submitBtn" class="btn apply-flitter mt-3 text-light">Leave us a Message <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
  <path d="M5.5 12.5H19.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M12.5 5.5L19.5 12.5L12.5 19.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg></button>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
    .form-control{  
        padding: 10px 10px 20px 10px;
        height: 100%;
        border:0;
         border-radius: 0;
        border-bottom: 1px solid #CACACA;
    }
</style>
@endsection

@section('scripts')
<!-- Include jQuery and jQuery Validate -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $('#contactForm').validate({
        rules: {
            name: { required: true, minlength: 2 },
            email: { required: true, email: true },
            phone: { required: true, minlength: 7 },
            subject: { required: true },
            message: { required: true, minlength: 10 }
        },
        messages: {
            name: {
                required: "Please enter your name",
                minlength: "Name must be at least 2 characters"
            },
            email: {
                required: "Please enter your email",
                email: "Enter a valid email address"
            },
            phone: {
                required: "Please enter your phone number",
                minlength: "Phone number must be at least 7 digits"
            },
            subject: {
                required: "Please enter a subject"
            },
            message: {
                required: "Please enter your message",
                minlength: "Message must be at least 10 characters"
            }
        },
        errorElement: 'small',
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
});
</script>
@endsection
