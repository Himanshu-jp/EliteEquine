<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\API\v1\user\CommonMasterResource;
use App\Services\API\v1\CommonMasterService;
use App\Http\Requests\API\v1\CommonMasterRequest;
use App\Http\Controllers\API\v1\BaseController;
use App\Models\CommonMaster;

class CommonMasterController extends BaseController
{
    protected $commonMasterService;

    public function __construct(CommonMasterService $commonMasterService)
    {
        $this->commonMasterService = $commonMasterService;
    }

    /**
     * Display a paginated list of common masters.
     *
     * @return JsonResponse
     */
    public function index(CommonMasterRequest $request)
    {
        $result = $this->commonMasterService->getByCategoryId($request->category_id);

        if (!$result['success']) {
            return $this->sendError('Failed to fetch common master.', $result['message'], $result['code']);
        }

        return $this->sendResponse($result['data'], 'Common master fetched successfully.',  $result['total']);
    }
}
