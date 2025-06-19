@extends('frontauth.layouts.main')
@section('title')
    Your Ads
@endsection
@section('content')

    <div class="container-fluid mt-4">
        <div class="ms-0 mb-3  d-flex align-items-center justify-content-between flex-wrap">
            <h4 class="h5 font-weight-bolder">Post Ad</h4>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('product') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            <div class="row">
                <input type="hidden" name="id" value="{{ @$products->id }}">
                <input type="hidden" name="category" value="{{ @$products->category_id }}">
                <div class="col-lg-6">
                    {{-- <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap">
                    <h6>Return Available:</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="return_available" checked id="yes" value="yes" {{(old('return_available')=='yes' || @$products->return_available=='yes')?'checked':''}}>
                        <label class="form-check-label fw-bold text-dark" for="yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="return_available" id="no" value="no" {{(old('return_available')=='no' || @$products->return_available=='no')?'checked':''}}>
                        <label class="form-check-label fw-bold text-dark" for="no">No</label>
                    </div>
                    @if ($errors->has('return_available'))
                        <span class="error text-danger">{{$errors->first('return_available')}}</span>
                    @endif
                </div> --}}

                    {{-- <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap">
                    <h6>Auction Winner Pay Within:</h6>
                    <div class="">
                        <input class="form-control form-control-sm" type="text" placeholder="Hours">
                    </div>
                </div> --}}

                    <div class="mt-3">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" autocomplete="off" class="inner-form form-control mb-0" id="title"
                                name="title" value="{{ old('title', @$products->title) }}"
                                placeholder="Short and Sweet Name only is Preferred">
                            @if ($errors->has('title'))
                                <span class="error text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>

                        <div class="position-relative">
                            <label for="exampleFormControlInput1" class="form-label">Currency</label>
                            <select class="form-select pe-5 mb-2 inner-form form-control" name="currency">
                                <option value="">Select an currency</option>
                                @foreach ($currencyList as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('currency') == $key || @$products->currency == $key ? 'selected' : '' }}>
                                        {{ $key }}</option>
                                @endforeach
                                {{-- <option value="USD" {{(old('currency')=='USD' || @$products->currency=='USD')?'selected':''}}>USD ($)</option>
                            <option value="AUD" {{(old('currency')=='AUD' || @$products->currency=='AUD')?'selected':''}}>AUD ($)</option> --}}
                            </select>

                            <i class="fi fi-rr-angle-small-down"
                                style="position: absolute;
                                    top: 63%;
                                    right: 30px;
                                    transform: translateY(-50%);
                                    pointer-events: none;
                                    color: #555;"></i>
                            @if ($errors->has('currency'))
                                <span class="error text-danger">{{ $errors->first('currency') }}</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="" class="form-label">Image</label>
                            <div class="file-upload ">
                                <div class="profile mt-2">
                                    <img src="{{ @$products->image ? asset('storage/' . @$products->image) : asset('front/auth/assets/img/icons/image.svg') }}"
                                        for="image" class="user-img" alt="" id="editImg">
                                </div>
                                <input type="file" id="image" name="image[]" multiple
                                    style="display: none; cursor: pointer;" onchange="handleImageUpload(event)"
                                    accept=".png, .jpg, .jpeg">

                                <h5 class="pt-3">Select Images </h5>
                                <a href="#" class="upload-image">
                                    <h6 id="uploadTriggerImage">Browse File</h6>
                                </a>

                            </div>
                            <div id="ImagesShowPreview" class="d-flex gap-2 flex-wrap mt-2"></div>
                            @if (@$products && @$products->image->count() > 0)
                                <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap mt-2">
                                    @foreach (@$products->image as $key => $image)
                                        <div class="position-relative">
                                            <a href="{{ asset('storage/' . $image->image) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $image->image) }}" alt="Image"
                                                    class="img-thumbnail" style="width: 150px;">
                                            </a>
                                            @if (@$products->image->count() > 1)
                                                <a href="{{ route('removeImage', $image->id) }}"><span
                                                        class="close-icon">&times;</span></a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if ($errors->has('image'))
                                <span class="error text-danger">{{ $errors->first('image') }}</span>
                            @endif

                        </div>


                        <div>
                            <label for="description" class="form-label">Description <span data-toggle="tooltip"
                                    data-placement="top" title="Describe your product">
                                    <img src="{{ asset('images/letter-i.png') }}" width="15" height="15"
                                        alt="" />
                                </span></label>
                            <textarea class="inner-form form-control h-auto" id="description" name="description" rows="8"
                                placeholder="Enter product details here...">{{ old('description', @$products->description) }}</textarea>
                            @if ($errors->has('description'))
                                <span class="error text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="col-lg-6 mt-3">
                    {{-- <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap">
                    <h6>Return Available: </h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioDefault" id="Yes" checked>
                        <label class="form-check-label fw-bold text-dark" for="Yes">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioDefault" id="No" checked>
                        <label class="form-check-label fw-bold text-dark" for="No">No</label>
                    </div>
                    <div>
                        <input class="form-control form-control-sm" type="text" placeholder="How many days">
                    </div>
                </div> --}}

                    <div class="row">

                        @if (@$products->category_id)
                            <div class="position-relative mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Category*</label>
                                <input type="text" autocomplete="off" class="inner-form form-control mb-0 pe-5" readonly
                                    value="{{ @$products->category->name }}" id="category"
                                    data-category-id="{{ @$products->category->id }}" placeholder="Category">
                            </div>
                        @else
                            <div class="position-relative">
                                <label for="exampleFormControlInput1" class="form-label">Category*</label>
                                <select class="form-select pe-5 mb-2 inner-form form-control" name="category"
                                    id="category">
                                    <option value="">-- Select Category --</option>
                                    @foreach (__categoryData() as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ old('category', @$products->category_id) == $key ? 'selected' : '' }}>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                                <i class="fi fi-rr-angle-small-down"
                                    style="position: absolute;
                                            top: 63%;
                                            right: 30px;
                                            transform: translateY(-50%);
                                            pointer-events: none;
                                            color: #555;"></i>
                                @if ($errors->has('category'))
                                    <span class="error text-danger ">{{ $errors->first('category') }}</span>
                                @endif
                            </div>
                        @endif

                        <div class="mb-2">
                            <label class="form-label">Add External Links <span data-toggle="tooltip" data-placement="top"
                                    title="Enter the external link for your product.">
                                    <img src="{{ asset('images/letter-i.png') }}" width="15" height="15"
                                        alt="" />
                                </span></label>
                            <div id="external-links-wrapper">
                                @php
                                    $externalLinks = old(
                                        'external_link',
                                        isset($products->externalLink) ? $products->externalLink : [''],
                                    );
                                @endphp
                                @foreach ($externalLinks as $index => $link)
                                    <div class="position-relative mb-2 external-link-group">
                                        <input type="text" name="external_link[]"
                                            class="inner-form form-control mb-0 pe-5" placeholder="Add External Link..."
                                            value="{{ @$link->link }}" autocomplete="off">
                                        <button type="button" class="remove-link" style="z-index:2;">&times;</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-link-btn" class="btn btn-sm btn-primary mt-2">+ Add More
                                Link</button>
                            @error('external_link.*')
                                <span class="error text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-2">
                            <label class="form-label">Add Video Links <span data-toggle="tooltip" data-placement="top"
                                    title="Enter the video link for your product.">
                                    <img src="{{ asset('images/letter-i.png') }}" width="15" height="15"
                                        alt="" />
                                </span></label>
                            <div id="external-video-links-wrapper">
                                @php
                                    $externalLinks = old(
                                        'video_link',
                                        isset($products->videoLink) ? $products->videoLink : [''],
                                    );
                                @endphp
                                @foreach ($externalLinks as $index => $link)
                                    <div class="position-relative mb-2 external-video-link-group">
                                        <input type="text" name="video_link[]"
                                            class="inner-form form-control mb-0 pe-5" placeholder="Add Video Link..."
                                            value="{{ @$link->link }}" autocomplete="off">
                                        <button type="button" class="remove-video-link "
                                            style="z-index:2;">&times;</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-video-link-btn" class="btn btn-sm btn-primary mt-2">+ Add More
                                Link</button>
                            @error('video_link.*')
                                <span class="error text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>



                        {{-- <div class="position-relative">
                        <label for="external_link" class="form-label">Add External Links</label>
                        <input type="text" autocomplete="off" class="inner-form form-control mb-0 pe-5" id="external_link" name="external_link"
                            value="{{old('external_link', @$products->external_link)}}" placeholder="Add External Links...">
                        <button type="button" class="add-new-link">+ Add More</button>
                        @if ($errors->has('external_link'))
                            <span class="error text-danger">{{$errors->first('external_link')}}</span>
                        @endif
                    </div>
                    
                    <div class="position-relative">
                        <label for="video_link" class="form-label">Add Video Links</label>
                        <input type="text" autocomplete="off" class="inner-form form-control mb-0 pe-5" id="video_link" name="video_link"
                            value="{{old('video_link', @$products->video_link)}}" placeholder="Add Vidoe Links...">
                        <button type="button" class="add-new-link">+ Add More</button>
                        @if ($errors->has('video_link'))
                            <span class="error text-danger">{{$errors->first('video_link')}}</span>
                        @endif

                    </div> --}}


                    </div>


                    <div class="mb-3">
                        <label for="" class="form-label">Videos</label>
                        <div class="file-upload">
                            <div class="profile mt-2">
                                <img src="{{ @$products->video ? asset('storage/' . @$products->video) : asset('front/auth/assets/img/icons/video.svg') }}"
                                    class="user-img" alt="" id="editVideo">
                            </div>
                            <input type="file" id="video" name="video[]" multiple
                                style="display: none; cursor: pointer;" onchange="handleVideoUpload(event)"
                                accept=".mp4,.avi,.mov,.wmv">

                            <h5 class="pt-3">Select video files </h5>
                            <a href="#" class="upload-image">
                                <h6 id="uploadTriggerVideo">Browse File</h6>
                            </a>
                        </div>
                        <div id="videoShowPreview"></div>
                        @if (@$products && @$products->video->count() > 0)
                            <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap mt-2">
                                @foreach (@$products->video as $image)
                                    <div class="position-relative">
                                        <a href={{ asset('storage/' . $image->video_url) }} target="_blank">
                                            <img src="{{ asset('front/auth/assets/img/icons/video.svg') }}"
                                                class="user-img" alt="" id="editVideo"
                                                style="width: 50px; height: 50px;">
                                        </a>
                                        @if (@$products->video->count() > 0)
                                            <a href="{{ route('removeVideo', $image->id) }}"><span
                                                    class="close-icon">&times;</span></a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($errors->has('video'))
                            <span class="error text-danger">{{ $errors->first('video') }}</span>
                        @endif
                    </div>



                    <div class="mb-3">
                        <label for="" class="form-label">
                            Optional PDF Upload (So you can upload things like health certs, PPES, purchase or pre-purchase
                            docs etc.)
                        </label>
                        <div class="file-upload">
                            <div class="profile mt-2">
                                <img src="{{ @$products->document ? asset('storage/' . @$products->document) : asset('front/auth/assets/img/icons/pdf-icon.svg') }}"
                                    class="user-img" alt="" id="editDocument">
                            </div>
                            <input type="file" id="document" name="document[]" multiple
                                style="display: none; cursor: pointer;" onchange="handleDocumentUpload(event)"
                                accept=".pdf,.doc,.docx">

                            <h5 class="pt-3">Select pdf & document format files. </h5>
                            <a href="#" class="upload-image">
                                <h6 id="uploadTriggerDocument">Browse File</h6>
                            </a>

                        </div>
                           
                        <div id="documentShowPreview" class="d-flex gap-2 flex-wrap mt-2"></div>
                        @if (@$products && @$products->document->count() > 0)
                            <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap mt-2">
                                @foreach (@$products->document as $image)
                                    <div class="position-relative">
                                        <a href={{ asset('storage/' . $image->file) }} target="_blank">
                                            <img src="{{ asset('front/auth/assets/img/icons/pdf-icon.svg') }}"
                                                class="user-img" alt="" id="editImg"
                                                style="width: 50px; height: 50px;">
                                        </a>
                                        @if (@$products->document->count() > 0)
                                            <a href="{{ route('removeDocument', $image->id) }}"><span
                                                    class="close-icon">&times;</span></a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if ($errors->has('document'))
                            <span class="error text-danger">{{ $errors->first('document') }}</span>
                        @endif
                    </div>


                </div>

                <div class="col-lg-6 mt-3">
                    <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap">
                        <h6>Select Sale Method:</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sale_method" id="standard"
                                value="standard"
                                {{ old('sale_method') == 'standard' || @$products->sale_method == 'standard' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-dark" for="standard">Standard</label>
                        </div>
                        <div class="form-check" id="auction_action">
                            <input class="form-check-input" type="radio" name="sale_method" id="auction"
                                value="auction"
                                {{ old('sale_method') == 'auction' || @$products->sale_method == 'auction' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-dark" for="auction">Auction</label>
                        </div>
                        @if ($errors->has('sale_method'))
                            <span class="error text-danger">{{ $errors->first('sale_method') }}</span>
                        @endif
                    </div>

                    <div class="col-lg-6 mb-3" id="bid_expire">
                        <label for="bid_end_date" class="form-label">Bid End Date</label>
                        <input type="date" autocomplete="off" class="inner-form form-control mb-0" id="bid_end_date"
                            name="bid_end_date" value="{{ old('bid_end_date', @$products->bid_expire_date) }}"
                            placeholder="Please select Bid end date">
                        @if ($errors->has('bid_end_date'))
                            <span class="error text-danger">{{ $errors->first('bid_end_date') }}</span>
                        @endif
                    </div>

                    <div class="col-lg-6 mb-3" id="bid_price">
                        <label for="bid_min_price" class="form-label">Bid Minimum Price</label>
                        <input type="text" name="bid_min_price" id="bid_min_price"
                            class="inner-form form-control mb-0 numbervalid" placeholder="Enter bid minimum price"
                            value="{{ old('bid_min_price', @$products->productDetail->bid_min_price) }}">
                        @if ($errors->has('bid_min_price'))
                            <span class="error text-danger">{{ $errors->first('bid_min_price') }}</span>
                        @endif
                    </div>
                </div>


                <div class="d-flex align-items-center justify-content-start gap-2 flex-wrap">
                    <h6>Select Transaction Method:</h6>
                    <div class="form-check" id="ourPlatformId">
                        <input class="form-check-input" type="radio" name="transaction_method" id="platform"
                            value="platform"
                            {{ old('transaction_method') == 'platform' || @$products->transaction_method == 'platform' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="platform">Our Platform
                            <span data-toggle="tooltip" data-placement="top" title="Our Platform.">
                                <img src="{{ asset('images/letter-i.png') }}" width="15" height="15"
                                    alt="" />
                            </span>
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="transaction_method" id="buyertoseller"
                            value="buyertoseller"
                            {{ old('transaction_method') == 'buyertoseller' || @$products->transaction_method == 'buyertoseller' ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold text-dark" for="buyertoseller">Buyer To Seller Connection
                            Only
                            <span data-toggle="tooltip" data-placement="top"
                                title="Allows direct contact between buyer and seller for this transaction method.">
                                <img src="{{ asset('images/letter-i.png') }}" width="15" height="15"
                                    alt="" />
                            </span>
                        </label>
                    </div>
                    @if ($errors->has('transaction_method'))
                        <span class="error text-danger">{{ $errors->first('transaction_method') }}</span>
                    @endif
                </div>

                <div class="col-lg-6 mb-3" id="priceDiv" style="display: none;">
                    <div class="d-flex align-items-center justify-content-between">
                        <label for="price" class="form-label">Price</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_negotiable" name="is_negotiable"
                                {{ old('is_negotiable') == 'on' || @$products->is_negotiable == 'yes' ? 'checked' : '' }}>
                            <label class="form-check-label" for="Height_hands">Is Negotiable?</label>
                        </div>
                    </div>
                    <input type="text" autocomplete="off" class="inner-form form-control mb-0 numbervalid"
                        id="price" name="price" value="{{ old('price', @$products->price) }}"
                        placeholder="Enter Price...">
                    @if ($errors->has('price'))
                        <span class="error text-danger">{{ $errors->first('price') }}</span>
                    @endif
                </div>


            </div>

            <hr class="horizontal dark mt-0 mt-5">

            <div class="text-end my-3">
                <button type="submit" class="btn btn-primary" id="product-form-submit">Continue</button>
            </div>
        </form>


    </div>
    <style>
        .upload-image {
            cursor: pointer;
        }

        /* .file-upload input[type="file"] {
            display: none;
        } */

        .file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 1px;
            height: 1px;
            z-index: -1;
        }
    </style>

@endsection

@section('script')
    <script>
        //--------for external links----------//
        $(document).ready(function() {
            $('#add-link-btn').click(function() {
                let newField = `
                <div class="position-relative mb-2 external-link-group">
                    <input type="text" name="external_link[]" class="inner-form form-control mb-0 pe-5" placeholder="Add External Link...">
                    <button type="button" class="remove-link " style="z-index:2;">&times;</button>
                </div>`;
                $('#external-links-wrapper').append(newField);
            });

            $(document).on('click', '.remove-link', function() {
                $(this).closest('.external-link-group').remove();
            });
        });

        //---------for video links-------------//
        $(document).ready(function() {
            $('#add-video-link-btn').click(function() {
                let newField = `
                <div class="position-relative mb-2 external-video-link-group">
                    <input type="text" name="video_link[]" class="inner-form form-control mb-0 pe-5" placeholder="Add Video Link...">
                    <button type="button" class="remove-video-link" style="z-index:2;">&times;</button>
                </div>`;
                $('#external-video-links-wrapper').append(newField);
            });

            $(document).on('click', '.remove-video-link', function() {
                $(this).closest('.external-video-link-group').remove();
            });
        });




        // document.getElementById('plusIcon').addEventListener('click', function() {
        //     // Yahan pe aap file upload ya koi bhi action likh sakte ho
        //     alert('Plus icon clicked!');
        // });

        const uploadTriggerImage = document.getElementById('uploadTriggerImage');
        const fileInputImage = document.getElementById('image');

        uploadTriggerImage.addEventListener('click', () => {
            // alert('Image trigger clicked!');
            fileInputImage.click();
        });

        const uploadTriggerVideo = document.getElementById('uploadTriggerVideo');
        const fileInputVideo = document.getElementById('video');

        uploadTriggerVideo.addEventListener('click', () => {
            // alert('Video trigger clicked!');
            fileInputVideo.click();
        });

        const uploadTriggerDocument = document.getElementById('uploadTriggerDocument');
        const fileInputDocument = document.getElementById('document');

        uploadTriggerDocument.addEventListener('click', () => {
            // alert('Document trigger clicked!');
            fileInputDocument.click();
        });

        //--------for document upload & remove preview-----
        let selectedDocs = [];

        function handleDocumentUpload(event) {
            const files = Array.from(event.target.files);
            const maxSize = 5 * 1024 * 1024; // 5MB

            files.forEach(file => {
                if (file.size > maxSize) {
                    alert(`"${file.name}" is too large. Max size allowed is 5MB.`);
                    return;
                }

                const isDuplicate = selectedDocs.some(f => f.name === file.name && f.size === file.size);
                if (!isDuplicate) {
                    selectedDocs.push(file);
                }
            });

            renderDocumentPreviews();
            updateInputDocuments();
        }

        function renderDocumentPreviews() {
            const previewContainer = document.getElementById("documentShowPreview");
            previewContainer.innerHTML = "";

            selectedDocs.forEach((file, index) => {
                const wrapper = document.createElement("div");
                wrapper.classList.add("position-relative", "me-2", "mb-2");

                const link = document.createElement("a");
                link.href = URL.createObjectURL(file);
                link.target = "_blank";

                const icon = document.createElement("img");
                icon.src = "{{ asset('front/auth/assets/img/icons/pdf-icon.svg') }}";
                icon.alt = "Document Preview";
                icon.className = "user-img";
                icon.style.width = "50px";
                icon.style.height = "50px";

                link.appendChild(icon);
                wrapper.appendChild(link);

                const removeBtn = document.createElement("span");
                removeBtn.innerHTML = "&times;";
                removeBtn.classList.add("close-icon");
                removeBtn.style.position = "absolute";
                removeBtn.style.top = "5px";
                removeBtn.style.right = "5px";
                removeBtn.style.cursor = "pointer";
                removeBtn.onclick = function() {
                    selectedDocs.splice(index, 1);
                    renderDocumentPreviews();
                    updateInputDocuments();
                };

                wrapper.appendChild(removeBtn);
                previewContainer.appendChild(wrapper);
            });
        }

        function updateInputDocuments() {
            const dataTransfer = new DataTransfer();
            selectedDocs.forEach(file => {
                dataTransfer.items.add(file);
            });

            const input = document.getElementById("document");
            input.files = dataTransfer.files;
        }


        //--------for video upload & remove preview-----
        let selectedImages = [];

        function handleImageUpload(event) {
            const files = Array.from(event.target.files);
            const maxSize = 4 * 1024 * 1024; // 4MB in bytes

            files.forEach(file => {
                if (file.size > maxSize) {
                    // alert(`"${file.name}" is too large. Maximum allowed size is 4MB.`);
                    Swal.fire("EliteQuine", `"${file.name}" is too large. Maximum allowed size is 4MB.`, "error");
                    return;
                }

                // prevent duplicates
                const isDuplicate = selectedImages.some(f => f.name === file.name && f.size === file.size);
                if (!isDuplicate) {
                    selectedImages.push(file);
                }
            });

            renderImagePreviews();
            updateInputImages();
        }

        function renderImagePreviews() {
            const previewContainer = document.getElementById("ImagesShowPreview");
            previewContainer.innerHTML = "";

            selectedImages.forEach((file, index) => {
                const wrapper = document.createElement("div");
                wrapper.classList.add("position-relative");

                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.classList.add("img-thumbnail");
                img.style.width = "150px";
                img.style.height = "150px";
                img.style.objectFit = "cover";

                const removeBtn = document.createElement("span");
                removeBtn.innerHTML = "&times;";
                removeBtn.classList.add("close-icon");
                removeBtn.style.position = "absolute";
                removeBtn.style.top = "2px";
                removeBtn.style.right = "8px";
                removeBtn.style.cursor = "pointer";
                removeBtn.style.background = "#fff";
                removeBtn.style.padding = "0 6px";
                removeBtn.style.borderRadius = "50%";
                removeBtn.style.fontWeight = "bold";
                removeBtn.style.color = "#000";
                removeBtn.title = "Remove";

                removeBtn.onclick = function() {
                    selectedImages.splice(index, 1);
                    renderImagePreviews();
                    updateInputImages();
                };

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                previewContainer.appendChild(wrapper);
            });
        }

        function updateInputImages() {
            const dataTransfer = new DataTransfer();
            selectedImages.forEach(file => {
                dataTransfer.items.add(file);
            });

            const input = document.getElementById("image");
            input.files = dataTransfer.files;
        }



        //--------for video upload & remove preview-----
        let selectedVideos = [];

        function handleVideoUpload(event) {

            const files = Array.from(event.target.files);
            const maxSize = 25 * 1024 * 1024; // 10MB in bytes

            files.forEach(file => {
                if (file.size > maxSize) {
                    // alert(`"${file.name}" is too large. Maximum allowed size is 10MB.`);
                    Swal.fire("EliteQuine", `"${file.name}" is too large. Maximum allowed size is 25MB.`, "error");
                    return;
                }

                const isDuplicate = selectedVideos.some(f => f.name === file.name && f.size === file.size);
                if (!isDuplicate) {
                    selectedVideos.push(file);
                }
            });

            renderVideoPreviews();
            updateInputFiles();
        }

        function renderVideoPreviews() {
            const previewContainer = document.getElementById("videoPreviewList") || document.createElement("div");
            previewContainer.id = "videoPreviewList";
            previewContainer.classList.add("video-preview-container");
            previewContainer.innerHTML = "";

            selectedVideos.forEach((file, index) => {
                const wrapper = document.createElement("div");
                wrapper.classList.add("video-wrapper");
                wrapper.style.position = "relative";
                wrapper.style.display = "inline-block";
                wrapper.style.margin = "10px";

                const video = document.createElement("video");
                video.controls = true;
                video.width = 180;
                video.src = URL.createObjectURL(file);

                const removeBtn = document.createElement("span");
                removeBtn.innerHTML = "&times;";
                removeBtn.classList.add("remove-video");
                removeBtn.style.position = "absolute";
                removeBtn.style.top = "5px";
                removeBtn.style.right = "5px";
                removeBtn.style.cursor = "pointer";
                removeBtn.style.fontSize = "18px";
                removeBtn.style.background = "#fff";
                removeBtn.style.padding = "0 5px";
                removeBtn.style.borderRadius = "50%";
                removeBtn.style.width = "20px";
                removeBtn.style.height = "20px";
                removeBtn.style.lineHeight = "20px";

                removeBtn.onclick = function() {
                    selectedVideos.splice(index, 1);
                    renderVideoPreviews();
                    updateInputFiles();
                };

                wrapper.appendChild(video);
                wrapper.appendChild(removeBtn);
                previewContainer.appendChild(wrapper);
            });

            document.querySelector('#videoShowPreview').appendChild(previewContainer);
        }

        function updateInputFiles() {
            const dataTransfer = new DataTransfer();

            selectedVideos.forEach(file => {
                dataTransfer.items.add(file);
            });

            const fileInput = document.getElementById("video");
            fileInput.files = dataTransfer.files;
        }
    </script>

    <script>
        // tooltip
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $("#auction").on('click', function() {
            $("#bid_expire").show();
            $("#bid_price").show();
        });
        $("#standard").on('click', function() {
            $("#bid_end_date").val('');
            $("#bid_min_price").val('');
            $("#bid_expire").hide();
            $("#bid_price").hide();
        });



        //------for transcation method-----kamal--------//

        $("input[name='transaction_method']:checked").each(function() {
            console.log($(this).val());
            if ($(this).val() == "platform") {
                $("#priceDiv").show();
            } else {
                $("#price").val('');
                $("#priceDiv").hide();
            }
        });

        $("#platform").on('click', function() {
            $("#priceDiv").show();
        });
        $("#buyertoseller").on('click', function() {
            $("#price").val('');
            $("#priceDiv").hide();
        });

        function toggleSaleMethodBasedOnCategory() {
            const selectedCategoryId = $('#category').val();

            if (selectedCategoryId === '1') {
                $("#ourPlatformId").hide();
                $('#platform').prop('checked', false);
            } else {
                $("#ourPlatformId").show();
            }

            if (selectedCategoryId === '2') {
                $('#auction_action').show();
                $('#standard').prop('checked', true);
                $("#bid_expire").hide();
                $("#bid_price").hide();
            } else if (selectedCategoryId === '1' || selectedCategoryId === '3' || selectedCategoryId === '4') {
                $('#auction_action').hide();
                $('#standard').prop('checked', true);
                $("#bid_expire").hide();
                $("#bid_price").hide();
            } else {
                $('#auction_action').hide();
                $("#bid_expire").hide();
                $("#bid_price").hide();
            }
        }

        // Run once when the page fully loads
        $(window).on('load', function() {
            toggleSaleMethodBasedOnCategory();

            const cat = $('#category').data('category-id'); // Use .data instead of .attr
            if (cat == 2) {
                $('#auction_action').show();

                if ($("#standard").is(':checked')) {
                    $("#bid_expire").hide();
                    $("#bid_price").hide();
                    $('#standard').prop('checked', true);
                } else {
                    $("#bid_expire").show();
                    $("#bid_price").show();
                    $('#auction').prop('checked', true);
                }
            } else {

                if (cat == '1') {
                    $("#ourPlatformId").hide();
                    $('#platform').prop('checked', false);
                } else {
                    $("#ourPlatformId").show();
                }

                $('#auction_action').hide();
                $('#standard').prop('checked', true);
                $("#bid_expire").hide();
                $("#bid_price").hide();
            }
        });

        // Also run on category change
        $('#category').on('change', function() {
            toggleSaleMethodBasedOnCategory();
        });



        // Calculate date 2 days from today
        let today = new Date();
        today.setDate(today.getDate() + 2);

        // Format date as yyyy-mm-dd
        let yyyy = today.getFullYear();
        let mm = String(today.getMonth() + 1).padStart(2, '0');
        let dd = String(today.getDate()).padStart(2, '0');
        let minDate = `${yyyy}-${mm}-${dd}`;

        // Set min attribute for bid_end_date
        $('#bid_end_date').attr('min', minDate);


        // Run on category change
        $('#category').on('change', function() {
            toggleSaleMethodBasedOnCategory();
        });

        $.validator.addMethod('filesize', function(value, element, param) {
            if (element.files.length === 0) return true;
            for (let i = 0; i < element.files.length; i++) {
                if (element.files[i].size > param) return false;
            }
            return true;
        }, 'File size must be less than specified.');

        $.validator.addMethod("fileRequired", function(value, element) {
            return element.files.length > 0;
        }, "Please upload at least one image.");

        // Custom validator for date at least 2 days after today
        $.validator.addMethod("minDateAfter2Days", function(value, element) {
            if (!value) return false; // required will be checked by required rule

            let selectedDate = new Date(value);
            let today = new Date();
            today.setHours(0, 0, 0, 0); // normalize start of day
            let minDate = new Date(today);
            minDate.setDate(minDate.getDate() + 2);

            return selectedDate >= minDate;
        }, "The date must be at least 2 days from today.");


        $("#productForm").validate({
            rules: {
                sale_method: {
                    required: true,
                },
                transaction_method: {
                    required: true,
                },
                category: {
                    required: true,
                },
                title: {
                    required: true,
                    maxlength: 500
                },
                currency: {
                    required: true,
                    maxlength: 3
                },
                'image[]': {
                    required: true,
                    extension: "jpg|jpeg|png",
                    filesize: 4 * 1024 * 1024 // 4 MB
                },
                'video[]': {
                    extension: "mp4|mov|avi|wmv",
                    filesize: 20 * 1024 * 1024 // 20 MB
                },
                'document[]': {
                    extension: "pdf|doc|docx",
                    filesize: 4 * 1024 * 1024 // 4 MB
                },
                'external_link[]': {
                    url: true,
                    maxlength: 400
                },
                'video_link[]': {
                    url: true,
                    maxlength: 400
                },
                description: {
                    required: true,
                    maxlength: 5000
                },
                price: {
                    required: function(element) {
                        return $('#platform').is(':checked');
                    }
                },
                bid_end_date: {
                    required: function(element) {
                        // validate only if auction is checked
                        return $('#auction').is(':checked');
                    },
                    minDateAfter2Days: function(element) {
                        return $('#auction').is(':checked');
                    }
                },
                bid_min_price: {
                    required: function(element) {
                        return $('#auction').is(':checked');
                    }
                },
            },
            messages: {
                sale_method: {
                    required: "Sale method is required.",
                },
                transaction_method: {
                    required: "Transaction method is required.",
                },
                category: {
                    required: "Category method is required.",
                },
                title: {
                    required: "Title is required.",
                    maxlength: "Title may not be greater than 500 characters."
                },
                price: {
                    required: "Price is required.",
                    number: "Price must be a number."
                },
                currency: {
                    required: "Currency is required.",
                    maxlength: "Currency may not be greater than 3 characters."
                },
                'image[]': {
                    fileRequired: "Please upload at least one image.",
                    extension: "Images must be of type jpeg, png, or jpg.",
                    filesize: "Each image must not exceed 4MB."
                },
                'video[]': {
                    extension: "Each video must be of type mp4, mov, avi, or wmv.",
                    filesize: "Each video must not exceed 20MB."
                },
                'document[]': {
                    extension: "Each document must be a file of type: pdf, doc, docx.",
                    filesize: "Each document must not exceed 4MB."
                },
                'external_link[]': {
                    url: "External link must be a valid URL.",
                    maxlength: "External link may not be greater than 400 characters."
                },
                'video_link[]': {
                    url: "Video link must be a valid URL.",
                    maxlength: "Video link may not be greater than 400 characters."
                },
                description: {
                    required: "Description is required.",
                    maxlength: "Description may not be greater than 5000 characters."
                },
                bid_end_date: {
                    required: "Bid End Date is required.",
                    minDateAfter2Days: "Bid End Date must be at least 2 days from today."
                },
                bid_min_price: {
                    required: "Minimum Bid price is required.",
                }
            },
            errorClass: 'error text-danger',
            errorElement: 'span',

            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                $('#product-form-submit').prop('disabled', true).text('Please wait...');

            }
        });
    </script>
      <script>
    var imageUploads = {
        image: [],
        video: [],
        document: []
    };

    var total_skip = 0;

    function uploadImageDocuments(count) {
        var imageFiles = $('input[name="image[]"]')[0]?.files || [];
        var videoFiles = $('input[name="video[]"]')[0]?.files || [];
        var documentFiles = $('input[name="document[]"]')[0]?.files || [];

        var file = null;
        var type = null;

        if (count < imageFiles.length) {
            file = imageFiles[count];
            type = 'image';
        } else if (count < imageFiles.length + videoFiles.length) {
            file = videoFiles[count - imageFiles.length];
            type = 'video';
        } else if (count < imageFiles.length + videoFiles.length + documentFiles.length) {
            file = documentFiles[count - imageFiles.length - videoFiles.length];
            type = 'document';
        } else {
            return false; // No more files to upload
        }

        var formData = new FormData();
        formData.append('file', file);
        formData.append('type', type); // Optional: useful in backend

        $.ajax({
            url: '{{ url("api/v1/uploadAjaxImage") }}', // Laravel route
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.url) {
                    imageUploads[type].push(response.url);
                }
                total_skip++;
                setTimeout(recurringImage, 0);
            },
            error: function(xhr) {
                console.error('Upload failed:', xhr.responseText);
                total_skip++;
                setTimeout(recurringImage, 0);
            }
        });

        return true;
    }

    function updateProgressBar(current, total) {
    let percent = Math.round((current / total) * 100);

        $('.fullscreen-cover').html(percent + '%')

}
function recurringImage() {
    var imageCount = $('input[name="image[]"]')[0]?.files.length || 0;
    var videoCount = $('input[name="video[]"]')[0]?.files.length || 0;
    var documentCount = $('input[name="document[]"]')[0]?.files.length || 0;
    var total_files = imageCount + videoCount + documentCount;

    updateProgressBar(total_skip, total_files);

    if (total_skip < total_files) {
        uploadImageDocuments(total_skip);
    } else {
        total_skip = 0;

        $('.fullscreen-cover').hide();
return false;

        $('.fullscreen-cover').html('Submitting Your Form, Please Wait!')

        // Build form data from the form element
        var formElement = document.getElementById('productForm');
        var formData = new FormData(formElement);

        // Append uploaded URLs from imageUploads object
        for (const [type, urls] of Object.entries(imageUploads)) {
            urls.forEach((url, index) => {
                formData.append(`${type}_uploads[${index}]`, url);
            });
        }

        $.ajax({
            url: $('#productForm').attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
        $('.fullscreen-cover').hide();

            location.href = response.url;
            Swal.fire("EliteQuine", response.message, "success");
            }
        });
    }
}



    
    $('#productForm').on('submit', function(e) {
        // if ($("#productForm").valid()) {
             $('.fullscreen-cover').css('display','flex')
        e.preventDefault(); // Prevent default form submission

        var imageCount = $('input[name="image[]"]')[0]?.files.length || 0;
        var videoCount = $('input[name="video[]"]')[0]?.files.length || 0;
        var documentCount = $('input[name="document[]"]')[0]?.files.length || 0;
        var total_files = imageCount + videoCount + documentCount;

        if (total_files > 0) {
            e.preventDefault();
            total_skip = 0;
            imageUploads = {
                image: [],
                video: [],
                document: []
            };
            recurringImage();
        }
    // }
        // else: form will submit normally if no file
    });
</script>

@endsection
