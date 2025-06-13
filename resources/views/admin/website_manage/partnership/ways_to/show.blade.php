@extends('admin.app')

@section('title', 'Partnership Way Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Partnership Way Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('partner_ways.index') }}">Partnership Ways List</a></li>
                        <li class="breadcrumb-item active">Partnership Way Details</li>
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
                    <div class="card">
                        <div class="d-flex justify-content-end mt-4 mr-4">
                            <a href="{{ route('partner_ways.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <div class="card-body">
                            <!-- Display Partnership Way Details -->
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Image</h4>
                                    <img src="{{ $way->image ? asset('storage/' . $way->image) : asset('images/default-blog.png') }}"
                                        width="150" height="150" alt="Way Image" class="img-thumbnail">
                                </div>
                                <div class="col-md-9">
                                    <h4>Way Information</h4>
                                    <ul class="list-unstyled">
                                        <li><strong>Title:</strong> {{ $way->title ?? 'N/A' }}</li>
                                        <li><strong>Description:</strong> {!! $way->description ?? 'N/A' !!}</li>
                                        <li><strong>Link:</strong>
                                            @if ($way->link)
                                                <a href="{{ $way->link }}" target="_blank" rel="noopener noreferrer">{{ $way->link }}</a>
                                            @else
                                                N/A
                                            @endif
                                        </li>
                                        <li><strong>Created At:</strong> {{ $way->created_at->format('d M, Y') }}</li>
                                    </ul>
                                </div>
                            </div>

                            {{--<div class="d-flex mt-3">
                                <a href="{{ route('partner_ways.edit', $way->id) }}" class="btn btn-warning mr-2">Edit</a>
                                <form action="{{ route('partner_ways.destroy', $way->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this way?')">Delete</button>
                                </form>
                            </div>--}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
