@extends('admin.app')

@section('title', 'Subscription Addons List')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Subscription Addons List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Subscription Addons</li>
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
                        <div class="d-flex justify-content-end mb-4">
                            <a href="{{ route('subscription-addons.create') }}" class="btn btn-primarys">Create Addon</a>
                        </div>
                            <table id="addonTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Days</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($addons as $key => $addon)
                                        <tr>
                                            <td>{{ $addons->firstItem() + $key }}</td>
                                            <td>{{ ucfirst($addon->type) }}</td>
                                            <td>@php echo Str::limit($addon->description, 60); @endphp </td>
                                            <td>${{ number_format($addon->price, 2) }}</td>
                                            <td>{{ $addon->days }} days</td>
                                            <td>
                                                <a href="{{ route('subscription-addons.edit', $addon->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('subscription-addons.show', $addon->id) }}" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
                                                <form action="{{ route('subscription-addons.destroy', $addon->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this addon?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                                @if($addon->deleted_at)
                                                    <form action="{{ route('subscription-addons.restore', $addon->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-trash-restore-alt"></i></button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No addons found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex mt-3 justify-content-end">
                                {{ $addons->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
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
    $('#addonTable').DataTable({
        paging: false,
        lengthChange: true,
        searching: true,
        ordering: true,
        columnDefs: [ { orderable: false, targets: [5] }],
        info: true,
        autoWidth: false,
        responsive: true
    });

    $(".dataTables_info").html(
            'Showing {{ $addons->firstItem() }} to {{ $addons->lastItem() }} of {{ $addons->total() }} entries'
        );
});
</script>
