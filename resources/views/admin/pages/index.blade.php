@extends('admin.app')

@section('title', 'CMS Pages List')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">CMS Pages List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">CMS Pages List</li>
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
              {{--<div class="d-flex justify-content-end m-4">
                <a href="{{ route('cms_pages.create') }}" class="btn btn-primarys">Create CMS Page</a>
              </div>--}}
              <div class="card-body">
                <table id="pageTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>S.No.</th>
                      {{-- <th>Image</th> --}}
                      <th>Title</th>
                      <th>Slug</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(!$pages->isEmpty())
                      @foreach($pages as $key => $page)
                        <tr>
                          <td>{{ $pages->firstItem() + $key }}</td>
                          {{-- <td>
                                @if($page->image)
                                    <div style="position: relative; display: inline-block;">
                                        <img src="{{ asset('storage/' . $page->image) }}" width="80" alt="page image" style="border: 1px solid #ddd; border-radius: 4px; padding: 2px;">
                                        <form action="{{ route('cms_pages.image.delete', $page->id) }}" method="POST" style="position: absolute; top: -8px; right: -8px;" onsubmit="return confirm('Delete this image?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger p-0" style="width: 20px; height: 20px; font-size: 19px; border-radius: 50px; line-height: 1;">×</button>
                                        </form>
                                    </div>
                                @else
                                    <img src="{{ asset('images/default-blog.png') }}" width="80" alt="page image">
                                @endif
                            </td> --}}
                          <td>{{ $page->name }}</td>
                          <td>{{ $page->slug }}</td>
                          <td>
                            <a href="{{ route('cms_pages.edit', $page->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                            {{--<form action="{{ route('cms_pages.destroy', $page->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            @if($page->deleted_at)
                              <form action="{{ route('cms_pages.restore', $page->id) }}" method="POST" style="display:inline;">
                                  @csrf
                                  @method('PATCH')
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
                  {{ @$pages->links('pagination::bootstrap-4') }}
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
    $('#pageTable').DataTable({
        paging: false,
        lengthChange: true,
        searching: true,
        ordering: true,
        columnDefs: [ { orderable: false, targets: [1,4] }],
        info: true,
        autoWidth: false,
        responsive: true
    });
});
</script>
