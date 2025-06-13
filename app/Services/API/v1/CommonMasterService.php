<?php

namespace App\Services\API\v1;

use App\Models\CommonMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Resources\API\v1\user\CommonMasterResource;

class CommonMasterService
{
    /**
     * Get paginated list of common masters.
     *
     * @param  int  $perPage
     * @return LengthAwarePaginator
     */
    public function getByCategoryId(int $categoryId)
    {
        if (!Auth::guard('sanctum')->check()) {
            return [
                'success' => false,
                'message' => 'Invalid credentials.',
                'code'    => 401
            ];
        }

        // Fetch common master by categoryId
        $commonMaster = CommonMaster::where('category_id', $categoryId)->orderBy('name');
        $total = $commonMaster->count();
        $commonMaster = $commonMaster->get();


        if ($commonMaster->isEmpty()) {
            return [
                'success' => false,
                'message' => 'No common master found.', // More accurate message
                'code'    => 200
            ];

        }

        // Group by 'type'
        $grouped = $commonMaster->groupBy('type')->mapWithKeys(function ($items, $type) {
            return [$type => CommonMasterResource::collection($items)];
        });

        return [
            'success' => true,
            'data'    => $grouped,
            'total'    => $total,
            'code'    => 200
        ];
    }
}
