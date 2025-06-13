@extends('admin.app')

@section('title', 'Partnership Ways List')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Partnership Ways List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Partnership Ways List</li>
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
                    <div class="card">
                        <div class="d-flex justify-content-end m-4">
                            <a href="{{ route('partner_ways.create') }}" class="btn btn-primarys">Create Partnership Way</a>
                        </div>
                        <div class="card-body">
                            <table id="waysTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Link</th> {{-- Added Link column --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!$partnershipWays->isEmpty())
                                        @foreach($partnershipWays as $key => $way)
                                            <tr>
                                                <td>{{ $partnershipWays->firstItem() + $key }}</td>
                                                <td>
                                                    @if($way->image)
                                                        <img src="{{ asset('storage/' . $way->image) }}" width="60" alt="image" style="border: 1px solid #ddd; border-radius: 4px; padding: 2px;">
                                                    @else
                                                        <img src="{{ asset('images/default-blog.png') }}" width="60" alt="default image">
                                                    @endif
                                                </td>
                                                <td>{{ $way->title }}</td>
                                                <td>{!! Str::limit($way->description, 50) !!}</td>
                                                <td>
                                                    @if($way->link)
                                                        <a href="{{ $way->link }}" target="_blank" rel="noopener noreferrer">{{ Str::limit($way->link, 40) }}</a>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('partner_ways.edit', $way->id) }}" class="btn btn-info btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('partner_ways.show', $way->id) }}" class="btn btn-success btn-sm" title="View"><i class="fas fa-eye"></i></a>
                                                    <form action="{{ route('partner_ways.destroy', $way->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No Partnership Ways Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="d-flex mt-3 justify-content-end">
                                {{ $partnershipWays->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<!-- DataTables Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#waysTable').DataTable({
        paging: false,
        lengthChange: true,
        searching: true,
        ordering: true,
        columnDefs: [ { orderable: false, targets: [1, 5] } ],
        info: true,
        autoWidth: false,
        responsive: true
    });
});
</script>
