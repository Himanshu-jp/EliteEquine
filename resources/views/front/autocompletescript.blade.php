 <script>
 var mapboxAccessToken = '{{ config('config.map_box_access_token') }}';
        function initializeLocationAutocomplete() {
            const sessionToken = Math.random().toString(36).substring(2, 15);

            // Elements for user location
            const locationInput = document.getElementById('location');
            const locationList = document.getElementById('location-list');
            const locationMessage = document.getElementById('location-message');
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');

           

            let selectedIndex = -1;
            let suggestions = [];

            function clearSuggestions() {
                locationList.innerHTML = '';
                locationList.style.display = 'none';
                locationMessage.style.display = 'none';
            
                selectedIndex = -1;
                suggestions = [];
            }

            function highlightSuggestion(index) {
                const items = locationList.querySelectorAll('li');
                items.forEach((li, i) => {
                    if (i === index) {
                        li.classList.add('highlighted');
                        li.scrollIntoView({
                            block: 'nearest'
                        });
                    } else {
                        li.classList.remove('highlighted');
                    }
                });
            }

            function selectSuggestion(index) {
                if (index < 0 || index >= suggestions.length) return;
                const suggestion = suggestions[index];

                const name = suggestion.name || '';
                let state = '';
                let country = '';

                if (suggestion.context && Array.isArray(suggestion.context)) {
                    suggestion.context.forEach(ctx => {
                        if (ctx.id.startsWith('region')) state = ctx.text || ctx.name || '';
                        if (ctx.id.startsWith('country')) country = ctx.text || ctx.name || '';
                    });
                } else if (typeof suggestion.context === 'object') {
                    state = suggestion.context.region?.name || suggestion.context.region?.text || '';
                    country = suggestion.context.country?.country_code || suggestion.context.country?.text || '';
                }

                const fullAddress = [name, state, country].filter(Boolean).join(', ');

                locationInput.value = fullAddress;
               

                clearSuggestions();

                const mapbox_id = suggestion.mapbox_id;

                fetch(
                        `https://api.mapbox.com/search/searchbox/v1/retrieve/${mapbox_id}?session_token=${sessionToken}&access_token=${mapboxAccessToken}`)
                    .then(response => response.json())
                    .then(data => {
                        const features = data.features;
                        if (features && features.length > 0) {
                            const coordinates = features[0].geometry.coordinates;
                            if (coordinates) {
                                const lat = coordinates[1];
                                const lon = coordinates[0];

                                latitudeInput.value = lat;
                                longitudeInput.value = lon;

                           
                                if (typeof fetchVenues === 'function') {
                                    fetchVenues(lat, lon);
                                }
                            }
                        }
                    })
                    .catch(err => console.error('Error fetching coordinates:', err));
            }

            locationInput.addEventListener('input', function() {
               
                const query = locationInput.value.trim();

                if (query.length > 2) {
                    fetch(
                            `https://api.mapbox.com/search/searchbox/v1/suggest?q=${encodeURIComponent(query)}&language=en&limit=5&session_token=${sessionToken}&access_token=${mapboxAccessToken}`)
                        .then(response => response.json())
                        .then(data => {
                            locationList.innerHTML = '';
                            suggestions = data.suggestions || [];

                            if (suggestions.length > 0) {
                                suggestions.forEach((suggestion, i) => {
                                    const li = document.createElement('li');

                                    const name = suggestion.name || '';
                                    let state = '';
                                    let country = '';

                                    if (suggestion.context && Array.isArray(suggestion.context)) {
                                        suggestion.context.forEach(ctx => {
                                            if (ctx.id.startsWith('region')) state = ctx.text ||
                                                ctx.name || '';
                                            if (ctx.id.startsWith('country')) country = ctx
                                                .text || ctx.name || '';
                                        });
                                    }

                                    const fullAddress = [name, state, country].filter(Boolean).join(
                                        ', ');
                                    li.textContent = fullAddress;
                                    li.setAttribute('data-index', i);

                                    li.addEventListener('click', () => selectSuggestion(i));
                                    locationList.appendChild(li);
                                });
                                locationList.style.display = 'block';
                                locationMessage.style.display = 'none';
                                selectedIndex = -1;
                            } else {
                                locationMessage.style.display = 'block';
                                locationMessage.textContent = 'No locations found';
                                locationList.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching location data:', error);
                            locationMessage.style.display = 'block';
                            locationMessage.textContent = 'Failed to fetch location data';
                            locationList.style.display = 'none';
                        });
                } else {
                    clearSuggestions();
                }
            });

            // Keyboard navigation
            locationInput.addEventListener('keydown', function(e) {
                const items = locationList.querySelectorAll('li');
                if (locationList.style.display === 'block' && items.length > 0) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        selectedIndex = (selectedIndex + 1) % items.length;
                        highlightSuggestion(selectedIndex);
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        selectedIndex = (selectedIndex - 1 + items.length) % items.length;
                        highlightSuggestion(selectedIndex);
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (selectedIndex >= 0 && selectedIndex < items.length) {
                            selectSuggestion(selectedIndex);
                        }
                    } else if (e.key === 'Escape') {
                        clearSuggestions();
                    }
                }
            });


            // Hide suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!locationInput.contains(e.target) && !locationList.contains(e.target)) {
                    clearSuggestions();
                }
            });
        }
        </script>