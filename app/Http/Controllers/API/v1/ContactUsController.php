<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\v1\BaseController;
use App\Http\Requests\API\v1\ContactUsRequest;
use App\Http\Resources\API\v1\user\ContactUsResource;
use App\Services\API\v1\ContactUsService;
use Illuminate\Support\Facades\Auth;

class ContactUsController extends BaseController
{
    protected ContactUsService $contactUsService;

    public function __construct(ContactUsService $contactUsService)
    {
        $this->contactUsService = $contactUsService;
    }

    public function submit(ContactUsRequest $request)
    {
        $user = Auth::guard('sanctum')->user();
        
        if (!$user) {
            return $this->sendError('Unauthorized', 'Invalid credentials.', 401);
        }
        
        $data = $request->validated();
        $data['user_id'] = $user->id;

        $result = $this->contactUsService->saveContact($data);

        if ($result['success']) {
            return $this->sendResponse(new ContactUsResource($result['data']), 'Contact message submitted successfully.');
        } else {
            return $this->sendError('Failed to add contact us.', $result['message'], $result['code']);
        }
    }
}
