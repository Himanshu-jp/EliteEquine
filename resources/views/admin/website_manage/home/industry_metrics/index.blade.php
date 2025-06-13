@extends('admin.app')

@section('title', 'Industry Metrics List')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Industry Metrics List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Industry Metrics List</li>
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
                        <div class="d-flex justify-content-end m-4">
                            <a href="{{ route('industry_metrics.create') }}" class="btn btn-primarys">Create Inustry Metric</a>
                        </div>
                        <div class="card-body">
                            <table id="metricsTable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Icon</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!$industryMetrics->isEmpty())
                                        @foreach($industryMetrics as $key => $metric)
                                            <tr>
                                                <td>{{ $industryMetrics->firstItem() + $key }}</td>
                                                <td>
                                                    @if($metric->image)
                                                        <div style="position: relative; display: inline-block;">
                                                            <img src="{{ asset('storage/' . $metric->image) }}" width="60" alt="icon" style="border: 1px solid #ddd; border-radius: 4px; padding: 2px;">
                                                            {{--<form action="{{ route('industry_metrics.icon.delete', $metric->id) }}" method="POST" style="position: absolute; top: -8px; right: -8px;" onsubmit="return confirm('Delete this icon?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger p-0" style="width: 20px; height: 20px; font-size: 19px; border-radius: 50px; line-height: 1;">×</button>
                                                            </form>--}}
                                                        </div>
                                                    @else
                                                        <img src="{{ asset('images/default-blog.png') }}" width="60" alt="default icon">
                                                    @endif
                                                </td>
                                                <td>{{ $metric->title }}</td>
                                                <td>{{ Str::limit($metric->description, 50) }}</td>
                                                <td>
                                                    <a href="{{ route('industry_metrics.edit', $metric->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('industry_metrics.show', $metric->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                                    <form action="{{ route('industry_metrics.destroy', $metric->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No Industry Metrics Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div class="d-flex mt-3 justify-content-end">
                                {{ $industryMetrics->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<!-- DataTables Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#metricsTable').DataTable({
        paging: false,
        lengthChange: true,
        searching: true,
        ordering: true,
        columnDefs: [ { orderable: false, targets: [1, 5] }],
        info: true,
        autoWidth: false,
        responsive: true
    });
});
</script>
