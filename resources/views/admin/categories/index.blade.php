@extends('admin.app')

@section('title', 'Category List')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Category List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Category List</li>
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
            {{--<div class="d-flex justify-content-end m-4">
                <a href="{{ route('categories.create') }}" class="btn btn-primary">Create Category</a>
            </div>--}}
                <div class="card-body">
                <table id="categoryTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>S.No.</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Slug</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!$categories->isEmpty())
                  @foreach($categories as $key => $category)
                    <tr>
                        <td>{{$categories->firstItem() + $key}}</td>
                        <td><img src="{{asset('storage/' . $category->image)}}" width="80" alt="category image"></td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                            {{--<form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></button>
                            </form>
                            @if($category->deleted_at)
                                <form action="{{ route('categories.restore', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-trash-restore-alt"></i></button>
                                </form>
                            @endif--}}
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan="5" class="text-center">Data Not Found</td></tr>
                    @endif
                  </tbody>
                </table>
                <div class="d-flex mt-3 justify-content-end">
                    {{ $categories->links('pagination::bootstrap-4') }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    $('#categoryTable').DataTable({
        paging: false,
        lengthChange: true,
        searching: true,
        ordering: true,
        columnDefs: [ { orderable: false, targets: [1,4] }],
        info: true,
        autoWidth: false,
        responsive: true,
    });
});
</script>

