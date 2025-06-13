@extends('admin.app')

@section('title', 'Subscription Addon Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Subscription Addon Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('subscription-addons.index') }}">Subscription Addons</a></li>
                        <li class="breadcrumb-item active">Addon Details</li>
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
                            <a href="{{ route('subscription-addons.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <div class="card-body">
                            <h4 class="mb-3">Addon Information</h4>
                            <ul class="list-unstyled">
                                <li><strong>Type:</strong> {{ ucfirst($subscriptionAddon->type) ?? 'N/A' }}</li>
                                <li><strong>Description:</strong> {!! $subscriptionAddon->description ?? 'N/A' !!}</li>
                                <li><strong>Price:</strong> ${{ number_format($subscriptionAddon->price, 2) ?? 'N/A' }}</li>
                                <li><strong>Duration (Days):</strong> {{ $subscriptionAddon->days ?? 'N/A' }}</li>
                                <li><strong>Created At:</strong> {{ $subscriptionAddon->created_at->format('d M, Y') }}</li>
                                @if($subscriptionAddon->deleted_at)
                                    <li><strong>Status:</strong> <span class="text-danger">Soft Deleted</span></li>
                                @endif
                            </ul>

                            {{--<div class="d-flex mt-3">
                                <a href="{{ route('subscription-addons.edit', $subscriptionAddon->id) }}" class="btn btn-warning mr-2">Edit</a>
                                <form action="{{ route('subscription-addons.destroy', $subscriptionAddon->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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
