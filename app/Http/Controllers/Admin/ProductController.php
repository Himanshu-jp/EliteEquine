<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\API\v1\ProductService;
use App\Http\Requests\API\v1\ProductFilterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\SubCategory;


class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(ProductFilterRequest $request)
    {
        $filters = $request->all();
        $result = $this->productService->filterProducts($filters);

        if (!$result['success']) {
            return redirect()->back()->with('error', $result['message']);
        }
        $products = $result['data']->orderBy('id', 'desc')->paginate(10);
        $categories = Category::orderBy('name')->get();
        $subcategories = SubCategory::withoutTrashed()->orderBy('name')->get();
        $adminId = Auth::user()->role;
        $users = User::withoutTrashed()->where('role', '!=', $adminId)->orderBy('name')->get();
        // $categories = Category::orderBy('name')->get();
        return view('admin.products.index', compact('products', 'categories', 'users', 'subcategories'));
    }

    public function show($id)
    {
        $product = Product::with(['user', 'category', 'subcategory.category'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function countFeature($categoryId)
    {
        $count = Product::where(['category_id' => $categoryId, 'feature' => true])->count();
        return response()->json(['count' => $count]);
    }

    public function toggleStatus($id, $categoryId)
    {
        $status = '1';
        $product = Product::where(['id' => $id, 'category_id' => $categoryId])->first();
        if(empty($product))
        {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }

        if($product->product_status == 'sold' && $product->feature != '1')
        {
            return response()->json(['success' => false, 'message' => 'Product has been sold.']);
        }
        
        if($product->product_status == 'expire' && $product->feature != '1')
        {
            return response()->json(['success' => false, 'message' => 'Product has been expired.']);
        }
        
        if($product->feature == '1')
        {
            $status = '0';
        }
        $product->feature = $status;
        $product->save();

        return response()->json(['success' => true, 'message' => 'Feature status updated.']);
    }

    /** 
     * get type according category
    */
    public function getSubcategoryByCategory($categoryId)
    {
        // Assuming you have a relation set like Category hasMany Types
        $subcategories = SubCategory::where('category_id', $categoryId)->get();

        if (!$subcategories) {
            return response()->json(['subcategories' => []], 404);
        }

        return response()->json(['subcategories' => $subcategories]);
    }
}
