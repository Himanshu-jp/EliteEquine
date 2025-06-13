@extends('admin.app')

@section('title', 'Enquiry Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Enquiry Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('enquiries.index') }}">Enquiries</a></li>
                        <li class="breadcrumb-item active">Enquiry Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="d-flex justify-content-end mt-4 mr-4">
                            <a href="{{ route('enquiries.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <div class="card-body">
                            <h4 class="mb-3">Enquiry Information</h4>
                            <ul class="list-unstyled">
                                <li><strong>Name:</strong> {{ $contactUs->name ?? 'N/A' }}</li>
                                <li><strong>Email:</strong> {{ $contactUs->email ?? 'N/A' }}</li>
                                <li><strong>Phone:</strong> {{ $contactUs->phone ?? 'N/A' }}</li>
                                <li><strong>User Name:</strong> {{ $contactUs->user->name ?? 'N/A' }}</li>
                                <li><strong>Subject:</strong> {{ $contactUs->subject ?? 'N/A' }}</li>
                                <li><strong>Message:</strong> {!! nl2br(e($contactUs->message)) ?? 'N/A' !!}</li>
                                <li><strong>Created At:</strong> {{ optional($contactUs->created_at)->format('d M, Y') ?? 'N/A' }}</li>
                                @if($contactUs->deleted_at)
                                    <li><strong>Status:</strong> <span class="text-danger">Soft Deleted</span></li>
                                @endif
                            </ul>

                            {{-- Uncomment below if you want edit/delete buttons --}}
                            {{--
                            <div class="d-flex mt-3">
                                <a href="{{ route('enquiries.edit', $contactUs->id) }}" class="btn btn-warning mr-2">Edit</a>
                                <form action="{{ route('enquiries.destroy', $contactUs->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                            --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
