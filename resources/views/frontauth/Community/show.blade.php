@extends('frontauth.layouts.main')
@section('title')
Community & Events 
@endsection
@section('content')

<div class="container-fluid mt-4">
    <div class="mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <h4 class="h5 fw-bold mb-3 mb-md-0">Community & Events Attendees List</h4>
        </div>
        {{-- <div class="col-lg-6 ms-auto">
            <form method="GET" action="{{ route('community.index') }}">
                <div class="row gy-3 gx-3 align-items-end">
                    <div class="col-12 col-md-8">
                        <label for="search" class="form-label mb-1">Search</label>
                        <input type="text" autocomplete="off" class="form-control inner-form mb-0" id="search" name="search"
                            value="{{ request('search') }}" placeholder="Search By Event...">
                    </div>

                    <div class="col-12 col-md-4 d-flex gap-2">
                        <button class="btn btn-primary w-100" type="submit">Search</button>
                        <a href="{{ route('community.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div> --}}
    </div>


    <!--Data table-->
    <div class="row mb-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card border-0">
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">User Email</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Join Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$community->isEmpty())
                                    @foreach($community as $key=>$value)                               
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>                                                    
                                                        <img src="{{(@$value->user->profile_photo_path)?asset('storage/'.@$value->user->profile_photo_path):asset('front/home/assets/images/logo/logo.svg')}}" width="80" class="avatar avatar-sm me-3" alt="image-1">   
                                                    </div>
                                                </div>
                                                
                                            </td>
                                            <td><span class="text-xs font-weight-bold"> {{ @$value->user->name }} </span></td>
                                            <td><span class="text-xs font-weight-bold"> {{ @$value->user->email }} </span></td>
                                            <td class="align-middle text-center">
                                                <span class="text-xs font-weight-bold">{{@$value->created_at->format('d M Y')}}</span>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                        <div class="col-lg-12 mx-auto mt-4">
                                            <nav aria-label="Page navigation example">
                                                <div class="Page navigation example">
                                                    <ul class="pagination d-flex justify-content-center align-items-center">
                                                        <h4>No Attendees Records found...</h4>
                                                    </ul>
                                                </div>
                                            </nav>
                                        </div>
                                        </td>
                                    </tr>
               
                                @endif
                            </tbody>
                        </table>

                        <div class="col-lg-12 mx-auto mt-4">
                            <nav aria-label="Page navigation example">
                                <div class="Page navigation example">
                                    <ul class="pagination d-flex justify-content-center align-items-center">
                                        {{ ($community->count()>0) ? $community->links('pagination::bootstrap-4'):''}}
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
<script>

</script>
@endsection