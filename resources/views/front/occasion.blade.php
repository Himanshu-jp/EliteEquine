@extends('front.layouts.main')
@section('title')
Occasion
@endsection
@section('content')



<section class="py-5">
    <div class="container">
        <div class="heading-page">
            <h3>Avocado for Sale</h3>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="left-side-deatils">
                    <div class="gallery">
                        <!-- Main Slider -->
                        <div class="swiper gallery-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                            </div>
                            <!-- Navigation Arrows -->

                        </div>

                        <!-- Thumbnails -->
                        <div class="swiper gallery-thumbs">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
                                <div class="swiper-slide"><img src="{{asset('front/home/assets/images/slider-img.png')}}" alt=""></div>
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
                        <h3 class="horse-info-heading">Listing Description</h3>
                        <div class="horse-info-box">

                            <div class="horse-info-row"><span class="horse-label">Subcategory :</span> For Lease,
                                For Sale, Lease-To-Buy Option</div>
                            <div class="horse-info-row"><span class="horse-label">Discipline:</span> Equitation,
                                Hunter, Jumper</div>
                            <div class="horse-info-row"><span class="horse-label">Age:</span> 2018</div>
                            <div class="horse-info-row"><span class="horse-label">Height in hands:</span> 16.1</div>
                            <div class="horse-info-row"><span class="horse-label">Breed:</span> Irish Sport horse
                            </div>
                            <div class="horse-info-row"><span class="horse-label">Sex:</span> Gelding</div>
                            <div class="horse-info-row"><span class="horse-label">Colors:</span> Chestnut</div>
                            <div class="horse-info-row"><span class="horse-label">Training & Show Experience:</span>
                                1–2 Years Showing</div>
                            <div class="horse-info-row"><span class="horse-label">Current Fence Height:</span> 3’6”
                                / 1.05 – 1.10m</div>
                            <div class="horse-info-row"><span class="horse-label">Potential Fence Height:</span>
                                4’0” / 1.20 – 1.25m</div>
                            <div class="horse-info-row"><span class="horse-label">Sire Bloodlines:</span> J’Taime
                                Flamenco</div>
                            <div class="horse-info-row"><span class="horse-label">Dam Bloodlines:</span> Cruising
                            </div>
                        </div>
                        <h3 class="horse-info-heading">Listing Description</h3>

                        <div class="listing-desc">
                            <p class="my-4">FLAMENCO SENSATION</p>
                            <p class="my-4">2018 imported ISH gelding chestnut by J’Taime Flamenco x Cruising</p>
                            <p class="my-4">Extremely genuine and straightforward, he’s the kind talented horse
                                everyone wants. “Felix” shows great aptitude for the hunter ring in addition to
                                having already shown 1.10m w a junior with lots of easy scope for more. A true three
                                ring prospect!</p>
                            <p class="my-4">Excellent vetting on file asking high fives</p>
                            <p class="my-4">Located in Ocala right near HITS</p>
                        </div>
                        <h3 class="horse-info-heading">Pedigree Chart</h3>
                        <img class="pedigreechart" src="{{asset('front/home/assets/images/pedigree-chart.svg')}}" alt="" />
                        <div class="info-desc-footer">
                            <ul>
                                <li><span> <img src="{{asset('front/home/assets/images/location-icon.svg')}}" alt="" /></span> Ocala, FL,
                                    USA</li>
                                <li><span> <img src="{{asset('front/home/assets/images/show-icon.svg')}}" alt="" /></span> 30 #11223</li>
                                <li><span> <img src="{{asset('front/home/assets/images/calendar-icon.svg')}}" alt="" /></span> February 4,
                                    2025</li>
                            </ul>
                        </div>
                    </div>
                    <div class="info-desc mt-4">
                        <h3 class="horse-info-heading">More Details</h3>
                        <ul>
                            <li><img src="{{asset('front/home/assets/images/pdf-icon.svg')}}" alt="" /></li>
                            <li><img src="{{asset('front/home/assets/images/pdf-icon.svg')}}" alt="" /></li>
                        </ul>
                    </div>
                    <div class="info-desc mt-4">
                        <h3 class="horse-info-heading">External Links</h3>
                        <ul class="links-box">
                            <li class="d-flex gap-2 align-items-center d-block"><img src="{{asset('front/home/assets/images/link-icon.svg')}}"
                                    alt="" /><a class="mb-0"
                                    href="https://www.figma.com/design/ofKsEd6UBTtKm2FsYTBeca/Elite-Equine-Marketplace?node-id=109-3550&t=asBuVdGacU3o6q5r-0">https://www.figma.com/design/ofKsEd6UBTtKm2FsYTBeca/Elite-Equine
                                    -Marketplace?node-id=109-3550&t=asBuVdGacU3o6q5r-0</a>
                            </li>
                            <li class="d-flex gap-2 align-items-center "><img src="{{asset('front/home/assets/images/link-icon.svg')}}"
                                    alt="" /><a class="mb-0"
                                    href="https://www.figma.com/design/ofKsEd6UBTtKm2FsYTBeca/Elite-Equine-Marketplace?node-id=109-3550&t=asBuVdGacU3o6q5r-0">https://www.figma.com/design/ofKsEd6UBTtKm2FsYTBeca/Elite-Equine
                                    -Marketplace?node-id=109-3550&t=asBuVdGacU3o6q5r-0</a>
                            </li>
                        </ul>

                        <style>
                        .info-desc ul.links-box li a {
                            display: -webkit-box;
                            -webkit-line-clamp: 1;
                            -webkit-box-orient: vertical;
                            overflow: hidden;
                            text-overflow: hidden;
                        }
                        </style>

                    </div>
                    <div class="comment-section">
                        <h3 class="comment-section-title">Comments</h3>

                        <!-- Comment Item -->
                        <div class="comment-item">
                            <div class="comment-header">
                                <div class="comment-avatar">A.T</div>
                                <div class="comment-meta">
                                    <span class="comment-author">Nicolas cage</span>
                                    <span class="comment-time">3 Days ago</span>
                                </div>
                            </div>
                            <div class="comment-body">
                                There are many variations of passages of Lorem Ipsum available, but the majority
                                have suffered alteration in some form, by injected humour
                            </div>
                            <div class="comment-actions">
                                <button class="comment-btn"><img src="{{asset('front/home/assets/images/calendar-icon.svg')}}" alt="" />
                                    Like</button>
                                <button class="comment-btn reply-btn">Reply</button>
                            </div>
                        </div>

                        <div class="comment-item">
                            <div class="comment-header">
                                <div class="comment-avatar">A.T</div>
                                <div class="comment-meta">
                                    <span class="comment-author">Sr.Robert Downey</span>
                                    <span class="comment-time">3 Days ago</span>
                                </div>
                            </div>
                            <div class="comment-body">
                                <p>The best product In Market</p>
                                <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots
                                    in a piece of classical Latin literature from 45 BC, making it over 2000 years
                                    old.</p>
                            </div>
                            <div class="comment-actions">
                                <button class="comment-btn"><img src="{{asset('front/home/assets/images/calendar-icon.svg')}}" alt="" />
                                    Like</button>
                                <button class="comment-btn reply-btn">Reply</button>
                            </div>
                        </div>

                        <a href="" class="all-btn-text">View All Comments</a>
                        <!-- Comment Form -->
                        <div class="comment-form">
                            <h4 class="comment-form-title">Write a Comment</h4>
                            <form>
                                <label>Title</label>
                                <input type="text" class="comment-input" placeholder="Title" />
                                <label>Content</label>
                                <textarea class="comment-textarea" placeholder="Write your comment here..."></textarea>
                                <div class="custom-file-upload-box">
                                    <label for="customFileInput" class="custom-file-label">
                                        <img src="{{asset('front/home/assets/images/file-choose.svg')}}" alt="Upload" class="upload-icon" />
                                    </label>
                                    <input type="file" id="customFileInput" class="custom-file-input"
                                        accept="image/*" />
                                    <span class="file-name" id="fileName">No file selected</span>

                                    <!-- Preview Image -->
                                    <div class="file-preview" id="filePreviewBox">
                                        <img id="filePreviewImage" src="" alt="Preview" />
                                    </div>
                                </div>

                                <button type="submit" class="comment-submit-btn">Submit</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="details-right">

                    <div class="card-boxleft">
                        <div class="pb-3 gap-2">
                            <span class="text-secondary">Minimum Bid Price</span>
                            <h2 class="fw-bold">$15,000.00 </h2>
                        </div>
                        <div>
                            <div class="btn-connected gap-2">
                                <button type="button" class="call-price w-100" data-bs-target="#PlaceBid"
                                    data-bs-toggle="modal">Buy Now</button>
                                <button class="call-price chat-btn"><img src="{{asset('front/home/assets/images/chat-icon.svg')}}"
                                        alt="" /></button>
                            </div>
                            <p class="text-center py-3">Auction winner must pay within 2 hours and buyer must ship
                                within 30 days</p>
                        </div>
                        <!-- Place Bid popup -->
                        <div class="modal fade" id="PlaceBid" aria-hidden="true" aria-labelledby="PlaceBid"
                            tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-center">
                                    <div class="modal-body p-0">
                                        <img src="{{asset('front/home/assets/images/icons/place-bid.png')}}" alt="place-bid.png')}}"
                                            height="50px">
                                        <h1 class="modal-title fs-3 fw-bold mt-4" id="exampleModalLabel">Place Bid
                                        </h1>

                                        <div class="py-3">
                                            <input type="number" class="form-control mb-3"
                                                placeholder="Input custom value" />
                                            <p>You have placed a bid for $15,000. Should we place this as your Bid?
                                            </p>
                                        </div>

                                        <div class="mx-auto d-flex gap-4 mt-3">
                                            <button type="button" class="btn-modal-dialog"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn-modal-primary">Yes, Place My
                                                Bid</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ad-owner-btn">
                            <h3>Ad Owner</h3>
                            <div class="owner-profile">
                                <div class="profil-info">
                                    <div class="proimg">
                                        <img src="{{asset('front/home/assets/images/blog-b-img-2.png')}}" alt="" />
                                        <span class="status-dot"></span>
                                    </div>
                                    <div class="proname">
                                        <h2>Katie B</h2>
                                        <div data-bs-target="#Rating" data-bs-toggle="modal"><img
                                                src="{{asset('front/home/assets/images/star-rating5.svg')}}" alt="" /></div>
                                    </div>
                                </div>
                                <div class="btn-right">
                                    <button class="btn-theme-bg" data-bs-target="#WriteReview"
                                        data-bs-toggle="modal">Write A Review</button>
                                </div>
                            </div>
                            <div class="connect-numr">
                                <h3>6133310XXX</h3>
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
                                            <img src="{{asset('front/home/assets/images/star-rating5.svg')}}" height="18px" alt="" />
                                            <span>Average</span>
                                        </div>

                                        <div class="rating-card">
                                            <div class="user-info">
                                                <img src="{{asset('front/home/assets/images/users/Ellipse 1-1.png')}}" height="49"
                                                    alt="Ellipse">
                                                <h5>Jonas Sousa</h5>
                                            </div>
                                            <img src="{{asset('front/home/assets/images/icons/stars02.png')}}" height="18" alt="stars02">
                                        </div>
                                        <div class="rating-card">
                                            <div class="user-info">
                                                <img src="{{asset('front/home/assets/images/users/Ellipse 1-2.png')}}" height="49"
                                                    alt="Ellipse">
                                                <h5>Jonas Sousa</h5>
                                            </div>
                                            <img src="{{asset('front/home/assets/images/icons/stars01.png')}}" height="18" alt="stars02">
                                        </div>
                                        <div class="rating-card">
                                            <div class="user-info">
                                                <img src="{{asset('front/home/assets/images/users/Ellipse 1-3.png')}}" height="49"
                                                    alt="Ellipse">
                                                <h5>Jonas Sousa</h5>
                                            </div>
                                            <img src="{{asset('front/home/assets/images/icons/stars02.png')}}" height="18" alt="stars02">
                                        </div>
                                        <div class="rating-card">
                                            <div class="user-info">
                                                <img src="{{asset('front/home/assets/images/users/Ellipse 1.png')}}" height="49"
                                                    alt="Ellipse">
                                                <h5>Jonas Sousa</h5>
                                            </div>
                                            <img src="{{asset('front/home/assets/images/icons/stars02.png')}}" height="18" alt="stars02">
                                        </div>
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
                                            <span class="rate">
                                                <i class="bi bi-star-fill active"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <textarea class="form-control style-2" placeholder="You are welcome..."
                                                id="contactMessage" rows="5"></textarea>
                                        </div>
                                        <div class="file-upload">
                                            <span class="text-secondary">Upload Image</span>
                                            <img src="{{asset('front/home/assets/images/icons/img-icon.png')}}" width="20px" alt="">
                                        </div>
                                        <button type="button" class="apply-flitter mt-3 w-100">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="contact-ad-owner-box">
                            <h4 class="form-title">Contact Ad Owner</h4>
                            <form>
                                <!-- Full Name -->
                                <div class="mb-3">
                                    <label for="contactName" class="form-label custom-label">Full Name
                                        <span>*</span></label>
                                    <input type="text" class="form-control custom-input" id="contactName" included />
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="contactEmail" class="form-label custom-label">Your Email
                                        <span>*</span></label>
                                    <input type="email" class="form-control custom-input" id="contactEmail" included />
                                </div>

                                <!-- Message -->
                                <div class="mb-3">
                                    <label for="contactMessage" class="form-label custom-label">Message</label>
                                    <textarea class="form-control custom-textarea" id="contactMessage"
                                        rows="4"></textarea>
                                </div>

                                <!-- Checkbox -->
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input custom-check" id="createAccount" />
                                    <label class="form-check-label custom-check-label" for="createAccount">
                                        Create an account for me
                                    </label>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn-theme-bg">Send</button>
                            </form>
                        </div>

                    </div>
                    <div class="card-boxleft">
                        <h4 class="title">Ad Action</h4>
                        <ul class="act-icon">
                            <li><a href=""><img src="{{asset('front/home/assets/images/share-icon.svg')}}" alt="" /></a></li>
                            <li><a href=""><img src="{{asset('front/home/assets/images/printer-icon.svg')}}" alt="" /></a></li>
                            <li><a href=""><img src="{{asset('front/home/assets/images/heart-icon.svg')}}" alt="" /></a></li>
                            <li><a href=""><img src="{{asset('front/home/assets/images/plag-icon.svg')}}" alt="" /></a></li>
                            <li><span data-bs-target="#Compare" data-bs-toggle="modal"><img
                                        src="{{asset('front/home/assets/images/return-icon.svg')}}" alt="" /></span></li>
                        </ul>
                    </div>
                </div>

              
                <div class="card-boxleft p-0">
                    <img src="{{asset('front/home/assets/images/map-img.png')}}" alt="" />
                </div>
                <div class="card-boxleft feat_card_bx">
                    <h4 class="title">More Ads From This User</h4>
                    <div class="adsfromcrd">
                        <div class="adsimg">
                            <img src="{{asset('front/home/assets/images/blog-b-img-1.png')}}" alt="" />
                        </div>
                        <div class="adsfromcrd-cont">
                            <h5>2015 KWPN gelding winning</h5>
                            <div class="btn-cont">
                                <a class=""><img src="{{asset('front/home/assets/images/call-icon-br.svg')}}" alt="" /> Call for
                                    price</a>
                                <div class="bx2">
                                    <button>
                                        <img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}" alt="">
                                    </button>
                                    <button>
                                        <img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}" alt="">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</section>


<script>
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
const fileInput = document.getElementById("customFileInput");
const fileNameDisplay = document.getElementById("fileName");
const previewBox = document.getElementById("filePreviewBox");
const previewImg = document.getElementById("filePreviewImage");

fileInput.addEventListener("change", function() {
    const file = this.files[0];

    if (file) {
        fileNameDisplay.textContent = file.name;

        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewBox.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            previewBox.style.display = "none";
            previewImg.src = "";
        }
    } else {
        fileNameDisplay.textContent = "No file selected";
        previewBox.style.display = "none";
        previewImg.src = "";
    }
});
</script>



@endsection