@extends('admin.app')

@section('title', 'Partnership Collaborate List')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Partnership Collaborate List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Collaborate List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-4">
                        <a href="{{ route('partner_collaborate.create') }}" class="btn btn-primarys">Create Collaboration</a>
                    </div>

                    <table id="collaborateTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($collaborates->count())
                                @foreach($collaborates as $key => $collab)
                                    <tr>
                                        <td>{{ $collaborates->firstItem() + $key }}</td>
                                        <td>
                                            @if($collab->image)
                                                <img src="{{ asset('storage/' . $collab->image) }}" width="80" height="80" class="img-thumbnail" alt="Image">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('partner_collaborate.edit', $collab->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('partner_collaborate.destroy', $collab->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="text-center">No Collaborations Found</td></tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="d-flex mt-3 justify-content-end">
                        {{ $collaborates->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<!-- Optional: jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#collaborateTable').DataTable({
            paging: false,
            lengthChange: false,
            searching: false,
            ordering: true,
            columnDefs: [{ orderable: false, targets: [2, 3] }],
            info: true,
            autoWidth: false,
            responsive: true
        });
    });
</script>
