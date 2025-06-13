@extends('frontauth.layouts.main')
@section('title')
HJ Forum Listing
@endsection
@section('content')

<div class="container-fluid mt-4">
    <!-- <div class="ms-0 mb-3  d-flex align-items-center justify-content-between flex-wrap">
        <h4 class="h5 font-weight-bolder">Product Listing</h4>
            <form method="GET" action="{{ route('productList') }}">
                <div class="row">

                        <div class="mb-3">
                            <input type="text" autocomplete="off" class="inner-form form-control mb-0" id="search" name="search"
                            value="{{request('search')}}" placeholder="Search by product name...">


                            <select name="category" id="category" name="category">
                                <option value="">Select Category</option>
                                @foreach(__categoryData() as $key=>$val)
                                    <option value="{{$key}}" {{(request('category')==$key)?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                            
                        </div>            

                        <div class="mb-3">                       
                            <button class="btn btn-primary" type="submit">Search</button>
                            <a href="{{route('productList')}}"><button class="btn btn-secondary" type="button">Reset</button></a>
                        </div>
                </div>
            </form>


        <div class="d-flex align-items-center gap-3 ">
            <a href="{{route('product')}}" class="btn btn-primary">Submit Ad</a>
        </div>

    </div> -->

    <div class="mb-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
            <h4 class="h5 fw-bold mb-3 mb-md-0">HJ Forum Listing</h4>
            <a href="{{ route('hjForum.create') }}" class="btn btn-primary">Add Forum</a>
        </div>
        <div class="col-lg-6 ms-auto">
            <form method="GET" action="{{ route('hjForum.index') }}">
            <div class="row gy-3 gx-3 align-items-end">
                <div class="col-12 col-md-8">
                    <label for="search" class="form-label mb-1">Search</label>
                    <input type="text" autocomplete="off" class="form-control inner-form mb-0" id="search" name="search"
                        value="{{ request('search') }}" placeholder="Search by title...">
                </div>

                <div class="col-12 col-md-4 d-flex gap-2">
                    <button class="btn btn-primary w-100" type="submit">Search</button>
                    <a href="{{ route('hjForum.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </div>
        </form>
        </div>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$forum->isEmpty())
                                    @foreach($forum as $key=>$value)                               
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>                                                    
                                                        <img src="{{(@$value->image)?asset('storage/'.@$value->image):asset('front/home/assets/images/logo/logo.svg')}}" width="80" class="avatar avatar-sm me-3" alt="image-1">   
                                                    </div>
                                                </div>
                                                
                                            </td>
                                            <td><span class="text-xs font-weight-bold"> {{ Str::limit(@$value->title, 40, '...') }} </span></td>
                                           
                                            
                                            <td class="align-middle text-center">
                                                <span class="text-xs font-weight-bold"> {{ Str::limit(@$value->description, 100, '...') }}  </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-xs font-weight-bold">{{@$value->created_at->format('d M Y')}}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('hjForum.edit',@$value->id)}}" class="text-dark me-2"><i class="fi fi-rr-pencil"></i></a>
                                                
                                                <span class="text-dark confirm-button" data-href="{{route('hjForum.delete',$value->id)}}">
                                                    <i class="fi fi-rr-trash"></i>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">
                                        <div class="col-lg-12 mx-auto mt-4">
                                            <nav aria-label="Page navigation example">
                                                <div class="Page navigation example">
                                                    <ul class="pagination d-flex justify-content-center align-items-center">
                                                        <h4>No Hj forum found...</h4>
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
                                        {{ ($forum->count()>0) ? $forum->links('pagination::bootstrap-4'):''}}
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