@extends('admin.app')

@section('title', 'Product Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Product Details</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products List</a></li>
                        <li class="breadcrumb-item active">Product Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="d-flex justify-content-end mt-3 mr-3">
                    <a href="{{ route('products.index') }}" class="btn btn-success">Back</a>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-2">
                            <h4>Product Images</h4>
                            @foreach ($product->image ?? [] as $index => $image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $image->image) }}"
                                         class="img-fluid img-thumbnail cursor-pointer open-image-carousel"
                                         data-index="{{ $loop->index }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-10">
                            <h4>Basic Information</h4>
                            <ul class="list-unstyled">
                                <li><strong>Title:</strong> {{ $product->title }}</li>
                                <li><strong>Slug:</strong> {{ $product->slug }}</li>
                                <li><strong>Price:</strong> {{ $product->currency }} {{ number_format($product->price, 2) }}</li>
                                <li><strong>Negotiable:</strong> {{ $product->is_negotiable ? 'Yes' : 'No' }}</li>
                                <li><strong>Sale Method:</strong> {{ ucfirst($product->sale_method) }}</li>
                                <li><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</li>
                                @if(in_array($product->category_id,[1,3]))
                                    <li><strong>Subcategory:</strong> {{
                                        @$product->subcategory->map(function($show) {
                                            return $show->category->name;
                                        })->filter()->implode(', ')
                                    
                                    }}</li>
                                @endif
                                <li><strong>Description:</strong> {!! $product->description !!}</li>
                                <li><strong>External Link:</strong>
                                    <a href="{{ $product->external_link }}" target="_blank">{{ $product->external_link }}</a>
                                </li>
                                <li><strong>Favorited:</strong> {{ $product->is_favorited ? 'Yes' : 'No' }}</li>
                                <li><strong>Created At:</strong> {{ \Carbon\Carbon::parse($product->created_at)->format('d M, Y') }}</li>
                                <li><strong>Updated At:</strong> {{ \Carbon\Carbon::parse($product->updated_at)->format('d M, Y') }}</li>
                            </ul>
                        </div>
                    </div>

                    <hr>

                    <h4>Product Videos</h4>
                    <div class="row">
                        @foreach ($product->video ?? [] as $index => $video)
                            <div class="col-md-2 mb-3 text-center">
                                <img src="{{ $video->thumbnail ? asset('storage/' . $video->thumbnail) : asset('images/default-blog.png') }}"
                                     class="img-fluid border cursor-pointer open-video-carousel"
                                     
                                     data-index="{{ $loop->index }}">
                            </div>
                        @endforeach
                    </div>

                    <hr>

                    <h4>Product Documents</h4>
                    @forelse ($product->document ?? [] as $doc)
                        <p>
                            <a href="{{ asset('storage/' . $doc->file) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                View Document (ID: {{ $doc->id }})
                            </a>
                        </p>
                    @empty
                        <p>No documents available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Image Gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <div class="modal-body bg-black">
                <div id="imageCarousel" class="carousel slide" data-ride="carousel" data-wrap="true">
                    <div class="carousel-inner" id="imageCarouselInner"></div>
                    <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Video Gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <div class="modal-body bg-black">
                <div id="videoCarousel" class="carousel slide" data-ride="carousel" data-wrap="true">
                    <div class="carousel-inner" id="videoCarouselInner"></div>
                    <a class="carousel-control-prev" href="#videoCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#videoCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageItems = [
            @foreach ($product->image ?? [] as $image)
                '{{ asset('storage/' . $image->image) }}',
            @endforeach
        ];

        const videoItems = [
            @foreach ($product->video ?? [] as $video)
                '{{ asset('storage/' . $video->video_url) }}',
            @endforeach
        ];

        function updateCarouselControls(carouselId) {
            const $carousel = $(carouselId);
            const $items = $carousel.find('.carousel-item');
            const activeIndex = $items.index($carousel.find('.carousel-item.active'));

            $carousel.find('.carousel-control-prev').toggle(activeIndex > 0);
            $carousel.find('.carousel-control-next').toggle(activeIndex < $items.length - 1);
        }

        $('.open-image-carousel').on('click', function () {
            const index = $(this).data('index');
            let content = '';
            imageItems.forEach((src, i) => {
                content += `
                    <div class="carousel-item ${i == index ? 'active' : ''}">
                        <img src="${src}" class="d-block w-100" style="max-height:600px;">
                    </div>`;
            });
            $('#imageCarouselInner').html(content);
            $('#imageModal').modal('show');
            setTimeout(() => updateCarouselControls('#imageCarousel'), 200); // Wait for DOM render
        });

        $('.open-video-carousel').on('click', function () {
            const index = $(this).data('index');
            let content = '';
            videoItems.forEach((src, i) => {
                content += `
                    <div class="carousel-item ${i == index ? 'active' : ''}">
                        <video src="${src}" class="d-block w-100" style="max-height:500px;" controls autoplay></video>
                    </div>`;
            });
            $('#videoCarouselInner').html(content);
            $('#videoModal').modal('show');
            setTimeout(() => updateCarouselControls('#videoCarousel'), 200);
        });

        $('#imageCarousel, #videoCarousel').on('slid.bs.carousel', function () {
            updateCarouselControls('#' + $(this).attr('id'));
        });

        $('#imageModal, #videoModal').on('hidden.bs.modal', function () {
            $(this).find('.carousel-inner').html('');
        });
    });
</script>

