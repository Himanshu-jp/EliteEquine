@extends('front.layouts.main')
@section('title')
Product Details
@endsection
@section('content')

<section class="py-5">
    <div class="container">
        <div class="heading-page">
            <h3>{{@$products->title}}</h3>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="left-side-deatils">
                    <div class="gallery">
                        <!-- Main Slider -->
                        <div class="swiper gallery-slider">
                            <div class="swiper-wrapper">

                                @foreach(@$products->image as $key=>$image)
                                    <div class="swiper-slide"><img src="{{asset('storage/'.$image->image)}}" alt=""></div>
                                @endforeach

                                @foreach(@$products->video as $key=>$video)
                                    <div class="swiper-slide">
                                        <video width="" height="" controls>
                                            <source src="{{asset('storage/'.$video->video_url)}}" type="video/mp4">
                                            <source src="{{asset('storage/'.$video->video_url)}}" type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                @endforeach

                                 @foreach(@$products->videoLink as $key => $video)
                                    <div class="swiper-slide">
                                        @php
                                            $link = $video->link;
                                            $isYoutube = str_contains($link, 'youtube.com') || str_contains($link, 'youtu.be');
                                            $isVideoFile = preg_match('/\.(mp4|mov|webm|ogg)$/i', $link);
                                        @endphp

                                        @if($isYoutube)
                                            @php
                                                // Extract YouTube ID from either youtu.be or youtube.com
                                                if (preg_match("/(?:v=|\/)([0-9A-Za-z_-]{11})/", $link, $matches)) {
                                                    $videoId = $matches[1];
                                                } else {
                                                    $videoId = null;
                                                }
                                            @endphp

                                            @if($videoId)
                                                <div class="ratio ratio-16x9">
                                                    <iframe
                                                        width="848"
                                                        height="480"
                                                        src="https://www.youtube.com/embed/{{ $videoId }}"
                                                        title="YouTube video player"
                                                        frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen>
                                                    </iframe>
                                                </div>
                                            @else
                                                <p>Invalid YouTube link.</p>
                                            @endif

                                        @elseif($isVideoFile)
                                            <div class="ratio ratio-16x9">
                                                <video width="848" height="480" controls>
                                                    <source src="{{ $link }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>

                                        @else
                                            <p>Unsupported or invalid video link.</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <!-- Navigation Arrows -->

                        </div>

                        <!-- Thumbnails -->
                        <div class="swiper gallery-thumbs">
                            <div class="swiper-wrapper">

                                @foreach(@$products->image as $key=>$image)
                                    <div class="swiper-slide"><img src="{{asset('storage/'.$image->image)}}" alt=""></div>
                                @endforeach


                                @foreach(@$products->video as $key=>$video)
                                    <div class="swiper-slide"><img src="{{asset('storage/'.$video->thumbnail)}}" alt=""></div>
                                @endforeach

                                @foreach(@$products->videoLink as $key=>$video)
                                    <div class="swiper-slide"><img src="{{asset('front/home/assets/images/youtube.png')}}" alt=""></div>
                                @endforeach

                                
                            </div>
                            <div class="btnprev"><svg xmlns="http://www.w3.org/2000/svg')}}" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path d="M15.75 4.5L8.25 12L15.75 19.5" stroke="black" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg></div>
                            <div class="btnnext"><svg xmlns="http://www.w3.org/2000/svg')}}" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path d="M8.25 4.5L15.75 12L8.25 19.5" stroke="black" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg></div>
                        </div>
                    </div>
                    <div class="info-desc">
                        <h3 class="horse-info-heading">More Details</h3>
                        <div class="horse-info-box">

                            <div class="horse-info-row"><span class="horse-label">Stalls Available For Hauling or Show :</span> {{@$products->productDetail->stalls_available_haulings}}</div>

                            <div class="horse-info-row"><span class="horse-label">Date Available From :</span> {{@$products->productDetail->fromdate}}</div>
                            <div class="horse-info-row"><span class="horse-label">Date Available To :</span> {{@$products->productDetail->todate}}</div>
                            <div class="horse-info-row"><span class="horse-label">Salary :</span> {{@$products->productDetail->salary}}</div>
                            
                            <div class="horse-info-row"><span class="horse-label">Hourly Pay :</span> {{@$products->productDetail->hourly_price}}</div>
                            <div class="horse-info-row"><span class="horse-label">Fixed Pay :</span> {{@$products->productDetail->fixed_price}}</div>
                            
                            <div class="horse-info-row"><span class="horse-label">Haulings: From Location :</span> {{@$products->productDetail->haulings_location_from}}</div>
                            <div class="horse-info-row"><span class="horse-label">Haulings: To Location :</span> {{@$products->productDetail->haulings_location_to}}</div>

                            <div class="horse-info-row"><span class="horse-label">Precise Location :</span> {{@$products->productDetail->precise_location}}</div>
                            <div class="horse-info-row"><span class="horse-label">Street:</span> {{@$products->productDetail->street}}</div>
                            
                            <div class="horse-info-row"><span class="horse-label">City:</span> {{@$products->productDetail->city}}</div>
                            <div class="horse-info-row"><span class="horse-label">State:</span> 
                                {{ @$products->productDetail->state }}
                            </div>

                            <div class="horse-info-row"><span class="horse-label">Country:</span> 
                                {{@$products->productDetail->country}}
                            </div>

                            
                            <div class="horse-info-row"><span class="horse-label">Job Listing Types:</span> 
                                {{ @$products->jobListingType->map(function($job_listing_type) {
                                    return optional($job_listing_type->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Service:</span> 
                                {{ @$products->service->map(function($service) {
                                    return optional($service->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Contract Types:</span> 
                                {{ @$products->contractTypes->map(function($contract_types) {
                                    return optional($contract_types->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Assistance at Upcoming Show:</span> 
                                {{ @$products->assistanceUpcomingShows->map(function($assistance_upcoming_shows) {
                                    return optional($assistance_upcoming_shows->commonMaster)->name;
                                })->filter()->implode(', ') }}
                            </div>
                        </div>
                        <h3 class="horse-info-heading">Listing Description</h3>
                        
                        <div class="listing-desc">
                            <p class="my-4">
                                {{@$products->description}}
                            </p>
                        </div>
                        @if(@$products->productDetail->pedigree_chart)
                        <h3 class="horse-info-heading">Pedigree Chart</h3>
                        <img class="pedigreechart" src="{{asset('storage/'.@$products->productDetail->pedigree_chart)}}" alt="" />
                        <div class="info-desc-footer">
                            <ul>
                                <li><span> <img src="{{asset('front/home/assets/images/location-icon.svg')}}" alt="" /></span> {{@$products->productDetail->city}}, {{@$products->productDetail->state}}, {{@$products->productDetail->country}}</li>
                                <li><span> <img src="{{asset('front/home/assets/images/show-icon.svg')}}" alt="" /></span> 30 #11223</li>
                                <li>
                                    <span> <img src="{{asset('front/home/assets/images/calendar-icon.svg')}}" alt="" /></span>
                                    {{ \Carbon\Carbon::parse($products->created_at)->format('M d, Y') }}                                
                                </li>
                            </ul>
                        </div>
                        @endif
                    </div>
                    @if(@$products->document->isNotEmpty())
                    <div class="info-desc mt-4">
                        <h3 class="horse-info-heading">More Details</h3>
                        <ul class="list-unstyled d-flex gap-3">
                            @foreach(@$products->document as $key=>$document)
                                <li><a href="{{asset('storage/'.$document->file)}}" target="_blank"><img src="{{asset('front/home/assets/images/pdf-icon.svg')}}" alt="" /></a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(@$products->externalLink->count()>0)
                    <div class="info-desc mt-4">
                        <h3 class="horse-info-heading">External Links</h3>
                        @foreach($products->externalLink as $key=>$link)
                            <div class="links-box">
                                <a href="{{@$link->link}}" target="_blank">
                                    <img src="{{asset('front/home/assets/images/link-icon.svg')}}" alt="" />
                                    <span>{{@$link->link}}</span>
                                </a>                            
                            </div>
                        @endforeach
                    </div>
                    @endif

                    <!------------Comments add / view section---------->
                    <div class="comment-section">                        
                        <!-- Comment Form -->
                        @if(auth()->check()) 
                           <div class="comment-form">
                                <h4 class="comment-form-title">Write a Comment</h4>
                                <form action="{{ route('productComment') }}" method="POST" enctype="multipart/form-data" id="product-comment-form">
                                    @csrf                
                                    <input type="hidden" name="product_id" value="{{$products->id}}">

                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="form-label">Title</label>
                                        <input type="text" class="form-control comment-input-form mb-0" placeholder="Enter your title" name="title" id="title" autocomplete="off">                                            
                                    </div>  
                                    <div>  
                                        <label for="name" class="form-label">Content</label>                                      
                                        <textarea class="comment-textarea form-control mb-2" rows="6" name="comment" id="comment" placeholder="Write your comment here...">{{old('comment')}}</textarea>    
                                        @if($errors->has('comment'))
                                            <span class="error text-danger">{{$errors->first('comment')}}</span>
                                        @endif
                                    </div>                                    
                                    <div class="col-md-12 mt-3">
                                        <div class="upload-cmt-input" onclick="document.getElementById('uploadFile').click();"> 
                                            <div class="upload-icon"> <img src="{{asset('front/auth/assets/img/icons/image.svg')}}" class="user-img" alt="" id="editDocument"></div>
                                                    <h5 class="pt-3">Select pdf & document format files. </h5>
                                                    <div href="#" class="upload-image">
                                                        <h6>Browse File</h6>
                                                    </div>
                                            <input type="file" name="file" id="uploadFile" accept="image/*">
                                            <img id="previewImage" class="preview" alt="Image Preview">
                                        </div>
                                    </div>
                                    <button type="submit" class="comment-submit-btn" id="product-comment-form-submit">Post Comment</button>
                                </form>
                            </div>
                        @else
                            <div class="comment-form">
                                <h4 class="comment-form-title">Write a Comment</h4>
                                <form action="{{route('productComment')}}" method="post" id="product-comment-form-guest">
                                    @csrf                
                                    <input type="hidden" name="product_id" value="{{$products->id}}">

                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="form-label">Title</label>
                                        <input type="text" class="form-control comment-input-form mb-0" placeholder="Enter your title" name="title" id="title" autocomplete="off">                                            
                                    </div>  
                                    <div>
                                        <label for="name" class="form-label">Content</label>
                                        <textarea class="comment-textarea form-control mb-2" rows="6" name="comment" id="comment" placeholder="Write your comment here...">{{old('comment')}}</textarea>    
                                        @if($errors->has('comment'))
                                            <span class="error text-danger">{{$errors->first('comment')}}</span>
                                        @endif  
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="upload-cmt-input" onclick="document.getElementById('uploadFile').click();"> 
                                            <div class="upload-icon"> <img src="{{asset('front/auth/assets/img/icons/image.svg')}}" class="user-img" alt="" id="editDocument"></div>
                                                    <h5 class="pt-3">Select pdf & document format files. </h5>
                                                    <div href="#" class="upload-image">
                                                        <h6>Browse File</h6>
                                                    </div>
                                            <input type="file" name="file" id="uploadFile" accept="image/*">
                                            <img id="previewImage" class="preview" alt="Image Preview">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mt-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="name" class="form-control comment-input-form mb-0" placeholder="Enter your name" name="name" id="name" value="{{old('name', @$guest['name'] ?? '')}}"  autocomplete="off">                                            
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control comment-input-form mb-0" placeholder="Enter email address" name="email" id="email" value="{{old('email', @$guest['email'] ?? '')}}" autocomplete="off">
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label for="website" class="form-label">Website</label>
                                            <input type="website" class="form-control comment-input-form mb-0" placeholder="Enter your website address" name="website" id="website" value="{{old('website', @$guest['website'] ?? '')}}" autocomplete="off">                                            
                                        </div>
                                    </div>
                                    
                                    <button type="submit" class="comment-submit-btn" id="product-comment-form-submit-guest">Post Comment</button>
                                </form>
                            </div>
                        @endif

                        

                        <!-- Comment Item -->
                        <hr/>
                        <h3 class="comment-section-title">Comments</h3>

                        <!-- Comment list -->
                        <div id="data-wrapper"></div>
                        <span id="noComments">No comments have been posted for this product.</span>
                       
                        <div class="col-lg-12 mx-auto mt-4">
                            <nav aria-label="Page navigation example" style="display: none;" id="commentPagination">
                                <div class="Page navigation example">
                                    <ul class="pagination d-flex justify-content-center align-items-center">
                                        <li>
                                            <span class="loadMorePreviousButton" onclick="previousLoadMore();"><< Previous</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                        </li>
                                        <li>
                                             <span class="loadMoreNextButton" onclick="nextLoadMore();">Next >></span>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
            

                    </div>

                </div>
            </div>

        <!-- Book Now Popup -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                                <h3>Book Service</h3>
                                <button class="btn bg-light rounded-pill px-4 mt-2 mt-md-0" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                            </div>

                            <div class="header-popup mb-3">
                                <div>
                                <label class="form-label">Select Time Slot</label><br>
                                <select id="monthSelect" class="form-select custom-dropdown w-auto d-inline-block">
                                    <!-- Populated by JS -->
                                </select>
                                </div>
                                {{--<div class="d-flex align-items-center gap-2">
                                <button id="prevWeek" class="custom-dropdown bg-white px-3"><img src="{{asset('front/home/assets/images/icons/arrow-left.svg')}}" alt="" width="24" /></button>
                                <div id="dateRange" class="custom-dropdown date-range">9 Feb - 15 Feb</div>
                                <button id="nextWeek" class="custom-dropdown bg-white px-3"><img src="{{asset('front/home/assets/images/icons/arrow-right.svg')}}" alt="" width="24" /></button>
                                </div>--}}
                            </div>
                            <div id="calendar" class="row gx-1 text-center">
                                    <!-- Week header and time slots will be populated here -->
                            </div>
                            <div class="text-end mt-4">
                                <button class="apply-flitter" id="continue_btn">Continue to Payment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="details-right">
                    <div class="card-boxleft">
                        
                        @if(@$products->sale_method == 'auction' && @$products->product_status == 'closed')
                            <div class="pb-3 gap-2">
                                <span class="text-secondary">Bid Winner!</span>
                                <h2 class="fw-bold">{{ucfirst(@$products->highestBid->user->name)}}</h2>
                            </div>
                        @endif

                        @if(@$products->sale_method == 'auction' && @$products->product_status == 'live' && !empty(@$products->bid_expire_date))
                            <div class="pb-3 gap-2">
                                <span class="text-secondary">Minimum Bid Price</span>
                                <h2 class="fw-bold">{{ '$'.number_format(optional($products->highestBid)->amount ?? $products->productDetail->bid_min_price) }} </h2>
                            </div>
                        @endif

                         @if(@$products->sale_method == 'standard' && @$products->product_status == 'live' && @$products->transaction_method == 'platform')
                            <div class="pb-3 gap-2">
                                <span class="text-secondary">Price</span>
                                <h2 class="fw-bold">{{ $products->currency.' '.number_format($products->price,2) }} </h2>
                            </div>
                        @endif

                        <div>
                            <div class="btn-connected gap-2">
                                @if($products->user_id == auth()->id())
                                    <button class="bid w-100">Owner</button>                                    
                                @else
                                    @if(@$products->sale_method == 'auction' && !empty(@$products->bid_expire_date))
                                        @if( @$products->product_status == 'live')
                                            <button class="bid w-100" data-bs-target="#PlaceBid" data-bs-toggle="modal">Bid Now</button>
                                        @elseif(@$products->product_status == 'closed' && auth()->check() == true && @$products->highestBid->user_id == auth()->user()->id)
                                            <a href="{{route('product.checkout', $products->id)}}"><button class="bid w-100">Checkout</button></a>
                                        @else
                                            <button class="call-price w-100">Bid Closed</button>
                                        @endif
                                    @elseif(@$products->sale_method == 'standard' && @$products->transaction_method == 'buyertoseller')
                                        <button class="call-price w-100"><img src="{{asset('front/home/assets/images/call-icon.svg')}}" alt="" /> Call for price</button>
                                    @elseif(@$products->sale_method == 'standard' && @$products->transaction_method == 'platform')
                                        @if( @$products->product_status == 'live')

                                            @if(auth()->check())
                                                <button class="call-price w-100"data-bs-toggle="modal" data-bs-target="#exampleModal">Book Now</button>
                                            @else
                                                <button class="call-price w-100" onclick="showLoginModal('You must be logged in to book this service.')">
                                                   Book Now
                                                </button>
                                            @endif
                                            
                                        @elseif( @$products->product_status == 'sold')
                                            <button class="call-price w-100">Sold</button>
                                        @endif
                                    @endif
                                @endif
                                
                                @if($products->user_id == auth()->id())
                                    <a href="{{route('editProduct', $products->id)}}"><button class="call-price chat-btn">Edit</button></a>
                                @else
                                    <button class="call-price chat-btn" onclick="{{auth()->check()?'chatCreate();': 'showLoginModal("Please login to chat with ad owner.")'}}">
                                        <img src="{{asset('front/home/assets/images/chat-icon.svg')}}" alt="" />
                                    </button>
                                @endif
                            </div>
                            @if(@$products->sale_method == 'auction' && @$products->product_status == 'live' && !empty(@$products->bid_expire_date))
                                <p  class="text-center py-3">Auction winner must pay within 2 hours and buyer must ship within 30 days</p>
                            @else
                            <p class="text-center py-3">Ship within 30 days</p>
                            @endif
                        </div>
                        <div class="ad-owner-btn">
                            <h3>Ad Owner</h3>
                            <div class="owner-profile">
                                <div class="profil-info">
                                    <div class="proimg">
                                        <img src="{{(@$products->user->profile_photo_path)?asset('storage/'.@$products->user->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}" class="user-img" alt="">
                                        <span class="status-dot"></span>
                                    </div>
                                    <div class="proname">
                                        <h2>{{@$products->user->name}}</h2>
                                        <div data-bs-target="#Rating" data-bs-toggle="modal">
                                        @php
                                            $averageRating = round($products->user->reviews->avg('rating'), 1);
                                            $totalReviews  = $products->user->reviews->count();
                                        @endphp 
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star-fill {{ $i <= $averageRating ? 'text-warning' : 'text-secondary' }}"></i>
                                        @endfor

                                        {{--<span class="ms-2">({{ $averageRating ?? '0.0' }} / 5 - {{ $totalReviews }} reviews)</span>--}}   
                                        {{--<img src="{{asset('front/home/assets/images/star-rating5.svg')}}" alt="" />--}}
                                        </div>
                                    </div>
                                </div>
                                @if($products->user_id !== auth()->id() && auth()->check())
                                    <div class="btn-right">
                                        <button class="btn-theme-bg" data-bs-target="#WriteReview" data-bs-toggle="modal">
                                            Write A Review
                                        </button>
                                    </div>
                                @elseif($products->user_id == auth()->id())
                                    <div class="btn-right">
                                        <button class="btn-theme-bg" data-bs-target="#Rating" data-bs-toggle="modal">
                                            View Reviews
                                        </button>
                                    </div>
                                @else
                                    <div class="btn-right">
                                        <button class="btn-theme-bg" onclick="showLoginModal('Please log in to submit a review for this ad owner')">
                                            Write A Review
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="connect-numr" id="contact-reval" data-last-digit="{{substr(@$products->user->getUserDetail->phone, -3)}}">
                                <h3>{{substr(@$products->user->getUserDetail->phone, 0, -3).'xxx'}}</h3>
                                <p>Click to reveal phone number</p>
                            </div>
                        </div>

                        <!-- Rating popup -->
                        <div class="modal fade" id="Rating" aria-hidden="true" aria-labelledby="Rating" tabindex="-1"
                            style="min-width: 380px;;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-center">
                                    <div class="modal-body p-4">
                                        <h1 class="modal-title fs-4" id="exampleModalLabel">Reviews</h1>
                                        <div class="average-box my-4">
                                            @php 
                                                $arr = ['Poor', 'Fair', 'Average', 'Good', 'Excellent'];
                                                $averageRating = round(optional(@$products->user->reviews)->avg('rating'), 1);
                                            @endphp
                                             @if($averageRating)
                                                <img src="{{asset('front/home/assets/images/star-rating5.svg')}}" height="18px" alt="" />
                                                <span>{{$arr[$averageRating-1]}}</span>
                                            @else
                                                <span>No reviews yet</span>
                                            @endif
                                        </div>

                                         @if(optional(@$products->user->reviews)->isNotEmpty())
                                            @foreach(@$products->user->reviews as $review)
                                                <div class="rating-card">
                                                    <div class="user-info modl-view-rating">
                                                       <div>
                                                           <img src="{{(@$review->user->profile_photo_path!="")?asset('storage/'.@$review->user->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}"  height="49" alt="">
                                                               @php
                                                                   $averageRating = @$review->rating;
                                                               @endphp 
                                                       <h5>{{ucfirst(@$review->user->name)}}</h5>

                                                       @for ($i = 1; $i <= 5; $i++)
                                                           <i class="bi bi-star-fill {{ $i <= $averageRating ? 'text-warning' : 'text-secondary' }}"></i>
                                                       @endfor
                                                       </div>
                                                       <div>
                                                           <p>{{@$review->message}}</p>
                                                           @if($review->image)
                                                               <img src="{{asset('storage/'.@$review->image)}}" class="rating-img-usr mt-2"  alt="">
                                                           @endif
                                                       </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Write A Review popup -->
                        <div class="modal fade" id="WriteReview" aria-hidden="true" aria-labelledby="WriteReview"
                            tabindex="-1" style="min-width: 380px;;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-center">
                                    <div class="modal-body p-0">
                                        
                                        <h1 class="modal-title fs-4" id="exampleModalLabel">Share your opinion.</h1>
                                        <div class="py-3">
                                            <p>Your rating for this product: Good</p>
                                            <span class="rate" data-product-id="{{ $products->user_id }}">
                                                <i class="bi bi-star-fill active" data-review="1"></i>
                                                <i class="bi bi-star-fill" data-review="2"></i>
                                                <i class="bi bi-star-fill" data-review="3"></i>
                                                <i class="bi bi-star-fill" data-review="4"></i>
                                                <i class="bi bi-star-fill" data-review="5"></i>
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control style-2" placeholder="You are welcome..."
                                                id="contactMessage" rows="5"></textarea>
                                        </div>
                                      
                                        <div class="file-upload cusom-uplod">
                                            <label for="reviewImage" class="upload-label" id="uploadText">Upload Image</label>
                                            <input type="file" id="reviewImage" accept="image/jpeg,image/png" hidden />
                                        </div>
                                        <button type="button" class="apply-flitter mt-3 w-100"  id="submitReview">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Report An Product popup -->
                        <div class="modal fade" id="ReportProduct" aria-hidden="true" aria-labelledby="ReportProduct"
                            tabindex="-1" style="min-width: 380px;;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-center">
                                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="modal-body p-0">
                                        
                                        <h1 class="modal-title fs-4" id="exampleModalLabel">Report To Ad Owner.</h1>
                                        <div class="py-3">
                                            <p>Your feedback helps us serve you better.</p>
                                        </div>
                                        <form action="{{route('submitReport')}}" method="post" id="reportProductForm">
                                            @csrf
                                            <input type="hidden" name="product_id" id="product_id" value="{{$products->id}}">
                                            <div class="mb-3">
                                                <textarea class="form-control style-2" placeholder="Enter your comment here..." id="message" name="message" rows="5"></textarea>
                                                @if($errors->has('message'))
                                                    <span class="error text-danger">{{$errors->first('message')}}</span>
                                                @endif
                                            </div>
                                            <button type="submit" class="apply-flitter mt-3 w-100"  id="reportProductFormSubmit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(!auth()->check())
                            <div class="contact-ad-owner-box">
                                <h4 class="form-title">Contact Ad Owner</h4>
                                <form action="{{route('contactAdOwner')}}" method="post" id="contactAdOwnerForm">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$products->id}}">

                                    <!-- Full Name -->
                                    <div class="mb-3">
                                        <label for="contactName" class="form-label custom-label">Full Name
                                            <span>*</span></label>
                                        <input type="text" name="contactName" autocomplete="off" class="form-control custom-input" id="contactName" />
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="contactEmail" class="form-label custom-label">Your Email
                                            <span>*</span></label>
                                        <input type="email" name="contactEmail" autocomplete="off" class="form-control custom-input" id="contactEmail" />
                                    </div>

                                    <!-- Message -->
                                    <div class="mb-3">
                                        <label for="contactMessage" class="form-label custom-label">Message  <span>*</span></label>
                                        <textarea class="form-control custom-textarea" id="contactMessage" name="contactMessage" rows="4"></textarea>
                                    </div>

                                    <!-- Checkbox -->
                                    <div class="form-check mb-3">
                                        <a href="{{route('register')}}" target="_blank" style="text-decoration: none;">
                                            <label class="form-check-label custom-check-label" for="createAccount">
                                                I want to create an account to contact the owner.
                                            </label>
                                        </a>
                                    </div>
                                    <!-- Submit Button -->
                                    <button type="submit" class="btn-theme-bg" id="contactAdOwnerFormSubmit">Send</button>
                                </form>
                            </div>
                        @endif

                    </div>
                    <div class="card-boxleft">
                        <h4 class="title">Ad Action</h4>
                        <ul class="act-icon">
                            <li><a href="javascript:void(0)" id="shareBtn"><img src="{{asset('front/home/assets/images/share-icon.svg')}}" alt="" /></a></li>
                            <li><a href="javascript:window.print()"><img src="{{asset('front/home/assets/images/printer-icon.svg')}}" alt="" /></a></li>
                            <li>
                                <button class="favorite-btn {{ $products->favorites->where('user_id', auth()->id())->count() ? 'favorited' : '' }}" data-product-id="{{ $products->id }}">
                                                                            {{--<img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}" alt="" />--}}
                                                                            @if($products->favorites->where('user_id', auth()->id())->count() > 0)
                                                                                <i class="fa-solid fa-heart"></i>
                                                                            @else
                                                                            <i class="fa-regular fa-heart favorited"></i>
                                                                            @endif
                                                                        </button></li>
                           @if($products->user_id !== auth()->id() && auth()->check())
                                <li><button class="report-btn"  data-bs-target="#ReportProduct" data-bs-toggle="modal"><img src="{{asset('front/home/assets/images/plag-icon.svg')}}" alt="" /></button></li>
                            @elseif($products->user_id == auth()->id())
                                <li><button class="report-btn"  onclick="Swal.fire('Elite Equine', 'You are not allowed to report this as the owner.', 'warning');"><img src="{{asset('front/home/assets/images/plag-icon.svg')}}" alt="" /></button></li>
                            @else
                                <li><button class="report-btn"  onclick="showLoginModal('Please login to report this to ad owner.')"><img src="{{asset('front/home/assets/images/plag-icon.svg')}}" alt="" /></button></li>
                            @endif
                            <li>
                                <a href="javascript:void(0)">
                                    <span class="compare-add-button" data-id="{{$products->id}}">
                                        <img src="{{asset('front/home/assets/images/return-icon.svg')}}" alt="" />
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                   
                    

                    <div class="card-boxleft p-0" id="map"></div>

                    @if(count($moreAdd)>0)
                        <div class="card-boxleft feat_card_bx">
                            <h4 class="title">More Ads From This User</h4>
                            @foreach(@$moreAdd as $key=>$value)

                                <div class="adsfromcrd">
                                    <div class="adsimg">
                                        <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" width="80" class="avatar avatar-sm me-3" alt="image-1">
                                    </div>
                                    <div class="adsfromcrd-cont">
                                        <h5>{{$value->title}}</h5>
                                        <div class="btn-cont">
                                            <a href="{{route('horseDetails',$value->id)}}">
                                                <img src="{{asset('front/home/assets/images/call-icon-br.svg')}}" alt="" /> 
                                                Call for price
                                            </a>
                                            <div class="bx2">
                                                <button class="compare-add-button" data-id="{{$value->id}}">
                                                    <img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}" alt="">
                                                </button>
                                                {{--<button>
                                                    <img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}" alt="">
                                                </button>--}}
                                                 <button class="favorite-btn {{ $value->favorites->where('user_id', auth()->id())->count() ? 'favorited' : '' }}" data-product-id="{{ $value->id }}">
                                                    @if($value->favorites->where('user_id', auth()->id())->count() > 0)
                                                        <i class="fa-solid fa-heart"></i>
                                                    @else
                                                    <i class="fa-regular fa-heart favorited"></i>
                                                    @endif
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>



<!----------------Edit comment box------------->
<!-- Edit Comment Modal -->
<div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="edit-comment-form">
      @csrf
      <input type="hidden" name="comment_id" id="edit-comment-id">
      <input type="hidden" name="product_id" id="edit-product-id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCommentModalLabel">Edit Comment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <textarea name="comment" class="form-control" id="edit-comment-text" rows="5" placeholder="Edit your comment..."></textarea>
          <span class="text-danger error" id="edit-comment-error"></span>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="edit-comment-submit">Update Comment</button>
        </div>
      </div>
    </form>
  </div>
</div>




<!----------------Edit comment box-------------->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
        integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let mapboxAccessToken = '{{ config("config.map_box_access_token") }}';
    mapboxgl.accessToken = mapboxAccessToken;

    let currentMarker = null;

    function addMapMarker(lat, lng) {
        if (currentMarker) currentMarker.remove();

        const el = document.createElement('div');
        el.className = 'custom-map-marker';

        currentMarker = new mapboxgl.Marker(el)
            .setLngLat([lng, lat])
            .addTo(map);

        map.flyTo({ center: [lng, lat], zoom: 14 });
    }

    window.onload = () => {
        const urlParams = new URLSearchParams(window.location.search);
        let lat = '{{@$products->productDetail->latitude}}' || 26.8467;
        let lng = '{{@$products->productDetail->longitude}}' || 75.7647;

        const updateLocation = () => {
            initializeMap(lat, lng);
            addMapMarker(lat, lng);
        };

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    lat = position.coords.latitude;
                    lng = position.coords.longitude;
                    updateLocation();
                },
                () => updateLocation(),
                { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
            );
        } else {
            updateLocation();
        }

        initializeLocationAutocomplete();
    };

    function initializeMap(latitude, longitude) {
        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [longitude, latitude],
            zoom: 10,
            pitch: 60,
            bearing: -20
        });

        map.addControl(new mapboxgl.NavigationControl(), 'top-right');
    }
</script>

<!-- // book Now Popup js -->
<script>

$(document).ready(function () {

    $("#reportProductForm").validate({
        rules: {
            message: {
                required: true,
                maxlength: 5000
            }
        },
        messages: {
            message: {
                required: "Message is required.",
                maxlength: "Message may not be greater than 5000 characters."
            }
        },
        errorClass: 'error text-danger',
        errorElement: 'span',

        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $('#reportProductFormSubmit').prop('disabled', true).text('Please wait...');
            form.submit();
        }
    });
    
    $("#contactAdOwnerForm").validate({
        rules: {
            contactName: {
                required: true,
                maxlength: 250
            },
            contactEmail: {
                required: true,
                email:true
            },
            contactMessage: {
                required: true,
                maxlength: 5000
            }
        },
        messages: {
            contactName: {
                required: "Name is required.",
                maxlength: "Name may not be greater than 250 characters."
            },
            contactEmail: {
                required: "Email is required.",
                email: "Please enter a valid email address."
            },
            contactMessage: {
                required: "Message is required.",
                maxlength: "Message may not be greater than 5000 characters."
            }
        },
        errorClass: 'error text-danger',
        errorElement: 'span',
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $('#contactAdOwnerFormSubmit').prop('disabled', true).text('Please wait...');
            form.submit();
        }
    });
});

function chatCreate() {
    var formData = new FormData();
    formData.append('sender_id', {{ auth()->id() }});
    formData.append('receiver_id', {{ $products->user_id }});
    formData.append('ticket_type', 'Single');
    formData.append("_token",`{{ csrf_token() }}`);

    $.ajax({
        url: '{{ asset("") }}'+ "api/v1/room-create",
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log('Chat room created:', response.data);
            if (response.success) {
                window.location.href = '{{ route("messages",["room_id" => ""]) }}' + response.data;
            } else {
                Swal.fire("Elite Equine", 'Failed to create chat room: ' + response.message, "error");
            }
        },
        error: function(xhr, status, error) {
            console.error('Error creating chat room:', xhr.responseText);
            Swal.fire("Elite Equine", 'Failed to create chat room', "error");
        }
    });
}


  /* const calendar = document.getElementById('calendar');
  const dateRange = document.getElementById('dateRange');
  const monthSelect = document.getElementById('monthSelect');
  const prevWeek = document.getElementById('prevWeek');
  const nextWeek = document.getElementById('nextWeek');

  const slots = ["06:00 A", "09:30 A", "12:00 P", "03:00 P", "04:00 P", "06:30 P", "09:45 P"];
  let currentDate = new Date(2025, 1, 9);

  function updateMonthOptions() {
    monthSelect.innerHTML = '';
    for (let i = 0; i < 12; i++) {
      const date = new Date(2025, i);
      const option = document.createElement('option');
      option.value = i;
      option.textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' });
      monthSelect.appendChild(option);
    }
    monthSelect.value = currentDate.getMonth();
  }

  function getWeekDates(date) {
    const day = date.getDay();
    const start = new Date(date);
    start.setDate(date.getDate() - day);
    const week = [];
    for (let i = 0; i < 7; i++) {
      const d = new Date(start);
      d.setDate(start.getDate() + i);
      week.push(d);
    }
    return week;
  }

  function renderCalendar(date) {
    const week = getWeekDates(date);
    calendar.innerHTML = '';

    const headerRow = document.createElement('div');
    headerRow.classList.add('row', 'text-center', 'mb-2');
    week.forEach((d, idx) => {
      const col = document.createElement('div');
      col.className = 'col day-header' + (idx > 0 ? ' active-week' : '');
      col.innerHTML = `${d.toLocaleDateString('en-GB', { weekday: 'short' })}<br><strong>${d.getDate()}</strong>`;
      headerRow.appendChild(col);
    });
    calendar.appendChild(headerRow);

    slots.forEach(slot => {
      const row = document.createElement('div');
      row.className = 'row text-center';
      week.forEach((_, idx) => {
        const col = document.createElement('div');
        col.className = 'col';
        if (idx > 0) {
          const slotDiv = document.createElement('div');
          slotDiv.className = 'time-slot';
          slotDiv.textContent = slot;
          col.appendChild(slotDiv);
        }
        row.appendChild(col);
      });
      calendar.appendChild(row);
    });

    const start = week[0].toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
    const end = week[6].toLocaleDateString('en-GB', { day: 'numeric', month: 'short' });
    dateRange.textContent = `${start} - ${end}`;
  }

  prevWeek.addEventListener('click', () => {
    currentDate.setDate(currentDate.getDate() - 7);
    renderCalendar(currentDate);
    monthSelect.value = currentDate.getMonth();
  });

  nextWeek.addEventListener('click', () => {
    currentDate.setDate(currentDate.getDate() + 7);
    renderCalendar(currentDate);
    monthSelect.value = currentDate.getMonth();
  });

  monthSelect.addEventListener('change', () => {
    currentDate.setMonth(+monthSelect.value);
    currentDate.setDate(1);
    renderCalendar(currentDate);
  });

  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('time-slot')) {
      document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
      e.target.classList.add('selected');
    }
  });

  updateMonthOptions();
  renderCalendar(currentDate); */
@php
    use Carbon\Carbon;
    $from = optional($products->productDetail)->fromdate;
    $to = optional($products->productDetail)->todate;
    $availableDates = collect($selectedDate)->pluck('service_date')->filter()->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))->values();

    $fromDateJs = $from ? Carbon::parse($from)->format('Y-m-d') : null;
    $toDateJs = $to ? Carbon::parse($to)->format('Y-m-d') : null;
//    echo $selectDateJs = $selected ? Carbon::parse($selected)->format('Y-m-d') : null;
@endphp

const fromDate = "{{ $fromDateJs }}"; 
const toDate = "{{ $toDateJs }}";     
const availableDates = @json($availableDates);
     
console.log('selectDate:' + availableDates);
const calendar = document.getElementById("calendar");
const monthSelect = document.getElementById("monthSelect");
const options = { weekday: "short", day: "2-digit", month: "short" };
const now = new Date();
let selectedDate = null;

// Helper to format date as YYYY-MM-DD
function formatDateLocal(date) {
    const y = date.getFullYear();
    const m = String(date.getMonth() + 1).padStart(2, "0");
    const d = String(date.getDate()).padStart(2, "0");
    return `${y}-${m}-${d}`;
}

// Populate month dropdown (next 12 months)
function populateMonthSelect() {
    const today = new Date();
    for (let i = 0; i < 12; i++) {
        const date = new Date(today.getFullYear(), today.getMonth() + i, 1);
        const monthYear = date.toLocaleString("default", { month: "long", year: "numeric" });
        const value = `${date.getFullYear()}-${String(date.getMonth()).padStart(2, '0')}`;
        const option = new Option(monthYear, value);
        monthSelect.appendChild(option);
    }
    monthSelect.value = `${now.getFullYear()}-${String(now.getMonth()).padStart(2, '0')}`;
}

// Render all days of the selected month
function renderMonth(year, month) {
    calendar.innerHTML = "";
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(year, month, day);
        const formattedDate = formatDateLocal(date);
        const display = date.toLocaleDateString("en-US", options);

        const isPast = date < new Date(new Date().setHours(0, 0, 0, 0));
        const isDisabled =
            isPast ||
            (fromDate && toDate && formattedDate >= fromDate && formattedDate <= toDate);

        const isAvailable = availableDates.includes(formattedDate);

        // const isDisabled = isPast || !isAvailable;

        const col = document.createElement("div");
        col.className = "col-4 col-sm-2 mb-3";

       /*  col.innerHTML = `
            <button class="btn w-100 date-btn ${isDisabled ? 'disabled' : 'selectabled'}"
                    data-date="${formattedDate}"
                    ${isDisabled ? 'disabled' : ''}>
                ${display}
            </button>
        `; */

        col.innerHTML = `
            <button class="btn w-100 date-btn ${isPast ? 'disabled' : ''} ${isDisabled ? 'selectabled' : 'disabled'} ${isAvailable ? 'disabled' : 'selectabled'}" 
                    data-date="${formattedDate}">
                ${display}
            </button>
        `;

        calendar.appendChild(col);
    }

    attachDateListeners();
}


// Listen for month change
monthSelect.addEventListener("change", () => {
    const [year, month] = monthSelect.value.split("-").map(Number);
    renderMonth(year, month);
});

// Handle date button click
function attachDateListeners() {
    document.querySelectorAll(".date-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            if (btn.classList.contains("disabled")) return;

            document.querySelectorAll(".date-btn").forEach((b) =>
                b.classList.remove("btn-primary")
            );

            this.classList.add("btn-primary");
            selectedDate = this.getAttribute("data-date");
        });
    });
}

// Handle "Continue" button click
document.getElementById("continue_btn").addEventListener("click", () => {
    if (selectedDate) {
        const url = "{{ route('product.checkout.process', $products->id) }}";
        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                service_job: true,
                service_date: selectedDate
            },
            success: function (response) {
                if (response.success && response.redirect_url) {
                    window.location.href = response.redirect_url;
                } else {
                    alert('Something went wrong. Please try again.');
                }
            },
            error: function (xhr) {
                alert('Submission failed. Please try again.');
                console.error('Error:', xhr.responseText);
            }
        });
    } else {
        Swal.fire({
            toast: true,
            title: 'Please select a date first.',
            icon: 'error',
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    }
});

// Initialize calendar on page load
document.addEventListener("DOMContentLoaded", () => {
    populateMonthSelect();
    renderMonth(now.getFullYear(), now.getMonth());
});

// share
document.getElementById('shareBtn').addEventListener('click', function(event) {
    event.preventDefault();
    if (navigator.share) {
      navigator.share({
        title: document.title,
        text: 'Check out this page!',
        url: window.location.href
      })
      .then(() => console.log('Successful share'))
      .catch((error) => console.log('Error sharing:', error));
    } else {
      alert('Sorry, your browser does not support the share feature.');
    }
  });
</script>    

 <script>
   
     $(document).ready(function () {
        $("#product-comment-form").validate({
            rules: {
                title:{
                    required: true,
                    maxlength: 500
                },
                comment: {
                    required: true,
                    maxlength: 5000
                }
            },
            messages: {
                title: {
                    required: "Title field is required.",
                    maxlength: "The title field must not be greater than 500 characters"
                },
                comment: {
                    required: "Content field is required.",
                    maxlength: "The Content field must not be greater than 5000 characters"
                }
            },
            errorClass: 'error text-danger',
            errorElement: 'span',

            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },

            submitHandler: function (form) {
           
                $('#product-comment-form-submit').prop('disabled', true).text('Please wait...');
                let formData = new FormData(form);

                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $('#product-comment-form-submit')
                            .prop('disabled', false)
                            .text('Post Comment');
                        
                        if (response.status) {
                            // Optionally reset form and append comment
                            $(form)[0].reset();
                            addProductComment(page);
                            $("#noComments").hide();
                            $("#data-wrapper").show();
                            const previewImageDiv = document.getElementById('previewImage');
                            previewImageDiv.src="";
                            previewImageDiv.style.display = 'none';

                        } else {
                            alert(response.message || 'Something went wrong');
                        }
                    },
                    error: function (xhr) {
                        $('#product-comment-form-submit').prop('disabled', false).text('Post Comment');

                        // Show error message
                        alert('Submission failed. Please try again.');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
       
       //-----for guest user comment form validation----//
        $("#product-comment-form-guest").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 255
                },
                website: {
                    required: false,
                    maxlength: 255,
                    url: true,
                },
                title:{
                    required: true,
                    maxlength: 500
                },
                comment: {
                    required: true,
                    maxlength: 5000
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    maxlength: "Name must not exceed 255 characters"
                },
                email: {
                    required: "Please enter your email address",
                    email: "The email should be in the format: john@domain.tld",
                    maxlength: "Email must not exceed 255 characters"
                },
                website: {
                    required: "Please enter your web address",
                    maxlength: "Website must not exceed 255 characters"
                },
                title: {
                    required: "Title field is required.",
                    maxlength: "The title field must not be greater than 500 characters"
                },  
                comment: {
                    required: "Content field is required.",
                    maxlength: "The Content field must not be greater than 5000 characters"
                }
            },
            errorClass: 'error text-danger',
            errorElement: 'span',

            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },

            submitHandler: function (form) {
                $('#product-comment-form-submit-guest').prop('disabled', true).text('Please wait...');
                let formData = new FormData(form);
                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.status) {

                            $('#product-comment-form-submit-guest')
                            .prop('disabled', false)
                            .text('Post Comment');
                            
                            // Optionally reset form and append comment
                            $(form)[0].reset();
                            addProductComment(page);
                            $("#noComments").hide();
                            $("#data-wrapper").show();
                            const previewImageDiv = document.getElementById('previewImage');
                            previewImageDiv.src="";
                            previewImageDiv.style.display = 'none';

                            //----guest user-----//
                            $("#name").val(response.guest['name']);
                            $("#email").val(response.guest['email']);
                            $("#website").val(response.guest['website']);

                        } else {
                            alert(response.message || 'Something went wrong');
                        }
                    },
                    error: function (xhr) {
                        $('#product-comment-form-submit-guest').prop('disabled', false).text('Post Comment');
                        // Show error message
                        alert('Submission failed. Please try again.');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

</script>

<script>
    $('#contact-reval').click( function () {
            const lastDigits = $('#contact-reval').data('last-digit');
            const currentText = $("#contact-reval h3").text();

            if (currentText.includes('xxx')) {
                const revealed = currentText.replace('xxx', lastDigits);
                $("#contact-reval").html('<a href="tel:'+ revealed +'"><h3>'+ revealed + '</h3><p>Click to reveal phone number</p></a>');
            }
        });
// Thumbnail slider
var thumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 10,
    slidesPerView: 'auto',
    centeredSlides: true,
    loop: true,
    slideToClickedSlide: true,
});

// Main image slider
var slider = new Swiper('.gallery-slider', {
    spaceBetween: 10,
    centeredSlides: true,
    loop: true,
    loopedSlides: 6, // match number of slides
    navigation: {
        nextEl: '.btnnext',
        prevEl: '.btnprev',
    },
    thumbs: {
        swiper: thumbs,
    },
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.reply-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const commentItem = btn.closest('.comment-item');
                const replyForm = commentItem.querySelector('.reply-form');
                if (replyForm) {
                    replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
                }
            });
        });
    });
</script>

<script>

    var page = 1;
    infinteLoadMore(page);

    function nextLoadMore(){       
        document.getElementById("product-comment-form-submit").scrollIntoView({ behavior: 'smooth' });
        page++;
        infinteLoadMore(page,'');
    }
    function previousLoadMore(){  
        document.getElementById("product-comment-form-submit").scrollIntoView({ behavior: 'smooth' });     
        page--;
        infinteLoadMore(page,'');
    }

    function addProductComment(page)
    {
        infinteLoadMore(page,'add');
    }
    
    
    function infinteLoadMore(page,status) {
        $('.preloader').show();
        if(page==1){
            $('.loadMorePreviousButton').hide();
        }else{
            $('.loadMorePreviousButton').show();
        }
        $.ajax({
                url: '{{ url("productCommentListing",$products->id) }}'+ "?page=" + page,
                datatype: "html",
                type: "get",
            })
            .done(function (response) {
                 $('.preloader').hide();

                 if(response.total>0){
                    $("#noComments").hide();
                }
                if(response.totalPages>0 && response.total>10){    
                    $('#commentPagination').show();
                    
                    if (response.html == '' || response.totalPages==page) {
                        $("#data-wrapper").html(response.html);
                        $('.preloader').hide();
                        $('.loadMoreNextButton').hide();
                        $('.loadMorePreviousButton').show();
                        $('#data-wrapper').append("We don't have more data to display.");
                        return;
                    }else{
                        $('.loadMoreNextButton').show();
                    }
                }
                $('.preloader').hide();
                if(status=="add"){
                    $("#data-wrapper").html(response.html);
                }else{
                    $("#data-wrapper").html(response.html);
                }

                

            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                $('.preloader').hide();
                console.log('Server error occured');
            });
    }


    function deleteComment(id){
        var href = $(this).data('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {

                    $.ajax({
                    url: `{{url('productCommentDelete')}}`  + '/' + id,
                    method: 'GET',
                    data: {},
                    success: function (response) {
                        if (response.status) {
                            Swal.fire("Elite Equine", "Comment removed successfully.", "success");
                            addProductComment(page);
                        } else {
                            Swal.fire("Elite Equine", response.message, "error");
                        }
                    },
                    error: function (xhr) {
                        Swal.fire("Elite Equine", "Submission failed. Please try again.", "error");
                        console.error(xhr.responseText);
                    }
                });

            }
        })
    }

     // Submit AJAX for updating comment
    $('#edit-comment-form').on('submit', function (e) {
        e.preventDefault();
        $('#edit-comment-submit').prop('disabled', true).text('Updating...');

        $.ajax({
            url: "{{ route('productComment.update') }}", // Define this route in Laravel
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.status) {
                    $('#editCommentModal').modal('hide');
                    addProductCommentReply(page)
                } else {
                    $('#edit-comment-error').text(response.message || 'Something went wrong.');
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors && errors.comment) {
                    $('#edit-comment-error').text(errors.comment[0]);
                }
            },
            complete: function () {
                $('#edit-comment-submit').prop('disabled', false).text('Update Comment');
            }
        });
    });

    
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("reviewImage");
    const uploadText = document.getElementById("uploadText");

    fileInput.addEventListener("change", function () {
      if (fileInput.files.length > 0) {
        uploadText.textContent = fileInput.files[0].name;
      } else {
        uploadText.textContent = "Upload Image";
      }
    });
  });
</script>

<script>
    const fileInput = document.getElementById('uploadFile');
    const previewImage = document.getElementById('previewImage');

    fileInput.addEventListener('change', function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();

        reader.onload = function () {
          previewImage.src = reader.result;
          previewImage.style.display = 'block';
        };

        reader.readAsDataURL(file);
      } else {
        previewImage.src = '';
        previewImage.style.display = 'none';
      }
    });
  </script>
<style>
    .comment-input-form {
    border-radius: 14px;
    border: 1px solid var(--Border-2, #DDD);
    background: var(--Color-White, #FFF);
    padding: 14px 22px;
    color: #3D3D3D;
    font-family: Inter;
    font-size: 15px;
    font-style: normal;
    font-weight: 500;
    line-height: 26px;
}

.upload-cmt-input {
    width: 100%;
    padding: 25px 15px;
    text-align: center;
    font-family: Arial, sans-serif;
    cursor: pointer;
    transition: border-color 0.3s ease;
    position: relative;
    border-radius: 20px;
    border: 1px dashed #DDD;
    background: #FFF;
    padding: 30px;
}
.upload-cmt-input h5 {
    color: #000;
    text-align: center;
    font-family: Inter;
    font-size: 18px;
    font-style: normal;
    font-weight: 500;
    line-height: 150%; /* 27px */
}

.upload-cmt-input .upload-image {
    color: #A19061;
    text-align: center;
    font-family: Inter;
    font-size: 15px;
    font-style: normal;
    font-weight: 700;
    line-height: 150%; /* 22.5px */
    text-decoration-line: underline !important;
    text-decoration-style: solid;
    text-decoration-skip-ink: none;
    text-decoration-thickness: auto;
    text-underline-offset: auto;
    text-underline-position: from-font;
}
 

    .upload-cmt-input input[type="file"] {
      display: none;
    }

    .upload-cmt-input .upload-icon {
      font-size: 36px;
      color: #888;
      margin-bottom: 10px;
    }

    .upload-cmt-input .upload-text {
      font-size: 14px;
      color: #444;
    }

    .upload-cmt-input img.preview {
      margin-top: 15px;
      max-width: 100%;
      max-height: 180px;
      display: none;
      border-radius: 6px;
      object-fit: contain;
      border: 1px solid #ccc;
    }
  </style>

@endsection

