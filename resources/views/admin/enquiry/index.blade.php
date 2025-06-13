@extends('admin.app')

@section('title', 'Enquiry List')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Enquiry List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Enquiries</li>
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
                            <form method="GET" action="{{ route('enquiries.index') }}" class="form-inline mb-4">
                                <div class="form-group mr-2">
                                    <input type="text" name="search" class="form-control" placeholder="Search name, email, phone, subject" value="{{ request('search') }}">
                                </div>

                                <div class="form-group mr-2">
                                    <select name="user_id" class="form-control">
                                        <option value="">All Users</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primarys mr-2">Filter</button>
                                    <a href="{{ route('enquiries.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </form>

                            <!-- Enquiry Table -->
                            <table id="enquiryTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>User</th>
                                        <th>Subject</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($enquiries as $key => $enquiry)
                                        <tr>
                                            <td>{{ $enquiries->firstItem() + $key }}</td>
                                            <td>{{ $enquiry->name }}</td>
                                            <td>{{ $enquiry->email }}</td>
                                            <td>{{ $enquiry->phone }}</td>
                                            <td>{{ $enquiry->user->name ?? 'N/A' }}</td>
                                            <td>{{ $enquiry->subject }}</td>
                                            <td>
                                                <a href="{{ route('enquiries.show', $enquiry->id) }}" class="btn btn-sm btn-success" title="View"><i class="fas fa-eye"></i></a>

                                                <form action="{{ route('enquiries.destroy', $enquiry->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                                </form>

                                                @if($enquiry->deleted_at)
                                                    <form action="{{ route('restore', $enquiry->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-warning" title="Restore"><i class="fas fa-trash-restore-alt"></i></button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No enquiries found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-end mt-3">
                                {{ $enquiries->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
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
        $('#enquiryTable').DataTable({
            paging: false,
            searching: false,
            ordering: true,
            columnDefs: [
                { orderable: false, targets: [6] }
            ],
            info: true,
            autoWidth: false,
            responsive: true
        });
        $(".dataTables_info").html(
            'Showing {{ $enquiries->firstItem() }} to {{ $enquiries->lastItem() }} of {{ $enquiries->total() }} entries'
        );
    });
</script>