@extends('admin.app')

@section('title', 'Sub-Category List')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sub-Category List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Sub-Category List</li>
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
              <div class="card-body">

                <!-- Create Button -->
                <div class="d-flex justify-content-end mb-4">
                    <a href="{{ route('sub-categories.create') }}" class="btn btn-primarys">Create Sub-Category</a>
                </div>
  
                <!-- Filter Form -->
                <form method="GET" action="{{ route('sub-categories.index') }}" class="form-inline mb-3">
                    
                        <div class="form-group mr-2">
                            <select name="category" class="form-control">
                                <option value="">-- Filter by Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mr-2">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by Name">
                        </div>
                        <div class="col-md-4 d-flex">
                            <button type="submit" class="btn btn-primarys mr-2">Filter</button>
                            <a href="{{ route('sub-categories.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    
                </form>

                <!-- Table -->
                    <table id="subcategoryTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$subCategories->isEmpty())
                                @foreach($subCategories as $key => $subcategory)
                                    <tr>
                                        <td>{{ $subCategories->firstItem() + $key }}</td>
                                        <td>{{ $subcategory->name }}</td>
                                        <td>{{ $subcategory->category ? $subcategory->category->name : 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('sub-categories.edit', $subcategory->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('sub-categories.destroy', $subcategory->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                            @if($subcategory->deleted_at)
                                                <form action="{{ route('sub-categories.restore', $subcategory->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Restore</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="text-center">Data Not Found</td></tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="d-flex mt-3 justify-content-end">
                        {{ $subCategories->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
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
    $('#subcategoryTable').DataTable({
        paging: false,
        lengthChange: true,
        searching: false,
        ordering: true,
        columnDefs: [ { orderable: false, targets: [3] }],
        info: true,
        autoWidth: false,
        responsive: true
    });
    $(".dataTables_info").html(
            'Showing {{ $subCategories->firstItem() }} to {{ $subCategories->lastItem() }} of {{ $subCategories->total() }} entries'
        );
    /* $('select[name="category"]').change(function () {
            $(this).closest('form').submit();
        }); */
});
</script>
