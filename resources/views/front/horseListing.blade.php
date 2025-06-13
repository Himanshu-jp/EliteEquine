@extends('front.layouts.main')
@section('title')
Horse Listing
@endsection
@section('content')

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <!-- Mobile Filter Toggle Button -->
                <button class="filter-toggle" onclick="toggleFilter()">Filter</button>
                <!-- Filter Sidebar -->
                <div class="filter-sidebar" id="filterSidebar">
                    <div class="filter-section">
                        <h4>Price Range</h4>
                        <div class="price-range-min-max">
                            <div>
                                <label for="keyword">Min</label>
                                <input type="text" class="input-filter numbervalid" id="minPrice" name="minPrice" />
                            </div>
                            <span>
                                <label for="keyword">&nbsp</label>
                                -
                            </span>
                            <div>
                                <label for="keyword">Max</label>
                                <input type="text" class="input-filter numbervalid" id="maxPrice" name="maxPrice"/>
                            </div>
                        </div>
                    </div>

                    <div class="filter-section">
                        <h4>Sale Price Range</h4>
                        <div class="price-range-min-max">
                            <div>
                                <label for="keyword">Min</label>
                                <input type="text" class="input-filter numbervalid" id="minSaleprice" name="minSaleprice" />
                            </div>
                            <span>
                                <label for="keyword">&nbsp</label>
                                -
                            </span>
                            <div>
                                <label for="keyword">Max</label>
                                <input type="text" class="input-filter numbervalid" id="maxSalePrice" name="maxSalePrice"/>
                            </div>
                        </div>
                    </div>

                    <div class="filter-section">
                        <h4>Lease Price Range</h4>
                        <div class="price-range-min-max">
                            <div>
                                <label for="keyword">Min</label>
                                <input type="text" class="input-filter numbervalid" id="minLeasePrice" name="minLeasePrice" />
                            </div>
                            <span>
                                <label for="keyword">&nbsp</label>
                                -
                            </span>
                            <div>
                                <label for="keyword">Max</label>
                                <input type="text" class="input-filter numbervalid" id="maxLeasePrice" name="maxLeasePrice" />
                            </div>
                        </div>

                    </div>


                  <div class="filter-section">
                        <label for="currency">Currency</label>
                        <select id="currency" class="form-select form-control" name="currency">    
                            <option value="">Select currency</option>
                            <option value="USD">USD</option>
                            <option value="AUD">AUD</option>
                        </select>
                    </div>

                    <div class="filter-section ">
                        <h4>Sub Category</h4>
                        <div class="filter-ads-checkbx">
                            @foreach(__subCategoryHorseData() as $key=>$val)
                                <input 
                                    type="checkbox" 
                                    id="subCategory_{{$key}}" 
                                    value="{{$key}}" 
                                    name="subCategory[]"
                                    {{ in_array($key, $selectedSubCategories ?? []) ? 'checked' : '' }}
                                />
                                <label for="subCategory_{{$key}}">{{$val}}</label>
                            @endforeach
                        </div>
                    </div>


                    <div class="filter-section ">
                        <h4>Disciplines</h4>
                        <div class="filter-ads-checkbx">
                            @foreach(__disciplinesData() as $key=>$val)
                                <input 
                                    type="checkbox" 
                                    id="discipline_{{$key}}" 
                                    value="{{$key}}" 
                                    name="discipline[]"
                                    {{ in_array($key, $selectedDiscipline ?? []) ? 'checked' : '' }}
                                />
                                <label for="discipline_{{$key}}">{{$val}}</label>
                            @endforeach
                        </div>
                    </div>

                    {{-- <div class="filter-section">
                        <h4>Year of Born</h4>
                        <div class="range-slider">
                            <div class="slider-track" id="sliderTrack" style="left:20%; width: 60%;"></div>
                            <input type="range" id="minRange" min="0" max="100" value="20" step="1"
                                oninput="updateRange()" />
                            <input type="range" id="maxRange" min="0" max="100" value="80" step="1"
                                oninput="updateRange()" />
                        </div>
                        <div class="born-values">
                            <span id="minPrice">2000</span> <span id="maxPrice">2028</span>
                        </div>
                    </div> --}}

                    <div class="filter-section">
                         <h4>Year of Born</h4>
                        <div class="price-range-min-max">
                            <div>
                                <label for="keyword">Min</label>
                                <input type="text" class="input-filter numbervalid" id="minAge" name="minAge" />
                            </div>
                            <span>
                                <label for="keyword">&nbsp</label>
                                -
                            </span>
                            <div>
                                <label for="keyword">Max</label>
                                <input type="text" class="input-filter numbervalid" id="maxAge" name="maxAge" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="filter-section">
                        <label for="heights">Height in hands</label>
                         <select id="heights" class="form-select form-control select2" name="heights[]" multiple>
                            @foreach(__heightsData() as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>
                    
                    <div class="filter-section">
                        <label for="sexes">SEX</label>
                         <select id="sexes" class="form-select form-control select2" name="sexes[]" multiple>
                            @foreach(__sexesData() as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>

                    <div class="filter-section">
                        <label for="breeds">Breed</label>
                         <select id="breeds" class="form-select form-control select2" name="breed[]" multiple>
                            @foreach(__breedsData() as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>
                   
                    <div class="filter-section">
                        <label for="colors">Colors</label>
                         <select id="colors" class="form-select form-control select2" name="colors[]" multiple>
                            @foreach(__colorsData() as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>
                    
                    <div class="filter-section">
                         <label for="trainingShowExperiences">Training & Show Experience</label>
                         <select id="trainingShowExperiences" class="form-select form-control select2" name="trainingShowExperiences[]" multiple>
                            @foreach(__trainingShowExperiencesData() as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>
                    
                    <div class="filter-section">
                         <label for="greenEligibilities">Green Eligibility</label>
                         <select id="greenEligibilities" class="form-select form-control select2" name="greenEligibilities">
                            <option value="">Select an option</option>
                            @foreach(__greenEligibilitiesData() as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>


                    <div class="filter-section">
                         <label for="qualifies">Qualified For</label>
                         <select id="qualifies" class="form-select form-control select2" name="qualifies[]" multiple>
                            @foreach(__qualifiesData() as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>
                    
                    <div class="filter-section">
                         <label for="currentFenceHeight">Current Fence Hegiht</label>
                         <select id="currentFenceHeight" class="form-select form-control select2" name="currentFenceHeight[]" multiple>
                            @foreach(__currentFenceHeightData() as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>
                  
                    <div class="filter-section">
                        <label for="potentialFenceHeight">Potential Fence Height</label>
                         <select id="potentialFenceHeight" class="form-select form-control select2" name="potentialFenceHeight[]" multiple>
                            @foreach(__potentialFenceHeightData() as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>
                    
                    <div class="filter-section">
                        <label for="triedUpcomingShows">Can Be Tried at Upcoming Show</label>
                         <select id="triedUpcomingShows" class="form-select form-control select2" name="triedUpcomingShows[]" multiple>
                            @foreach(__triedUpcomingShowsData() as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>



                    <div class="filter-section">
                         <h4>Trial Dates Available From</h4>
                        <div class="price-range-min-max">
                            <div>
                                <label for="trial_from">From</label>
                                <input type="text" class="form-control datepicker" id="ftrial_from" name="trial_from" />
                            </div>
                            <span>
                                <label for="keyword">&nbsp</label>
                                -
                            </span>
                            <div>
                                <label for="trial_to">To</label>
                                <input type="text" class="form-control datepicker" id="ftrial_to" name="ftrial_to"/>
                            </div>
                        </div>
                    </div>
                  
                    <div class="filter-section">
                         <h4>To Trial Dates</h4>
                        <div class="price-range-min-max">
                            <div>
                                <label for="trial_from">From</label>
                                <input type="text" class="form-control datepicker" id="ttrial_from" name="trial_from" />
                            </div>
                            <span>
                                <label for="keyword">&nbsp</label>
                                -
                            </span>
                            <div>
                                <label for="trial_to">To</label>
                                <input type="text" class="form-control datepicker" id="ttrial_to" name="trial_to" />
                            </div>
                        </div>
                    </div>



                    <div class="filter-section">
                        <label for="trainer">Trainer</label>
                         <select id="trainer" class="form-select form-control select2" name="trainer[]" multiple>
                            @foreach(__trainerData() as $val)
                                <option value="{{$val}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>
                   
                    <div class="filter-section">
                        <label for="facility">Facility</label>
                         <select id="facility" class="form-select form-control select2" name="facility[]" multiple>
                            @foreach(__facilityData() as $key=>$val)
                                <option value="{{$val}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>
                    
                    <div class="filter-section">
                        <label for="sirebloodline">Sire Bloodlines</label>
                         <select id="sirebloodline" class="form-select form-control select2" name="sirebloodline[]" multiple>
                            @foreach(__sireBloodData() as $key=>$val)
                                <option value="{{$val}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>
                    
                    <div class="filter-section">
                        <label for="dambloodline">Dam Bloodlines</label>
                         <select id="dambloodline" class="form-select form-control select2" name="dambloodline[]" multiple>
                            @foreach(__damBloodData() as $key=>$val)
                                <option value="{{$val}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>
                    
                    <div class="filter-section">
                        <label for="usef">USEF #</label>
                         <select id="usef" class="form-select form-control select2" name="usef[]" multiple>
                            @foreach(__usefData() as $key=>$val)
                                <option value="{{$val}}">{{$val}}</option>
                            @endforeach          
                        </select>
                    </div>


                    <button type="button" class="apply-flitter w-100" onclick="loadHorsesAndScroll()">Apply Filters</button>

                </div>
            </div>
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="search-head-top">
                    <div class="results-bar">
                        <div class="results-left">
                            Showing all <span id="total">0</span> results
                        </div>
                        <div class="results-right">
                            <span class="sort-label">Sort:</span>
                            <select class="sort-select" id="sort" onchange="loadHorses();">
                                <option value="">Sort By Latest</option>
                                <option value="ASC">Price Low to High</option>
                                <option value="DESC">Price High to Low</option>
                            </select>

                            <span class="divider">|</span>

                            <span class="show-label">Show:</span>
                            <select class="show-select" id="limit" onchange="loadHorses();">
                                <option value="20">20 Items</option>
                                <option value="40">40 Items</option>
                                <option value="60">60 Items</option>
                            </select>

                            <div class="view-toggle">
                                <input 
                                    type="radio" 
                                    id="view_grid" 
                                    name="view_mode" 
                                    value="grid" 
                                    hidden
                                    checked
                                >
                                <label 
                                    for="view_grid" 
                                    class="view-btn active"
                                >
                                    <img src="{{ asset('front/home/assets/images/gridicon.svg') }}" alt="Grid View">
                                </label>

                                <input 
                                    type="radio" 
                                    id="view_map" 
                                    name="view_mode" 
                                    value="map" 
                                    hidden
                                >
                                <label 
                                    for="view_map" 
                                    class="view-btn"
                                >
                                    <img src="{{ asset('front/home/assets/images/mapicon.svg') }}" alt="Map View">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="map-locations">

                    <!---serch filters----->
                    <div class="top-form">
                        <div class="search-box">
                            <input type="text" placeholder="Search for" id="search" value="{{@$filter['search']}}" class="form-control" autocomplete="off"/>
                            <img class="icon-input" src="{{asset('front/home/assets/images/search-icon.svg')}}">
                        </div>
                        
                        <div class="search-box">
                            <input type="text" placeholder="Located in" class="form-control" value="{{@$filter['location']}}" id="location" autocomplete="off" />
                            <img class="icon-input" src="{{asset('front/home/assets/images/search-icon.svg')}}">
                        </div>

                        <div class="date-box">
                             <input type="text" class="inner-form form-control mb-0 datepicker" autocomplete="off" name="date" id="date" placeholder="Date">
                            <img class="icon-input date" src="{{asset('front/home/assets/images/date-icon.svg')}}">
                        </div>

                        {{-- <div class="date-box">
                            <select name="category" id="category" class="form-control">
                                <option value="">Select Category</option>
                                @foreach(__categoryData() as $key=>$val)
                                    <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <button class="search-btn" onclick="loadHorses();">Search</button>
                        <button class="search-btn btn btn-warning" onclick="window.location.href='{{route('horse-listing')}}'">Reset</button>
                    </div>

                    <div id="horse-list" class="row">
                        {{-- Horse cards will be injected here --}}
                        
                    </div>
                    <div class="row">                        
                        <!-- <div class="col-lg-12 mx-auto mt-4" id="noDataFound" style="display:none;">
                            <nav aria-label="Page navigation example">
                                <div class="Page navigation example">
                                    <ul class="pagination d-flex justify-content-start align-items-center">
                                        <h3>Nothing here yet. Stay tuned — more content coming shortly...</h3>
                                    </ul>
                                </div>
                            </nav>
                        </div> -->
                        
                        @if(!auth()->check())
                            <div class="col-md-8 mx-auto noDataFound" style="display:none;">
                                <div class="notification-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="70" viewBox="0 0 71 70" fill="none">
                                        <path d="M33.0086 70C29.5703 70 26.7726 67.0894 26.7726 63.512V60.9094C26.7726 57.3318 29.5699 54.4214 33.0083 54.4214C36.4467 54.4214 39.2443 57.332 39.2443 60.9094V63.512C39.2445 67.0894 36.447 70 33.0086 70ZM33.0086 56.6967C30.8248 56.6967 29.0481 58.5865 29.0481 60.9092V63.5118C29.0481 65.8345 30.8248 67.7243 33.0085 67.7243C35.1923 67.7243 36.969 65.8345 36.969 63.5118V60.9092C36.9692 58.5865 35.1925 56.6967 33.0086 56.6967ZM35.8587 50.0352C35.8564 50.0352 35.854 50.0352 35.852 50.0352L31.1602 50.007C30.1217 50.1344 29.0691 49.8181 28.2577 49.1315C27.3871 48.3948 26.8756 47.3089 26.8541 46.1517C26.7489 40.4691 28.803 35.8479 32.9598 32.4168C33.475 31.9913 34.0096 31.566 34.5755 31.116C38.6922 27.8412 43.3581 24.1294 42.6379 18.8006C42.3274 16.5034 41.0264 15.0926 39.9895 14.3136C38.3468 13.0793 36.2298 12.5469 34.1829 12.8511C31.2459 13.2885 28.529 15.3928 26.7294 18.6235L26.7121 18.6546C25.5398 20.7566 22.9841 21.5453 20.8935 20.4506L17.6679 18.7614C15.5628 17.6593 14.6783 15.0405 15.6541 12.7997C17.6258 8.2715 21.0154 4.68871 25.4559 2.43888C29.5363 0.371404 34.2845 -0.419329 38.8245 0.21163C47.9089 1.47481 54.3212 7.94708 55.5589 17.1024C56.4895 23.9862 53.88 30.1977 47.8036 35.5638C47.0886 36.1953 46.3472 36.797 45.6305 37.3786C42.4627 39.9498 39.7269 42.1702 39.3168 46.4099C39.1361 48.2757 37.7832 49.7612 36.0264 50.0227C35.9708 50.031 35.9147 50.0352 35.8587 50.0352ZM35.3163 10.4922C37.4819 10.4922 39.6219 11.1917 41.3561 12.4945C43.3124 13.9642 44.5683 16.0955 44.8924 18.4957C45.7854 25.105 40.355 29.425 35.9917 32.8963C35.4342 33.3398 34.9073 33.7588 34.4079 34.1712C30.7624 37.1805 29.0358 41.0856 29.1289 46.1094C29.1381 46.6122 29.3565 47.0805 29.727 47.3942C30.0684 47.6831 30.4915 47.8063 30.9198 47.7434C30.9775 47.7346 31.0371 47.7283 31.0941 47.731L35.7649 47.7592C36.4501 47.6198 36.9744 46.986 37.0514 46.1907C37.5533 41.0031 40.9303 38.2624 44.1962 35.6119C44.8949 35.0447 45.6175 34.4586 46.2971 33.8583C51.8458 28.958 54.1377 23.5768 53.304 17.4069C52.1925 9.18423 46.6624 3.5985 38.5111 2.4649C31.3023 1.46307 21.7262 4.55298 17.7398 13.7081C17.2466 14.8408 17.6876 16.2036 18.723 16.7456L21.9489 18.4348C22.9549 18.9613 24.1483 18.5798 24.7248 17.5467L24.7418 17.5161C26.8877 13.6637 30.207 11.1429 33.8478 10.6005C34.3354 10.5278 34.8267 10.4922 35.3163 10.4922Z" fill="#C6B075"/>
                                    </svg>
                                    <h5 class="my-4">No ads found matched your criteria</h5>
                                    <button class="search-btn" onclick="window.location.href='{{route('login')}}'">Login to Get Notified</button>
                                </div>
                            </div>
                        @else
                            <div class="col-md-8 mx-auto noDataFound" style="display:none;">
                                <div class="notification-box">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="70" viewBox="0 0 71 70" fill="none">
                                        <path d="M33.0086 70C29.5703 70 26.7726 67.0894 26.7726 63.512V60.9094C26.7726 57.3318 29.5699 54.4214 33.0083 54.4214C36.4467 54.4214 39.2443 57.332 39.2443 60.9094V63.512C39.2445 67.0894 36.447 70 33.0086 70ZM33.0086 56.6967C30.8248 56.6967 29.0481 58.5865 29.0481 60.9092V63.5118C29.0481 65.8345 30.8248 67.7243 33.0085 67.7243C35.1923 67.7243 36.969 65.8345 36.969 63.5118V60.9092C36.9692 58.5865 35.1925 56.6967 33.0086 56.6967ZM35.8587 50.0352C35.8564 50.0352 35.854 50.0352 35.852 50.0352L31.1602 50.007C30.1217 50.1344 29.0691 49.8181 28.2577 49.1315C27.3871 48.3948 26.8756 47.3089 26.8541 46.1517C26.7489 40.4691 28.803 35.8479 32.9598 32.4168C33.475 31.9913 34.0096 31.566 34.5755 31.116C38.6922 27.8412 43.3581 24.1294 42.6379 18.8006C42.3274 16.5034 41.0264 15.0926 39.9895 14.3136C38.3468 13.0793 36.2298 12.5469 34.1829 12.8511C31.2459 13.2885 28.529 15.3928 26.7294 18.6235L26.7121 18.6546C25.5398 20.7566 22.9841 21.5453 20.8935 20.4506L17.6679 18.7614C15.5628 17.6593 14.6783 15.0405 15.6541 12.7997C17.6258 8.2715 21.0154 4.68871 25.4559 2.43888C29.5363 0.371404 34.2845 -0.419329 38.8245 0.21163C47.9089 1.47481 54.3212 7.94708 55.5589 17.1024C56.4895 23.9862 53.88 30.1977 47.8036 35.5638C47.0886 36.1953 46.3472 36.797 45.6305 37.3786C42.4627 39.9498 39.7269 42.1702 39.3168 46.4099C39.1361 48.2757 37.7832 49.7612 36.0264 50.0227C35.9708 50.031 35.9147 50.0352 35.8587 50.0352ZM35.3163 10.4922C37.4819 10.4922 39.6219 11.1917 41.3561 12.4945C43.3124 13.9642 44.5683 16.0955 44.8924 18.4957C45.7854 25.105 40.355 29.425 35.9917 32.8963C35.4342 33.3398 34.9073 33.7588 34.4079 34.1712C30.7624 37.1805 29.0358 41.0856 29.1289 46.1094C29.1381 46.6122 29.3565 47.0805 29.727 47.3942C30.0684 47.6831 30.4915 47.8063 30.9198 47.7434C30.9775 47.7346 31.0371 47.7283 31.0941 47.731L35.7649 47.7592C36.4501 47.6198 36.9744 46.986 37.0514 46.1907C37.5533 41.0031 40.9303 38.2624 44.1962 35.6119C44.8949 35.0447 45.6175 34.4586 46.2971 33.8583C51.8458 28.958 54.1377 23.5768 53.304 17.4069C52.1925 9.18423 46.6624 3.5985 38.5111 2.4649C31.3023 1.46307 21.7262 4.55298 17.7398 13.7081C17.2466 14.8408 17.6876 16.2036 18.723 16.7456L21.9489 18.4348C22.9549 18.9613 24.1483 18.5798 24.7248 17.5467L24.7418 17.5161C26.8877 13.6637 30.207 11.1429 33.8478 10.6005C34.3354 10.5278 34.8267 10.4922 35.3163 10.4922Z" fill="#C6B075"/>
                                    </svg> 
                                    <h5 class="my-4">No ads found matched your criteria</h5>
                                    <hr>
                                    <a href="{{route('settings')}}" class="text-gold"><u>Select Your Notifications Settings</u></a>
                                </div>
                            </div>
                        @endif

                        <div class="col-lg-12 mx-auto mt-4">
                            <nav aria-label="Page navigation example">
                                    <div class="Page navigation example">
                                    <ul class="pagination d-flex justify-content-center align-items-center">
                                        <div id="pagination-links" class="mt-4 text-center"></div>
                                    </ul>
                                </div>
                            </nav>
                        </div>  
                                              
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>


@endsection

@section('script')


<script>
    const pages = document.querySelectorAll(".page");
    const prev = document.getElementById("prev");
    const next = document.getElementById("next");

    let currentPage = 1;

    function updateUI() {
      pages.forEach((page, index) => {
        page.classList.toggle("active", index + 1 === currentPage);
      });
      prev.classList.toggle("disabled", currentPage === 1);
      next.classList.toggle("disabled", currentPage === pages.length);
    }

    pages.forEach((page, index) => {
      page.addEventListener("click", () => {
        currentPage = index + 1;
        updateUI();
      });
    });

    prev.addEventListener("click", () => {
      if (currentPage > 1) {
        currentPage--;
        updateUI();
      }
    });

    next.addEventListener("click", () => {
      if (currentPage < pages.length) {
        currentPage++;
        updateUI();
      }
    });

    updateUI();
  </script>

<!-- pagination CSS AND JS end -->








<script>
    document.querySelectorAll('input[name="view_mode"]').forEach((radio) => {
        radio.addEventListener('change', function () {
            // Remove 'active' class from all labels
            document.querySelectorAll('.view-btn').forEach(label => {
                label.classList.remove('active');
            });

            // Add 'active' class to the currently selected one
            const selectedLabel = document.querySelector(`label[for="${this.id}"]`);
            if (selectedLabel) {
                selectedLabel.classList.add('active');
            }
            loadHorses();
        });
    });
</script>



<script>

$(function () {
    $('.datepicker').datepicker({
        dateFormat: "dd-mm-yy" // <-- Use this format for Y-m-d
    });
});

function loadHorses(page = 1) {
    

    //------sub category--------//
    let selectedSubCategories = [];
    $('input[name="subCategory[]"]:checked').each(function () {
        selectedSubCategories.push($(this).val());
    });
    
    //------sub category--------//
    let selectedDiscipline = [];
    $('input[name="discipline[]"]:checked').each(function () {
        selectedDiscipline.push($(this).val());
    });

    //--------View mode of listing---------//
    let selectedView = $('input[name="view_mode"]:checked').val();


    $('.preloader').show();
    $.ajax({
        url: '{{ url("horse-listing/dataTable") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            page: page,
            search:$("#search").val(),
            location:$("#location").val(),
            category: $('#category').val(),
            sort: $('#sort').val(),
            limit: $('#limit').val(),
            subCategory: selectedSubCategories,
            minPrice:$("#minPrice").val(),
            maxPrice:$("#maxPrice").val(),
            
            minSaleprice:$("#minSaleprice").val(),
            maxSalePrice:$("#maxSalePrice").val(),
           
            minLeasePrice:$("#minLeasePrice").val(),
            maxLeasePrice:$("#maxLeasePrice").val(),
            
            currency:$("#currency").val(),
            discipline:selectedDiscipline,
            
            minAge:$("#minAge").val(),
            maxAge:$("#maxAge").val(),

            heights:$("#heights").val(),
            sexes:$("#sexes").val(),
            breeds:$("#breeds").val(),
            colors:$("#colors").val(),
            
            trainingShowExperiences:$("#trainingShowExperiences").val(),
            qualifies:$("#qualifies").val(),
            currentFenceHeight:$("#currentFenceHeight").val(),
            potentialFenceHeight:$("#potentialFenceHeight").val(),
            triedUpcomingShows:$("#triedUpcomingShows").val(),
            greenEligibilities:$("#greenEligibilities").val(),


            ftrial_from:$("#ftrial_from").val(),
            ftrial_to:$("#ftrial_to").val(),
            ttrial_from:$("#ttrial_from").val(),
            ttrial_to:$("#ttrial_to").val(),
            
            
            trainer:$("#trainer").val(), 
            facility:$("#facility").val(),
            sirebloodline:$("#sirebloodline").val(),
            dambloodline:$("#dambloodline").val(),
            usef:$("#usef").val(),
            date:$("#date").val(),
            view_mode:selectedView,
        },
        success: function(response) { 
            window.scrollTo({ top: 0, behavior: 'smooth' });    
            $("#total").html(response.total);       
            if(response.total==0){
                $('.noDataFound').show();
            }else{
                $('.noDataFound').hide();
            }
            $('.preloader').hide();
            $('#horse-list').html(response.html); // Inject rendered HTML
            $('#pagination-links').html(response.pagination); // Optional pagination
        }
    });
}
 // Initial load
$(document).ready(function () {
    loadHorses();
    // Optional: click on pagination
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        loadHorses(page);
    });
});


function loadHorsesAndScroll() {
    // Scroll to top smoothly
    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Call your original function
    loadHorses();
}

</script>
@endsection