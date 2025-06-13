@extends('front.layouts.main')
@section('title')
Not found
@endsection
@section('content')



<section class="section">
    <div class="container">
        <div class="row">
            <!-- sitebaar start-->
            <div class="col-lg-3">
                <!-- Mobile Filter Toggle Button -->
                <button class="filter-toggle" onclick="toggleFilter()">Filter</button>

                <!-- Filter Sidebar -->
                <div class="filter-sidebar" id="filterSidebar">
                    <div class="filter-section">
                        <h4>Filter Ads</h4>
                        <label for="keyword">Keyword</label>
                        <input type="text" id="keyword" placeholder="Search.." />
                    </div>

                    <div class="filter-section">
                        <label for="category">Currency</label>
                        <select id="category">
                            <option value="">Select your Currency </option>
                            <option value="USD ($)">USD ($)</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="JPY">JPY</option>
                            <option value="AUD">AUD</option>
                            <option value="CAD">CAD</option>
                        </select>
                    </div>
                    <div class="filter-section">
                        <label for="category">Job Listing Type</label>
                        <select id="category">
                            <option value="Job Listing">Job Listing</option>
                            <option value="Select">Select</option>
                            <option value="Select">Select</option>
                        </select>
                    </div>
                    <div class="filter-section">
                        <label for="category">Service</label>
                        <select id="category">
                            <option value="">Select Service</option>
                            <option value="Service02">Service03</option>
                            <option value="Service04">Service04</option>
                        </select>
                    </div>
                    <div class="filter-section">
                        <label for="category">Contract Type</label>
                        <select id="category">
                            <option value="">Contract Type</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                        </select>
                    </div>
                    <div class="filter-section">
                        <label for="category">Assistance at Upcoming Show</label>
                        <select id="category">
                            <option value="">Select Experience</option>
                        </select>
                    </div>

                    <div class="filter-section">
                        <h4>Date Available From</h4>
                        <div class="price-range-min-max">
                            <div>
                                <label for="keyword">From</label>
                                <input type="text" class="input-filter" value="0" />
                            </div>
                            <span><label for="keyword">&nbsp</label>-</span>
                            <div>
                                <label for="keyword">To</label>
                                <input type="text" class="input-filter" value="30" />
                            </div>
                        </div>
                    </div>
                    <div class="filter-section">
                        <h4>Date Available To</h4>
                        <div class="price-range-min-max">
                            <div>
                                <label for="keyword">From</label>
                                <input type="text" class="input-filter" value="0" />
                            </div>
                            <span><label for="keyword">&nbsp</label>-</span>
                            <div>
                                <label for="keyword">To</label>
                                <input type="text" class="input-filter" value="30" />
                            </div>
                        </div>
                    </div>

                    <div class="filter-section">
                        <label for="category">Hauling: From Location</label>
                        <select id="category">
                            <option value="">Select your Location.</option>
                            <option value="">Location01</option>
                            <option value="">Location02</option>
                        </select>
                    </div>
                    <div class="filter-section">
                        <label for="category">Hauling: To Location</label>
                        <select id="category">
                            <option value="">Select your Location.</option>
                            <option value="">Location01</option>
                            <option value="">Location02</option>
                        </select>
                    </div>

                    <div class="filter-section">
                        <h4>Stalls Available For Hauling or</h4>
                        <div class="price-range-min-max">
                            <div>
                                <label for="keyword">Show</label>
                                <input type="text" class="input-filter" value="Min" />
                            </div>
                            <span><label for="keyword">&nbsp</label>-</span>
                            <div>
                                <label for="keyword">Max price</label>
                                <input type="text" class="input-filter" value="Max" />
                            </div>

                        </div>
                        <div class="price-range-min-max">
                            <div>
                                <label for="keyword">Salary</label>
                                <input type="text" class="input-filter" value="Min" />
                            </div>
                            <span><label for="keyword">&nbsp</label>-</span>
                            <div>
                                <label for="keyword">Max price</label>
                                <input type="text" class="input-filter" value="Max" />
                            </div>
                        </div>
                        <div class="price-range-min-max">
                            <div>
                                <label for="keyword">Hourly Pay</label>
                                <input type="text" class="input-filter" value="Min" />
                            </div>
                            <span>
                                <label for="keyword">&nbsp</label>-</span>
                            <div>
                                <label for="keyword">Max price</label>
                                <input type="text" class="input-filter" value="Max" />
                            </div>
                        </div>
                        <div class="price-range-min-max">
                            <div>
                                <label for="keyword">Fixed Pay</label>
                                <input type="text" class="input-filter" value="Min" />
                            </div>
                            <span><label for="keyword">&nbsp</label>-</span>
                            <div>
                                <label for="keyword">Max price</label>
                                <input type="text" class="input-filter" value="Max" />
                            </div>
                        </div>
                    </div>
                    <button type="button" class="apply-flitter w-100">Apply Filters</button>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="search-head-top">
                    <div class="results-bar">
                        <div class="results-left">Showing all 16 results</div>
                        <div class="results-right">
                            <span class="sort-label">Sort:</span>
                            <select class="sort-select">
                                <option>Sort By Featured</option>
                                <option>Price Low to High</option>
                                <option>Price High to Low</option>
                            </select>

                            <span class="divider">|</span>

                            <span class="show-label">Show:</span>
                            <select class="show-select">
                                <option>40 Items</option>
                                <option>20 Items</option>
                                <option>60 Items</option>
                            </select>

                            <div class="view-toggle">
                                <a href="#" class="view-btn active"><img
                                        src="{{asset('front/home/assets/images/gridicon.svg')}}"></a>
                                <a href="no-add-found02.php" class="view-btn "><img
                                        src="{{asset('front/home/assets/images/mapicon.svg')}}"></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 mx-auto">
                    <div class="notification-box">
                        <img src="{{asset('front/home/assets/images/icons/question.svg')}}" alt="question">
                        <h5>No ads found matched your criteria</h5>
                        <button class="search-btn">Login to Get Notified</button>
                    </div>
                </div>


                <div class="col-md-8 mx-auto">
                    <div class="notification-box">
                        <img src="{{asset('front/home/assets/images/icons/question.svg')}}" alt="question">
                        <h5>No ads found matched your criteria</h5>
                        <hr>
                        <p>Thank you for subscribing! We are excited to inform you that we will send you an email and
                            text as soon as a matching listing becomes available for your search.</p>
                    </div>
                </div>

            </div>
        </div>
</section>



@endsection