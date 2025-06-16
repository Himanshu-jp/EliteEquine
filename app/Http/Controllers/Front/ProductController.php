<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ProductBarnsDetailsRequest;
use App\Http\Requests\Front\ProductEquipmentDetailsRequest;
use App\Http\Requests\Front\ProductHorseDetailsRequest;
use App\Http\Requests\Front\ProductRequest;
use App\Http\Requests\Front\AddRatingRequest;
use App\Http\Requests\Front\StoreBidRequest;
use App\Http\Requests\Front\ProductServiceDetailsRequest;
use App\Http\Requests\Front\CheckoutRequest;
use App\Services\Front\RatingService;
use App\Services\Front\CheckoutService;
use App\Models\Category;
use App\Models\CommonMaster;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductComment;
use App\Models\ProductDetail;
use App\Models\ProductDocument;
use App\Models\Favorite;
use App\Models\ProductBid;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use App\Models\SubCategory;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use App\Services\Front\ProductService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\Front\BidService;
use Carbon\Carbon;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
Stripe::setApiKey(env('STRIPE_SECRET'));

class ProductController extends Controller
{

    protected $productService;
    protected $ratingService;
    protected $bidService;
    protected $checkoutService;
    public function __construct(ProductService $productService, RatingService $ratingService, BidService $bidService, CheckoutService $checkoutService)
    {
        $this->productService = $productService;
        $this->ratingService = $ratingService;
        $this->bidService = $bidService;
        $this->checkoutService = $checkoutService;
    }

    public function index()
    {
        $user = auth::user();
        if($user->phone_no =="" || $user->country =="" || $user->state=="" || $user->city=="" ){
            return redirect()->route('profile')->with('error', 'Please first complete your Profile details.');
        }        
        $settingDetails = UserDetails::where('user_id',$user->id)->where('phone','!=',null)->first();
        if(!$settingDetails)
        {
            return redirect()->route('settings')->with('error', 'Please first complete your Settings details.');
        }
        
        // $products = Product::with(['image', 'video', 'document'])
        //     ->where(['deleted_at' => null, 'user_id' => $user->id, 'product_status' => null])
        //     ->orderBy('id', 'desc')
        //     ->first();
        // return view('frontauth/product', compact('products'));

        return view('frontauth/product');
    }

    public function editProduct($id)
    {
        $user = auth::user();
        $products = Product::with(['image', 'video', 'document','category','externalLink','videoLink'])
            ->where(['id' => $id, 'deleted_at' => null, 'user_id' => $user->id])
            ->orderBy('id', 'desc')
            ->first();
        
        if($products->product_status=="sold"){
             return redirect()->back()->with('error', 'This product has been sold and can no longer be updated.');
        }            
        return view('frontauth/product', compact('products'));
    }
   
    public function removeImage($id)
    {
        $user = auth::user();
        $result = ProductImage::where(['id'=>$id])->first();   
        if ($result->image && Storage::disk('public')->exists($result->image)) {
            Storage::disk('public')->delete($result->image);
        }
        $result->delete();   
        return redirect()->back()->with('success', 'Image removed successfully.');
    }
  
    public function removeVideo($id)
    {
        $user = auth::user();
        $result = ProductVideo::where(['id'=>$id])->first();   
        if ($result->video_url && Storage::disk('public')->exists($result->video_url)) {
            Storage::disk('public')->delete($result->video_url);
        }
        $result->delete();   
        return redirect()->back()->with('success', 'Video removed successfully.');
    }
    
    public function removeDocument($id)
    {
        $user = auth::user();
        $result = ProductDocument::where(['id'=>$id])->first();   
        if ($result->file && Storage::disk('public')->exists($result->file)) {
            Storage::disk('public')->delete($result->file);
        }
        $result->delete();   
        return redirect()->back()->with('success', 'Document removed successfully.');
    }

    
    public function productList(Request $request)
    {
        $user = auth::user();
        $products = Product::with(['category','image', 'video', 'document']);
        $products = $products->where(['deleted_at' => null, 'user_id' => $user->id]);

        if ($request->has('search') && $request->search !== null) {
            $products->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->has('category') && $request->category !== null) {
            $products->where('category_id', $request->category);
        }

        $products = $products->orderBy('id', 'desc')->paginate(10)->appends($request->all());
        return view('frontauth/productListing', compact('products'));
    }


    public function productDelete($id)
    {
        // $isUsed = Product::where('id',$id)->count();
        // if($isUsed>0){ 
        //     session()->flash('error','This Product is in used in listing so you can not remove it.');
        // }else{
        $product = Product::find($id)->delete();
        session()->flash('message', 'This Product Record Deleted Successfully');
        // }
        return redirect()->back();
    }

    public function storeProduct(ProductRequest $request)
    {
        $user = Auth::user();
        $validatedData = $request->all();
        $product = $this->productService->createProduct($validatedData, $user);

        //productZone
        if (!$product) {
            return redirect()->back()->with('error', 'Failed to create product.');
        } 
        else if($product->category_id==1) {
            return redirect()->route('productHorseDetails', ['id' => $product->id]);
        }
        else if($product->category_id==2) {
            return redirect()->route('productEquipmentDetails', ['id' => $product->id]);
        }
        else if($product->category_id==3) {
            return redirect()->route('productBarnsDetails', ['id' => $product->id]);
        }
        else if($product->category_id==4) {
            return redirect()->route('productServiceDetails', ['id' => $product->id]);
        }
        else{
            return redirect()->back()->with('error', 'Failed to find the category.');
        }
    }

    //------Horse 0001-------//
    public function productHorseDetails(Request $request)
    {
        $user = auth::user();
        $productExists = Product::where(['id' => $request->id, 'deleted_at' => null, 'user_id' => $user->id])->first();
        if (!$productExists) {
            return redirect()->route('product')->with('error', 'This product is not available.');
        }
        if($productExists->product_status=="sold"){
             return redirect()->back()->with('error', 'This product has been sold and can no longer be updated.');
        }
        $productId = $request->query('id'); // Get the product ID from the query string
        $subcategories = SubCategory::where(['category_id' => $productExists->category_id, 'deleted_at' => null])->pluck('name', 'id')->toArray();

        $products = Product::with([
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
        ])
            ->where(['id' => $request->id, 'deleted_at' => null, 'user_id' => $user->id])
            ->orderBy('id', 'desc')
            ->first();
        return view('frontauth/productHorseDetails', compact(['productId', 'products', 'subcategories']));
    }

    public function storeProductHorseDetails(ProductHorseDetailsRequest $request)
    {
        $user = Auth::user();
        $validatedData = $request->all();
        $product = $this->productService->createProductHorseDetails($validatedData, $user);
        if (!$product) {
            return redirect()->back()->with('error', 'Failed to create product details.');
        } else {
            return redirect()->route('productList')->with('success', 'Product store successfully.');
        }
    }


    //------Equipment & Apparel------- 0002 //
    public function productEquipmentDetails(Request $request)
    {
        $user = auth::user();
        $productExists = Product::where(['id' => $request->id, 'deleted_at' => null, 'user_id' => $user->id])->first();
        if (!$productExists) {
            return redirect()->route('product')->with('error', 'This product is not available.');
        }
        if($productExists->product_status=="sold"){
             return redirect()->back()->with('error', 'This product has been sold and can no longer be updated.');
        }
        $productId = $request->query('id'); // Get the product ID from the query string

        $products = Product::with([
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
        ])
            ->where(['id' => $request->id, 'deleted_at' => null, 'user_id' => $user->id])
            ->orderBy('id', 'desc')
            ->first();

        return view('frontauth/productEquipmentDetails', compact(['productId', 'products']));
    }

    public function storeProductEquipmentDetails(ProductEquipmentDetailsRequest $request)
    {
        $user = Auth::user();
        $validatedData = $request->all();
        $product = $this->productService->createProductEquipmentDetails($validatedData, $user);
        if (!$product) {
            return redirect()->back()->with('error', 'Failed to create product details.');
        } else {
            return redirect()->route('productList')->with('success', 'Product store successfully.');
        }
    }
    
    //------Barns & Housing------- 0003 //
    public function productBarnsDetails(Request $request)
    {
        $user = auth::user();
        $productExists = Product::where(['id' => $request->id, 'deleted_at' => null, 'user_id' => $user->id])->first();
        if (!$productExists) {
            return redirect()->route('product')->with('error', 'This product is not available.');
        }
        if($productExists->product_status=="sold"){
             return redirect()->back()->with('error', 'This product has been sold and can no longer be updated.');
        }
        $productId = $request->query('id'); // Get the product ID from the query string
        $subcategories = SubCategory::where(['category_id' => $productExists->category_id, 'deleted_at' => null])->pluck('name', 'id')->toArray();

        $products = Product::with([
            'productDetail',
            'category',
            'subcategory',
            'propertyTypes',
            'stableAmenities',
            'housingStablesAroundHorseShows',
            'housingAmenities'
        ])
            ->where(['id' => $request->id, 'deleted_at' => null, 'user_id' => $user->id])
            ->orderBy('id', 'desc')
            ->first();
        return view('frontauth/productBarnsDetails', compact(['productId', 'products','subcategories']));
    }

    public function storeProductBarnsDetails(ProductBarnsDetailsRequest $request)
    {
        $user = Auth::user();
        $validatedData = $request->all();
        $product = $this->productService->createProductBarnsDetails($validatedData, $user);
        if (!$product) {
            return redirect()->back()->with('error', 'Failed to create product details.');
        } else {
            return redirect()->route('productList')->with('success', 'Product store successfully.');
        }
    }
    


    //------Service & jobs------- 0004 //
    public function productServiceDetails(Request $request)
    {
        $user = auth::user();
        $productExists = Product::where(['id' => $request->id, 'deleted_at' => null, 'user_id' => $user->id])->first();
        if (!$productExists) {
            return redirect()->route('product')->with('error', 'This product is not available.');
        }
        if($productExists->product_status=="sold"){
             return redirect()->back()->with('error', 'This product has been sold and can no longer be updated.');
        }
        $productId = $request->query('id'); // Get the product ID from the query string
        $subcategories = SubCategory::where(['category_id' => $productExists->category_id, 'deleted_at' => null])->pluck('name', 'id')->toArray();

        $products = Product::with([
            'productDetail',
            'category',
            'jobListingType',
            'service',
            'contractTypes',
            'assistanceUpcomingShows',
        ])
            ->where(['id' => $request->id, 'deleted_at' => null, 'user_id' => $user->id])
            ->orderBy('id', 'desc')
            ->first();
        return view('frontauth/productServiceDetails', compact(['productId', 'products','subcategories']));
    }

    public function storeProductServiceDetails(ProductServiceDetailsRequest $request)
    {
        $user = Auth::user();
        $validatedData = $request->all();
        $product = $this->productService->createProductServiceJobsDetails($validatedData, $user);
        if (!$product) {
            return redirect()->back()->with('error', 'Failed to create product details.');
        } else {
            return redirect()->route('productList')->with('success', 'Product store successfully.');
        }
    }


    public function toggleFavorite($productId)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        $favorite = Favorite::where(['user_id' => $user->id, 'product_id' => $productId])->first();

        if ($favorite) {
            // Remove favorite
            $favorite->delete();
            return response()->json(['message' => 'Removed from favorites', 'favorited' => false]);
        } else {
            // Add favorite
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            return response()->json(['message' => 'Added to favorites', 'favorited' => true]);
        }
    }

    // product rating
    public function addRating(AddRatingRequest $request)
    {
        try {
            $data = $request->validated();

            $this->ratingService->storeRating(auth()->id(), $data);

            return redirect()->back()->with('success', 'Rating submitted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit rating.');
        }
    }

    // product bid store
    public function bidStore(StoreBidRequest $request)
    {
        $data = $request->validated();
        if(Auth::check() != true)
        {
            return redirect()->back()->with('error', 'Please login first!');
        }
        $data['user_id'] = Auth::id();

        $product = Product::where(['id' => $data['product_id'], 'user_id' => $data['user_id']])->first();
        if(!empty($product))
        {
            return redirect()->back()->with('error', 'You are not able to add bid!');
        }
        $highestBid = ProductBid::where(['product_id'=>$data['product_id']])->where('amount','>=',$data['amount'])->orderBy('amount', 'desc')->first();
        if($highestBid)
        {
            return redirect()->back()->with('error', 'Your bid amount must be greater than the current bid amount!');
        }

        $bid = $this->bidService->create($data);
        return redirect()->back()->with('success', 'Bid placed successfully!');        
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'product_status' => 'required|string|in:live,sold'
        ]);

        $product = Product::find($request->product_id);
        $product->product_status = $request->product_status;
        $product->save();

        return response()->json(['success' => true, 'message' => 'Product status updated.']);
    }

    public function productBidDetail($id)
    {
        $product = Product::with(
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
            'productBids'
        )->whereId($id)->first();
        return view('frontauth.bidDetails', compact('product'));
    }

    // checkout
    public function checkout($id)
    {
        $products = Product::with(
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
            'productBids'
        )->whereId($id)->first();
        return view('front.checkout_new', compact('products'));
    }

    // checkout
    public function paymentCheckout(CheckoutRequest $request, $id)
    {
        $data = $request->validated();

        if (!Auth::check()) {
            return redirect()->back()->with('error', 'To join this event, please log in to your account.');
        }
        $user = Auth::user();
        $product = Product::with(
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
            'productBids'
        )->whereId($id)->first();

        if(empty($product))
        {
            return redirect()->back()->with('error', "Data not found.");
        }

        if($product->sale_method == 'auction' && $product->transaction_method == 'closed')
        {
            $exits = Order::where(['product_id' => $id, 'user_id'])->first();
            if($exits){
                return redirect()->back()->with('warning', "You're already purchase this product.");
            }
        }
        
        if($product->sale_method == 'platform' && $product->transaction_method == 'live' && $product->category_id == 4)
        {
            $currentDate = Carbon::now()->toDateString();
            $exits = Order::where(['product_id' => $id, 'user_id', 'service_date' => $currentDate])->first();
            if($exits){
                return redirect()->back()->with('warning', "You're already purchase this product.");
            }
        }
        $service_date = $data['service_date'] ?? '';
        $result = $this->checkoutService->process($data, $product, $user->id, $service_date);
        if($result['success'] == false)
        {
            return redirect()->back()->with('error', $result['message']);
        }

        if(isset($data['service_date']))
        {
            return [
                'success' => true,
                'message' => 'success',
                'redirect_url' => $result['url']
            ];
        }
        return redirect($result['url']);

    }

    public function success(Request $request)
    {
        
        $sessionId = $request->query('session_id');
        $productId = $request->query('product_id');

        if (!$sessionId) {
            return redirect()->back()->with('error', "Missing session ID. Payment failed.");
        }
        $user = Auth::user();  
        
        $result = $this->checkoutService->success($sessionId, $productId, $user);
        
        if($result['success'] == false)
        {
            return redirect()->back()->with('error', $result['message']);
        }

        return redirect()->route('home')->with('success', $result['message']);
    }


}
