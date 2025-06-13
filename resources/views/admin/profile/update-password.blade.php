@extends('admin.app')

@section('title', 'Change Password')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Change Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
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
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form id="changePasswordForm" action="{{ route('admin.change-password.update') }}" method="post">
                            @csrf
                            <div class="card-body">

                                <!-- Current Password -->
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Enter current password" />
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" data-target="current_password" style="cursor: pointer;">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('current_password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" placeholder="Enter new password" />
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" data-target="new_password" style="cursor: pointer;">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" placeholder="Confirm new password" />
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" data-target="confirm_password" style="cursor: pointer;">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @error('confirm_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primarys" id="submitBtn">Submit</button>
                                <button type="reset" class="btn btn-secondary" id="resetBtn">Reset</button>
                                {{--<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>--}}
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $.validator.addMethod("strongPassword", function(value, element) {
                return this.optional(element) ||
                    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/.test(value);
            },
            "Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character."
        );
    });

    $(function () {
        // Prevent form from submitting multiple times
        var submitting = false;

        // Form validation rules
        $("#changePasswordForm").validate({
            rules: {
                current_password: {
                    required: true,
                    minlength: 8
                },
                new_password: {
                    required: true,
                    strongPassword: true,
                    minlength: 8
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new_password"
                }
            },
            messages: {
                current_password: {
                    required: "Please enter your current password",
                    minlength: "Password must be at least 8 characters"
                },
                new_password: {
                    required: "Please enter a new password",
                    minlength: "New password must be at least 8 characters"
                },
                confirm_password: {
                    required: "Please confirm your new password",
                    equalTo: "Passwords do not match"
                }
            },
            errorElement: 'span',
            errorClass: 'text-danger',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent()); 
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function (form) {
                // Prevent multiple submissions
                if (submitting) {
                    return false; // Prevent further submission
                }
                submitting = true; // Set flag to true (form is being submitted)
                form.submit(); // Submit the form
            }
        });

        // Toggle password visibility (shared handler)
        $('.toggle-password').on('click', function () {
            const inputId = $(this).data('target');
            const input = $('#' + inputId);
            const icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Reset button functionality
        $('#resetBtn').on('click', function() {
            // Reset the form to its default state
            $('#changePasswordForm')[0].reset();
        });
    });
</script>
