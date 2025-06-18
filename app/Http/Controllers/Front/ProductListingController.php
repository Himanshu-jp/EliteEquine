<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use App\Models\Schedule;

class ProductListingController extends Controller
{

    //------------------------horse listing & detais routes---------------//
    public function horseListing(Request $request)
    {
        $filter = $request->query();
        return view('front/horseListing',compact('filter'));
    }

    public function getHorseDataTable(Request $request)
    {
        // -----login user-------//
        $data = Product::with([
            'user',
            'productDetail',
            'image',
            'video',
            'document',
            'category',
            'subcategory',
            'disciplines',
            'breeds',
            'colors',
            'trainingShowExperiences',
            'qualifies',
            'currentFenceHeight',
            'potentialFenceHeight',
            'triedUpcomingShows',
            'height',
            'sex',
            'greenEligibilities'
        ])->where(['product_status' => 'live', 'deleted_at' => null]);

        //-----add horse category condition------//
        $data = $data->where('category_id', 1);

        $searchString = $request->search;
        if (!empty($searchString)) {
            $data = $data->where(function ($query) use ($searchString) {
                $query->where('title', 'like', "%$searchString%");
                // $query->orWhereHas('productDetail', function ($q) use ($searchString) {
                //     $q->where('city', 'like', "%$searchString%")
                //     ->orWhere('state', 'like', "%$searchString%")
                //     ->orWhere('country', 'like', "%$searchString%")
                //     ->orWhere('street', 'like', "%$searchString%");
                // });
            });
        }

        if (!empty($request->location)) {
            $location = $request->location;
            $data = $data->where(function ($query) use ($location) {
                $query->orWhereHas('productDetail', function ($q) use ($location) {
                    $q->where('precise_location', 'like', "%$location%")
                        ->orWhere('city', 'like', "%$location%")
                        ->orWhere('state', 'like', "%$location%")
                        ->orWhere('country', 'like', "%$location%")
                        ->orWhere('street', 'like', "%$location%");
                });
            });
        }

        if (!empty($request->category)) {
            $data->where('category_id', $request->category);
        }

        if (!empty($request->subCategory)) {
            $data->whereIn('sub_category', $request->subCategory);
        }

        if (!empty($request->minPrice) && !empty($request->maxPrice)) {
            $data->whereBetween('price', [$request->minPrice, $request->maxPrice]);
        }

        if (!empty($request->minSalePrice) && !empty($request->maxSalePrice)) {
            $minSalePrice = $request->minSalePrice;
            $maxSalePrice = $request->maxSalePrice;
            $data = $data->where(function ($query) use ($minSalePrice, $maxSalePrice) {
                $query->orWhereHas('productDetail', function ($q) use ($minSalePrice, $maxSalePrice) {
                    $q->whereBetween('sale_price', [$minSalePrice, $maxSalePrice]);
                });
            });
        }

        if (!empty($request->minLeasePrice) && !empty($request->maxLeasePrice)) {
            $minLeasePrice = $request->minLeasePrice;
            $maxLeasePrice = $request->maxLeasePrice;
            $data = $data->where(function ($query) use ($minLeasePrice, $maxLeasePrice) {
                $query->orWhereHas('productDetail', function ($q) use ($minLeasePrice, $maxLeasePrice) {
                    $q->whereBetween('lease_price', [$minLeasePrice, $maxLeasePrice]);
                });
            });
        }

        if (!empty($request->currency)) {
            $data->where('currency', $request->currency);
        }


        if (!empty($request->discipline)) {
            $discipline = $request->discipline; // should be an array of discipline IDs
            $data->whereHas('disciplines', function ($q) use ($discipline) {
                $q->whereIn('common_master_id', $discipline);
            });
        }

        if (!empty($request->minAge) && !empty($request->maxAge)) {
            $minAge = $request->minAge;
            $maxAge = $request->maxAge;
            $data = $data->where(function ($query) use ($minAge, $maxAge) {
                $query->orWhereHas('productDetail', function ($q) use ($minAge, $maxAge) {
                    $q->whereBetween('age', [$minAge, $maxAge]);
                });
            });
        }

        if (!empty($request->heights)) {
            $heights = $request->heights;
            $data = $data->where(function ($query) use ($heights) {
                $query->orWhereHas('productDetail', function ($q) use ($heights) {
                    $q->whereIn('height_id', $heights);
                });
            });
        }

        if (!empty($request->sexes)) {
            $sexes = $request->sexes;
            $data = $data->where(function ($query) use ($sexes) {
                $query->orWhereHas('productDetail', function ($q) use ($sexes) {
                    $q->whereIn('sex_id', $sexes);
                });
            });
        }

        if (!empty($request->breed)) {
            $breed = $request->breed; // should be an array of discipline IDs
            $data->whereHas('breeds', function ($q) use ($breed) {
                $q->whereIn('common_master_id', $breed);
            });
        }

        if (!empty($request->colors)) {
            $colors = $request->colors; // should be an array of discipline IDs
            $data->whereHas('colors', function ($q) use ($colors) {
                $q->whereIn('common_master_id', $colors);
            });
        }

        if (!empty($request->trainingShowExperiences)) {
            $trainingShowExperiences = $request->trainingShowExperiences; // should be an array of discipline IDs
            $data->whereHas('trainingShowExperiences', function ($q) use ($trainingShowExperiences) {
                $q->whereIn('common_master_id', $trainingShowExperiences);
            });
        }

        if (!empty($request->greenEligibilities)) {
            $greenEligibilities = $request->greenEligibilities;
            $data = $data->where(function ($query) use ($greenEligibilities) {
                $query->orWhereHas('productDetail', function ($q) use ($greenEligibilities) {
                    $q->where('green_eligibilitie_id', $greenEligibilities);
                });
            });
        }

        if (!empty($request->qualifies)) {
            $qualifies = $request->qualifies; // should be an array of discipline IDs
            $data->whereHas('qualifies', function ($q) use ($qualifies) {
                $q->whereIn('common_master_id', $qualifies);
            });
        }

        if (!empty($request->currentFenceHeight)) {
            $currentFenceHeight = $request->currentFenceHeight; // should be an array of discipline IDs
            $data->whereHas('currentFenceHeight', function ($q) use ($currentFenceHeight) {
                $q->whereIn('common_master_id', $currentFenceHeight);
            });
        }

        if (!empty($request->potentialFenceHeight)) {
            $potentialFenceHeight = $request->potentialFenceHeight; // should be an array of discipline IDs
            $data->whereHas('potentialFenceHeight', function ($q) use ($potentialFenceHeight) {
                $q->whereIn('common_master_id', $potentialFenceHeight);
            });
        }

        if (!empty($request->triedUpcomingShows)) {
            $triedUpcomingShows = $request->triedUpcomingShows; // should be an array of discipline IDs
            $data->whereHas('triedUpcomingShows', function ($q) use ($triedUpcomingShows) {
                $q->whereIn('common_master_id', $triedUpcomingShows);
            });
        }

        if (!empty($request->date) && !empty($request->date)) {
            $date = !empty($request->date)
                ? Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d')
                : null;
            $data = $data->where(function ($query) use ($date) {
                $query->orWhereHas('productDetail', function ($q) use ($date) {
                    $q->whereDate('created_at', '>=', $date)
                        ->whereDate('created_at', '<=', $date);
                });
            });
        }


        if (!empty($request->ftrial_from) && !empty($request->ftrial_to)) {

            $from = !empty($request->ftrial_from)
                ? Carbon::createFromFormat('d-m-Y', $request->ftrial_from)->format('Y-m-d')
                : null;
            $to = !empty($request->ftrial_to)
                ? Carbon::createFromFormat('d-m-Y', $request->ftrial_to)->format('Y-m-d')
                : null;
            $data = $data->where(function ($query) use ($from, $to) {
                $query->orWhereHas('productDetail', function ($q) use ($from, $to) {
                    $q->whereDate('fromdate', '>=', $from)
                        ->whereDate('fromdate', '<=', $to);
                });
            });
        }

        if (!empty($request->ttrial_from) && !empty($request->ttrial_to)) {
            $from = !empty($request->ttrial_from)
                ? Carbon::createFromFormat('d-m-Y', $request->ttrial_from)->format('Y-m-d')
                : null;
            $to = !empty($request->ttrial_to)
                ? Carbon::createFromFormat('d-m-Y', $request->ttrial_to)->format('Y-m-d')
                : null;

            $data = $data->where(function ($query) use ($from, $to) {
                $query->orWhereHas('productDetail', function ($q) use ($from, $to) {
                    $q->whereDate('todate', '>=', $from)
                        ->whereDate('todate', '<=', $to);
                });
            });
        }


        if (!empty($request->banner)) {
            $banner = $request->banner;
            $data = $data->where(function ($query) use ($banner) {
                $query->orWhereHas('productDetail', function ($q) use ($banner) {
                    $q->whereIn('banner', $banner);
                });
            });
        }
        
        if (!empty($request->trainer)) {
            $trainer = $request->trainer;
            $data = $data->where(function ($query) use ($trainer) {
                $query->orWhereHas('productDetail', function ($q) use ($trainer) {
                    $q->whereIn('trainer', $trainer);
                });
            });
        }

        if (!empty($request->facility)) {
            $facility = $request->facility;
            $data = $data->where(function ($query) use ($facility) {
                $query->orWhereHas('productDetail', function ($q) use ($facility) {
                    $q->whereIn('facility', $facility);
                });
            });
        }

        if (!empty($request->sirebloodline)) {
            $sirebloodline = $request->sirebloodline;
            $data = $data->where(function ($query) use ($sirebloodline) {
                $query->orWhereHas('productDetail', function ($q) use ($sirebloodline) {
                    $q->whereIn('sirebloodline', $sirebloodline);
                });
            });
        }

        if (!empty($request->dambloodline)) {
            $dambloodline = $request->dambloodline;
            $data = $data->where(function ($query) use ($dambloodline) {
                $query->orWhereHas('productDetail', function ($q) use ($dambloodline) {
                    $q->whereIn('dambloodline', $dambloodline);
                });
            });
        }

        if (!empty($request->usef)) {
            $usef = $request->usef;
            $data = $data->where(function ($query) use ($usef) {
                $query->orWhereHas('productDetail', function ($q) use ($usef) {
                    $q->whereIn('usef', $usef);
                });
            });
        }

        //-------sorting---------//
        if (!empty($request->sort)) {
            $data->orderBy('price', $request->sort);
        } else {
            $data->orderBy('id', 'desc');
        }

        $limit = 20;
        if (!empty($request->limit)) {
            $limit = $request->limit;
        }


        $total = $data->count();
        $data = $data->paginate($limit); // Adjust per page as needed
        $viewMode = $request->view_mode;
        $html = view('front/card', compact(['data','viewMode']))->render();
        // return view('front/card', compact(['data','viewMode']));
       
        $pagination = $data->withQueryString()->links('pagination::bootstrap-4')->render();

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'total' => $total
        ]);
    }

    public function horseDetails($id)
    {

        // if(Auth::user()!=null){
        //     dd($id);
        //     Cookie::queue(Cookie::forget('guest'));
        // }
        $products = Product::with([
            'user',
            'productDetail',
            'image',
            'video',
            'document',
            'category',
            'subcategory',
            'disciplines',
            'breeds',
            'colors',
            'trainingShowExperiences',
            'qualifies',
            'currentFenceHeight',
            'potentialFenceHeight',
            'triedUpcomingShows',
            'height',
            'sex',
            'greenEligibilities',
            'highestBid',
            'externalLink',
            'videoLink'
        ]);
        $products = $products->where(['deleted_at' => null, 'id' => $id]);
        // $products = $products->where('product_status', '!=', 'sold');
        $products = $products->whereNotIn('product_status', ['expire']);
        $products = $products->orderBy('id', 'desc')->first(); // keep search on pagination links
        if(!$products){
            return redirect()->back()->with('error','This record is not available at the moment.');
        }

        $moreAdd = Product::with(['image'])
            ->where('id', '!=', $id)
            ->where('category_id', 1)
            ->where('product_status', '!=', 'sold')
            ->where(['deleted_at' => null, 'user_id' => $products->user_id])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        //----guest user cookie---//
        $guest = json_decode(Cookie::get('guest', '[]'), true);

        // dd($products->toArray());
        return view('front/horseDetails', compact(['products', 'moreAdd', 'guest']));
    }


    //---------------- Equipment & Apparel listing & details routes------------------//
    public function equipmentListing(Request $request)
    {
        $filter = $request->query();
        return view('front/equipmentListing',compact('filter'));
    }

    public function getEquipmentDataTable(Request $request)
    {
        // -----login user-------//
        $data = Product::with([
            'user',
            'image',
            'productDetail',
            'category',
            'subcategory',
            'horseApparels',
            'riderApparels',
            'horseTacks',
            'trailerTrucks',
            'forBarns',
            'equineSupplements',
            'conditions',
            'brands',
            'horseSizes',
            'riderSizes',
            'exchangedUpcomingHorseShows',

        ])->where(['product_status' => 'live', 'deleted_at' => null]);

        //-----add horse category condition------//
        $data = $data->where('category_id', 2);


        $searchString = $request->search;
        if (!empty($searchString)) {
            $data = $data->where(function ($query) use ($searchString) {
                $query->where('title', 'like', "%$searchString%");
                // $query->orWhereHas('productDetail', function ($q) use ($searchString) {
                //     $q->where('city', 'like', "%$searchString%")
                //     ->orWhere('state', 'like', "%$searchString%")
                //     ->orWhere('country', 'like', "%$searchString%")
                //     ->orWhere('street', 'like', "%$searchString%");
                // });
            });
        }

        if (!empty($request->location)) {
            $location = $request->location;
            $data = $data->where(function ($query) use ($location) {
                $query->orWhereHas('productDetail', function ($q) use ($location) {
                    $q->where('precise_location', 'like', "%$location%")
                        ->orWhere('city', 'like', "%$location%")
                        ->orWhere('state', 'like', "%$location%")
                        ->orWhere('country', 'like', "%$location%")
                        ->orWhere('street', 'like', "%$location%");
                });
            });
        }

        if (!empty($request->date) && !empty($request->date)) {
            $date = !empty($request->date)
                ? Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d')
                : null;
            $data = $data->where(function ($query) use ($date) {
                $query->orWhereHas('productDetail', function ($q) use ($date) {
                    $q->whereDate('created_at', '>=', $date)
                        ->whereDate('created_at', '<=', $date);
                });
            });
        }

        if (!empty($request->category)) {
            $data->where('category_id', $request->category);
        }

      
        if (!empty($request->minPrice) && !empty($request->maxPrice)) {
            $data->whereBetween('price', [$request->minPrice, $request->maxPrice]);
        }

        if (!empty($request->minHourlyPrice) && !empty($request->maxHourlyPrice)) {
            $minHourlyPrice = $request->minHourlyPrice;
            $maxHourlyPrice = $request->maxHourlyPrice;
            $data = $data->where(function ($query) use ($minHourlyPrice, $maxHourlyPrice) {
                $query->orWhereHas('productDetail', function ($q) use ($minHourlyPrice, $maxHourlyPrice) {
                    $q->whereBetween('hourly_price', [$minHourlyPrice, $maxHourlyPrice]);
                });
            });
        }

        if (!empty($request->minLeasePrice) && !empty($request->maxLeasePrice)) {
            $minLeasePrice = $request->minLeasePrice;
            $maxLeasePrice = $request->maxLeasePrice;
            $data = $data->where(function ($query) use ($minLeasePrice, $maxLeasePrice) {
                $query->orWhereHas('productDetail', function ($q) use ($minLeasePrice, $maxLeasePrice) {
                    $q->whereBetween('fixed_price', [$minLeasePrice, $maxLeasePrice]);
                });
            });
        }

        if (!empty($request->currency)) {
            $data->where('currency', $request->currency);
        }

        if (!empty($request->banner)) {
            $banner = $request->banner;
            $data = $data->where(function ($query) use ($banner) {
                $query->orWhereHas('productDetail', function ($q) use ($banner) {
                    $q->whereIn('banner', $banner);
                });
            });
        }


        if (!empty($request->horseApparels)) {
            $horseApparels = $request->horseApparels; // should be an array of discipline IDs
            $data->whereHas('horseApparels', function ($q) use ($horseApparels) {
                $q->whereIn('common_master_id', $horseApparels);
            });
        }
        
        if (!empty($request->riderApparels)) {
            $riderApparels = $request->riderApparels; // should be an array of discipline IDs
            $data->whereHas('riderApparels', function ($q) use ($riderApparels) {
                $q->whereIn('common_master_id', $riderApparels);
            });
        }


        if (!empty($request->horseTacks)) {
            $horseTacks = $request->horseTacks; // should be an array of discipline IDs
            $data->whereHas('horseTacks', function ($q) use ($horseTacks) {
                $q->whereIn('common_master_id', $horseTacks);
            });
        }
       
        if (!empty($request->trailerTrucks)) {
            $trailerTrucks = $request->trailerTrucks; // should be an array of discipline IDs
            $data->whereHas('trailerTrucks', function ($q) use ($trailerTrucks) {
                $q->whereIn('common_master_id', $trailerTrucks);
            });
        }

        if (!empty($request->forBarns)) {
            $forBarns = $request->forBarns; // should be an array of discipline IDs
            $data->whereHas('forBarns', function ($q) use ($forBarns) {
                $q->whereIn('common_master_id', $forBarns);
            });
        }

        if (!empty($request->equineSupplements)) {
            $equineSupplements = $request->equineSupplements; // should be an array of discipline IDs
            $data->whereHas('equineSupplements', function ($q) use ($equineSupplements) {
                $q->whereIn('common_master_id', $equineSupplements);
            });
        }
       
        if (!empty($request->conditions)) {
            $conditions = $request->conditions; // should be an array of discipline IDs
            $data->whereHas('conditions', function ($q) use ($conditions) {
                $q->whereIn('common_master_id', $conditions);
            });
        }

       

        if (!empty($request->brands)) {
            $brands = $request->brands; // should be an array of discipline IDs
            $data->whereHas('brands', function ($q) use ($brands) {
                $q->whereIn('common_master_id', $brands);
            });
        }

        if (!empty($request->horseSizes)) {
            $horseSizes = $request->horseSizes; // should be an array of discipline IDs
            $data->whereHas('horseSizes', function ($q) use ($horseSizes) {
                $q->whereIn('common_master_id', $horseSizes);
            });
        }

        if (!empty($request->riderSizes)) {
            $riderSizes = $request->riderSizes; // should be an array of discipline IDs
            $data->whereHas('riderSizes', function ($q) use ($riderSizes) {
                $q->whereIn('common_master_id', $riderSizes);
            });
        }

        if (!empty($request->exchangedUpcomingHorseShows)) {
            $exchangedUpcomingHorseShows = $request->exchangedUpcomingHorseShows; // should be an array of discipline IDs
            $data->whereHas('exchangedUpcomingHorseShows', function ($q) use ($exchangedUpcomingHorseShows) {
                $q->whereIn('common_master_id', $exchangedUpcomingHorseShows);
            });
        }

        //-------sorting---------//
        if (!empty($request->sort)) {
            $data->orderBy('price', $request->sort);
        } else {
            $data->orderBy('id', 'desc');
        }

        $limit = 20;
        if (!empty($request->limit)) {
            $limit = $request->limit;
        }


        $total = $data->count();
        $data = $data->paginate($limit); // Adjust per page as needed
        $viewMode = $request->view_mode;
        $html = view('front/equipmentCard', compact(['data','viewMode']))->render();
        $pagination = $data->withQueryString()->links('pagination::bootstrap-4')->render();

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'total' => $total
        ]);
    }

    public function equipmentDetails($id)
    {

        // if(Auth::user()!=null){
        //     dd($id);
        //     Cookie::queue(Cookie::forget('guest'));
        // }
        $products = Product::with([
            'user',
            'productDetail',
            'image',
            'video',
            'document',
            'category',
            'subcategory',
            'disciplines',
            'breeds',
            'colors',
            'trainingShowExperiences',
            'qualifies',
            'currentFenceHeight',
            'potentialFenceHeight',
            'triedUpcomingShows',
            'height',
            'sex',
            'greenEligibilities'
        ]);
        $products = $products->where(['deleted_at' => null, 'id' => $id]);
        $products = $products->where('product_status', '!=', 'sold');
        $products = $products->orderBy('id', 'desc')->first(); // keep search on pagination links

        $moreAdd = Product::with(['image'])
            ->where('id', '!=', $id)
            ->where('category_id', 2)
            ->where('product_status', '!=', 'sold')
            ->where(['deleted_at' => null, 'user_id' => $products->user_id])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        //----guest user cookie---//
        $guest = json_decode(Cookie::get('guest', '[]'), true);

        return view('front/equipmentDetails', compact(['products', 'moreAdd', 'guest']));
    }


    //--------------------Barns & Housing listing & details routes--------------//
    public function barnsListing(Request $request)
    {
        $filter = $request->query();
        return view('front/barnsListing',compact('filter'));
    }

    public function getBarnsDataTable(Request $request)
    {
        // -----login user-------//
        $data = Product::with([
            'user',
            'image',            
            'productDetail',
            'category',
            'subcategory',
            'propertyTypes',
            'stableAmenities',
            'housingStablesAroundHorseShows',
            'housingAmenities'

        ])->where(['product_status' => 'live', 'deleted_at' => null]);

        //-----add horse category condition------//
        $data = $data->where('category_id', 3);


        $searchString = $request->search;
        if (!empty($searchString)) {
            $data = $data->where(function ($query) use ($searchString) {
                $query->where('title', 'like', "%$searchString%");
                // $query->orWhereHas('productDetail', function ($q) use ($searchString) {
                //     $q->where('city', 'like', "%$searchString%")
                //     ->orWhere('state', 'like', "%$searchString%")
                //     ->orWhere('country', 'like', "%$searchString%")
                //     ->orWhere('street', 'like', "%$searchString%");
                // });
            });
        }

        if (!empty($request->location)) {
            $location = $request->location;
            $data = $data->where(function ($query) use ($location) {
                $query->orWhereHas('productDetail', function ($q) use ($location) {
                    $q->where('precise_location', 'like', "%$location%")
                        ->orWhere('city', 'like', "%$location%")
                        ->orWhere('state', 'like', "%$location%")
                        ->orWhere('country', 'like', "%$location%")
                        ->orWhere('street', 'like', "%$location%");
                });
            });
        }

        if (!empty($request->date) && !empty($request->date)) {
            $date = !empty($request->date)
                ? Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d')
                : null;
            $data = $data->where(function ($query) use ($date) {
                $query->orWhereHas('productDetail', function ($q) use ($date) {
                    $q->whereDate('created_at', '>=', $date)
                        ->whereDate('created_at', '<=', $date);
                });
            });
        }

        if (!empty($request->currency)) {
            $data->where('currency', $request->currency);
        }

        if (!empty($request->category)) {
            $data->where('category_id', $request->category);
        }

        if (!empty($request->subCategory)) {
            $data->whereIn('sub_category', $request->subCategory);
        }

        if (!empty($request->propertyTypes)) {
            $propertyTypes = $request->propertyTypes; // should be an array of discipline IDs
            $data->whereHas('propertyTypes', function ($q) use ($propertyTypes) {
                $q->whereIn('common_master_id', $propertyTypes);
            });
        }
    

        if (!empty($request->minStall) && !empty($request->maxStall)) {
            $minStall = $request->minStall;
            $maxStall = $request->maxStall;
            $data = $data->where(function ($query) use ($minStall, $maxStall) {
                $query->orWhereHas('productDetail', function ($q) use ($minStall, $maxStall) {
                    $q->whereBetween('stalls_available', [$minStall, $maxStall]);
                });
            });
        }

        if (!empty($request->banner)) {
            $banner = $request->banner;
            $data = $data->where(function ($query) use ($banner) {
                $query->orWhereHas('productDetail', function ($q) use ($banner) {
                    $q->whereIn('banner', $banner);
                });
            });
        }

        if (!empty($request->stableAmenities)) {
            $stableAmenities = $request->stableAmenities; // should be an array of discipline IDs
            $data->whereHas('stableAmenities', function ($q) use ($stableAmenities) {
                $q->whereIn('common_master_id', $stableAmenities);
            });
        }
        
        if (!empty($request->housingStablesAroundHorseShows)) {
            $housingStablesAroundHorseShows = $request->housingStablesAroundHorseShows; // should be an array of discipline IDs
            $data->whereHas('housingStablesAroundHorseShows', function ($q) use ($housingStablesAroundHorseShows) {
                $q->whereIn('common_master_id', $housingStablesAroundHorseShows);
            });
        }
    

        if (!empty($request->ftrial_from) && !empty($request->ftrial_to)) {

            $from = !empty($request->ftrial_from)
                ? Carbon::createFromFormat('d-m-Y', $request->ftrial_from)->format('Y-m-d')
                : null;
            $to = !empty($request->ftrial_to)
                ? Carbon::createFromFormat('d-m-Y', $request->ftrial_to)->format('Y-m-d')
                : null;
            $data = $data->where(function ($query) use ($from, $to) {
                $query->orWhereHas('productDetail', function ($q) use ($from, $to) {
                    $q->whereDate('fromdate', '>=', $from)
                        ->whereDate('fromdate', '<=', $to);
                });
            });
        }


         if (!empty($request->minSleep) && !empty($request->maxSleep)) {
            $minSleep = $request->minSleep;
            $maxSleep = $request->maxSleep;
            $data = $data->where(function ($query) use ($minSleep, $maxSleep) {
                $query->orWhereHas('productDetail', function ($q) use ($minSleep, $maxSleep) {
                    $q->whereBetween('sleeps', [$minSleep, $maxSleep]);
                });
            });
        }

        if (!empty($request->housingAmenities)) {
            $housingAmenities = $request->housingAmenities; // should be an array of discipline IDs
            $data->whereHas('housingAmenities', function ($q) use ($housingAmenities) {
                $q->whereIn('common_master_id', $housingAmenities);
            });
        }
        
        if (!empty($request->minDailyPrice) && !empty($request->maxDailyPrice)) {
            $minDailyPrice = $request->minDailyPrice;
            $maxDailyPrice = $request->maxDailyPrice;
            $data = $data->where(function ($query) use ($minDailyPrice, $maxDailyPrice) {
                $query->orWhereHas('productDetail', function ($q) use ($minDailyPrice, $maxDailyPrice) {
                    $q->whereBetween('daily_board_rental_rate', [$minDailyPrice, $maxDailyPrice]);
                });
            });
        }
        
        if (!empty($request->minWeeklyPrice) && !empty($request->maxWeeklyPrice)) {
            $minWeeklyPrice = $request->minWeeklyPrice;
            $maxWeeklyPrice = $request->maxWeeklyPrice;
            $data = $data->where(function ($query) use ($minWeeklyPrice, $maxWeeklyPrice) {
                $query->orWhereHas('productDetail', function ($q) use ($minWeeklyPrice, $maxWeeklyPrice) {
                    $q->whereBetween('weekly_board_rental_rate', [$minWeeklyPrice, $maxWeeklyPrice]);
                });
            });
        }
        
        if (!empty($request->minMonthlyPrice) && !empty($request->maxMonthlyPrice)) {
            $minMonthlyPrice = $request->minMonthlyPrice;
            $maxMonthlyPrice = $request->maxMonthlyPrice;
            $data = $data->where(function ($query) use ($minMonthlyPrice, $maxMonthlyPrice) {
                $query->orWhereHas('productDetail', function ($q) use ($minMonthlyPrice, $maxMonthlyPrice) {
                    $q->whereBetween('monthly_board_rental_rate', [$minMonthlyPrice, $maxMonthlyPrice]);
                });
            });
        }

        if (!empty($request->minSalePrice) && !empty($request->maxSalePrice)) {
            $minSalePrice = $request->minSalePrice;
            $maxSalePrice = $request->maxSalePrice;
            $data = $data->where(function ($query) use ($minSalePrice, $maxSalePrice) {
                $query->orWhereHas('productDetail', function ($q) use ($minSalePrice, $maxSalePrice) {
                    $q->whereBetween('sale_cost', [$minSalePrice, $maxSalePrice]);
                });
            });
        }

        //-------sorting---------//
        if (!empty($request->sort)) {
            $data->orderBy('price', $request->sort);
        } else {
            $data->orderBy('id', 'desc');
        }

        $limit = 20;
        if (!empty($request->limit)) {
            $limit = $request->limit;
        }


        $total = $data->count();
        $data = $data->paginate($limit); // Adjust per page as needed
        $viewMode = $request->view_mode;
        $html = view('front/barnsCard', compact(['data','viewMode']))->render();
        $pagination = $data->withQueryString()->links('pagination::bootstrap-4')->render();

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'total' => $total
        ]);
    }

    public function barnsDetails($id)
    {

        // if(Auth::user()!=null){
        //     dd($id);
        //     Cookie::queue(Cookie::forget('guest'));
        // }
        $products = Product::with([
            'user',
            'productDetail',
            'image',
            'video',
            'document',
            'category',
            'subcategory',
            'disciplines',
            'breeds',
            'colors',
            'trainingShowExperiences',
            'qualifies',
            'currentFenceHeight',
            'potentialFenceHeight',
            'triedUpcomingShows',
            'height',
            'sex',
            'greenEligibilities'
        ]);
        $products = $products->where(['deleted_at' => null, 'id' => $id]);
        $products = $products->where('product_status', '!=', 'sold');
        $products = $products->orderBy('id', 'desc')->first(); // keep search on pagination links

        $moreAdd = Product::with(['image'])
            ->where('id', '!=', $id)
            ->where('category_id', 3)
            ->where('product_status', '!=', 'sold')
            ->where(['deleted_at' => null, 'user_id' => $products->user_id])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        //----guest user cookie---//
        $guest = json_decode(Cookie::get('guest', '[]'), true);

        return view('front/barnsDetails', compact(['products', 'moreAdd', 'guest']));
    }


    //---------------------- Services & Jobs listing & details routes-----------------------//
    public function serviceListing(Request $request)
    {
        $filter = $request->query();
        return view('front/serviceListing',compact('filter'));
    }

    public function getServiceDataTable(Request $request)
    {
        // -----login user-------//
        $data = Product::with([
            'user',
            'image',    
            'productDetail',
            'category',
            'jobListingType',
            'service',
            'contractTypes',
            'assistanceUpcomingShows',

        ])->where(['product_status' => 'live', 'deleted_at' => null]);

        //-----add horse category condition------//
        $data = $data->where('category_id', 4);


        $searchString = $request->search;
        if (!empty($searchString)) {
            $data = $data->where(function ($query) use ($searchString) {
                $query->where('title', 'like', "%$searchString%");
                // $query->orWhereHas('productDetail', function ($q) use ($searchString) {
                //     $q->where('city', 'like', "%$searchString%")
                //     ->orWhere('state', 'like', "%$searchString%")
                //     ->orWhere('country', 'like', "%$searchString%")
                //     ->orWhere('street', 'like', "%$searchString%");
                // });
            });
        }

        if (!empty($request->location)) {
            $location = $request->location;
            $data = $data->where(function ($query) use ($location) {
                $query->orWhereHas('productDetail', function ($q) use ($location) {
                    $q->where('precise_location', 'like', "%$location%")
                        ->orWhere('city', 'like', "%$location%")
                        ->orWhere('state', 'like', "%$location%")
                        ->orWhere('country', 'like', "%$location%")
                        ->orWhere('street', 'like', "%$location%");
                });
            });
        }

        if (!empty($request->date) && !empty($request->date)) {
            $date = !empty($request->date)
                ? Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d')
                : null;
            $data = $data->where(function ($query) use ($date) {
                $query->orWhereHas('productDetail', function ($q) use ($date) {
                    $q->whereDate('created_at', '>=', $date)
                        ->whereDate('created_at', '<=', $date);
                });
            });
        }

        if (!empty($request->currency)) {
            $data->where('currency', $request->currency);
        }

        if (!empty($request->category)) {
            $data->where('category_id', $request->category);
        }

        if (!empty($request->banner)) {
            $banner = $request->banner;
            $data = $data->where(function ($query) use ($banner) {
                $query->orWhereHas('productDetail', function ($q) use ($banner) {
                    $q->whereIn('banner', $banner);
                });
            });
        }


        if (!empty($request->jobListingType)) {
            $jobListingType = $request->jobListingType; // should be an array of discipline IDs
            $data->whereHas('jobListingType', function ($q) use ($jobListingType) {
                $q->whereIn('common_master_id', $jobListingType);
            });
        }
        
        if (!empty($request->service)) {
            $service = $request->service; // should be an array of discipline IDs
            $data->whereHas('service', function ($q) use ($service) {
                $q->whereIn('common_master_id', $service);
            });
        }
        
        if (!empty($request->contractTypes)) {
            $contractTypes = $request->contractTypes; // should be an array of discipline IDs
            $data->whereHas('contractTypes', function ($q) use ($contractTypes) {
                $q->whereIn('common_master_id', $contractTypes);
            });
        }
       
        if (!empty($request->assistanceUpcomingShows)) {
            $assistanceUpcomingShows = $request->assistanceUpcomingShows; // should be an array of discipline IDs
            $data->whereHas('assistanceUpcomingShows', function ($q) use ($assistanceUpcomingShows) {
                $q->whereIn('common_master_id', $assistanceUpcomingShows);
            });
        }

        if (!empty($request->ftrial_from) && !empty($request->ftrial_to)) {

            $from = !empty($request->ftrial_from)
                ? Carbon::createFromFormat('d-m-Y', $request->ftrial_from)->format('Y-m-d')
                : null;
            $to = !empty($request->ftrial_to)
                ? Carbon::createFromFormat('d-m-Y', $request->ftrial_to)->format('Y-m-d')
                : null;
            $data = $data->where(function ($query) use ($from, $to) {
                $query->orWhereHas('productDetail', function ($q) use ($from, $to) {
                    $q->whereDate('fromdate', '>=', $from)
                        ->whereDate('fromdate', '<=', $to);
                });
            });
        }
        
        if (!empty($request->ttrial_from) && !empty($request->ttrial_to)) {
            $from = !empty($request->ttrial_from)
                ? Carbon::createFromFormat('d-m-Y', $request->ttrial_from)->format('Y-m-d')
                : null;
            $to = !empty($request->ttrial_to)
                ? Carbon::createFromFormat('d-m-Y', $request->ttrial_to)->format('Y-m-d')
                : null;

            $data = $data->where(function ($query) use ($from, $to) {
                $query->orWhereHas('productDetail', function ($q) use ($from, $to) {
                    $q->whereDate('todate', '>=', $from)
                        ->whereDate('todate', '<=', $to);
                });
            });
        }

        
        if (!empty($request->locationFrom)) {
            $locationFrom = $request->locationFrom;
            $data = $data->where(function ($query) use ($locationFrom) {
                $query->orWhereHas('productDetail', function ($q) use ($locationFrom) {
                    $q->whereIn('haulings_location_from', $locationFrom);
                });
            });
        }

        if (!empty($request->locationTo)) {
            $locationTo = $request->locationTo;
            $data = $data->where(function ($query) use ($locationTo) {
                $query->orWhereHas('productDetail', function ($q) use ($locationTo) {
                    $q->whereIn('haulings_location_to', $locationTo);
                });
            });
        }

        if (!empty($request->minStall) && !empty($request->maxStall)) {
            $minStall = $request->minStall;
            $maxStall = $request->maxStall;
            $data = $data->where(function ($query) use ($minStall, $maxStall) {
                $query->orWhereHas('productDetail', function ($q) use ($minStall, $maxStall) {
                    $q->whereBetween('stalls_available_haulings', [$minStall, $maxStall]);
                });
            });
        }       
   
        if (!empty($request->minSalary) && !empty($request->maxSalary)) {
            $minSalary = $request->minSalary;
            $maxSalary = $request->maxSalary;
            $data = $data->where(function ($query) use ($minSalary, $maxSalary) {
                $query->orWhereHas('productDetail', function ($q) use ($minSalary, $maxSalary) {
                    $q->whereBetween('salary', [$minSalary, $maxSalary]);
                });
            });
        }
        
        if (!empty($request->minHourlyPay) && !empty($request->maxHourlyPay)) {
            $minHourlyPay = $request->minHourlyPay;
            $maxHourlyPay = $request->maxHourlyPay;
            $data = $data->where(function ($query) use ($minHourlyPay, $maxHourlyPay) {
                $query->orWhereHas('productDetail', function ($q) use ($minHourlyPay, $maxHourlyPay) {
                    $q->whereBetween('hourly_price', [$minHourlyPay, $maxHourlyPay]);
                });
            });
        }
        
        if (!empty($request->minFixedPay) && !empty($request->maxFixedPay)) {
            $minFixedPay = $request->minFixedPay;
            $maxFixedPay = $request->maxFixedPay;
            $data = $data->where(function ($query) use ($minFixedPay, $maxFixedPay) {
                $query->orWhereHas('productDetail', function ($q) use ($minFixedPay, $maxFixedPay) {
                    $q->whereBetween('fixed_price', [$minFixedPay, $maxFixedPay]);
                });
            });
        }
        //-------sorting---------//
        if (!empty($request->sort)) {
            $data->orderBy('price', $request->sort);
        } else {
            $data->orderBy('id', 'desc');
        }

        $limit = 20;
        if (!empty($request->limit)) {
            $limit = $request->limit;
        }


        $total = $data->count();
        $data = $data->paginate($limit); // Adjust per page as needed
        $viewMode = $request->view_mode;
        $html = view('front/serviceCard', compact(['data','viewMode']))->render();
        $pagination = $data->withQueryString()->links('pagination::bootstrap-4')->render();

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'total' => $total
        ]);
    }

    public function serviceDetails($id)
    {

        // if(Auth::user()!=null){
        //     dd($id);
        //     Cookie::queue(Cookie::forget('guest'));
        // }
        $products = Product::with([
            'user',
            'productDetail',
            'image',
            'video',
            'document',
            'category',
            'subcategory',
            'disciplines',
            'breeds',
            'colors',
            'trainingShowExperiences',
            'qualifies',
            'currentFenceHeight',
            'potentialFenceHeight',
            'triedUpcomingShows',
            'height',
            'sex',
            'greenEligibilities',
        ]);
        $products = $products->where(['deleted_at' => null, 'id' => $id]);
        $products = $products->where('product_status', '!=', 'sold');
        $products = $products->orderBy('id', 'desc')->first(); // keep search on pagination links

        $moreAdd = Product::with(['image'])
            ->where('id', '!=', $id)
            ->where('category_id', 4)
            ->where('product_status', '!=', 'sold')
            ->where(['deleted_at' => null, 'user_id' => $products->user_id])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        //----guest user cookie---//
        $guest = json_decode(Cookie::get('guest', '[]'), true);
        $schedulesArr = [];
        $schedules = Schedule::where('product_id', $products->id)->get();
        if($schedules->isNotEmpty())
        {
            $schedulesArr = $schedules->toArray();
        }
        $selectedDate = null;
        if(auth()->check() == true)
        {
            $selectedDate = Schedule::where(['product_id' => @$products->id, 'user_id' => auth()->id(), 'status' => '1'])->orderBy('id', 'desc')->get();
        }

        return view('front/serviceDetails', compact(['products', 'moreAdd', 'guest', 'selectedDate', 'schedulesArr']));
    }

    // category search
    public function categoryWiseProduct(Request $request)
    {
        // -----login user-------//
        $data = Product::with([
            'user',
            'productDetail',
            'image',
            'video',
            'document',
            'category',
            'subcategory',
            'disciplines',
            'breeds',
            'colors',
            'trainingShowExperiences',
            'qualifies',
            'currentFenceHeight',
            'potentialFenceHeight',
            'triedUpcomingShows',
            'height',
            'sex',
            'greenEligibilities'
        ])->where(['product_status' => 'live', 'deleted_at' => null]);

        //-----add horse category condition------//
        $events = $data->where('category_id', 1);

        // dd($data);
        return view('events.index', compact('events'));
    }
}
