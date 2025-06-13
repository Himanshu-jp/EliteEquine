@extends('admin.app')

@section('title', 'User Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User List</a></li>
                        <li class="breadcrumb-item active">User Details</li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="d-flex justify-content-end mt-4 mr-4">
                            <a href="{{ route('users.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <div class="card-body">
                            <!-- Display User Profile -->
                            <div class="row">
                                <div class="col-md-3">
                                    <!-- <h4>Profile</h4> -->
                                    <img src="{{ ($user->profile_photo_path) ? asset('storage/' . $user->profile_photo_path) : asset('images/default-user.png') }}" 
                                        width="150" height="150" style="object-fit:cover;" alt="User Image">
                                </div>
                                <div class="col-md-9">
                                    <h4>User Information</h4>
                                    <ul class="list-unstyled">
                                        <li><strong>Name:</strong> {{ $user->name ?? 'N/A' }}</li>
                                        <li><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</li>
                                        <li><strong>Username:</strong> {{ $user->username ?? 'N/A' }}</li>
                                        <li><strong>Phone No:</strong> {{ $user->phone_no ?? 'N/A' }}</li>
                                        <li><strong>Bio:</strong> {{ $user->bio ?? 'N/A' }}</li>
                                    </ul>
                                </div>
                            </div>

                            <hr>

                            <!-- Address Details -->
                            <h4>Address Information</h4>
                            <ul class="list-unstyled">
                                <li><strong>Country:</strong> {{ $user->country ?? 'N/A' }}</li>
                                <li><strong>State:</strong> {{ $user->state ?? 'N/A' }}</li>
                                <li><strong>City:</strong> {{ $user->city ?? 'N/A' }}</li>
                                <li><strong>Street:</strong> {{ $user->street ?? 'N/A' }}</li>
                            </ul>

                            {{--<div class="d-flex mt-3">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning mr-2">Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                            </div>--}}
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
@endsection
