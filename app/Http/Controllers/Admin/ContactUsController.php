<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Auth;
use App\Services\API\v1\ContactUsService;

class ContactUsController extends Controller
{
    protected $enquiryService;

    public function __construct(ContactUsService $enquiryService)
    {
        $this->enquiryService = $enquiryService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['user_id', 'search']);
        
        $enquiries = $this->enquiryService->getEnquiries($filters);
        $adminId = Auth::user()->role;
        $users = User::withoutTrashed()->where('role', '!=', $adminId)->orderBy('name')->get();
        
        return view('admin.enquiry.index', compact('enquiries', 'users'));
    }

    public function show($id)
    {
        $contactUs = ContactUs::with('user')->findOrFail($id);
        return view('admin.enquiry.show', compact('contactUs'));
    }

    public function destroy($id)
    {
        $this->enquiryService->delete($id);
        return redirect()->route('enquiries.index')->with('success', 'ContactUs soft-deleted.');
    }

    // Restore a deleted category
    public function restore($id)
    {
        $this->enquiryService->restore($id);
        return redirect()->route('enquiries.index')->with('success', 'ContactUs restored successfully!');
    }
}
