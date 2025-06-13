@extends('admin.app')

@section('title', 'Profile')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <!-- form start -->
                        <form action="{{ route('admin.profile.update') }}" id="profile_form" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name"
                                        value="{{ !empty($admin) ? $admin->name : old('name') }}" placeholder="Enter name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email"
                                        value="{{ !empty($admin) ? $admin->email : old('email') }}"
                                        placeholder="Enter email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="username">User Name</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username"
                                        value="{{ !empty($admin) ? $admin->username : old('username') }}"
                                        placeholder="Enter username">
                                    @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone"
                                        value="{{ !empty($admin) ? $admin->phone_no : old('phone') }}"
                                        placeholder="Enter phone">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Profile Image</label><br>
                                    @if (!empty($admin) && !empty($admin->profile_photo_path))
                                        @php $img = asset('storage/' . $admin->profile_photo_path);@endphp
                                    @else
                                        @php $img = asset('images/default-user.png');@endphp
                                    @endif
                                    <img src="{{ $img }}" width="80" class="mb-2 rounded-circle"><br>

                                    <input type="file" name="profile_image"
                                        class="form-control-file @error('profile_image') is-invalid @enderror">
                                    @error('profile_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

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
    <!-- /.content -->
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Prevent form from submitting multiple times
    var submitting = false;

    // Validate the form
    $("#profile_form").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            email: {
                required: true,
                email: true,
                maxlength: 100
            },
            username: {
                required: true,
                minlength: 3,
                maxlength: 100
            },
            phone: {
                required: true,
                minlength: 7,
                maxlength: 15,
                digits: true
            },
            profile_image: {
                extension: "jpg|jpeg|png|webp"
            }
        },
        messages: {
            name: {
                required: "Please enter your name",
                minlength: "Name must be at least 3 characters",
                maxlength: "Name must not exceed 100 characters"
            },
            email: {
                required: "Please enter your email",
                email: "Please enter a valid email address",
                maxlength: "Email must not exceed 100 characters"
            },
            username: {
                required: "Please enter your username",
                minlength: "Username must be at least 3 characters",
                maxlength: "Username must not exceed 100 characters"
            },
            phone: {
                required: "Please enter your phone number",
                minlength: "Phone number must be at least 7 digits",
                maxlength: "Phone number must not exceed 15 digits",
                digits: "Phone number must contain only digits"
            },
            profile_image: {
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
            // Prevent multiple submissions
            if (submitting) {
                return false; // Prevent further submission
            }
            submitting = true; // Set flag to true (form is being submitted)
            form.submit(); // Submit the form
        }
    });

    // Reset the form data to default values
    $('#resetBtn').on('click', function() {
        $('#profile_form')[0].reset();
        // Optionally set default values to the fields
        $('#name').val("{{ old('name', $admin->name ?? '') }}");
        $('#email').val("{{ old('email', $admin->email ?? '') }}");
        $('#username').val("{{ old('username', $admin->username ?? '') }}");
        $('#phone').val("{{ old('phone', $admin->phone_no ?? '') }}");
    });
});
</script>
