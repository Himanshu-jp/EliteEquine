<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Front\ProductService;

class SoldController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function sold()
    {
        return view('front/sold');
    }

    public function soldDataTable()
    {
        $result = $this->productService->getSoldProducts(12);
        $total = $result['total'];
        $data = $result['data'];
        $viewMode = 'grid';
        // $viewMode = $request->view_mode;
        $html = view('front/card', compact('data', 'total', 'viewMode'))->with('columnClass', 'col-lg-3')->render();
        $pagination = $data->withQueryString()->links('pagination::bootstrap-4')->render();
 
        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'total' => $total
        ]);
    }
}
