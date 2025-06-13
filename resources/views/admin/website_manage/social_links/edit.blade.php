@extends('admin.app')

@section('title', 'Edit Social Links')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Social Links</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Social Links</li>
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
                        <form action="{{ route('update.social.link') }}" method="POST" id="social_links_form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">

                                @foreach(['facebook', 'tiktok', 'instagram', 'twitter', 'linkedin', 'youtube'] as $platform)
                                    <div class="form-group">
                                        <label for="{{ $platform }}">{{ ucfirst($platform) }} URL</label>
                                        <input type="url" class="form-control @error($platform) is-invalid @enderror"
                                            name="{{ $platform }}" id="{{ $platform }}"
                                            value="{{ old($platform, $social->$platform ?? '') }}"
                                            placeholder="Enter {{ ucfirst($platform) }} link">
                                        @error($platform)
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach

                                <!-- Android App Link -->
                                <div class="form-group">
                                    <label for="android_app_link">Android App Link</label>
                                    <input type="url" class="form-control @error('android_app') is-invalid @enderror"
                                        name="android_app" id="android_app_link"
                                        value="{{ old('android_app', $social->android_app ?? '') }}"
                                        placeholder="Enter Android app link">
                                    @error('android_app')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- iOS App Link -->
                                <div class="form-group">
                                    <label for="ios_app_link">iOS App Link</label>
                                    <input type="url" class="form-control @error('ios_app') is-invalid @enderror"
                                        name="ios_app" id="ios_app_link"
                                        value="{{ old('ios_app', $social->ios_app ?? '') }}"
                                        placeholder="Enter iOS app link">
                                    @error('ios_app')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primarys" id="submitBtn">Update</button>
                                <button type="reset" class="btn btn-secondary" id="resetBtn">Reset</button>
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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $('#social_links_form').validate({
        rules: {
            facebook: { url: true },
            tiktok: { url: true },
            instagram: { url: true },
            twitter: { url: true },
            linkedin: { url: true },
            youtube: { url: true },
            android_app_link: { url: true },
            ios_app_link: { url: true }
        },
        messages: {
            facebook: "Please enter a valid Facebook URL",
            tiktok: "Please enter a valid TikTok URL",
            instagram: "Please enter a valid Instagram URL",
            twitter: "Please enter a valid Twitter URL",
            linkedin: "Please enter a valid LinkedIn URL",
            youtube: "Please enter a valid YouTube URL",
            android_app_link: "Please enter a valid Android app URL",
            ios_app_link: "Please enter a valid iOS app URL"
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
            $('#submitBtn').attr('disabled', true).text('Updating...');
            form.submit();
        }
    });

    $('#resetBtn').click(function () {
        $('.is-invalid').removeClass('is-invalid');
        $('.text-danger').text('');
    });
});
</script>
