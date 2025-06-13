@extends('admin.app')

@section('title', 'Buyer Browser Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Buyer Browser Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Details</li>
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
                        <a href="{{ route('buyer-faqs.index') }}" class="btn btn-primarys mr-2">Buyer Faq</a>    
                        @if(empty($buyer))
                            <a href="{{ route('buyers.create') }}" class="btn btn-primarys">Add Buyer Browser</a>
                            @else
                            <a href="{{ route('buyers.edit', $buyer->id) }}" class="btn btn-primarys">Edit Buyer Browser</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <h5>Image</h5>
                                    <img src="{{ @$buyer->image ? asset('storage/' . @$buyer->image) : asset('images/default-blog.png') }}"
                                         width="150" height="150" alt="Buyer Browser Image" class="img-thumbnail">
                                </div>
                                <div class="col-md-9">
                                    <h5>Information</h5>
                                    <ul class="list-unstyled">
                                        <li><strong>Title:</strong> {{ @$buyer->title ?? 'N/A' }}</li>
                                        <li><strong>Description:</strong> {!! @$buyer->description ?? 'N/A' !!}</li>
                                        <li><strong>Last Updated:</strong> {{ @$buyer->updated_at ? @$buyer->updated_at->format('d M, Y') : 'N/A' }}</li>
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
