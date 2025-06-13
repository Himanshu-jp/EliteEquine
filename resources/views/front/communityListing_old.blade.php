@extends('front.layouts.main')
@section('title')
Community & Events
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
                        <h4>Filter</h4>
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
                        <h4>Price Range</h4>
                        <div class="price-range-min-max">
                            <div>
                                <label for="keyword">Min</label>
                                <input type="text" class="input-filter" value="0" />
                            </div>
                            <span><label for="keyword">&nbsp</label>-</span>
                            <div>
                                <label for="keyword">Max</label>
                                <input type="text" class="input-filter" value="30" />
                            </div>
                        </div>
                    </div>

                    <div class="filter-section ">
                        <h4>Type</h4>
                        <div class="filter-ads-checkbx">
                            <input type="checkbox" id="Clinic" />
                            <label for="Clinic">Clinic</label>
                            <input type="checkbox" id="Trunkshow" />
                            <label for="trunkshow">Trunk Show</label>
                            <input type="checkbox" id="Happyhour" />
                            <label for="Happyhour">Happy Hour</label>
                            <input type="checkbox" id="Openhouse" />
                            <label for="Openhouse">Open House</label>
                            <input type="checkbox" id="Meetgreet" />
                            <label for="Meetgreet">Meet & Greet</label>
                            <input type="checkbox" id="Sale" />
                            <label for="Sale">Sale</label>
                        </div>
                    </div>
                    <div class="filter-section ">
                        <h4>includements</h4>
                        <div class="filter-ads-checkbx">
                            <input type="checkbox" id="Thepublic" />
                            <label for="Thepublic">Open to the public</label>
                            <input type="checkbox" id="Registration" />
                            <label for="Registration">Registration included</label>
                            <input type="checkbox" id="Private" />
                            <label for="Private">Private</label>
                        </div>
                    </div>
                    <div class="filter-section">
                        <h4>Price Options</h4>
                        <div class="filter-ads-checkbx">
                            <input type="checkbox" id="Priceoptions" />
                            <label for="Priceoptions">Price Options</label>
                            <input type="checkbox" id="Fixedprice" />
                            <label for="Fixedprice">Fixed Price option</label>
                            <input type="checkbox" id="Callprice" />
                            <label for="Callprice">Call for Price</label>
                        </div>
                    </div>
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
                                <a href="gridmap-view.php" class="view-btn">
                                    <img src="{{asset('front/home/assets/images/gridicon.svg')}}">
                                </a>
                                <a href="listing-map-view.php" class="view-btn active">
                                    <img src="{{asset('front/home/assets/images/mapicon.svg')}}">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="map-locations">
                    <div class="top-form">
                        <div class="search-box">
                            <input type="text" placeholder="Search for" class="form-control" />
                            <img class="icon-input" src="{{asset('front/home/assets/images/search-icon.svg')}}">
                        </div>
                        <div class="located-box">
                            <input type="text" placeholder="Located in" class="form-control" />

                        </div>
                        <div class="date-box">
                            <input type="text" id="dateInput" class="form-control" placeholder="Date" readonly />
                            <div id="calendar" class="calendar hidden"></div>
                            <img class="icon-input date" src="{{asset('front/home/assets/images/date-icon.svg')}}">
                        </div>
                        <button class="search-btn">Search</button>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="feat_card_bx grid-view">
                                <div class="image">
                                    <img src="{{asset('front/home/assets/images/featured_hource6.jpg')}}"
                                        alt="hource-image" />
                                    <span class="tag-img">First Year Green</span>
                                </div>
                                <div class="content">
                                    <a href="##">
                                        <h3>Hauling near WEC to KY | Hauling Slots Available: 1</h3>
                                    </a>
                                    <span class="sp1">Call for Price</span>
                                    <div class="location">
                                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}"
                                            alt="location-icon" />
                                        <span>Ocala, FL | Dates: (1/22/25 - 3/15/25)<br />
                                            World Equestrian Center, Ocala to Lexington, KY Date(s): (3/20/25 or
                                            3/20/25-3/22/25)</span>
                                    </div>
                                    <div class="foot">
                                        <div class="bx">
                                            <div class="imagee">
                                                <img src="{{asset('front/home/assets/images/profile_feture.svg')}}"
                                                    alt="Featured-profiles" />
                                            </div>
                                            <div class="content">
                                                <h4>Martin Douzant</h4>
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
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feat_card_bx grid-view">
                                <div class="image">
                                    <img src="{{asset('front/home/assets/images/featured_hource7.jpg')}}"
                                        alt="hource-image" />
                                    <span class="tag-img">First Year Green</span>
                                </div>
                                <div class="content">
                                    <h3>
                                        Synergy | 2019 | 16.2h <br />
                                        Westphalian | Gelding
                                    </h3>
                                    <h4>Sale: $100,000 - $150,000</h4>
                                    <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4>
                                    <span class="sp1">Hunter, Jumper, Equitation</span>
                                    <div class="location">
                                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}"
                                            alt="location-icon" />
                                        <span>Ocala, FL <br />
                                            Trial: World Equestrian Center - Ocala (1/22/25
                                            - 3/15/25)</span>
                                    </div>
                                    <div class="foot">
                                        <div class="bx">
                                            <div class="imagee">
                                                <img src="{{asset('front/home/assets/images/profile_feture.svg')}}"
                                                    alt="Featured-profiles" />
                                            </div>
                                            <div class="content">
                                                <h4>Martin Douzant</h4>
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
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feat_card_bx grid-view">
                                <div class="image">
                                    <img src="{{asset('front/home/assets/images/featured_hource3.png')}}"
                                        alt="hource-image" />
                                    <span class="tag-img">First Year Green</span>
                                </div>
                                <div class="content">
                                    <h3>
                                        Synergy | 2019 | 16.2h <br />
                                        Westphalian | Gelding
                                    </h3>
                                    <h4>Sale: $100,000 - $150,000</h4>
                                    <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4>
                                    <span class="sp1">Hunter, Jumper, Equitation</span>
                                    <div class="location">
                                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}"
                                            alt="location-icon" />
                                        <span>Ocala, FL <br />
                                            Trial: World Equestrian Center - Ocala (1/22/25
                                            - 3/15/25)</span>
                                    </div>
                                    <div class="foot">
                                        <div class="bx">
                                            <div class="imagee">
                                                <img src="{{asset('front/home/assets/images/profile_feture.svg')}}"
                                                    alt="Featured-profiles" />
                                            </div>
                                            <div class="content">
                                                <h4>Martin Douzant</h4>
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
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feat_card_bx grid-view">
                                <div class="image">
                                    <img src="{{asset('front/home/assets/images/featured_hource5.jpg')}}"
                                        alt="hource-image" />
                                    <span class="tag-img">First Year Green</span>
                                </div>
                                <div class="content">
                                    <h3>
                                        Synergy | 2019 | 16.2h <br />
                                        Westphalian | Gelding
                                    </h3>
                                    <h4>Sale: $100,000 - $150,000</h4>
                                    <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4>
                                    <span class="sp1">Hunter, Jumper, Equitation</span>
                                    <div class="location">
                                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}"
                                            alt="location-icon" />
                                        <span>Ocala, FL <br />
                                            Trial: World Equestrian Center - Ocala (1/22/25
                                            - 3/15/25)</span>
                                    </div>
                                    <div class="foot">
                                        <div class="bx">
                                            <div class="imagee">
                                                <img src="{{asset('front/home/assets/images/profile_feture.svg')}}"
                                                    alt="Featured-profiles" />
                                            </div>
                                            <div class="content">
                                                <h4>Martin Douzant</h4>
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
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feat_card_bx grid-view">
                                <div class="image">
                                    <img src="{{asset('front/home/assets/images/featured_hource6.jpg')}}"
                                        alt="hource-image" />
                                    <span class="tag-img">First Year Green</span>
                                </div>
                                <div class="content">
                                    <h3>
                                        Synergy | 2019 | 16.2h <br />
                                        Westphalian | Gelding
                                    </h3>
                                    <h4>Sale: $100,000 - $150,000</h4>
                                    <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4>
                                    <span class="sp1">Hunter, Jumper, Equitation</span>
                                    <div class="location">
                                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}"
                                            alt="location-icon" />
                                        <span>Ocala, FL <br />
                                            Trial: World Equestrian Center - Ocala (1/22/25
                                            - 3/15/25)</span>
                                    </div>
                                    <div class="foot">
                                        <div class="bx">
                                            <div class="imagee">
                                                <img src="{{asset('front/home/assets/images/profile_feture.svg')}}"
                                                    alt="Featured-profiles" />
                                            </div>
                                            <div class="content">
                                                <h4>Martin Douzant</h4>
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
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feat_card_bx grid-view">
                                <div class="image">
                                    <img src="{{asset('front/home/assets/images/featured_hource3.png')}}"
                                        alt="hource-image" />
                                    <span class="tag-img">First Year Green</span>
                                </div>
                                <div class="content">
                                    <h3>
                                        Synergy | 2019 | 16.2h <br />
                                        Westphalian | Gelding
                                    </h3>
                                    <h4>Sale: $100,000 - $150,000</h4>
                                    <h4 class="mb-1">Lease: $40,000 - $60,000 / yr</h4>
                                    <span class="sp1">Hunter, Jumper, Equitation</span>
                                    <div class="location">
                                        <img src="{{asset('front/home/assets/images/icons/loction_icn.svg')}}"
                                            alt="location-icon" />
                                        <span>Ocala, FL <br />
                                            Trial: World Equestrian Center - Ocala (1/22/25
                                            - 3/15/25)</span>
                                    </div>
                                    <div class="foot">
                                        <div class="bx">
                                            <div class="imagee">
                                                <img src="{{asset('front/home/assets/images/profile_feture.svg')}}"
                                                    alt="Featured-profiles" />
                                            </div>
                                            <div class="content">
                                                <h4>Martin Douzant</h4>
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
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/re_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                            <button>
                                                <img src="{{asset('front/home/assets/images/icons/like_icn.svg')}}"
                                                    alt="" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mx-auto mt-4">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination d-flex justify-content-center align-items-center">
                                    <li class="page-item"><a class="page-link" href="#"><img
                                                src="{{asset('front/home/assets/images/icons/arrow_left.png')}}"
                                                width="24" alt=""></a></li>
                                    <li class="page-item"><a class="page-link active" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#"><img
                                                src="{{asset('front/home/assets/images/icons/arrow_right.png')}}"
                                                width="24" alt=""></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection