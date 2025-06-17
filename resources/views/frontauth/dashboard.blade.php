@extends('frontauth.layouts.main')
@section('title')
Dashboard
@endsection
@section('content')

<div class="container-fluid mt-4">
    <div class="ms-0 mb-3  d-flex align-items-center justify-content-between flex-wrap">
        <h4 class="h5 font-weight-bolder">Dashboard</h4>
        <div class="d-flex align-items-center gap-3 ">
            <a href="{{route('product')}}" class="btn btn-primary">Submit Ad</a>
            <div class="dropdown">
                <button class="btn btn-secondary d-flex align-items-center gap-2" type="button" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    This Month
                    <i class="fi fi-rr-angle-small-down"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#">January</a></li>
                    <li><a class="dropdown-item" href="#">February</a></li>
                    <li><a class="dropdown-item" href="#">March</a></li>
                    <li><a class="dropdown-item" href="#">April</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row dashboard-box">
        <div class="col-12 col-sm-12 col-md-6 col-xl-3">
            <div class="dashboard-card border-end remove-border-md">
                <div class="card-header p-0 pe-3">
                    <div class="d-flex justify-content-between">
                        <div>

                            @if(Auth::user()->plan_expired_on != '' && Auth::user()->plan_expired_on != null)
                      <h4>{{ \Carbon\Carbon::createFromTimestamp(Auth::user()->plan_expired_on)->format('d M Y h:i A') }}</h4>

                            <p>Subscription Expires</p>

                            @else
                            <h4>Not a valid subscription plan.</h4>

                            @endif
                        </div>
                        <div class="icon">
                            <img src="{{asset('front/auth/assets/img/icons/subscription.svg')}}" width="26" height="26"
                                alt="">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="mb-0 text-sm">Account submission type</p>
                </div>
            </div>
        </div>
        <hr class="horizontal dark mt-0 mt-4 d-lg-none">
        <div class="col-12 col-sm-12 col-md-6 col-xl-3">
            <div class="dashboard-card border-end remove-border-md">
                <div class="card-header p-0 pe-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>0</h4>
                            <p>Submitted ads</p>
                        </div>
                        <div class="icon">
                            <img src="{{asset('front/auth/assets/img/icons/ads.svg')}}" width="26" height="26" alt="">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="mb-0 text-sm">Number of submitted ads</p>
                </div>
            </div>
        </div>
        <hr class="horizontal dark mt-0 mt-4 d-lg-none">
        <div class="col-12 col-sm-12 col-md-6 col-xl-3">
            <div class="dashboard-card border-end remove-border-md">
                <div class="card-header p-0 pe-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>0/5</h4>
                            <p>Your Rating</p>
                        </div>
                        <div class="icon">
                            <img src="{{asset('front/auth/assets/img/icons/rating.svg')}}" width="26" height="26"
                                alt="">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="mb-0 text-sm">Based on all your ads</p>
                </div>
            </div>
        </div>
        <hr class="horizontal dark mt-0 mt-4 d-lg-none">
        <div class="col-12 col-sm-12 col-md-6 col-xl-3">
            <div class="dashboard-card">
                <div class="card-header p-0 ">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{$favorites}}</h4>
                            <p>Favorite Ads</p>
                        </div>
                        <div class="icon">
                            <img src="{{asset('front/auth/assets/img/icons/favorite.svg')}}" width="26" height="26"
                                alt="">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="mb-0 text-sm">Number of ads you like</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9 col-md-8 mt-4 mb-4">
            <div class="card ">
                <div class="card-body">
                    <!-- <div id="chart_div"></div> -->
                    <div class="d-flex align-items-center justify-content-between pb-4">
                        <h6 class="mb-0 ">Visit Chart</h6>
                        <div class="dropdown">
                            <button class="btn btn-secondary small d-flex align-items-center gap-2" type="button"
                                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">Monthly
                                <i class="fi fi-rr-angle-small-down"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">January</a></li>
                                <li><a class="dropdown-item" href="#">February</a></li>
                                <li><a class="dropdown-item" href="#">March</a></li>
                                <li><a class="dropdown-item" href="#">April</a></li>
                            </ul>
                        </div>
                    </div>
                    <img src="{{asset('front/auth/assets/img/visit-chart.svg')}}" width="100%" alt="">
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between pb-4">
                        <h6 class="mb-0 ">Earnings</h6>
                        <img src="{{asset('front/auth/assets/img/icons/more.svg')}}" alt="">
                    </div>
                    <div class="pe-2 text-center">
                        <img src="{{asset('front/auth/assets/img/Circle-Chart.svg')}}" width="253" alt="">
                    </div>
                    <ul class=" mt-3 mb-0 list-unstyled d-flex align-items-center justify-content-center gap-2">
                        <li>
                            <img src="{{asset('front/auth/assets/img/icons/green.svg')}}" alt="">
                            <small>Horses</small>
                        </li>
                        <li>
                            <img src="{{asset('front/auth/assets/img/icons/orange.svg')}}" alt="">
                            <small>Equipment & Apparel</small>
                        </li>
                        <li>
                            <img src="{{asset('front/auth/assets/img/icons/blue.svg')}}" alt="">
                            <small>Services & Jobs</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--  -->
    <div class="row mb-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card border-0">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6>Your Recent Ads</h6>
                            <a href="{{route('productList')}}" class="btn btn-samll">View All</a>
                        </div>
                        {{-- <div class="col-lg-6 col-5 my-auto text-end">
                            <div class="dropdown float-lg-end pe-4">
                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-secondary"></i>
                                </a>
                                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a>
                                    </li>
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else
                                            here</a></li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Title</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Price</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Category</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    {{-- <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Age</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Height</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Sex</th> --}}
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key=>$value)                               
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>                                                    
                                                    <img src="{{(@$value->image->first())?asset('storage/'.@$value->image->first()->image):asset('front/home/assets/images/logo/logo.svg')}}" width="80" class="avatar avatar-sm me-3" alt="image-1">                                                                    
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{@$value->title}}</h6>
                                                </div>
                                            </div>
                                            
                                        </td>
                                        <td><span class="text-xs font-weight-bold">$ {{number_format(@$value->price,2)}} ({{@$value->currency}})</span></td>
                                        <td class="align-middle text-sm">
                                            {{-- <span class="text-xs font-weight-bold" style="color:#A19061;">
                                                {{ @$value->disciplines->map(function($disciplines) {
                                                    return optional($disciplines->commonMaster)->name;
                                                })->filter()->implode(' ,') }}
                                            </span> --}}
                                             <span class="text-xs font-weight-bold" style="color:#A19061;">
                                                {{@$value->category->name}}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if(@$value->product_status=='live')
                                                <span class="badge" style="background-color:#00A591;">{{(@$value->product_status)?@$value->product_status:'N/A'}}</span>
                                            @elseif(@$value->product_status=='expire')
                                                <span class="badge" style="background-color:red;">{{@$value->product_status}}</span>
                                            @elseif(@$value->product_status=='sold')
                                                <span class="badge" style="background-color:green;">{{@$value->product_status}}</span>
                                            @else
                                                <span class="badge" style="background-color:gray;">N/A</span>
                                            @endif
                                        </td>
                                        {{-- <td class="align-middle text-center">
                                            <span class="text-xs font-weight-bold">{{ (@$value->productDetail->age)?\Carbon\Carbon::parse("01-01-".@$value->productDetail->age)->age:0}} Years</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-xs font-weight-bold">{{@$value->height->commonMaster->name}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-xs font-weight-bold">{{@$value->sex->commonMaster->name}}</span>
                                        </td> --}}
                                        <td class="align-middle text-center">
                                            <a href="{{ route('editProduct',@$value->id)}}" class="text-dark me-2"><i class="fi fi-rr-pencil"></i></a>
                                            <span class="text-dark confirm-button" data-href="{{route('product/delete',$value->id)}}">
                                                <i class="fi fi-rr-trash"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
<script>
var ctx = document.getElementById("chart-bars").getContext("2d");

new Chart(ctx, {
    type: "bar",
    data: {
        labels: ["M", "T", "W", "T", "F", "S", "S"],
        datasets: [{
            label: "Views",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "#43A047",
            data: [50, 45, 22, 28, 50, 60, 76],
            barThickness: 'flex'
        }, ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
        scales: {
            y: {
                grid: {
                    drawBorder: false,
                    display: true,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [5, 5],
                    color: '#e5e5e5'
                },
                ticks: {
                    suggestedMin: 0,
                    suggestedMax: 500,
                    beginAtZero: true,
                    padding: 10,
                    font: {
                        size: 14,
                        lineHeight: 2
                    },
                    color: "#737373"
                },
            },
            x: {
                grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false,
                    borderDash: [5, 5]
                },
                ticks: {
                    display: true,
                    color: '#737373',
                    padding: 10,
                    font: {
                        size: 14,
                        lineHeight: 2
                    },
                }
            },
        },
    },
});

var ctx2 = document.getElementById("chart-line").getContext("2d");

new Chart(ctx2, {
    type: "line",
    data: {
        labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
        datasets: [{
            label: "Sales",
            tension: 0,
            borderWidth: 2,
            pointRadius: 3,
            pointBackgroundColor: "#43A047",
            pointBorderColor: "transparent",
            borderColor: "#43A047",
            backgroundColor: "transparent",
            fill: true,
            data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
            maxBarThickness: 6

        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                callbacks: {
                    title: function(context) {
                        const fullMonths = ["January", "February", "March", "April", "May", "June",
                            "July", "August", "September", "October", "November", "December"
                        ];
                        return fullMonths[context[0].dataIndex];
                    }
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
        scales: {
            y: {
                grid: {
                    drawBorder: false,
                    display: true,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [4, 4],
                    color: '#e5e5e5'
                },
                ticks: {
                    display: true,
                    color: '#737373',
                    padding: 10,
                    font: {
                        size: 12,
                        lineHeight: 2
                    },
                }
            },
            x: {
                grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false,
                    borderDash: [5, 5]
                },
                ticks: {
                    display: true,
                    color: '#737373',
                    padding: 10,
                    font: {
                        size: 12,
                        lineHeight: 2
                    },
                }
            },
        },
    },
});

var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

new Chart(ctx3, {
    type: "line",
    data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Tasks",
            tension: 0,
            borderWidth: 2,
            pointRadius: 3,
            pointBackgroundColor: "#43A047",
            pointBorderColor: "transparent",
            borderColor: "#43A047",
            backgroundColor: "transparent",
            fill: true,
            data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
            maxBarThickness: 6

        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
        scales: {
            y: {
                grid: {
                    drawBorder: false,
                    display: true,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [4, 4],
                    color: '#e5e5e5'
                },
                ticks: {
                    display: true,
                    padding: 10,
                    color: '#737373',
                    font: {
                        size: 14,
                        lineHeight: 2
                    },
                }
            },
            x: {
                grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false,
                    borderDash: [4, 4]
                },
                ticks: {
                    display: true,
                    color: '#737373',
                    padding: 10,
                    font: {
                        size: 14,
                        lineHeight: 2
                    },
                }
            },
        },
    },
});
</script>
@endsection