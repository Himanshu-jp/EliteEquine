@extends('admin.app')

@section('title', 'CMS Page Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CMS Page Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cms_pages.index') }}">CMS Pages List</a></li>
                        <li class="breadcrumb-item active">CMS Page Details</li>
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
                            <a href="{{ route('cms_pages.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <div class="card-body">
                            <!-- Display CMS Page Details -->
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Page Image</h4>
                                    <img src="{{ ($page->image) ? asset('storage/' . $page->image) : asset('images/default-page.jpg') }}" 
                                        width="150" height="150" alt="Page Image">
                                </div>
                                <div class="col-md-9">
                                    <h4>Page Information</h4>
                                    <ul class="list-unstyled">
                                        <li><strong>Title:</strong> {{ $page->name ?? 'N/A' }}</li>
                                        <li><strong>Content:</strong> {!! $page->content ?? 'N/A' !!}</li>
                                        <li><strong>Created At:</strong> {{ $page->created_at->format('d M, Y') }}</li>
                                    </ul>
                                </div>
                            </div>

                            {{--<div class="d-flex mt-3">
                                <a href="{{ route('cms_pages.edit', $page->id) }}" class="btn btn-warning mr-2">Edit</a>
                                <form action="{{ route('cms_pages.destroy', $page->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this page?')">Delete</button>
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
