@php
    $columnClass = $columnClass ?? 'col-lg-4';
@endphp

@if($viewMode=="grid")
    <div class="row">
        @foreach($data as $key=>$value)
            <div class="{{ $columnClass }} mb-3">
                <div class="feat_card_bx grid-view">
                    <a href="{{route('horseDetails',@$value->id)}}">
                        <div class="image">
                            <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="hourse-image">
                            
                            @if(@$value->product_status == 'sold')
                                <span class="tag-img sold-tag">Sold</span>
                            @else
                                @if(!empty(@$value->greenEligibilities))<span class="tag-img">{{@$value->greenEligibilities->commonMaster->name}} </span>@endif
                            @endif
                        </div>
                    </a>
                    <div class="content">
                        <a href="{{route('horseDetails',@$value->id)}}">
                        <h3>
                                {{@$value->title}} | {{@$value->productDetail->age}} | {{@$value->height->commonMaster->name}} <br />
                                {{ @$value->breeds->map(function($breed) {
                                    return optional($breed->commonMaster)->name;
                                })->filter()->implode(' | ') }}
                            </h3>
                        </a>

                        <!-- <h4>Call For Price</h4> -->
                          @if(@$value->sale_method == 'auction' && !empty(@$value->bid_expire_date))
                                    @if( @$value->product_status == 'live')
                                        <h4>Bid Now</h4>
                                    @elseif(@$value->product_status == 'closed' && auth()->check() == true && @$value->highestBid->user_id == auth()->user()->id)
                                        <h4>Checkout</h4>
                                    @else
                                        <h4>Bid Closed</h4>
                                    @endif
                                @elseif(@$value->sale_method == 'standard' && @$value->transaction_method == 'buyertoseller')
                                    <h4>Call for price</h4>
                                @elseif(@$value->sale_method == 'standard' && @$value->transaction_method == 'platform')
                                    @if( @$value->product_status == 'live')
                                   <h4>Buy Now</h4>
                                    @elseif( @$value->product_status == 'sold')
                                    <h4>Sold</h4>
                                    @endif
                                @endif
                           

                        {{-- <h4>Sale: $100,000 - $150,000</h4>
                        <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4> --}}

                        <span class="sp1">
                            {{ @$value->disciplines->map(function($disciplines) {
                                return optional($disciplines->commonMaster)->name;
                            })->filter()->implode(' | ') }}
                            </span>
                        <div class="location">
                            <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}" alt="location-icon" />
                            <span>{{@$value->productDetail->city}}, {{@$value->productDetail->state}}, {{@$value->productDetail->country}} <br />
                                Trial: {{ @$value->triedUpcomingShows->map(function($upcoming) {
                                            return optional($upcoming->commonMaster)->name;
                                        })->filter()->implode(' | ') }}
                            @if(@$value->productDetail->fromdate)
                                <br/>
                                ({{ format_date(@$value->productDetail->fromdate).' - '.format_date(@$value->productDetail->todate)}})
                            @endif
                        </div>
                        <div class="foot">
                            <div class="bx">
                                <div class="imagee">
                                    <img src="{{(@$value->user->profile_photo_path)?asset('storage/'.@$value->user->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}" class="user-img" alt="">
                                </div>
                                <div class="content">
                                    <h4>{{@$value->user->name}}</h4>
                                    <div class="stars">
                                        @php
                                            $averageRating = round(optional(@$value->user->reviews)->avg('rating'), 1);
                                            $totalReviews  = optional(@$value->user->reviews)->count();
                                        @endphp 
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star-fill {{ $i <= $averageRating ? 'text-warning' : 'text-secondary' }}"></i>
                                        @endfor

                                    </div>
                                </div>
                            </div>
                            <div class="bx2">
                                <button class="compare-add-button" data-id="{{$value->id}}">
                                    <img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}" alt="" />
                                </button>

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
            </div>
        @endforeach
    </div>

@else

    <div class="col-lg-8">
        <div class="map-info">
            <div>
                <div class="top-header-map">
                    <div class="map-locainfo">
                        <div class="tag-loacinfo">
                            <span class="blue"></span>
                            Location
                        </div>
                        <div class="tag-loacinfo">
                            <span class="red"></span>
                            Trial / Exchange Location
                        </div>
                        <div class="tag-loacinfo">
                            <span class="black"></span>
                            Transportation
                        </div>
                    </div>
                </div>
            </div>
            <div id="map">
                <!-- <div class="onlinebox"><span class="online"></span> Online</div> -->
            </div>
            
            <!-- Card INSIDE MAP container -->
            <div class="horsescard-popup" id="popupCard">
                <div class="inner-box">

                    <img src="{{asset('front/home/assets/images/featured_hource1.png')}}" id="popupImage" />
                    <div class="info" id="popupInfo"></div>
                </div>
                <span class="close-btn" onclick="closePopup()">×</span>

            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        @foreach($data as $key=>$value)
            <div class="feat_card_bx list-page-card">
                <a href="{{route('horseDetails',@$value->id)}}">
                    <div class="imagelist">
                        <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" alt="hourse-image">
                        <span class="tag-img">{{@$value->greenEligibilities->commonMaster->name}} </span>
                    </div>
                </a>

                <div class="content">
                    <a href="{{route('horseDetails',@$value->id)}}">
                    <h3>
                            {{@$value->title}} | {{@$value->productDetail->age}} | {{@$value->height->commonMaster->name}} <br />
                            {{ @$value->breeds->map(function($breed) {
                                return optional($breed->commonMaster)->name;
                            })->filter()->implode(' | ') }}
                        </h3>
                    </a>

                    <h4>Call For Price</h4>

                    {{-- <h4>Sale: $100,000 - $150,000</h4>
                    <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4> --}}

                    <span class="sp1">
                        {{ @$value->disciplines->map(function($disciplines) {
                            return optional($disciplines->commonMaster)->name;
                        })->filter()->implode(' | ') }}
                        </span>
                    <div class="location">
                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}" alt="location-icon" />
                        <span>{{@$value->productDetail->city}}, {{@$value->productDetail->state}}, {{@$value->productDetail->country}} <br />
                            Trial: {{ @$value->triedUpcomingShows->map(function($upcoming) {
                                        return optional($upcoming->commonMaster)->name;
                                    })->filter()->implode(' | ') }}
                        @if(@$value->productDetail->fromdate)
                            <br/>
                            ({{ format_date(@$value->productDetail->fromdate).' - '.format_date(@$value->productDetail->todate)}})
                        @endif
                    </div>


                    <div class="foot">
                        <div class="bx">
                             <div class="imagee">
                                <img src="{{(@$value->user->profile_photo_path)?asset('storage/'.@$value->user->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}" class="user-img" alt="">
                            </div>
                            <div class="content">
                                    <h4>{{@$value->user->name}}</h4>
                                    
                                <div class="stars">
                                     @php
                                        $averageRating = round(optional(@$value->user->reviews)->avg('rating'), 1);
                                        $totalReviews  = optional(@$value->user->reviews)->count();
                                    @endphp 
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star-fill {{ $i <= $averageRating ? 'text-warning' : 'text-secondary' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="bx2">
                            <button class="compare-add-button" data-id="{{$value->id}}">
                                <img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}" alt="" />
                            </button>

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
        @endforeach
    </div>
 

<!-- Your map initialization script -->
 @once

<!-- Your map initialization script -->
<script>
(function () {
    let mapboxAccessToken = '{{ config("config.map_box_access_token") }}';
mapboxgl.accessToken = mapboxAccessToken;

let map; // global map reference
let currentPopup = null; // to keep track of the currently opened popup

// Reverse geocode to get human-readable location from lat,lng and set input value
function reverseGeocode(lat, lng) {
    const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxAccessToken}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.features && data.features.length > 0) {
                // Use the place_name of the first feature as the location string
                const placeName = data.features[0].place_name;
                const mapLocationInput = document.getElementById('map-location');
                if(mapLocationInput){
                    mapLocationInput.value = placeName;
                }

                const locationInput = document.getElementById('location');
                if(locationInput){
                    locationInput.value = placeName;
                }
            }
        })
        .catch(error => {
            console.error('Reverse geocoding error:', error);
        });
}

alert('onload');
    const urlParams = new URLSearchParams(window.location.search);
    // Default or from URL
    let lat = parseFloat(urlParams.get('latitude')) || 26.8467;
    let lng = parseFloat(urlParams.get('longitude')) || 75.7647;
    const selectedCategory = urlParams.get('category') || '1';

    // Elements to store lat and lng values
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');

    // Try to get user's current location via Geolocation API
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
                lat = position.coords.latitude;
                lng = position.coords.longitude;

                // Update lat/lng input fields
                if (latInput) latInput.value = lat.toFixed(6);
                if (lngInput) lngInput.value = lng.toFixed(6);

                initializeMap(lat, lng);

                // Reverse geocode to update location input text
                reverseGeocode(lat, lng);

                fetchEventsByCategory(selectedCategory);
            },
            error => {
                // If geolocation denied or fails, fallback to URL or defaults
                if (latInput) latInput.value = lat.toFixed(6);
                if (lngInput) lngInput.value = lng.toFixed(6);

                initializeMap(lat, lng);
                reverseGeocode(lat, lng);
                fetchEventsByCategory(selectedCategory);
            },
            { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
        );
    } else {
        // Geolocation not supported
        if (latInput) latInput.value = lat.toFixed(6);
        if (lngInput) lngInput.value = lng.toFixed(6);

        initializeMap(lat, lng);
        reverseGeocode(lat, lng);
        fetchEventsByCategory(selectedCategory);
    }

    // Set active category button
    /* const buttons = document.querySelectorAll('.category-scroll button[data-id]');
    let activeButton = document.querySelector(`.category-scroll button[data-id="${selectedCategory}"]`);
    if (!activeButton) {
        activeButton = document.querySelector('.category-scroll button[data-id="1"]');
    }
    if (activeButton) {
        activeButton.classList.add('active');
    } */

    // Handle category click
    /* document.querySelector('.category-scroll').addEventListener('click', function (e) {
        const btn = e.target.closest('button[data-id]');
        if (!btn) return;

        // Remove active class from all buttons, add to clicked one
        document.querySelectorAll('.category-scroll button[data-id]').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const catId = btn.getAttribute('data-id');
        const url = new URL(window.location);
        url.searchParams.set('category', catId);
        window.history.replaceState({}, '', url);

        // Close any open popup before fetching new markers
        if (currentPopup) {
            currentPopup.remove();
            currentPopup = null;
        }

        // Remove active marker highlight from previous markers
        document.querySelectorAll('.red-circle-marker').forEach(el => el.classList.remove('active-marker'));

        fetchEventsByCategory(catId);
    }); */


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

function fetchEventsByCategory(categoryId = 1) {
    if (!map) return;

    // Remove all existing markers
    const oldMarkers = document.querySelectorAll('.mapboxgl-marker');
    oldMarkers.forEach(m => m.remove());

    // Close any open popup
    if (currentPopup) {
        currentPopup.remove();
        currentPopup = null;
    }

    // Remove active marker highlights
    document.querySelectorAll('.red-circle-marker').forEach(el => el.classList.remove('active-marker'));

    let apiUrl = '{{ url("/api/v1/product/mapbox-list?category=") }}' + categoryId;
    fetch(apiUrl)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            updateMapMarkers(data, categoryId);
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
}

function updateMapMarkers(events, categoryId) {
    if (!map) return;

    if (!events.length) {
        // Optionally clear markers or show “no results” message
        return;
    }

    const eventGroups = {};
    const venueDetailRoute = "{{ route('horseDetails', ':id') }}";
    const activeClass = 'active-marker';
    
        events.forEach(event => {
            const lat = parseFloat(event.product_detail?.latitude);
            const lng = parseFloat(event.product_detail?.longitude);
            if (!isNaN(lat) && !isNaN(lng)) {
                const key = `${lat},${lng}`;
                if (!eventGroups[key]) eventGroups[key] = [];
                eventGroups[key].push(event);
            }
        });

        for (const latLng in eventGroups) {
            const [lat, lng] = latLng.split(',').map(Number);
            const markerEl = document.createElement('div');
            markerEl.className = 'red-circle-marker';

            const img = document.createElement('img');
            /* img.src = "{{ asset('images/marker_map_icon.svg') }}";
            img.className = 'marker-image';
            markerEl.appendChild(img); */

            const firstProduct = eventGroups[latLng][0];
            /* const venueName = document.createElement('span');
            venueName.className = 'marker-venue-name';
            venueName.innerText = firstProduct.title || 'No Title';
            markerEl.appendChild(venueName); */

            const marker = new mapboxgl.Marker(markerEl).setLngLat([lng, lat]).addTo(map);

            const popupHTML = eventGroups[latLng].map(product => {
                img.src = "{{ asset('images/marker_map_icon.svg') }}";
                img.className = 'marker-image';
                markerEl.appendChild(img);

                const title = product.title || 'Untitled';
                const desc = product.description || '';
                const truncated = desc.length > 40 ? desc.slice(0, 40) + '...' : desc;
                const imgUrl = product.image?.[0]?.image ? `{{asset('/storage')}}/${product.image[0].image}` : '';
                const price = product.price || product.product_detail?.sale_price || 'N/A';
                const fullAddr = [product.product_detail?.street, product.product_detail?.city, product.product_detail?.state, product.product_detail?.country].filter(Boolean).join(', ');
                const detailUrl = venueDetailRoute.replace(':id', product.id);

                return `
                    <div class="map-pp-main">
                        <div class="evn-dte-ll">
                            <div class="ent-emg">
                                ${imgUrl ? `<img src="${imgUrl}" style="width:60px;height:60px;" alt="${title}">` : ''}
                                <div>
                                    <h3><a href="${detailUrl}" target="_blank">${title}</a></h3>
                                    <p>${truncated}</p>
                                </div>
                            </div>
                            <div class="venue-name-new-ic">
                                <img src="{{ asset('images/location-mdl-icon.svg') }}" alt="Location icon" />
                                ${fullAddr}
                            </div>
                            <div class="loc-meta">
                                <div><strong>Price:</strong> $${price}</div>
                                <div class="loc-metabutton">
                                    <a href="${detailUrl}" target="_blank" class="meta-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                `;
            }).join('');

            const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(popupHTML);

            marker.setPopup(popup);

            markerEl.addEventListener('click', () => {
                // Close previously opened popup if different
                if (currentPopup && currentPopup !== popup) {
                    currentPopup.remove();
                }

                // Open clicked popup
                popup.addTo(map);
                currentPopup = popup;

                // Update active marker class
                document.querySelectorAll('.red-circle-marker').forEach(el => el.classList.remove(activeClass));
                markerEl.classList.add(activeClass);
            });
        }
    

    
}
})();
</script>


@endonce
@endif


<script>
    // add favorite
    $('.favorite-btn').on('click', function(e) {
        e.preventDefault();

        let productId = $(this).data('product-id');
        let url = `{{ url('favorite') }}`+'/'+ productId;
        let $btn = $(this);

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // alert(response.message);
                if (response.favorited) {
                    $btn.addClass('favorited');  
                    $btn.find("i").addClass('fa-solid').removeClass('fa-regular favorited');
                } else {
                    $btn.removeClass('favorited');
                    $btn.find("i").addClass('fa-regular favorited').removeClass('fa-solid');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    Swal.fire({
                        title: "Elite Equine",
                        text: "Please login to add favorite.",
                        imageUrl: "{{ asset('front/home/assets/images/add-favorite.svg') }}",
                        imageWidth: 400,
                        imageHeight: 200,
                        imageAlt: "Elite Equine",
                        // This disables the default Swal styling for confirm button
                        customClass: {
                            confirmButton: 'commen_btn'
                        },
                        buttonsStyling: false, // <--- disables SweetAlert's built-in styling
                        confirmButtonText: "<a href='{{ route('login') }}' class='commen_btn'>Login</a>"
                    });
                } else {
                    alert('Something went wrong.');
                }
            }
        });
    });
</script>
<script>
    /* document.addEventListener('DOMContentLoaded', function () {
        const mapContainer = document.getElementById('map');
        if (mapContainer) {
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [77.2090, 28.6139],
                zoom: 10
            });

            // Optional: Add a marker example
            new mapboxgl.Marker()
                .setLngLat([77.2090, 28.6139])
                .addTo(map);
        }
    }); */
</script>