<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CommonMasterRequest;
use App\Http\Requests\Admin\ToggleCommonMasterStatusRequest;
use App\Models\CommonMaster;
use App\Models\Category; 
use App\Services\Admin\CommonMasterService;
use App\Enums\CommonMasterType;

class CommonMasterController extends Controller
{
    protected $commonMasterService;

    public function __construct(CommonMasterService $commonMasterService)
    {
        $this->commonMasterService = $commonMasterService;
    }

    public function index(Request $request)
    {
        $query = CommonMaster::withoutTrashed()->with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $masters = $query->orderBy('id', 'desc')->paginate(10)->appends($request->query());

        // Dynamic type list
        $types = CommonMaster::withoutTrashed()->select('type')->distinct()->pluck('type');
        $categories = Category::orderBy('name')->get();
        // $masters = $this->commonMasterService->all();
        return view('admin.common_master.index', compact('masters', 'categories', 'types'));
    }

    public function create()
    {
        $categories = Category::all(); 
        $typeOptions = CommonMasterType::getValues();
        return view('admin.common_master.create', compact('categories', 'typeOptions'));
    }

    public function store(CommonMasterRequest $request)
    {
        $data = $request->validated();
        $commonMaster = $this->commonMasterService->create($data);
        return redirect()->route('common-masters.index')->with('success', 'Common Master created successfully.');
    }

    public function edit($id)
    {
        $commonMaster = $this->commonMasterService->find($id);
        $categories = Category::all();
        
        $typeOptions = CommonMasterType::getValues();
        return view('admin.common_master.edit', compact('commonMaster', 'categories', 'typeOptions'));
    }

    public function show($id)
    {
        $commonMaster = $this->commonMasterService->find($id);
        return view('admin.common_master.show', compact('commonMaster'));
    }

    public function update(CommonMasterRequest $request, CommonMaster $commonMaster)
    {
        $data = $request->validated();
        $this->commonMasterService->update($commonMaster, $data);
        return redirect()->route('common-masters.index')->with('success', 'Common Master updated successfully.');
    }

    public function destroy(CommonMaster $commonMaster)
    {
        $this->commonMasterService->delete($commonMaster);
        return redirect()->route('common-masters.index')->with('success', 'Common Master deleted successfully.');
    }

    public function restore(CommonMaster $commonMaster)
    {
        $this->commonMasterService->restore($commonMaster);
        return redirect()->route('common-masters.index')->with('success', 'Common Master restored successfully.');
    }

    public function toggleStatus(ToggleCommonMasterStatusRequest $request, CommonMaster $commonMaster)
    {
        $this->commonMasterService->updateStatus($commonMaster, $request->input('status'));
        return response()->json(['status' => 'success', 'message' => 'Common Master status updated successfully.']);
    }

    /** 
     * get type according category
    */
    public function getTypesByCategory($categoryId)
    {
        // Assuming you have a relation set like Category hasMany Types
        $types = CommonMaster::where('category_id', $categoryId)->distinct()->pluck('type');

        if (!$types) {
            return response()->json(['types' => []], 404);
        }

        return response()->json(['types' => $types]);
    }
}
