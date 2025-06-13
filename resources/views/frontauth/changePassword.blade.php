@extends('frontauth.layouts.main')
@section('title')
Change Password
@endsection
@section('content')

<div class="container-fluid mt-4">
    <div class="ms-0 mb-3">
        <h5 class="font-weight-bolder">Change Password</h5>
    </div>

    <!-- data table -->
    <form action="{{ route('change-password') }}" method="post" class="row" id="changePasswordForm">
        @csrf
        <div class="col-md-4 mt-5 mx-auto">
            <div class="mb-3 Password-form">
                <label for="old_password" class="form-label">Old Password <span
                        class="text-danger">*</span></label>
                <input type="password" class="inner-form form-control mb-0" id="old_password" placeholder="Enter your old password" name="old_password" value="{{old('old_password')}}">
               
                <div class="icon_eye">
                    <img src="{{asset('front/auth/assets/img/eyeoff.svg')}}" class="toggle-password-input" data-toggle="#old_password" alt="Toggle Password">
                </div>

                @if($errors->has('old_password'))
                    <span class="error text-danger">{{$errors->first('old_password')}}</span>
                @endif
            </div>
            <div class="mb-3 Password-form">
                <label for="password" class="form-label">New Password <span
                        class="text-danger">*</span></label>
                <input type="password" class="inner-form form-control mb-0" id="password" name="password"
                    placeholder="Enter your new password"  value="{{old('password')}}">

                <div class="icon_eye">
                    <img src="{{asset('front/auth/assets/img/eyeoff.svg')}}" class="toggle-password-input" data-toggle="#password" alt="Toggle Password">
                </div>

                @if($errors->has('password'))
                    <span class="error text-danger">{{$errors->first('password')}}</span>
                @endif
            </div>
            <div class="mb-3 Password-form">
                <label for="password_confirmation" class="form-label">Confirm New Password <span
                        class="text-danger">*</span></label>
                <input type="password" class="inner-form form-control mb-0" id="password_confirmation" name="password_confirmation"
                    placeholder="Confirm password"  value="{{old('password_confirmation')}}">

                <div class="icon_eye">
                    <img src="{{asset('front/auth/assets/img/eyeoff.svg')}}" class="toggle-password-input" data-toggle="#password_confirmation" alt="Toggle Password">
                </div>

                @if($errors->has('password_confirmation'))
                    <span class="error text-danger">{{$errors->first('password_confirmation')}}</span>
                @endif
            </div>

            <div class="d-flex align-items-center gap-4 mt-3">
                <button type="submit" class="btn btn-primary" id="change-password-submit">Update</button>
                <a href={{route('profile')}}><button type="button" class="btn btn-secondary">Cancel</button></a>
            </div>
        </div>
    </form>


    <!-- data table end -->
</div>
@endsection

@section('script')

<script>
    $(document).ready(function() {

        $.validator.addMethod("strongPassword", function(value, element) {
                return this.optional(element) ||
                    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/.test(value);
            },
            "Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character."
        );

        $("#changePasswordForm").validate({
            rules: {
                old_password: {
                    required: true,
                },
                password: {
                    required: true,
                    strongPassword: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                old_password: {
                    required: "Please enter your old password",
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 8 characters"
                },
                password_confirmation: {
                    required: "Please confirm your password",
                    equalTo: "Confirm passwords do not match"
                },
            },
            errorClass: 'error text-danger',
            errorElement: 'span',
            
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                $('#change-password-submit').prop('disabled', true).text('Please wait...');
                form.submit();
            }
        });
    });


    $(document).ready(function () {
      $(".toggle-password-input").click(function () {
        var input = $($(this).attr("data-toggle"));
        var img = $(this);
 
        if (input.attr("type") === "password") {
          input.attr("type", "text");
          img.attr("src", "{{ asset('front/auth/assets/img/aye.svg') }}");
        } else {
          input.attr("type", "password");
          img.attr("src", "{{ asset('front/auth/assets/img/eyeoff.svg') }}");
        }
      });
    });
    </script>



@endsection