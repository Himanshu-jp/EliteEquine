<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Front\ContactUsRequest;
use App\Services\API\v1\ContactUsService;

class ContactUsController extends Controller
{
    protected $contactUsService;

    public function __construct(ContactUsService $contactUsService)
    {
        $this->contactUsService = $contactUsService;
    }

    public function show()
    {
        return view('front.contact_us'); 
    }

    public function submit(ContactUsRequest $request): RedirectResponse
    {
        $this->contactUsService->saveContact($request->validated());

        return redirect()->back()->with('success', 'Your message has been sent successfully.');
    }
}
