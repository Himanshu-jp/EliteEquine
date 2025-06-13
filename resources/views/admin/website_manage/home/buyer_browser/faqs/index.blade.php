@extends('admin.app')

@section('title', 'Buyer FAQ List')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Buyer FAQ List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">FAQ List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-4">
                        <a href="{{ route('buyer-faqs.create') }}" class="btn btn-primarys">Create Buyer FAQ</a>
                    </div>
                     <!-- Filter form -->
                        <form action="{{ route('buyer-faqs.index') }}" method="GET" class="form-inline">
                            <input type="text" name="question" class="form-control mr-2" placeholder="Search by question..." value="{{ request('question') }}">
                            <button type="submit" class="btn btn-primarys mr-2">Filter</button>
                            <a href="{{ route('buyer-faqs.index') }}" class="btn btn-secondary">Reset</a>
                        </form>
                    <table id="faqTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($faqs->count())
                                @foreach($faqs as $key => $faq)
                                    <tr>
                                        <td>{{ $faqs->firstItem() + $key }}</td>
                                        <td>{{ $faq->questions }}</td>
                                        <td>{!! Str::limit($faq->answers, 100) !!}</td>
                                        <td>
                                            <a href="{{ route('buyer-faqs.edit', $faq->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                            <a href="{{ route('buyer-faqs.show', $faq->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                            <form action="{{ route('buyer-faqs.destroy', $faq->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="text-center">No FAQs Found</td></tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="d-flex mt-3 justify-content-end">
                        {{ $faqs->withQueryString()->onEachSide(1)->links('pagination::bootstrap-4') }}
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
    $('#faqTable').DataTable({
        paging: false,
        lengthChange: true,
        searching: false,
        ordering: true,
        columnDefs: [{ orderable: false, targets: [2, 3] }],
        info: true,
        autoWidth: false,
        responsive: true
    });
});
</script>
