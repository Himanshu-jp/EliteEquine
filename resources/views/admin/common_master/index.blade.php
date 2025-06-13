@extends('admin.app')

@section('title', 'Common Masters List')

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Common Master List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Common Master</li>
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
                        <!-- Create Button -->
                        <div class="card-body">
                            <div class="d-flex justify-content-end mb-4">
                                <a href="{{ route('common-masters.create') }}" class="btn btn-primarys">Create Master</a>
                            </div>

                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('common-masters.index') }}" class="form-inline mb-3">
                                <div class="form-group mr-2">
                                    <input type="text" name="search" class="form-control" placeholder="Search by Name"
                                           value="{{ request('search') }}">
                                </div>

                                <div class="form-group mr-2">
                                    <select name="category" class="form-control" id="categorySelect">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mr-2">
                                    <select name="type" class="form-control {{request()->type ?? 'd-none'}}" id="typeSelect">
                                        <option value="">All Types</option>
                                        @foreach($types->sort() as $type)
                                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mr-2">
                                    <select name="status" class="form-control">
                                        <option value="">All Statuses</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="deactive" {{ request('status') == 'deactive' ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primarys">Filter</button>
                                <a href="{{ route('common-masters.index') }}" class="btn btn-secondary ml-2">Reset</a>
                            </form>

                            <!-- Table -->
                            <table id="commonMasterTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($masters as $key => $master)
                                        <tr>
                                            <td>{{ $masters->firstItem() + $key }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $master->name)) }}</td>
                                            <td>{{ $master->category->name ?? 'N/A' }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $master->type)) }}</td>
                                            <td>
                                                <label class="switch">
                                                    <input type="checkbox" class="toggle-status" data-id="{{ $master->id }}"
                                                    data-url="{{ route('common-masters.toggleStatus', $master->id) }}"
                                                    {{ $master->status == 'active' ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <a href="{{ route('common-masters.edit', $master->id) }}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                <form action="{{ route('common-masters.destroy', $master->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                                @if($master->deleted_at)
                                                    <form action="{{ route('common-masters.restore', $master->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-trash-restore-alt"></i></button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center">No records found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="d-flex mt-3 justify-content-end">
                                {{ $masters->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
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
    $('#commonMasterTable').DataTable({
        paging: false,
        lengthChange: true,
        searching: false,
        ordering: true,
        columnDefs: [ { orderable: false, targets: [4,5] }],
        info: true,
        autoWidth: false,
        responsive: true
    });
    $(".dataTables_info").html(
        'Showing {{ $masters->firstItem() }} to {{ $masters->lastItem() }} of {{ $masters->total() }} entries'
    );
    // category to get type
    $('#categorySelect').on('change', function () {
        let categoryId = $(this).val();
        if(categoryId == '')
        {
            $("#typeSelect").addClass('d-none');
            return void 0;
        }

        let url = '{{ url("admin/common-masters/types") }}/' + categoryId;

        if (categoryId) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $("#typeSelect").removeClass('d-none').css('display', 'block');
                    let $typeSelect = $('#typeSelect');
                    $typeSelect.empty();
                    $typeSelect.append('<option value="">All Types</option>');
                    data.types.forEach(function (type) {
                        $typeSelect.append('<option value="' + type + '">' + type.charAt(0).toUpperCase() + type.slice(1).replace(/_/g, ' ') + '</option>');
                    });
                },
                error: function () {
                    alert('Failed to fetch types');
                }
            });
        } else {
            $('#typeSelect').html('<option value="">All Types</option>');
        }
    });

    $(window).on('load', function() {
        let categoryId = $('#categorySelect').val();
        if(categoryId == '')
        {
            $("#typeSelect").addClass('d-none');
            return void 0;
        }

        let url = '{{ url("admin/common-masters/types") }}/' + categoryId;

        if (categoryId) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $("#typeSelect").removeClass('d-none').css('display', 'block');
                    let $typeSelect = $('#typeSelect');
                    $typeSelect.empty();
                    $typeSelect.append('<option value="">All Types</option>');
                    data.types.forEach(function (type) {
                        let selected = '';
                        if(type == '{{request()->type}}')
                        {
                            selected = 'selected';
                        }
                        $typeSelect.append('<option value="' + type + '" '+selected+'>' + type.charAt(0).toUpperCase() + type.slice(1).replace(/_/g, ' ') + '</option>');
                    });
                },
                error: function () {
                    alert('Failed to fetch types');
                }
            });
        } else {
            $('#typeSelect').html('<option value="">All Types</option>');
        }
    });
    // Toggle Status AJAX
    $('.toggle-status').click(function () {
        let url = $(this).data('url');
        let status = $(this).is(':checked') ? 'active' : 'deactive';

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function (response) {
                // Optionally show a toast or message
            },
            error: function () {
                alert('Error updating status');
            }
        });
    });
});
</script>
