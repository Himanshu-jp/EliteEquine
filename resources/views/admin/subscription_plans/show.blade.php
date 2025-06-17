@extends('admin.app')

@section('title', 'Subscription Plan Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Subscription Plan Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('subscription_plans.index') }}">Subscription Plans List</a></li>
                        <li class="breadcrumb-item active">Subscription Plan Details</li>
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
                            <a href="{{ route('subscription_plans.index') }}" class="btn btn-success">Back</a>
                        </div>
                        <div class="card-body">
                            <!-- Display Subscription Plan Details -->
                            <div class="row">
                                <div class="col-md-3">
                                    <h4>Plan Image</h4>
                                    <img src="{{ ($subscriptionPlan->image) ? asset('storage/' . $subscriptionPlan->image) : asset('images/default-blog.png') }}" 
                                    width="150" height="150" alt="Plan Image">
                                </div>
                                <div class="col-md-9">
                                    <h4>Plan Information</h4>
                                    <ul class="list-unstyled">
                                        <li><strong>Title:</strong> {{ $subscriptionPlan->title ?? 'N/A' }}</li>
                                        <li><strong>Subtitle:</strong> {{ $subscriptionPlan->subtitle ?? 'N/A' }}</li>
                                        <li><strong>Price:</strong> ${{ number_format($subscriptionPlan->price, 2) ?? 'N/A' }}</li>
                                        <li><strong>Duration (Days):</strong> {{ $subscriptionPlan->days ?? 'N/A' }}</li>
                                        <li><strong>Type:</strong> {{ ucfirst($subscriptionPlan->type) ?? 'N/A' }}</li>
                                        {{-- <li><strong>Post Limit:</strong> {{ $subscriptionPlan->post_limit ?? 'N/A' }}</li> --}}
                                        <li><strong>Description:</strong> {!! $subscriptionPlan->description ?? 'N/A' !!}</li>
                                        <li><strong>Created At:</strong> {{ $subscriptionPlan->created_at->format('d M, Y') }}</li>
                                    </ul>
                                </div>
                            </div>

                            {{--<div class="d-flex mt-3">
                                <a href="{{ route('subscription_plans.edit', $subscriptionPlan->id) }}" class="btn btn-warning mr-2">Edit</a>
                                <form action="{{ route('subscription_plans.destroy', $subscriptionPlan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
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
