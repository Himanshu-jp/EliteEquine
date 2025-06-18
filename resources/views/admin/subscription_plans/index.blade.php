@extends('admin.app')

@section('title', 'Subscription Plans List')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Subscription Plans List</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Subscription Plans</li>
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
                      <div class="card-body">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('subscription_plans.create') }}" class="btn btn-primarys">
                                    Create Subscription Plan
                                </a>
                            </div>
                        <!-- Filters -->
                        <form action="{{ route('subscription_plans.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search title, subtitle, price...">
                                </div>
                                <div class="col-md-2">
                                    <select name="type" class="form-control">
                                        <option value="">All Types</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primarys" type="submit">Filter</button>
                                    <a href="{{ route('subscription_plans.index') }}" class="btn btn-secondary ml-1">Reset</a>
                                </div>
                            </div>
                        </form>

                            <table id="subscriptionPlanTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Price</th>
                                        <th>Duration (Days)</th>
                                        {{-- <th>Post Limit</th> --}}
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($plans as $key => $plan)
                                        <tr>
                                            <td>{{ $plans->firstItem() + $key }}</td>
                                            <td>{{ $plan->title }}</td>
                                            <td>{{ $plan->subtitle }}</td>
                                            <td>${{ number_format($plan->price, 2) }}</td>
                                            <td>{{ $plan->days }} Days</td>
                                            {{-- <td>{{ $plan->post_limit }}</td> --}}
                                            <td>{{ ucfirst($plan->type) }}</td>
                                            <td>
                                                <a href="{{ route('subscription_plans.edit', $plan->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('subscription_plans.show', $plan->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="8" class="text-center">No Subscription Plans Found</td></tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="d-flex mt-3 justify-content-end">
                                {{ $plans->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#subscriptionPlanTable').DataTable({
        paging: false,
        searching: false, // Laravel handles search
        ordering: true,
        columnDefs: [{ orderable: false, targets: [7] }],
        info: false,
        autoWidth: false,
        responsive: true
    });

    $(".dataTables_info").html(
            'Showing {{ $plans->firstItem() }} to {{ $plans->lastItem() }} of {{ $plans->total() }} entries'
        );
});
</script>
