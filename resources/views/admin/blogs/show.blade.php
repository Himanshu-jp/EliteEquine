@extends('admin.app')

@section('title', 'Blog Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Blog Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Blog List</a></li>
                        <li class="breadcrumb-item active">Blog Details</li>
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
                            <a href="{{ route('blogs.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <div class="card-body">
                            <!-- Display Blog Details -->
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Blog Image</h4>
                                    <img src="{{ ($blog->image) ? asset('storage/' . $blog->image) : asset('images/default-blog.png') }}" 
                                        width="150" height="150"  alt="Blog Image">
                                </div>
                                <div class="col-md-9">
                                    <h4>Blog Information</h4>
                                    <ul class="list-unstyled">
                                        <li><strong>Title:</strong> {{ $blog->title ?? 'N/A' }}</li>
                                        <li><strong>Category:</strong> {{ $blog->category->name ?? 'N/A' }}</li>
                                        <li><strong>Content:</strong> {!! $blog->content ?? 'N/A' !!}</li>
                                        <li><strong>Created At:</strong> {{ $blog->created_at->format('d M, Y') }}</li>
                                    </ul>
                                </div>
                            </div>

                            <hr>

                            <!-- Address Details (If any) -->
                            @if($blog->address)
                                <h4>Address Information</h4>
                                <ul class="list-unstyled">
                                    <li><strong>Country:</strong> {{ $blog->country ?? 'N/A' }}</li>
                                    <li><strong>State:</strong> {{ $blog->state ?? 'N/A' }}</li>
                                    <li><strong>City:</strong> {{ $blog->city ?? 'N/A' }}</li>
                                    <li><strong>Street:</strong> {{ $blog->street ?? 'N/A' }}</li>
                                </ul>
                            @endif

                            {{--<div class="d-flex mt-3">
                                <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning mr-2">Edit</a>
                                <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this blog?')">Delete</button>
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
