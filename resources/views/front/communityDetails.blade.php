@extends('front.layouts.main')
@section('title')
Community & Event Details
@endsection
@section('content')

<section class="py-5">
    <div class="container">
        <div class="heading-page">
            <h3>{{@$community->title}}</h3>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="left-side-deatils">
                   
                    @if(@$community->image)
                        
                        <img class="pedigreechart" src="{{asset('storage/'.@$community->image)}}" alt="" />
                        <div class="info-desc-footer">
                            <ul>
                                <li><span> <img src="{{asset('front/home/assets/images/location-icon.svg')}}" alt="" /></span> {{@$community->location}}</li>
                                {{-- <li><span> <img src="{{asset('front/home/assets/images/show-icon.svg')}}" alt="" /></span> 30 #11223</li> --}}
                                <li>
                                    <span> Created Date : <img src="{{asset('front/home/assets/images/calendar-icon.svg')}}" alt="" /></span>
                                    {{ \Carbon\Carbon::parse($community->created_at)->format('M d, Y') }}                                
                                </li>
                            </ul>
                        </div>
                    @endif

                    <div class="info-desc">
                        <h3 class="horse-info-heading">Community & Events Description</h3>
                       
                        <div class="horse-info-row"><span class="horse-label">Title :</span> {{@$community->title}}</div>
                        <div class="horse-info-row"><span class="horse-label">Requirement:</span> {{@$community->requirement}} </div>
                        <div class="horse-info-row"><span class="horse-label">Date & Time:</span> 
                            {{ \Carbon\Carbon::parse($community->date)->format('d M Y') }} : {{ \Carbon\Carbon::parse($community->time)->format('h:i A') }}
                        </div>


                        <div class="horse-info-row"><span class="horse-label">Event around:</span> 
                            {{@$community->event_around}}
                        </div>

                        <div class="horse-info-row"><span class="horse-label">Location:</span> 
                            {{@$community->location}}
                        </div>
                    </div>                                        
                </div>
            </div>

            <div class="col-lg-4">
                <div class="details-right">

                    <div class="card-boxleft">
                        <div class="pb-3 gap-2">
                            <span class="text-secondary">Event Price</span>
                            <h2 class="fw-bold">${{number_format(@$community->price,2)}} </h2>
                        </div>
                        <div>
                            @if(isset($attending))
                                <div class="btn-connected gap-2">                                
                                    <button type="button" class="call-price w-100">You’re Registered</button>
                                    @if($community->user_id == auth()->id())
                                        <a href="{{route('community.edit', $community->id)}}"><button class="call-price chat-btn">Edit</button></a>
                                    @else
                                        <button class="call-price chat-btn" onclick="{{auth()->check()?'chatCreate();': 'showLoginModal("Please login to chat with ad owner.")'}}">
                                            <img src="{{asset('front/home/assets/images/chat-icon.svg')}}" alt="" />
                                        </button>
                                    @endif
                                </div>
                            @else
                                <div class="btn-connected gap-2">
                                     @if($community->user_id == auth()->id())
                                        <button type="button" class="call-price w-100">Event Owner</button>
                                        <a href="{{route('community.edit', $community->id)}}"><button class="call-price w-100 chat-btn">Edit</button></a>
                                    @else
                                        <button type="button" onclick="window.location.href='{{route('community.join',$community->id)}}'" class="call-price w-100">Join Now</button>
                                        <button class="call-price chat-btn" onclick="{{auth()->check()?'chatCreate();': 'showLoginModal("Please login to chat with ad owner.")'}}">
                                            <img src="{{asset('front/home/assets/images/chat-icon.svg')}}" alt="" />
                                        </button>
                                    @endif

                                </div>
                            @endif
                            <p class="text-center py-3">Event Date : {{ \Carbon\Carbon::parse($community->date)->format('d M Y') }} : {{ \Carbon\Carbon::parse($community->time)->format('h:i A') }} </p>
                            
                        </div>

                        <div class="ad-owner-btn">
                            <h3>Event Owner</h3>
                            <div class="owner-profile">
                                <div class="profil-info">
                                    <div class="proimg">
                                        <img src="{{(@$community->user->profile_photo_path)?asset('storage/'.@$community->user->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}" class="user-img" alt="">
                                        <span class="status-dot"></span>
                                    </div>
                                    <div class="proname">
                                        <h2>{{ @$community->user->name }}</h2>
                                        <div data-bs-target="#Rating" data-bs-toggle="modal"><img
                                                src="{{asset('front/home/assets/images/star-rating5.svg')}}" alt="" /></div>
                                    </div>
                                </div>
                                {{-- <div class="btn-right">
                                    <button class="btn-theme-bg" data-bs-target="#WriteReview"
                                        data-bs-toggle="modal">Write A Review</button>
                                </div> --}}
                            </div>
                            <div class="connect-numr" id="contact-reval" data-last-digit="{{substr(@$community->user->getUserDetail->phone, -3)}}">
                                <h3>{{substr(@$community->user->getUserDetail->phone, 0, -3).'xxx'}}</h3>
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
                                        <div class="file-upload cusom-uplod">
                                            <label for="reviewImage" class="upload-label" id="uploadText">Upload Image</label>
                                            <input type="file" id="reviewImage" accept="image/jpeg,image/png" hidden />
                                        </div>
                                        <button type="button" class="apply-flitter mt-3 w-100">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="contact-ad-owner-box">
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
                        </div> --}}

                    </div>

                    {{-- <div class="card-boxleft">
                        <h4 class="title">Ad Action</h4>
                        <ul class="act-icon">
                            <li><a href=""><img src="{{asset('front/home/assets/images/share-icon.svg')}}" alt="" /></a></li>
                            <li><a href=""><img src="{{asset('front/home/assets/images/printer-icon.svg')}}" alt="" /></a></li>
                          
                            <li><a href=""><img src="{{asset('front/home/assets/images/plag-icon.svg')}}" alt="" /></a></li>
                            <li>
                                <a href="javascript:void(0)">
                                    <span class="compare-add-button" data-id="{{$community->id}}">
                                        <img src="{{asset('front/home/assets/images/return-icon.svg')}}" alt="" />
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div> --}}

                    <div class="card-boxleft p-0" id="map"></div> 

                    @if(count($moreAdd)>0)
                        <div class="card-boxleft feat_card_bx">
                            <h4 class="title">More Events From This User</h4>
                            @foreach(@$moreAdd as $key=>$value)

                                <div class="adsfromcrd">
                                    <a href="{{route('communityDetails',$value->id)}}">
                                        <div class="adsimg">
                                            <img src="{{(@$value->image)?asset('storage/'.@$value->image):asset('front/home/assets/images/logo/logo.svg')}}" width="80" class="avatar avatar-sm me-3" alt="image-1">
                                        </div>
                                    </a>
                                    <div class="adsfromcrd-cont">
                                        <h5>{{$value->title}}</h5>
                                        <div class="btn-cont">
                                            <a href="{{route('communityDetails',$value->id)}}">
                                                <img src="{{asset('front/home/assets/images/location-icon.svg')}}" alt="" /> 
                                                Location : {{$value->location}}
                                            </a>                                           
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



<!----------------Edit comment box-------------->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
        integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>    

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

<script>

function chatCreate() {
    var formData = new FormData();
    formData.append('sender_id', {{ auth()->id() }});
    formData.append('receiver_id', {{ $community->user_id }});
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
                Swal.fire("EliteQuine", 'Failed to create chat room: ' + response.message, "error");
            }
        },
        error: function(xhr, status, error) {
            console.error('Error creating chat room:', xhr.responseText);
            Swal.fire("EliteQuine", 'Failed to create chat room', "error");
        }
    });
}


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
@endsection
