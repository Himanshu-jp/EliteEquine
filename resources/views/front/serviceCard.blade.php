@if ($viewMode == 'grid')
    <div class="row">
        @foreach ($data as $key => $value)
            <div class="col-lg-4 mb-3">
                <div class="feat_card_bx grid-view">
                    <a href="{{ route('serviceDetails', @$value->id) }}">
                        <div class="image">
                            <img src="{{ @$value->image->first() ? asset('storage/' . @$value->image->first()->image) : asset('front/home/assets/images/logo/logo.svg') }}"
                                alt="hourse-image">
                            {{-- <span class="tag-img">{{@$value->greenEligibilities->commonMaster->name}} </span> --}}
                        </div>
                    </a>
                    <div class="content">
                        <a href="{{ route('serviceDetails', @$value->id) }}">
                            <h3>
                                {{ @$value->title }}
                                {{-- {{@$value->title}} | {{@$value->productDetail->age}} | {{@$value->height->commonMaster->name}} <br />
                            {{ @$value->breeds->map(function($breed) {
                                return optional($breed->commonMaster)->name;
                            })->filter()->implode(' | ') }} --}}
                            </h3>
                        </a>

                        {{-- <h4>Call For Price</h4> --}}
                        <h4>Houlry Pay: ${{ number_format(@$value->productDetail->hourly_price) }} </h4>
                        <h4>Fixed Pay: ${{ number_format(@$value->productDetail->fixed_price) }} </h4>
                        <h4>Salary Price: ${{ number_format(@$value->productDetail->salary) }} </h4>

                        {{-- <span class="sp1"></span> --}}
                        <div class="location">
                            <img src="{{ asset('front/home/assets/images/icons/loction_icn.svg') }}"
                                alt="location-icon" />
                            <span>{{ @$value->productDetail->city }}, {{ @$value->productDetail->state }},
                                {{ @$value->productDetail->country }} <br />
                                Dates Available :
                                {{ @$value->triedUpcomingShows->map(function ($upcoming) {
                                        return optional($upcoming->commonMaster)->name;
                                    })->filter()->implode(' | ') }}

                                @if (@$value->productDetail->fromdate)
                                    <br />
                                    ({{ format_date(@$value->productDetail->fromdate) . ' - ' . format_date(@$value->productDetail->todate) }})
                                @endif
                            </span>
                        </div>
                        <div class="foot">
                            <div class="bx">
                                <div class="imagee">
                                    <img src="{{ @$value->user->profile_photo_path ? asset('storage/' . @$value->user->profile_photo_path) : asset('front/auth/assets/img/user-img.png') }}"
                                        class="user-img" alt="">
                                </div>
                                <div class="content">
                                    <h4>{{ @$value->user->name }}</h4>
                                    <div class="stars">
                                        @php
                                            $averageRating = round(optional(@$value->user->reviews)->avg('rating'), 1);
                                            $totalReviews = optional(@$value->user->reviews)->count();
                                        @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="bi bi-star-fill {{ $i <= $averageRating ? 'text-warning' : 'text-secondary' }}"></i>
                                        @endfor
                                        <!-- <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i> -->
                                    </div>
                                </div>
                            </div>
                            <div class="bx2">
                                <button class="compare-add-button" data-id="{{ $value->id }}">
                                    <img src="{{ asset('front/home/assets/images/icons/re_icn.svg') }}"
                                        alt="" />
                                </button>

                                {{-- <button>
                                <img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}" alt="" />
                            </button> --}}
                                <button
                                    class="favorite-btn {{ $value->favorites->where('user_id', auth()->id())->count() ? 'favorited' : '' }}"
                                    data-product-id="{{ $value->id }}">
                                    @if ($value->favorites->where('user_id', auth()->id())->count() > 0)
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

                    <img src="{{ asset('front/home/assets/images/featured_hource1.png') }}" id="popupImage" />
                    <div class="info" id="popupInfo"></div>
                </div>
                <span class="close-btn" onclick="closePopup()">×</span>

            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @foreach ($data as $key => $value)
            <div class="feat_card_bx list-page-card">
                <a href="{{ route('serviceDetails', @$value->id) }}">
                    <div class="imagelist">
                        <img src="{{ @$value->image->first() ? asset('storage/' . @$value->image->first()->image) : asset('front/home/assets/images/logo/logo.svg') }}"
                            alt="hourse-image">
                    </div>
                </a>

                <div class="content">
                    <a href="{{ route('serviceDetails', @$value->id) }}">
                        <h3>
                            {{ @$value->title }}
                        </h3>
                    </a>

                    <h4>Houlry Pay: ${{ number_format(@$value->productDetail->hourly_price) }} </h4>
                    <h4>Fixed Pay: ${{ number_format(@$value->productDetail->fixed_price) }} </h4>
                    <h4>Salary Price: ${{ number_format(@$value->productDetail->salary) }} </h4>

                    {{-- <span class="sp1"></span> --}}
                    <div class="location">
                        <img src="{{ asset('front/home/assets/images/icons/loction_icn.svg') }}" alt="location-icon" />
                        <span>{{ @$value->productDetail->city }}, {{ @$value->productDetail->state }},
                            {{ @$value->productDetail->country }} <br />
                            Dates Available :
                            {{ @$value->triedUpcomingShows->map(function ($upcoming) {
                                    return optional($upcoming->commonMaster)->name;
                                })->filter()->implode(' | ') }}

                            @if (@$value->productDetail->fromdate)
                                <br />
                                ({{ format_date(@$value->productDetail->fromdate) . ' - ' . format_date(@$value->productDetail->todate) }})
                            @endif
                        </span>
                    </div>

                    <div class="foot">
                        <div class="bx">
                            <div class="imagee">
                                <img src="{{ @$value->user->profile_photo_path ? asset('storage/' . @$value->user->profile_photo_path) : asset('front/auth/assets/img/user-img.png') }}"
                                    class="user-img" alt="">
                            </div>
                            <div class="content">
                                <h4>{{ @$value->user->name }}</h4>
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bx2">
                            <button class="compare-add-button" data-id="{{ $value->id }}">
                                <img src="{{ asset('front/home/assets/images/icons/re_icn.svg') }}" alt="" />
                            </button>

                            <button
                                class="favorite-btn {{ $value->favorites->where('user_id', auth()->id())->count() ? 'favorited' : '' }}"
                                data-product-id="{{ $value->id }}">
                                @if ($value->favorites->where('user_id', auth()->id())->count() > 0)
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

    @once

        <!-- Your map initialization script -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://api.mapbox.com/mapbox-gl-js/v3.9.0/mapbox-gl.js"></script>
        <script>
            (function() {


                var map; // global map reference
                var currentPopup = null; // to keep track of the currently opened popup

                // Reverse geocode to get human-readable location from lat,lng and set input value
                function reverseGeocode(lat, lng) {
                    var url =
                        `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxAccessToken}`;

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            if (data.features && data.features.length > 0) {
                                // Use the place_name of the first feature as the location string
                                var placeName = data.features[0].place_name;
                                var mapLocationInput = document.getElementById('map-location');
                                if (mapLocationInput) {
                                    mapLocationInput.value = placeName;
                                }

                                var locationInput = document.getElementById('location');
                                if (locationInput) {
                                    locationInput.value = placeName;
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Reverse geocoding error:', error);
                        });
                }


                var urlParams = new URLSearchParams(window.location.search);
                // Default or from URL
                var lat = parseFloat(urlParams.get('latitude')) || 26.8467;
                var lng = parseFloat(urlParams.get('longitude')) || 75.7647;
                var selectedCategory = urlParams.get('category') || '1';

                // Elements to store lat and lng values
                var latInput = document.getElementById('latitude');
                var lngInput = document.getElementById('longitude');

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
                        }, {
                            enableHighAccuracy: true,
                            timeout: 5000,
                            maximumAge: 0
                        }
                    );
                } else {
                    // Geolocation not supported
                    if (latInput) latInput.value = lat.toFixed(6);
                    if (lngInput) lngInput.value = lng.toFixed(6);

                    initializeMap(lat, lng);
                    reverseGeocode(lat, lng);
                    fetchEventsByCategory(selectedCategory);
                }
            })
            var userCoordinates = [75.769446, 26.836992];
            mapboxgl.accessToken = '{{ env('MAPBOX_ACCESS_TOKEN') }}';
            var map = new mapboxgl.Map({
                container: 'map',
                center: userCoordinates,
                style: "mapbox://styles/mapbox/standard",
                //  style: "mapbox://styles/mapbox-map-design/standard-experimental-ime", // used on may 2 2025
                // style: "mapbox://styles/mtdeveloper/cma6drmn800e801s539sqc6of",
                /* style: 'mapbox://styles/mapbox/streets-v12', */
                //center: [-104.8797372146656, 39.76008581046093],
                zoom: 10,
                pitch: 62,
                bearing: -60
            });

            var events = @json($data);
            var horseList = events.data;



            var eventGroups = {};
            var allData = [];
            horseList.forEach(event => {

                if (event.product_detail) {

                    if (event.product_detail?.latitude && event.product_detail?.longitude) {
                        var latLng = `${event.product_detail?.latitude},${event.product_detail?.longitude}`;
                          var latLng1 = `${event.product_detail.trail_latitude},${event.product_detail.trail_longitude}`;

                        if (!eventGroups[latLng]) {
                            eventGroups[latLng] = [];
                        }
                        eventGroups[latLng].push(event);
                        if (!eventGroups[latLng1]) {
                            eventGroups[latLng1] = [];
                        }
                        eventGroups[latLng1].push(event);
                        var object = {};
                        object.title = event.title;
                        object.price = event.price;
                        object.description = event.description;
                        object.image = event.image && event.image.length > 0 ? event.image[0].image : '';
                        object.address = event.product_detail ? (event.product_detail?.street + ' ' + event
                            .product_detail.city) : '';
                        object.latitude = event.product_detail ? (event.product_detail?.latitude) : '';
                        object.longitude = event.product_detail ? (event.product_detail?.longitude) : '';
                        object.trail_longitude = event.product_detail ? (event.product_detail.trail_longitude) : '';
                        object.trail_latitude = event.product_detail ? (event.product_detail.trail_latitude) : '';
                        allData.push(object)
                    }

                }
            });
            console.log('allData', allData)

            function getUniqueFeatures(features, comparatorProperty) {
                var uniqueIds = new Set();
                var uniqueFeatures = [];
                for (var feature of features) {
                    var id = feature.properties[comparatorProperty];
                    if (!uniqueIds.has(id)) {
                        uniqueIds.add(id);
                        uniqueFeatures.push(feature);
                    }
                }
                return uniqueFeatures;
            }


            function makeMarker() {

                if (typeof customMarkers !== 'undefined' && Array.isArray(customMarkers)) {
                    customMarkers.forEach(marker => marker.remove());

                }
                customMarkers = [];
                var features = map.queryRenderedFeatures({
                    layers: ['unclustered-point']
                });
                console.log('features', features);

                var uniqueFeatures = getUniqueFeatures(features, 'venue_name');
                console.log('uniqueFeatures', uniqueFeatures);
                uniqueFeatures.forEach(feature => {
                    var coordinates = feature.geometry.coordinates;
                    var {
                        venue_name,
                        venue_address,
                        latitude,
                        isTrail,
                        longitude
                    } = feature.properties;
                    console.log(coordinates, "coordinates");
                    if (isTrail == 1) {
                        var markerIconUrl = "{{ env('MAP_PUBLIC') }}/images/Services Jobs Red.png";
                    } else {
                        var markerIconUrl = "{{ env('MAP_PUBLIC') }}/images/Services Jobs Blue.png";
                    }
                    // Create a custom HTML element for the marker
                    var markerElement = document.createElement('div');
                    markerElement.className = 'red-circle-marker';

                    var markerImage = document.createElement('img');
                    markerImage.src = markerIconUrl;
                    markerImage.alt = "Marker";
                    markerImage.className = "marker-image";

                    markerElement.appendChild(markerImage);

                    var venueName = document.createElement('span');
                    venueName.className = 'marker-venue-name';
                    //venueName.innerText = venue_name;
                    markerElement.appendChild(venueName);

                    var marker = new mapboxgl.Marker(markerElement).setLngLat([coordinates[0], coordinates[1]]).addTo(
                        map);

                    var latLng = `${latitude},${longitude}`;
                    var eventsAtLocation = eventGroups[latLng];
                    var popupContent = '';
                    console.log(latitude, longitude, "SSSS")
                    console.log(latLng, 'latLng')
                    console.log(eventGroups[latLng])

                    eventsAtLocation.forEach(event => {


                        var ticketPrice = event.price ? `Starts from $${event.price}` :
                            'Price not available';

                        //var ticketUrl = isAuthenticated ? (event.ticket_sale_link || '#') : loginRoute;
                        // var eventImage = event.image && event.image.length > 0  ?"{{ env('MAP_PUBLIC') }}/"+ event.image[0].image : '{{ env('MAP_PUBLIC') }}/public/front/home/assets/images/logo/logo.svg' ;
                        var eventImage = "{{ env('MAP_PUBLIC') }}/front/home/assets/images/logo/logo.svg";
                        var baseUrl = "{{ url('/') }}";
                        var authUserId = '{{ auth()->id() }}';
                        var reviews = event?.user?.reviews;

                        var averageRating = Array.isArray(reviews) && reviews.length > 0 ?
                            Math.round(reviews.reduce((sum, r) => sum + r.rating, 0) / reviews.length) :
                            0;

                        var imageSrc = event.image?.[0]?.image ?
                            `${baseUrl}/public/storage/${event.image[0].image}` :
                            `${baseUrl}/public/front/home/assets/images/logo/logo.svg`;

                        var profileSrc = event.user?.profile_photo_path ?
                            `${baseUrl}/public/storage/${event.user.profile_photo_path}` :
                            `${baseUrl}/public/front/auth/assets/img/user-img.png`;

                        var favorites = event.favorites || [];
                        var isFavorited = favorites.some(fav => fav.user_id === authUserId);

                        var upcomingDates = (event.tried_upcoming_shows || [])
                            .map(u => u.common_master?.name)
                            .filter(Boolean)
                            .join(" | ");

                        var fromDate = event.product_detail?.fromdate ?
                            `(${formatDate(event.product_detail?.fromdate)} - ${formatDate(event.product_detail?.todate)})` :
                            "";

                        var eventUrl = `${baseUrl}/eventdetail/${event.id}`;
                        var maxLength = 40;
                        var descriptionText = event.description || '';
                        var truncatedDescription = descriptionText.length > maxLength ?
                            descriptionText.substring(0, maxLength) + "..." :
                            descriptionText;
                        console.log(event);
                        var venueHtml = '';
                        if (event.title && event.title) {
                            var venueDetailUrl = "url".replace(':id', event.id);
                            venueHtml = `
                            <div class="venue-name-new">
                                <a href="${venueDetailUrl}" target="_blank" class="venue-name-new-ic">
                                  
                                   ${event.title}
                                </a>
                            </div>
                        `;
                        }
                        popupContent += `
                        <div class="feat_card_bx list-page-card">
                            <a href="${baseUrl}/service-details/${event.id}" target="_blank">
                                <div class="imagelist">
                                <img src="${imageSrc}" alt="hourse-image">
                                </div>
                            </a>

                            <div class="content">
                                <a href="${baseUrl}/service-details/${event.id}" target="_blank">
                                <h3>${event.title}</h3>
                                </a>

                                <h4>Houlry Pay: $${Number(event.product_detail?.hourly_price).toLocaleString()}</h4>
                                <h4>Fixed Pay: $${Number(event.product_detail?.fixed_price).toLocaleString()}</h4>
                                <h4>Salary Price: $${Number(event.product_detail?.salary).toLocaleString()}</h4>

                                <div class="location">
                               <img src="${baseUrl}/public/front/home/assets/images/icons/loction_icn.svg" alt="location-icon" />
                                <span>
                                    ${event.product_detail?.city}, ${event.product_detail?.state}, ${event.product_detail?.country}<br/>
                                    Dates Available: ${upcomingDates}<br/>
                                    ${fromDate}
                                </span>
                                </div>

                                <div class="foot">
                                <div class="bx">
                                    <div class="imagee">
                                    <img src="${profileSrc}" class="user-img" alt="">
                                    </div>
                                    <div class="content">
                                    <h4>${event.user.name}</h4>
                                    <div class="stars">
                                        ${[1, 2, 3, 4, 5].map(() => `<i class="fa-solid fa-star"></i>`).join("")}
                                    </div>
                                    </div>
                                </div>

                                <div class="bx2">
                                    <a href="${baseUrl}/service-details/${event.id}" target="_blank">Deatil</a>
                                </div>
                                </div>
                            </div>
                            </div>
                        `;
                    });
                    var popup = new mapboxgl.Popup({
                            offset: 25
                        })
                        .setHTML(popupContent);
                    popup.on('open', () => {

                        var popupElement = document.querySelector('.mapboxgl-popup-content');
                    });
                    marker.setPopup(popup);

                    customMarkers.push(marker);

                });



            }

            function formatDate(dateString) {
                var date = new Date(dateString);
                return date.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
            }

            function addClusterView() {
                var seenCoords = new Set();

                var eventsfeature = allData.flatMap((event) => [{
                        type: "Feature",
                        geometry: {
                            type: "Point",
                            coordinates: [
                                parseFloat(event.longitude),
                                parseFloat(event.latitude),
                            ],
                        },
                        properties: {
                            venue_name: event.title || "Unknown Venue",
                            venue_address: event.address || "No Address",
                            latitude: event.latitude || "No Address",
                            longitude: event.longitude || "No Address",
                            isTrail: 0,
                        },
                    },
                    {
                        type: "Feature",
                        geometry: {
                            type: "Point",
                            coordinates: [
                                parseFloat(event.trail_longitude),
                                parseFloat(event.trail_latitude),
                            ],
                        },
                        properties: {
                            venue_name: event.title || "Unknown Venue",
                            venue_address: event.address || "No Address",
                            latitude: event.trail_latitude || "No Address",
                            longitude: event.trail_longitude || "No Address",
                            isTrail: 1,
                        },
                    }
                ]);
                console.log("eventsfeature", eventsfeature)
                map.addSource("clusterEvent", {
                    type: "geojson",
                    data: {
                        type: "FeatureCollection",
                        features: eventsfeature
                    },
                    cluster: true,
                    clusterMaxZoom: 12,
                    clusterRadius: 50
                });
                map.addLayer({
                    id: 'clusters',
                    type: 'circle',
                    source: 'clusterEvent',
                    filter: ['has', 'point_count'],
                    paint: {
                        // Use step expressions (https://docs.mapbox.com/style-spec/reference/expressions/#step)
                        // with three steps to implement three types of circles:
                        //   * Blue, 20px circles when point count is less than 100
                        //   * Yellow, 30px circles when point count is between 100 and 750
                        //   * Pink, 40px circles when point count is greater than or equal to 750
                        'circle-color': [
                            'step',
                            ['get', 'point_count'],
                            '#0B1E33',
                            100,
                            '#f1f075',
                            750,
                            '#f28cb1'
                        ],
                        'circle-radius': [
                            'step',
                            ['get', 'point_count'],
                            20,
                            100,
                            30,
                            750,
                            40
                        ]
                    }
                });

                map.addLayer({
                    id: 'cluster-count',
                    type: 'symbol',
                    source: 'clusterEvent',
                    filter: ['has', 'point_count'],
                    layout: {
                        'text-field': ['get', 'point_count_abbreviated'],
                        'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                        'text-size': 12
                    },
                    paint: {
                        'text-color': '#ffffff' // white text
                    }
                });

                map.addLayer({
                    id: 'unclustered-point',
                    type: 'circle',
                    source: 'clusterEvent',
                    filter: ['!', ['has', 'point_count']],
                    paint: {
                        'circle-color': '#11b4da',


                        'circle-stroke-color': '#fff',
                        "circle-radius": 0.1,
                        "circle-opacity": 0.8
                    }
                });
                this.makeMarker();
                setTimeout(() => {
                    this.makeMarker();
                }, 1000);
                // inspect a cluster on click
                map.on('click', 'clusters', (e) => {
                    var features = map.queryRenderedFeatures(e.point, {
                        layers: ['clusters']
                    });
                    var clusterId = features[0].properties.cluster_id;
                    map.getSource('clusterEvent').getClusterExpansionZoom(
                        clusterId,
                        (err, zoom) => {
                            if (err) return;

                            map.easeTo({
                                center: features[0].geometry.coordinates,
                                zoom: zoom
                            });
                        }
                    );
                });

                // When a click event occurs on a feature in
                // the unclustered-point layer, open a popup at
                // the location of the feature, with
                // description HTML from its properties.
                map.on('click', 'unclustered-point', (e) => {
                    var coordinates = e.features[0].geometry.coordinates.slice();
                    var mag = e.features[0].properties.mag;
                    var tsunami =
                        e.features[0].properties.tsunami === 1 ? 'yes' : 'no';

                    // Ensure that if the map is zoomed out such that
                    // multiple copies of the feature are visible, the
                    // popup appears over the copy being pointed to.
                    if (['mercator', 'equirectangular'].includes(map.getProjection().name)) {
                        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                        }
                    }

                    new mapboxgl.Popup()
                        .setLngLat(coordinates)
                        .setHTML(
                            `magnitude: ${mag}<br>Was there a tsunami?: ${tsunami}`
                        )
                        .addTo(map);
                });
            }
            var nav = new mapboxgl.NavigationControl();
            map.addControl(nav, 'top-right');

            if (typeof window.RelocateControl === 'undefined') {
                class RelocateControl {
                    onAdd(map) {
                        this.map = map;
                        this.container = document.createElement('div');
                        this.container.className = 'mapboxgl-ctrl mapboxgl-ctrl-group';
                        this.container.innerHTML = `
                    <button id="relocateBtn" type="button" title="Relocate" style="padding:3px;">
                        <img src="{{ asset('images/current-location-10.svg') }}">
                    </button>
                `;
                        this.container.querySelector('#relocateBtn').addEventListener('click', () => {
                            map.easeTo({
                                center: userCoordinates,
                                zoom: 10,
                                duration: 500
                            });
                        });
                        return this.container;
                    }
                    onRemove() {
                        this.container.parentNode.removeChild(this.container);
                        this.map = undefined;
                    }
                }
                map.addControl(new RelocateControl(), 'top-right');
            }

            map.on("load", () => {

                this.addClusterView()
                map.setConfigProperty('basemap', 'lightPreset', 'dusk');

            });
            map.on('moveend', () => {
                var zoomLevel = map.getZoom();
                this.makeMarker();

                var bounds = map.getBounds();
                var southWest = bounds.getSouthWest();
                var northEast = bounds.getNorthEast();
                var latRange = [southWest.lat, northEast.lat];
                var lngRange = [southWest.lng, northEast.lng];


                var urlParams = new URLSearchParams(window.location.search);
                var datetimes = urlParams.get('datetimes') || '';



            });
        </script>
    @endonce
@endif

<script>
    // add favorite
    $('.favorite-btn').on('click', function(e) {
        e.preventDefault();

        var productId = $(this).data('product-id');
        var url = `{{ url('favorite') }}` + '/' + productId;
        var $btn = $(this);

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
                        title: "EliteQuine",
                        text: "Please login to add favorite.",
                        imageUrl: "{{ asset('front/home/assets/images/add-favorite.svg') }}",
                        imageWidth: 400,
                        imageHeight: 200,
                        imageAlt: "EliteQuine",
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
