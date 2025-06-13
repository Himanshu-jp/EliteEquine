@extends('admin.app')

@section('title', 'Newsletter Subscribers')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Newsletter Subscribers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Newsletters</li>
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
                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('newsletters.index') }}" class="form-inline mb-4">
                                <div class="form-group mr-2">
                                    <input type="text" name="search" class="form-control" placeholder="Search email" value="{{ request('search') }}">
                                </div>

                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primarys mr-2">Filter</button>
                                    <a href="{{ route('newsletters.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </form>

                            <!-- Newsletter Table -->
                            <table id="newsletterTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Email</th>
                                        <th>Subscribed At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($newsletters as $key => $subscriber)
                                        <tr>
                                            <td>{{ $newsletters->firstItem() + $key }}</td>
                                            <td>{{ $subscriber->email }}</td>
                                            <td>{{ $subscriber->created_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <form action="{{ route('newsletters.destroy', $subscriber->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No subscribers found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-end mt-3">
                                {{ $newsletters->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#newsletterTable').DataTable({
            paging: false,
            searching: false,
            ordering: true,
            columnDefs: [
                { orderable: false, targets: [3] }
            ],
            info: true,
            autoWidth: false,
            responsive: true
        });

        $(".dataTables_info").html(
            'Showing {{ $newsletters->firstItem() }} to {{ $newsletters->lastItem() }} of {{ $newsletters->total() }} entries'
        );
    });
</script>
@endpush
