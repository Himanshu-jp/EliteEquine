@extends('admin.app')

@section('title', 'Industry Metric Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Industry Metric Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('industry_metrics.index') }}">Industry Metrics List</a></li>
                        <li class="breadcrumb-item active">Industry Metric Details</li>
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
                            <a href="{{ route('industry_metrics.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <div class="card-body">
                            <!-- Display Industry Metric Details -->
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Icon</h4>
                                    <img src="{{ $industryMetric->image ? asset('storage/' . $industryMetric->image) : asset('images/default-blog.png') }}"
                                        width="150" height="150" alt="Metric Icon" class="img-thumbnail">
                                </div>
                                <div class="col-md-9">
                                    <h4>Metric Information</h4>
                                    <ul class="list-unstyled">
                                        <li><strong>Title:</strong> {{ $industryMetric->title ?? 'N/A' }}</li>
                                        <li><strong>Description:</strong> {!! $industryMetric->description ?? 'N/A' !!}</li>
                                        <li><strong>Created At:</strong> {{ $industryMetric->created_at->format('d M, Y') }}</li>
                                    </ul>
                                </div>
                            </div>

                            {{--<div class="d-flex mt-3">
                                <a href="{{ route('industry_metrics.edit', $industryMetric->id) }}" class="btn btn-warning mr-2">Edit</a>
                                <form action="{{ route('industry_metrics.destroy', $industryMetric->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this metric?')">Delete</button>
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
