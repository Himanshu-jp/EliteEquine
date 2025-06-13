@extends('admin.app')

@section('title', 'Create Common Master')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create Common Master</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('common-masters.index') }}">Common Master List</a></li>
                        <li class="breadcrumb-item active">Create Common Master</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="d-flex justify-content-end mt-4 mr-4">
                            <a href="{{ route('common-masters.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <form action="{{ route('common-masters.store') }}" id="common_master_create" method="POST">
                            @csrf
                            <div class="card-body">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" placeholder="Enter name">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                                        <option value="">Select Type</option>
                                        @foreach($typeOptions as $option)
                                            <option value="{{ $option }}" {{ old('type') == $option ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $option)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="deactive" {{ old('status') == 'deactive' ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primarys" id="submitBtn">Submit</button>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {
    $('#common_master_create').validate({
        rules: {
            name: { required: true, minlength: 3, maxlength: 100 },
            type: { required: true },
            category: { required: true },
            status: { required: true }
        },
        messages: {
            name: {
                required: "Please enter the name",
                minlength: "Name must be at least 3 characters",
                maxlength: "Name must not exceed 100 characters"
            },
            type: { required: "Please select a type" },
            category: { required: "Please select a category" },
            status: { required: "Please select the status" }
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
            $('#submitBtn').attr('disabled', true).text('Submitting...');
            form.submit();
        }
    });

    $('#resetBtn').click(function () {
        $('#common_master_create')[0].reset();
    });
});
</script>
