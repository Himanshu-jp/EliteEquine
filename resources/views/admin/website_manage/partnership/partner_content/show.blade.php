@extends('admin.app')

@section('title', 'Partnership Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Partnership Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Partnership Content Details</li>
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
                            @if(!$partnership)
                                <a href="{{ route('paertner_content.create') }}" class="btn btn-primarys">Add Partnership Content</a>
                            @else
                                <a href="{{ route('paertner_content.edit', $partnership->id) }}" class="btn btn-primarys">Edit Partnership Content</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <!-- Display Partnership Details -->
                            <div class="row">
                                <div class="col-md-9">
                                    <h4>Partnership Information</h4>
                                    <ul class="list-unstyled">
                                        <li><strong>Title:</strong> {{ @$partnership->title ?? 'N/A' }}</li>
                                        <li><strong>Description:</strong> {!! @$partnership->description ?? 'N/A' !!}</li>
                                        <li><strong>Last Updated:</strong> {{ (!empty($partnership) && !empty($partnership->updated_at)) ? $partnership->updated_at->format('d M, Y') : 'N/A' }}</li>
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
