@extends('admin.app')

@section('title', 'View About Seller Business')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">About Seller Business - View</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">View About Seller Business</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="d-flex justify-content-end mt-4 mr-4">
                            @if(!$business)
                            <a href="{{ route('about-seller-business.create') }}" class="btn btn-primarys">Add Seller Business</a>
                            @else
                            <a href="{{ route('about-seller-business.edit', $business->id) }}" class="btn btn-primarys">Edit Seller Business</a>
                            @endif
                        </div>
                <div class="card-body">
                    <!-- Title -->
                     {{--<div class="form-group">
                        <label>Title</label>
                        <p>{{ @$business->title ?? 'N/A' }}</p>
                    </div>
                    
                    <!-- Description -->
                    <div class="form-group">
                        <label>Main Description</label>
                        <div class="border p-3" style="background-color: #f9f9f9; min-height: 100px;">
                            {!! @$business->description !!}
                        </div>
                    </div>--}}
                    <!-- Image -->
                    <div class="form-group">
                        <label>Main Image</label><br>
                        @if(!empty($business) && !empty($business->image))
                            <img src="{{ asset('storage/'.$business->image) }}" alt="Main Image" style="max-width: 300px;">
                        @else
                            <p><em>No image available</em></p>
                        @endif
                    </div>

                    @php
                        $sections = ['listing' => 'Listing', 'track' => 'Track', 'featured' => 'Featured', 'post' => 'Post'];
                    @endphp

                    @foreach ($sections as $key => $label)
                        <hr>
                        <h5>{{ $label }} Section</h5>

                        <div class="form-group">
                            <label>Icon</label><br>
                            @if(@$business->{$key.'_icon'})
                                <img src="{{ asset('storage/'.$business->{$key.'_icon'}) }}" alt="{{ $label }} Icon" style="max-width: 100px;">
                            @else
                                <p><em>No icon uploaded</em></p>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <p>{{ @$business->{$key.'_title'} ?? 'N/A' }}</p>
                        </div>

                        <div class="form-group">
                            <label>Content</label>
                            <div class="border p-3" style="background-color: #f9f9f9; min-height: 70px;">
                                {!! @$business->{$key.'_content'} ?? 'N/A' !!}
                            </div>
                        </div>
                    @endforeach
                </div>

                {{--<div class="card-footer">
                    <a href="{{ route('sellers_business.edit', @$business->id) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('sellers_business.index') }}" class="btn btn-secondary">Back to List</a>
                </div>--}}
            </div>
        </div>
    </section>
</div>
@endsection
