@extends('admin.app')

@section('title', 'Blog List')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Blog List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">Blog List</li>
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
              <div class="d-flex justify-content-end mb-4">
                <a href="{{ route('blogs.create') }}" class="btn btn-primarys">Create Blog</a>
              </div>
            <!-- Filter Form -->
                <form method="GET" action="{{ route('blogs.index') }}" class="form-inline mb-3">
                    <div class="form-group mr-2">
                        <select name="category" class="form-control">
                            <option value="">-- Filter by Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mr-2">
                        <input type="text" name="search" class="form-control" placeholder="Search by title"
                              value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 d-flex">
                      <button type="submit" class="btn btn-primarys">Filter</button>
                      <a href="{{ route('blogs.index') }}" class="btn btn-secondary ml-2">Reset</a>
                    </div>
                </form>
              
                <table id="blogTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>S.No.</th>
                      <th>Image</th>
                      <th>Title</th>
                      <th>Category</th>
                      <th>Slug</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!$blogs->isEmpty())
                      @foreach($blogs as $key => $blog)
                        <tr>
                          <td>{{ $blogs->firstItem() + $key }}</td>
                          <td>
                            @if($blog->image)
                              <img src="{{ asset('storage/' . $blog->image) }}" width="80" alt="blog image">
                            @else
                            <img src="{{ asset('images/default-blog.png') }}" width="80" alt="blog image">
                            @endif
                          </td>
                          <td>{{ Str::limit($blog->title, 40, '...') }}</td>
                          <td>{{ $blog->category->name ?? 'N/A' }}</td>
                          <td>{{ Str::limit($blog->slug, 40, '...') }}</td>
                          <td>
                            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            @if($blog->deleted_at)
                              <form action="{{ route('restore', $blog->id) }}" method="POST" style="display:inline;">
                                  @csrf
                                  @method('PATCH')
                                  <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-trash-restore-alt"></i></button>
                              </form>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    @else
                      <tr><td colspan="6" class="text-center">Data Not Found</td></tr>
                    @endif
                  </tbody>
                </table>
                <div class="d-flex mt-3 justify-content-end">
                  {{ $blogs->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
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
    $('#blogTable').DataTable({
        paging: false,
        lengthChange: true,
        searching: false,
        ordering: true,
        columnDefs: [ { orderable: false, targets: [1,5] }],
        info: true,
        autoWidth: false,
        responsive: true
    });
    $(".dataTables_info").html(
        'Showing {{ $blogs->firstItem() }} to {{ $blogs->lastItem() }} of {{ $blogs->total() }} entries'
    );
    // Auto-submit on category change (optional UX)
        /* $('select[name="category"]').change(function () {
            $(this).closest('form').submit();
        }); */
});
</script>
