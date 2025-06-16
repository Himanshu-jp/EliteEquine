<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use App\Http\Requests\API\v1\ProductRequest;
use App\Http\Requests\API\v1\ProductListRequest;
use App\Http\Requests\API\v1\ProductFilterRequest;
use App\Http\Requests\API\v1\ProductShowRequest;
use App\Services\API\v1\ProductService;
use App\Http\Resources\API\v1\user\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Community;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProductController extends BaseController
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    
    /**
     * Store a newly created product.
     */
    public function store(ProductRequest $request): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return $this->sendError('Unauthorized', 'Invalid credentials.', 401);
        }
        // check profile or setting update
        $checkResult = checkProfileSettingUpdate($user);
        if (!$checkResult['success']) 
        {
            return $this->sendError('Failed to fetch products.', $checkResult['message'], $checkResult['code']);
        }

        $data = $request->all();

        $product = $this->productService->createUpdateProduct($data, $user);
        if (!$product) {
            return $this->sendError('Server Error', 'Failed to create product. Please try again later.', 500);
        }
        $data['productId'] = $product->id;
        $productDetail = $this->productService->createUpdateProductDetails($data, $user);

        if (!$productDetail) {
            return $this->sendError('Server Error', 'Failed to create product. Please try again later.', 500);
        }
        $productData = Product::find($product->id);
        return $this->sendResponse(new ProductResource($productData), 'Product created successfully.');
    }

    /** 
     * product List
    */
    public function allProductList(ProductListRequest $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return $this->sendError('Unauthorized', 'Invalid credentials.', 401);
        }
        // check profile or setting update
        $checkResult = checkProfileSettingUpdate($user);
        if (!$checkResult['success']) 
        {
            return $this->sendError('Failed to fetch products.', $checkResult['message'], $checkResult['code']);
        }
        $userId = $request->user_id ?? '';
        $categoryId = $request->category_id ?? 0;
        $productStatus = $request->product_status ?? 'all';

        // Pass productStatus to service
        $result = $this->productService->getAllProduct(
            $request->page,
            // $request->index,
            $categoryId,
            $userId,
            $productStatus
        );

        if (!$result['success']) {
            return $this->sendError('Failed to fetch products.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Product fetched successfully.', $result['total']);
    }

    /** 
     * product filter
    */
    public function filterProducts(ProductFilterRequest $request)
    {
        $user = Auth::guard('sanctum')->user();
        
        if (!$user) {
            return $this->sendError('Unauthorized', 'Invalid credentials.', 401);
        }
        // check profile or setting update
        /* $checkResult = checkProfileSettingUpdate($user);
        if($checkResult['success'] == false)
        {
            return $this->sendError('Failed to fetch products.', $checkResult['message'], $checkResult['code']);
        } */
        // Get validated input including lease price range, sort, pagination, etc.
        $filters = $request->validated();

        // Call the service method and pass filters array
        $result = $this->productService->filterProducts($filters);

        if (!$result['success']) {
            return $this->sendError('Failed to fetch products.', $result['message'], $result['code']);
        }

        $total = $result['total']; 
        $limit = 10;
        $page = max(1, (int) $request->page);

        // Calculate the index (offset)
        $index = ($page - 1) * $limit;

        $products = $result['data']
            ->distinct()
            ->offset($index)
            ->limit($limit)
            ->get();
                
        // Return collection wrapped in resource and include total count
        return $this->sendResponse(ProductResource::collection($products), 'Product filter fetched successfully.', $result['total']);
    }

    
    /** 
     * product detail
    */
    public function show(ProductShowRequest $request)
    {
         $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return $this->sendError('Unauthorized', 'Invalid credentials.', 401);
        }

        $product = Product::where(['id' => $request->product_id])->first();

        if (!$product) {
            return $this->sendError('Not Found or Unauthorized', 'Product not found or unauthorized access.', 200);
        }
        
        return $this->sendResponse(new ProductResource($product), 'Product fetched successfully.');
    }

    /** 
     * product update api
    */
    public function update(ProductRequest $request): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return $this->sendError('Unauthorized', 'Invalid credentials.', 401);
        }

        $data = $request->all();

        $product = $this->productService->createUpdateProduct($data, $user);
        if (!$product) {
            return $this->sendError('Server Error', 'Failed to update product. Please try again later.', 500);
        }

        $data['productId'] = $product->id;

        $productDetail = $this->productService->createUpdateProductDetails($data, $user);
        if (!$productDetail) {
            return $this->sendError('Server Error', 'Failed to update product details. Please try again later.', 500);
        }

        $productData = Product::find($product->id);

        return $this->sendResponse(new ProductResource($productData), 'Product updated successfully.');
    }

    /** 
     * product soft delete
    */
    public function delete(ProductShowRequest $request)
    {
        $user = Auth::guard('sanctum')->user();
        
        if (!$user) {
            return $this->sendError('Unauthorized', 'Invalid credentials.', 401);
        }

        $result = $this->productService->softDeleteProduct($request->product_id, $user);

        if (!$result['success']) {
            return $this->sendError('Failed to fetch products.', $result['message'], $result['code']);
        }
        
        return $this->sendResponse($result['data'], 'Product deleted successfully.');
    }

    // for mapbox
    public function getByCategory(Request $request)
    {
        $categoryId = $request->query('category');

        if (!$categoryId) {
            return response()->json([
                'error' => 'Category parameter is required'
            ], 400);
        }
        
        if(in_array($categoryId, [1,2,3,4]))
        {
            $data = Product::with(['user', 'productDetail', 'image'])
                ->where(['product_status' => 'live', 'deleted_at' => null])
                ->where('category_id', $categoryId)
                ->orderBy('id', 'desc')
                ->get();
        }elseif($categoryId == 5)
        {
            $now = Carbon::now();

            $data = Community::with('user')
                ->whereNull('deleted_at') // or use softDeletes if applicable
                ->where(function ($query) use ($now) {
                    $query->where('date', '>', $now->toDateString())
                        ->orWhere(function ($q) use ($now) {
                            $q->where('date', $now->toDateString())
                                ->where('time', '>=', $now->toTimeString());
                        });
                })
                ->orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->get();
        }

        return response()->json($data);
    }
}
