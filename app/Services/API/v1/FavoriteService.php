<?php

namespace App\Services\API\v1;

use App\Models\Favorite;
use App\Http\Resources\API\v1\user\FavoriteResource;

class FavoriteService
{
    public function index(int $page = 1, $user)
    {
        $userId = $user->id;

        $query = Favorite::where('user_id', $userId)->latest();
        $total = $query->count();

        $limit = 10;
        $page = max(1, (int) $page);

        // Calculate the index (offset)
        $index = ($page - 1) * $limit;

        $favorites = $query
            ->distinct()
            ->offset($index)
            ->limit($limit)
            ->get();

        // $favorites = $query->offset($index)->limit($limit)->get();

        if ($favorites->isNotEmpty()) {
            return [
                'success' => true,
                'data' => FavoriteResource::collection($favorites),
                'total' => $total,
                'code' => 200
            ];
        }

        return [
            'success' => false,
            'message' => 'No favorite found.',
            'code' => 200
        ];
    }

    public function add(int $productId, $user)
    {
        $userId = $user->id;

        // Enforce max 10 favorites per user
        $favoriteCount = Favorite::where('user_id', $userId)->count();
        if ($favoriteCount >= 10) {
            return [
                'success' => false,
                'message' => 'You have reached the limit of 10 favorites.',
                'code' => 200
            ];
        }

        // Prevent duplicates
        $exists = Favorite::where('user_id', $userId)
                          ->where('product_id', $productId)
                          ->exists();

        if ($exists) {
            return [
                'success' => false,
                'message' => 'You have already favorited this product.',
                'code' => 200
            ];
        }

        $favorite = Favorite::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        return [
            'success' => true,
            'data' => new FavoriteResource($favorite),
            'code' => 200
        ];
    }

    public function delete(int $id, $user)
    {
        $userId = $user->id;

        $favorite = Favorite::where('id', $id)
                            ->where('user_id', $userId)
                            ->first();

        if ($favorite) {
            $favorite->delete();

            return [
                'success' => true,
                'data' => [],
                'code' => 200
            ];
        }

        return [
            'success' => false,
            'message' => 'No favorite found.',
            'code' => 200
        ];
    }
}
