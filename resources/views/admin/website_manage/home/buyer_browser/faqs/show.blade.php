@extends('admin.app')

@section('title', 'View Buyer FAQ')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Buyer FAQ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('buyer-faqs.index') }}">FAQ List</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="d-flex justify-content-end mt-4 mr-4">
                    <a href="{{ route('buyer-faqs.index') }}" class="btn btn-success">Back</a>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label><strong>Question:</strong></label>
                        <p>{{ $buyerFaq->questions }}</p>
                    </div>

                    <div class="form-group">
                        <label><strong>Answer:</strong></label>
                        <div class="border p-3" style="background: #f9f9f9;">
                            {!! $buyerFaq->answers !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
