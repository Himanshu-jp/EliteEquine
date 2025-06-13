@extends('admin.app')

@section('title', 'About Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">About Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">About Details</li>
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
                        <div class="d-flex justify-content-end mt-4 mr-4">
                            @if(!$about)
                            <a href="{{ route('about.create') }}" class="btn btn-primarys">Add About</a>
                            @else
                            <a href="{{ route('about.edit', $about->id) }}" class="btn btn-primarys">Edit About</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <!-- Display About Details -->
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Image</h4>
                                    <img src="{{ @$about->image ? asset('storage/' . $about->image) : asset('images/default-blog.png') }}"
                                         width="150" height="150" alt="About Image" class="img-thumbnail">
                                </div>
                                <div class="col-md-9">
                                    <h4>About Information</h4>
                                    <ul class="list-unstyled">
                                        <li><strong>Title:</strong> {{ @$about->title ?? 'N/A' }}</li>
                                        <li><strong>Description:</strong> {!! @$about->description ?? 'N/A' !!}</li>
                                        <li><strong>Created At:</strong> {{ (!empty($about) && !empty($about->updated_at))?$about->updated_at->format('d M, Y') : '' }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
