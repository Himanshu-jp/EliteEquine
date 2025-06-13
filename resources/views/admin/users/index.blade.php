@extends('admin.app')

@section('title', 'User List')
@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6"><h1 class="m-0">User List</h1></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">User List</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
              <!-- Filter Form -->
              <form action="{{ route('users.index') }}" method="GET">
                <div class="row">
                  <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search name/email/username..." value="{{ request('search') }}">
                  </div>
                  
                  <div class="col-md-2">
                    <button class="btn btn-primarys" type="submit">Filter</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary ml-2">Reset</a>
                  </div>
                </div>
              </form>

              
                <table id="usersTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>S.No.</th>
                      <th>Profile</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Username</th>
                      <th>Phone No</th>
                      <th>Country</th>
                      <th>State</th>
                      <th>City</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($users as $key => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $key }}</td>
                        <td>
                            @if($user->profile_photo_path)
                              <img src="{{ asset('storage/' . $user->profile_photo_path) }}" width="50" height="50" style="object-fit:cover;" alt="User Image">
                            @else
                              <img src="{{ asset('/images/default-user.png') }}" width="50" height="50" style="object-fit:cover;" alt="User Image">
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->phone_no }}</td>
                        <td>{{ $user->country }}</td>
                        <td>{{ $user->state }}</td>
                        <td>{{ $user->city }}</td>
                        <td>
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            @if($user->deleted_at)
                              <form action="{{ route('restore', $user->id) }}" method="POST" style="display:inline;">
                                  @csrf
                                  @method('PATCH')
                                  <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-trash-restore-alt"></i></button>
                              </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                      <tr>
                        <td colspan="10" class="text-center">No users found.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
                <div class="d-flex mt-3 justify-content-end">
                    {{ $users->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
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
    $('#usersTable').DataTable({
        paging: false,
        searching: false, // Laravel handles it
        ordering: true,
        columnDefs: [ { orderable: false, targets: [1, 9] }],
        info: true,
        autoWidth: false,
        responsive: true
    });

    $(".dataTables_info").html(
            'Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries'
        );
});
</script>
