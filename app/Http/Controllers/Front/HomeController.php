<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CommentRequest;
use App\Http\Requests\Front\ContactAdOwnerRequest;
use App\Http\Requests\Front\NewsLetterRequest;
use App\Http\Requests\Front\ReportAdOwnerRequest;
use App\Models\Blog;
use App\Models\HjForum;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserDetailAlert;
use App\Models\IndustryMatric;
use App\Models\HomeAbout;
use App\Models\About;
use App\Models\Category;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionAddOnPlan;
use App\Models\PartnershipContent;
use App\Models\PartnershipWay;
use App\Models\PartnerShipCollaborate;
use App\Services\Admin\website\PartnershipService;
use App\Models\SellerBusiness;
use App\Models\AboutSellerBusiness;
use App\Models\BuyerBrowser;
use App\Models\BuyerFaq;
use App\Models\ChatUser;
use App\Models\Conveniencs;
use App\Models\ProductComment;
use App\Models\ProductReport;
use App\Models\Review;
use App\Services\Front\HomeService;
use App\Services\Front\NewsletterService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use Stripe\Stripe;
use Stripe\Price;
use Stripe\Subscription;
use Stripe\Checkout\Session as StripeSession;

class HomeController extends Controller
{
    protected $homeService;
    protected $newsletterService;
    protected $partnershipService;
    public function __construct(HomeService $homeService, NewsletterService $newsletterService, PartnershipService $partnershipService)
    {
        $this->homeService = $homeService;
        $this->newsletterService = $newsletterService;
        $this->partnershipService = $partnershipService;
    }

    public function index(Request $request)
    {
        $blogs = Blog::with('category')->where('deleted_at', null)->orderBy('id', 'desc')->take(6)->get();
        $hjForumData = HjForum::latest()->take(10)->get();
        $featured = Product::with([
            'category',
            'user',
            'productDetail',
            'image',
            'video',
            'document',
            'disciplines',
            'breeds',
            'triedUpcomingShows',
            'height',
            'greenEligibilities'
        ])->where(['deleted_at' => null, 'feature' => 1, 'product_status' => 'live'])->orderBy('category_id')->get();
        $featuredData = $featured->groupBy('category_id');

        // Industry Matric
        $industryMatricData = IndustryMatric::orderBy('id', 'desc')->get();
        // about us
        $homeAboutData = HomeAbout::first();
        $sellerBusinessData = SellerBusiness::first();
        $buyerBrowserData = BuyerBrowser::first();
        $buyerFaqData = BuyerFaq::orderBy('id', 'desc')->get();
        $partnerShipListing = PartnerShipCollaborate::get();
        $partnershipCollaborate = $partnerShipListing->chunk(15);

        $coordinate = ['latitude' => '', 'longitude' => ''];
        if (Auth::check() == true) {
            $latitude = Auth::user()->getUserDetail->latitude;
            $longitude = Auth::user()->getUserDetail->longitude;
            $coordinate = ['latitude' => $latitude, 'longitude' => $longitude];
        }

        // category search
        $data = Product::with([
            'user',
            'productDetail',
            'image'
        ])->where(['product_status' => 'live', 'deleted_at' => null]);

        //-----add horse category condition------//
        $searchString = $request->search;
        if (!empty($searchString)) {
            $data = $data->where(function ($query) use ($searchString) {
                $query->where('title', 'like', "%$searchString%");
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
        $events = $data->orderBy('id', 'desc')->take(3)->get()->toArray();
        return view('front/home', compact(['blogs', 'partnershipCollaborate', 'featuredData', 'industryMatricData', 'homeAboutData', 'sellerBusinessData', 'buyerBrowserData', 'buyerFaqData', 'events', 'coordinate', 'hjForumData']));
    }

    public function universalSearch(Request $request)
    {
        $search = $request->query('search');
        $location = $request->query('location');
        $category = $request->query('category');
        if ($category == 1) {
            return redirect()->route('horse-listing', ['search' => $search, 'location' => $location]);
        } elseif ($category == 2) {
            return redirect()->route('equipment-listing', ['search' => $search, 'location' => $location]);
        } elseif ($category == 3) {
            return redirect()->route('barns-listing', ['search' => $search, 'location' => $location]);
        } elseif ($category == 4) {
            return redirect()->route('service-listing', ['search' => $search, 'location' => $location]);
        } else {
            return redirect()->back()->with('error', 'This category is not recognized. Try a different one.');
        }
    }
    /** 
     * newsletter subscribe
     */
    public function newsletterSubscribe(NewsLetterRequest $request)
    {
        $result = $this->newsletterService->subscribe($request->email);

        return redirect()->back()->with('success', 'Newsletter subscribed successfully.');
    }

    public function compare(Request $request)
    {

        // Get existing cookie value
        $productId = $request->id;

        if ($request->status == "add") {

            $compare = json_decode(Cookie::get('compare_products', '[]'), true);

            // Add new value only if not already present
            if (!in_array($productId, $compare)) {
                $compare[] = $productId;
            }

            // Set updated cookie (120 minutes lifetime)
            Cookie::queue('compare_products', json_encode($compare), 120);
        } elseif ($request->status == "remove") {
            $compare = json_decode(Cookie::get('compare_products', '[]'), true);

            // Remove the item
            $compare = array_filter($compare, function ($id) use ($productId) {
                return $id != $productId;
            });

            // Re-index array
            $compare = array_values($compare);

            Cookie::queue('compare_products', json_encode($compare), 120);
        } else {
            Cookie::queue(Cookie::forget('compare_products'));
            $compare = [];
        }

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
            'greenEligibilities',
        ])->where(['deleted_at' => null]);
        $data = $data->whereIn('id', $compare);
        $total = $data->count();
        $data = $data->get();

        $html = view('front/compare', compact(['data']))->render();
        return response()->json([
            'html' => $html,
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
            'greenEligibilities'
        ]);
        $products = $products->where(['deleted_at' => null, 'id' => $id]);
        // $products = $products->where('product_status', '!=', 'sold');
        $products = $products->orderBy('id', 'desc')->first();

        $moreAdd = Product::with(['image'])
            ->where('id', '!=', $id)
            ->where('product_status', '!=', 'sold')
            ->where(['deleted_at' => null, 'user_id' => $products->user_id])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        //----guest user cookie---//
        $guest = json_decode(Cookie::get('guest', '[]'), true);

        return view('front/horseDetails', compact(['products', 'moreAdd', 'guest']));
    }

    public function productCommentListing(Request $request, $id)
    {
        $productId = $id;
        $data = ProductComment::with('children')
            ->where('product_id', $productId)
            ->whereNull('product_comment_id')
            ->with('children')
            ->orderBy('id', 'desc');

        $total = $data->count();
        $data = $data->paginate(10);

        $html = "";
        //----guest user cookie---//
        $guest = json_decode(Cookie::get('guest', '[]'), true);
        if ($data->count() > 0) {
            $html = view('front/product-comment', compact(['data', 'productId', 'guest']))->render();
        }
        $pagination = $data->withQueryString()->links('pagination::bootstrap-4')->render();
        $totalPages = ceil($total / 10);


        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'total' => $total,
            'totalPages' => $totalPages
        ]);
    }

    //----store product comment---//
    public function productComment(CommentRequest $request)
    {
        if (!Auth::user()) {
            // \Log::info("message: Guest user comment");
            $compare = [
                'name' => $request->name,
                'email' => $request->email,
                'website' => $request->website
            ];
            // Set updated cookie (120 minutes lifetime)
            Cookie::queue('guest', json_encode($compare), 120);
        }

        $user = (Auth::user()) ? Auth::user() : null;
        $validatedData = $request->all();
        $comment = $this->homeService->storeComment($validatedData, $user);

        return response()->json([
            'status' => true,
            'comment' => "DONE",
            'guest' => [
                    'name' => $request->name,
                    'email' => $request->email,
                    'website' => $request->website
                ]
        ]);
    }

    //----update product comment---//
    public function commentUpdate(Request $request)
    {
        $request->validate([
            'comment' => 'required|max:5000',
            'comment_id' => 'required|exists:product_comments,id',
        ]);

        $guest = json_decode(Cookie::get('guest', '[]'), true);
        $user = (Auth::user()) ? Auth::user() : null;

        if ($user && $user->id != ProductComment::find($request->comment_id)->user_id) {
            return response()->json([
                'status' => false,
                'message' => "You are not authorized to update this comment.",
            ]);
        }

        if (!$user && $guest['email'] != ProductComment::find($request->comment_id)->email) {
            return response()->json([
                'status' => false,
                'message' => "You are not authorized to update this comment.",
            ]);
        }

        $comment = ProductComment::find($request->comment_id);
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['status' => true, 'message' => 'Comment updated.']);
    }

    //----store product comment---//
    public function productCommentDelete($id)
    {
        $guest = json_decode(Cookie::get('guest', '[]'), true);
        $user = (Auth::user()) ? Auth::user() : null;


        if ($user && $user->id != ProductComment::find($id)->user_id) {
            return response()->json([
                'status' => false,
                'message' => "You are not authorized to delete this comment.",
            ]);
        }

        if (!$user && $guest['email'] != ProductComment::find($id)->email) {
            return response()->json([
                'status' => false,
                'message' => "You are not authorized to delete this comment.",
            ]);
        }

        // Check if the comment exists
        if (!ProductComment::find($id)) {
            return response()->json([
                'status' => false,
                'message' => "Comment not found.",
            ]);
        }

        // Call the service to remove the comment
        if (!$this->homeService->removeComment($id, $user)) {
            return response()->json([
                'status' => false,
                'message' => "Failed to delete comment.",
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => "Comment deleted.",
            ]);
        }
    }

    public function chatMessage(Request $request)
    {
        $roomId = $request->query('room_id') ?? null;

        $user = Auth::user();

        $chatList = ChatUser::where('user_id', $user->id)->pluck('convenience_id');
        $list = ChatUser::with(['getUser', 'room'])
            ->where('user_id', '!=', $user->id)
            ->where('is_user_delete', 0)
            ->whereIn('convenience_id', $chatList->toArray())
            ->withCount([
                    'chat as total_unread' => function ($q) use ($user) {
                        $q->whereRaw('NOT FIND_IN_SET(?, is_read)', [$user->id]);
                    }
                ]);

        if (isset($request->search) && !empty($request->search) && $request->search != 'all') {
            $search = $request->search;
            $list->where(function ($q) use ($search) {
                return $q->orWhereRelation('getUser', 'username', 'like', '%' . $search . '%');
            });
        }
        $list = $list->orderBy('updated_at', 'desc')->get();
        // dd($list->toArray());
        return view('frontauth/chat/messages', compact('roomId'));
    }


    //-------------------------------------------------------------------------------------------------------//

    public function aboutus()
    {
        $aboutData = About::first();
        $sellerBusinessData = SellerBusiness::first();
        $buyerBrowserData = BuyerBrowser::first();
        $buyerFaqData = BuyerFaq::orderBy('id', 'desc')->get();
        // $aboutSellerBusinessData = AboutSellerBusiness::first();
        $hjForumData = HjForum::latest()->take(6)->get();

        $subscription = SubscriptionPlan::whereNull('deleted_at')
            ->get()
            ->groupBy('type');
        $addon = SubscriptionAddOnPlan::all();

        return view('front/aboutus', compact('aboutData', 'hjForumData', 'sellerBusinessData', 'buyerBrowserData', 'buyerFaqData', 'subscription', 'addon'));
    }

    public function partnerships()
    {
        $partnerContent = PartnershipContent::first();
        $partnerhipWay = PartnershipWay::get();

        $partnerShipListing = PartnerShipCollaborate::get();
        $partnershipCollaborate = $partnerShipListing->chunk(15);

        return view('front/partnerships', compact('partnerContent', 'partnerhipWay', 'partnershipCollaborate'));
    }

    public function contactAdOwner(ContactAdOwnerRequest $request)
    {
        $data = $request->all();
        $this->homeService->contactAdOwner($data);
        return redirect()->back()->with('success', 'Your message has been sent successfully. Owner will contact you soon.');
    }

    public function submitReport(ReportAdOwnerRequest $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $existingReport = ProductReport::where('user_id', $user->id)
            ->where('product_id', $data['product_id'])
            ->first();
        if ($existingReport) {
            return redirect()->back()->with('error', 'You have already reported this.');
        }
        $this->homeService->submitReport($data, $user);
        return redirect()->back()->with('success', 'Success! Your report is on its way—thank you, and we’re proud of your contribution.');
    }


    public function communityEvents()
    {
        return view('front/communityEvents');
    }

    public function checkout()
    {
        return view('front/checkout');
    }

    public function bidNow()
    {
        return view('front/bidNow');
    }

    public function occasion()
    {
        return view('front/occasion');
    }

    public function sale()
    {
        return view('front/sale');
    }

    public function notFound()
    {
        return view('front/notFound');
    }

    // ----------After login routes--------------//



    //************************************bleow routes need to work****************************************-//

    public function favorite(Request $request)
    {
        $type = $request->input('type', 'all');
        $order = $request->input('order_by', 'desc');
        $categoryId = $request->input('category_id', null);
        // $orderBy = in_array($request->input('order_by'), ['asc', 'desc']) ? $request->input('order_by') : 'desc';

        // Get only products that are favorited by the authenticated user
        $query = Product::whereHas('favorites', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->with('favorites');

        // Filter by product status if specified
        if ($type !== 'all') {
            $query->where('product_status', $type);
        }
        // Filter by product status if specified
        if ($categoryId !== null) {
            $query->where('category_id', $categoryId);
        }

        // Sort and paginate
        $favProducts = $query->orderBy('id', $order)->paginate(10);
        // $favProducts = $query->where('category_id', $categoryId)->orderBy('id', $order)->paginate(10);

        // AJAX response
        if ($request->ajax()) {
            $html = view('frontauth.partials.favorite-products', compact('favProducts', 'type'))->render();

            return response()->json([
                'status' => 200,
                'html' => $html,
                'type' => $type
            ]);
        }

        // Load categories for the full page view
        $categories = Category::withoutTrashed()->orderBy('name')->get();

        return view('frontauth.favorite', compact('categories', 'favProducts'));
    }


    public function review()
    {
        $user = Auth::user();
        $review = Review::where('user_id', $user->id)
            ->with(['user', 'ownerUser'])
            ->orderBy('id', 'desc')
            ->paginate(9);

        return view('frontauth/review', compact('review'));
    }

    public function invoice()
    {
        $transaction = Transaction::where('user_id', Auth::user()->id)->get();

        return view('frontauth/invoice', compact('transaction'));
    }

    public function invoiceDetails(request $request, $id)
    {
        $id = base64_decode($id);

        $invoice = Transaction::with(['planData', 'addonData'])->where('id', $id)->first();

        return view('frontauth.invoice_details', compact('invoice'));


    }

    public function charge_add_ons(request $request)
    {
        $xdataarry = $request->addon_prices;

        if (count($xdataarry) == '0') {
            return redirect()->back()->with('error', 'Please select addons');
        }
        $priceArray = SubscriptionAddOnPlan::whereIn('id', $request->addon_prices)->pluck('price')->toArray();
        $exactPrice = array_sum($priceArray);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkoutSession = StripeSession::create([
            'mode' => 'payment', // ✅ One-time payment mode
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'One-Time Service Fee',
                        ],
                        'unit_amount' => $exactPrice * 100, // $29.99 in cents
                    ],
                    'quantity' => 1,
                ]
            ],
            'customer_email' => Auth::user()->email, // optional
            'metadata' => [
                'addon_ids' => implode(',', $request->addon_prices), // Your hidden ID
                'type' => 'charge-addons', // Your hidden ID
                'user_id' => Auth::id(),    // Optional
            ],
            'success_url' => route('plan_purchase.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('plan_purchase.cancel'),
        ]);

        return redirect()->to($checkoutSession->url);

    }

    public function notificationModalnextLevel(request $request)
    {
      $lister=explode(',',Auth::user()->lister_type);
      // <p class="w-100 text-center">Current OPT Notification: '.ucfirst(Auth::user()->opt_in_notification).'</p>
        $html = '
        <div class="lister-checkbox-box p-0 d-flex justify-content-center mt-3">
                                                    <div class="m-2">

                                                        <label class="ad-lister-checkbox">
                                                            <input class="form-check-input  check_series" type="checkbox"
                                                                id="email1" name="lister[]" value="1" '.(in_array('1',$lister)?'checked':'').'>
                                                            <span>Ad Lister</span>
                                                        </label>

                                                    </div>
                                                    <div class="m-2">

                                                        <label class="ad-lister-checkbox">
                                                            <input class="form-check-input check_series" name="lister[]" type="checkbox"
                                                                id="email2" value="2" '.(in_array('2',$lister)?'checked':'').'>
                                                            <span>Ad Viewer</span>
                                                        </label>

                                                    </div>
                                                </div>
                                                ';

        return response()->json([
            'html' => $html
        ]);
    }

    public function check_seriesCheck(request $request){
      $checkSeries= $request->check_series;  
   
        $userDetails = UserDetails::where('user_id', Auth::user()->id)->first();

         $userDetailAlert = UserDetailAlert::where(['user_id' => Auth::user()->id, 'user_detail_id' => $userDetails->id])->get()->toArray();
            foreach ($userDetailAlert as $item) {
                $alertDetails[$item['meta_key']] = [
                    'sms' => $item['sms'],
                    'mobile' => $item['mobile'],
                    'email' => $item['email'],
                ];
            }

         $view     = View::make('frontauth.partials.check_seriesCheck', ['explodeLister' => explode(',',$checkSeries),'alertDetails'=>$alertDetails ?? []]);
        $contents = (string) $view;

        $contents = $view->render();

        return response()->json(['status' => 1, 'contents' => $contents], 200);

    }

    public function updateNotificationData(request $request){


    if(!isset($request->lister)){
 User::where('id',Auth::user()->id)->update(['opt_in_notification'=>'no']);

$request->lister=[];
      }else{
 User::where('id',Auth::user()->id)->update(['opt_in_notification'=>'yes']);

      }
$alerts=[];
if (is_array($request->lister) && in_array('1', $request->lister)) {
    array_push($alerts, 'subscription', 'payment');
}

if (is_array($request->lister) && in_array('2', $request->lister)) {
    array_push($alerts, 'listMatch', 'biddinItem');
}

if (count($alerts) > 0) {
    array_push($alerts, 'auction');
}

 User::where('id',Auth::user()->id)->update(['lister_types'=>implode(',',$request->lister)]);
      
   $userDetails = UserDetails::where('user_id' ,Auth::user()->id)->first();
      UserDetailAlert::where('user_id',Auth::user()->id)->where('user_detail_id',$userDetails->id)->delete();

    $notifiactionDetails=[];
         foreach ($alerts as $metaKey) {
          
            $notifiactionDetails[] = [
                'user_id' => Auth::user()->id,
                'user_detail_id' => $userDetails->id,
                'meta_key' => $metaKey,
                'sms' => !empty($request->$metaKey['sms']) ? 1 : 0,
                'mobile' => !empty($request->$metaKey['mobile']) ? 1 : 0,
                'email' => !empty($request->$metaKey['email']) ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

    
         UserDetailAlert::insert($notifiactionDetails);
    
         return redirect()->back()->with('success','Your notification setting updated successfully.');
    }
}
