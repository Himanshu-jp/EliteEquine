<?php

namespace App\Services\API\v1;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductDocument;
use App\Models\ProductImage;
use App\Models\ProductRelation;
use App\Models\ProductVideo;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\API\v1\user\ProductResource;
use FFMpeg;

class ProductService
{
    public function createUpdateProduct($data,$user)
    {
        if (isset($data['product_id'])) {
            $product = Product::where(['id' => $data['product_id'], 'user_id' => $user->id])->where('product_status', '!=', 'sold')->first();
            // If no product is found, return an error message
            if (!$product) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You are not authorized to edit this product or the product is already sold.'
                ], 403);
            }
        } else {
            $product = new Product();
            $product->user_id = $user->id;
        }
        
        $product->sale_method = $data['sale_method'];
        $product->title = $data['title'];
        $product->slug = Str::slug($data['title'], '-');
        $product->price = $data['price'];
        $product->is_negotiable = (isset($data['is_negotiable']) && $data['is_negotiable'] == 'on') ? 'yes' : 'no';
        $product->currency = $data['currency'];
        $product->transaction_method = $data['transaction_method'];
        $product->description = $data['description'];
        $product->external_link = $data['external_link'];
        $product->created_at = Carbon::now();
        $product->updated_at = Carbon::now();
        $product->save();


        // Handle file uploads
        $imagePaths = [];
        if (isset($data['image'])) {

            $existingImages = ProductImage::where('product_id', $product->id)->get();
            foreach ($existingImages as $video) {
                // Delete the file from storage
                if ($video->image && Storage::disk('public')->exists($video->image)) {
                    Storage::disk('public')->delete($video->image);
                }
            }
            // Delete existing images for the product
            ProductImage::where('product_id', $product->id)->delete();

            foreach ($data['image'] as $key => $image) {
                $imagePath = $image->store('products/images', 'public');
                $imagePaths[$key]['product_id'] = $product->id;
                $imagePaths[$key]['image'] = $imagePath;
                $imagePaths[$key]['created_at'] = Carbon::now();
                $imagePaths[$key]['updated_at'] = Carbon::now();
            }
        }
        // Store the image paths in the database
        $imageResult = ProductImage::insert($imagePaths);


        // Store the image paths in the database
        $videoPaths = [];
        if (isset($data['video'])) {

            $existingVideos = ProductVideo::where('product_id', $product->id)->get();
            foreach ($existingVideos as $video) {
                // Delete the file from storage
                if ($video->video_url && Storage::disk('public')->exists($video->video_url)) {
                    Storage::disk('public')->delete($video->video_url);
                }
                if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
                    Storage::disk('public')->delete($video->thumbnail);
                }
            }
            // Delete existing video for the product
            ProductVideo::where('product_id', $product->id)->delete();

            foreach ($data['video'] as $key => $video) {
                $videoPath = $video->store('products/videos', 'public');
                $thumbnailFilename = Str::uuid() . '.jpg';
                $thumbnailPath = 'products/thumbnails/' . $thumbnailFilename;

                // Generate Thumbnail using FFmpeg
                FFMpeg::fromDisk('public')
                    ->open($videoPath)  
                    ->getFrameFromSeconds(1)
                    ->export()
                    ->toDisk('public')
                    ->save($thumbnailPath);

                $videoPaths[$key]['product_id'] = $product->id;
                $videoPaths[$key]['video_url'] = $videoPath;
                $videoPaths[$key]['thumbnail'] = $thumbnailPath;
                $videoPaths[$key]['created_at'] = Carbon::now();
                $videoPaths[$key]['updated_at'] = Carbon::now();
            }
        }
        // Store the vidoe paths in the database
        $videoResult = ProductVideo::insert($videoPaths);

        $documentPaths = [];
        if (isset($data['document'])) {

            $existingdocuments = ProductDocument::where('product_id', $product->id)->get();
            foreach ($existingdocuments as $video) {
                // Delete the file from storage
                if ($video->file && Storage::disk('public')->exists($video->file)) {
                    Storage::disk('public')->delete($video->file);
                }
            }
            // Delete existing document for the product
            ProductDocument::where('product_id', $product->id)->delete();

            foreach ($data['document'] as $key => $document) {
                $documentPath = $document->store('products/documents', 'public');
                $documentPaths[$key]['product_id'] = $product->id;
                $documentPaths[$key]['file'] = $documentPath;
                $documentPaths[$key]['created_at'] = Carbon::now();
                $documentPaths[$key]['updated_at'] = Carbon::now();
            }
        }
        // Store the document paths in the database
        $documentResult = ProductDocument::insert($documentPaths);
        return $product;
    }

    public function createUpdateProductDetails($data, $user)
    {
        $categoryId = $data['category_id'] ?? null;

        // Fetch or create Product
        $product = Product::where(['id' => $data['productId'], 'user_id' => $user->id])->firstOrFail();
        $product->category_id = $categoryId;
        $product->sub_category = $data['subcategory_ids'] ?? null;
        $product->product_status = 'live';
        $product->updated_at = now();
        $product->save();

        // Check category-specific handling
        switch ($categoryId) {
            case 1:
                $this->handleCategoryOneDetails($data, $user, $product);
                // multi options
                $relationTypes = [
                    'disciplines',
                    'breeds',
                    'colors',
                    'training_show_experiences',
                    'qualifies',
                    'current_fence_height',
                    'potential_fence_height',
                    'tried_upcoming_shows'
                ];

                // Single options
                $singleTypes = [
                    'heights' => 'heights',
                    'sexes' => 'sexes',
                    'green_eligibilities' => 'green_eligibilities'
                ];
                // Save common relations
                $this->saveProductRelations($data, $relationTypes, $singleTypes, $product->id);
                break;
            case 2:
                $this->handleCategoryTwoDetails($data, $user, $product);
                $relationTypes = [
                    'horse_apparels',
                    'rider_apparels',
                    'horse_tacks',
                    'trailer_trucks',
                    'for_barns',
                    'equine_supplements',
                    'conditions',
                    'brands',
                    'horse_sizes',
                    'rider_sizes',
                    'exchanged_upcoming_horse_shows',
                ];

                // Single options
                $singleTypes = [];

                // Save common relations
                $this->saveProductRelations($data, $relationTypes, $singleTypes, $product->id);
                break;
            case 3:
                $this->handleCategoryThreeDetails($data, $user, $product);
                $relationTypes = [
                    'property_types',
                    'stable_amenities',
                    'housing_stables_around_horse_shows',
                    'housing_amenities',
                    // 'realtor',
                    // 'property_manager'
                ];

                // Single options
                $singleTypes = [];

                // Save common relations
                $this->saveProductRelations($data, $relationTypes, $singleTypes, $product->id);
                break;
            case 4:
                $this->handleCategoryFourDetails($data, $user, $product);
                $relationTypes = [
                    'job_listing_types',
                    'services',
                    'contract_types',
                    'assistance_upcoming_shows'
                ];

                // Single options
                $singleTypes = [];

                // Save common relations
                $this->saveProductRelations($data, $relationTypes, $singleTypes, $product->id);
                break;
        }
       
        return $product;
    }

    private function handleCategoryOneDetails($data, $user, $product)
    {
        $productDetail = ProductDetail::firstOrNew([
            'product_id' => $product->id
        ]);

        $productDetail->age = $data['year_born'] ?? null;
        $productDetail->height_id = $data['heights'] ?? null;
        $productDetail->sex_id = $data['sexes'] ?? null;
        $productDetail->green_eligibilitie_id = $data['green_eligibilities'] ?? null;
        $productDetail->fromdate = $data['trial_date_from'] ?? null;
        $productDetail->todate = $data['trial_date_to'] ?? null;
        $productDetail->sale_price = $data['sale_price'] ?? null;
        $productDetail->lease_price = $data['lease_price'] ?? null;
        $productDetail->trainer = $data['trainer'] ?? null;
        $productDetail->facility = $data['facility'] ?? null;
        $productDetail->sirebloodline = $data['sire_bloodlines'] ?? null;
        $productDetail->dambloodline = $data['dam_bloodlines'] ?? null;
        $productDetail->usef = $data['usef'] ?? null;
        $productDetail->latitude = $data['latitude'] ?? null;
        $productDetail->longitude = $data['longitude'] ?? null;

        if (isset($data['pedigree_chart'])) {
            $productDetail->pedigree_chart = $data['pedigree_chart']->store('products/pedigree_chart', 'public');
        }

        $userDetail = UserDetails::where('user_id', $user->id)->first();

        $productDetail->phone = ($data['contactSet'] ?? false) ? $userDetail->phone : ($data['phone'] ?? null);

        if ($data['addressSet'] ?? false) {
            $productDetail->precise_location = $userDetail->precise_location;
            $productDetail->country = $userDetail->country;
            $productDetail->state = $userDetail->state;
            $productDetail->city = $userDetail->city;
            $productDetail->street = $userDetail->street;
        } else {
            $productDetail->precise_location = $data['precise_location'] ?? null;
            $productDetail->country = $data['country'] ?? null;
            $productDetail->state = $data['state'] ?? null;
            $productDetail->city = $data['city'] ?? null;
            $productDetail->street = $data['street'] ?? null;
        }

        $productDetail->banner = $data['banners'] ?? null;
        $productDetail->agree = $data['agree'] ?? null;
        $productDetail->created_at = now();
        $productDetail->updated_at = now();
        $productDetail->save();
    }

    private function handleCategoryTwoDetails($data, $user, $product)
    {
        $productDetail = ProductDetail::firstOrNew([
            'product_id' => $product->id
        ]);

        // Save pricing-related fields
        $productDetail->sale_price = $data['price'] ?? null;
        $productDetail->hourly_price = $data['hourly_rental_price'] ?? null;
        $productDetail->fixed_price = $data['fixed_rental_price'] ?? null;

        $userDetail = UserDetails::where('user_id', $user->id)->first();

        $productDetail->phone = ($data['contactSet'] ?? false) ? $userDetail->phone : ($data['phone'] ?? null);

        if ($data['addressSet'] ?? false) {
            $productDetail->precise_location = $userDetail->precise_location;
            $productDetail->country = $userDetail->country;
            $productDetail->state = $userDetail->state;
            $productDetail->city = $userDetail->city;
            $productDetail->street = $userDetail->street;
        } else {
            $productDetail->precise_location = $data['precise_location'] ?? null;
            $productDetail->country = $data['country'] ?? null;
            $productDetail->state = $data['state'] ?? null;
            $productDetail->city = $data['city'] ?? null;
            $productDetail->street = $data['street'] ?? null;
        }

        $productDetail->banner = $data['banners'] ?? null;
        $productDetail->agree = $data['agree'] ?? null;
        $productDetail->created_at = now();
        $productDetail->updated_at = now();
        $productDetail->save();
    }

    private function handleCategoryThreeDetails($data, $user, $product)
    {
        $productDetail = ProductDetail::firstOrNew([
            'product_id' => $product->id
        ]);

        $productDetail->stalls_available = $data['stalls_available'] ?? null;
        $productDetail->fromdate = $data['date_avalable_from'] ?? null;
        $productDetail->todate = $data['date_avalable_to'] ?? null;
        $productDetail->sleeps = $data['sleeps'] ?? null;
        $productDetail->daily_board_rental_rate = $data['daily_board_rental_rate'] ?? null;
        $productDetail->monthly_board_rental_rate = $data['monthly_board_rental_rate'] ?? null;
        $productDetail->weekly_board_rental_rate = $data['weekly_board_rental_rate'] ?? null;
        $productDetail->sale_cost = $data['sale_cost'] ?? null;
        $productDetail->realtor = $data['realtor'] ?? null;
        $productDetail->property_manager = $data['property_manager'] ?? null;

        // Optional: handle phone/address if needed like in Category One
        $userDetail = UserDetails::where('user_id', $user->id)->first();
        $productDetail->phone = ($data['contactSet'] ?? false) ? $userDetail->phone : ($data['phone'] ?? null);

        if ($data['addressSet'] ?? false) {
            $productDetail->precise_location = $userDetail->precise_location;
            $productDetail->country = $userDetail->country;
            $productDetail->state = $userDetail->state;
            $productDetail->city = $userDetail->city;
            $productDetail->street = $userDetail->street;
        } else {
            $productDetail->precise_location = $data['precise_location'] ?? null;
            $productDetail->country = $data['country'] ?? null;
            $productDetail->state = $data['state'] ?? null;
            $productDetail->city = $data['city'] ?? null;
            $productDetail->street = $data['street'] ?? null;
        }

        $productDetail->banner = $data['banners'] ?? null;
        $productDetail->agree = $data['agree'] ?? null;

        $productDetail->save();
    }

    private function handleCategoryFourDetails($data, $user, $product)
    {
        $productDetail = ProductDetail::firstOrNew([
            'product_id' => $product->id
        ]);

        // Set job-related salary and pay details
        $productDetail->salary = $data['salary'] ?? null;
        $productDetail->fixed_price = $data['fixed_pay'] ?? null;
        $productDetail->hourly_price = $data['hourly'] ?? null;

        // Set hauling locations and stall availability
        $productDetail->haulings_location_from = $data['haulings_location_from'] ?? null;
        $productDetail->haulings_location_to = $data['haulings_location_to'] ?? null;
        $productDetail->stalls_available_haulings = $data['stalls_available_haulings'] ?? null;

        // Set availability dates
        $productDetail->fromdate = $data['date_avalable_from'] ?? null;
        $productDetail->todate = $data['date_avalable_to'] ?? null;

        // Set contact info
        $userDetail = UserDetails::where('user_id', $user->id)->first();
        $productDetail->phone = ($data['contactSet'] ?? false) ? $userDetail->phone : ($data['phone'] ?? null);

        // Set address
        if ($data['addressSet'] ?? false) {
            $productDetail->precise_location = $userDetail->precise_location;
            $productDetail->country = $userDetail->country;
            $productDetail->state = $userDetail->state;
            $productDetail->city = $userDetail->city;
            $productDetail->street = $userDetail->street;
        } else {
            $productDetail->precise_location = $data['precise_location'] ?? null;
            $productDetail->country = $data['country'] ?? null;
            $productDetail->state = $data['state'] ?? null;
            $productDetail->city = $data['city'] ?? null;
            $productDetail->street = $data['street'] ?? null;
        }

        // Banner and agreement
        $productDetail->banner = $data['banners'] ?? null;
        $productDetail->agree = $data['agree'] ?? null;

        // Set timestamps
        $productDetail->created_at = now();
        $productDetail->updated_at = now();

        // Save to DB
        $productDetail->save();
    }

    private function saveProductRelations(array $data, array $relationTypes, array $singleTypes=[], int $productId)
    {
        // Delete existing relations for the given types (multi + single)
        $typesToDelete = array_merge($relationTypes, array_values($singleTypes));

        ProductRelation::where('product_id', $productId)
            ->whereIn('type', $typesToDelete)
            ->delete();
            
        // Prepare new insert data
        $insertData = [];
        // Multi-option types
        foreach ($relationTypes as $type) {
            if (!empty($data[$type]) && is_array($data[$type])) {
                foreach ($data[$type] as $id) {
                    $insertData[] = [
                        'product_id' => $productId,
                        'common_master_id' => $id,
                        'type' => $type,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Single options
        foreach ($singleTypes as $key => $type) {
            if (!empty($data[$key])) {
                $insertData[] = [
                    'product_id' => $productId,
                    'common_master_id' => $data[$key],
                    'type' => $type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert new data
        if (!empty($insertData)) {
            ProductRelation::insert($insertData);
        }
    }

    /**
     * get all product list
     */
    public function getAllProduct(int $page = 1, int $categoryId = 0,  $userId = null, string $productStatus = 'all')
    {
        $products = Product::withoutTrashed()->orderBy('id', 'desc');

        // Filter by user if userId provided and non-zero
        if (!empty($userId) && $userId != 0) {
            $products = $products->where('user_id', $userId);
        }

        // Filter by category if categoryId is non-zero
        if ($categoryId != 0) {
            $products = $products->where('category_id', $categoryId);
        }

        // Filter by product_status if not 'all'
        if ($productStatus !== 'all') {
            $products = $products->where('product_status', $productStatus);
        }

        // Get total count before pagination
        $total = $products->count();

        // Apply pagination
        $limit = 10;
        $page = max(1, (int) $page);

        // Calculate the index (offset)
        $index = ($page - 1) * $limit;

        $products = $products
            ->distinct()
            ->offset($index)
            ->limit($limit)
            ->get();

        if ($products->isNotEmpty()) {
            return [
                'success' => true,
                'data' => ProductResource::collection($products),
                'total' => $total,
                'code' => 200
            ];
        }

        return [
            'success' => false,
            'message' => 'No product found.',
            'code' => 200
        ];
    }


    /** 
     * product filter api
    */
    public function filterProducts(array $filters)
    {
        // Start the query with necessary relationships
        $query = Product::withoutTrashed()->with(['user', 'category', 'subcategory']);

        // Title filter
        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        // Price filter (min and max price)
        if (isset($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }
        if (isset($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }

        // Lease price filter (min and max)
        if (isset($filters['lease_price_min'])) {
            $query->where('lease_price', '>=', $filters['lease_price_min']);
        }
        if (isset($filters['lease_price_max'])) {
            $query->where('lease_price', '<=', $filters['lease_price_max']);
        }

        // User filter
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // Category filter
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Subcategory filter (correct column assumed: subcategory_id)
        if (!empty($filters['subcategory_id'])) {
            $query->where('sub_category', $filters['subcategory_id']);
        }
        // Subcategory filter (correct column assumed: subcategory_id)
        if (isset($filters['feature'])) {
            $query->where('feature', $filters['feature']);
        }
        // Subcategory filter (correct column assumed: subcategory_id)
        if (isset($filters['status'])) {
            $query->where('product_status', $filters['status']);
        }

        // Sort by product status
        if (!empty($filters['sort_by'])) {
            switch ($filters['sort_by']) {
                case 'live':
                    $query->where('product_status', 'live');
                    break;
                case 'expire':
                    $query->where('product_status', 'expire');
                    break;
                case 'sold':
                    $query->where('product_status', 'sold');
                    break;
            }
        }

        // Sorting order (asc or desc)
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $products = $query->distinct()->orderBy('id', $sortOrder);

        // Pagination logic
        /* $limit = $filters['limit'] ?? 10;  // Default limit to 10
        $index = $filters['index'] ?? 0;   // Default index to 0
        $page = floor($index / $limit) + 1; */

        // Paginate results with page and limit
        // $products = $query->paginate($page);
        // $products = $query->paginate($limit, ['*'], 'page', $page);

        // Check if products are found
        if (!empty($products)) {
            return [
                'success' => true,
                'data' => $products,
                'total' => $query->get()->count(),
                'code' => 200,
            ];
        }

        return [
            'success' => false,
            'message' => 'No product found.',
            'code' => 200,
        ];
    }



    /**
     * Soft delete a product
     */
    public function softDeleteProduct(int $productId, $user)
    {
        $product = Product::where('id', $productId)
                        ->where('user_id', $user->id)
                        ->first();

        if (!$product) {
            return [
                'success' => false,
                'message' => 'Product not found or unauthorized.',
                'code' => 404
            ];
        }

        if ($product->product_status === 'sold') {
            return [
                'success' => false,
                'message' => 'Cannot delete a sold product.',
                'code' => 403
            ];
        }

        $product->delete();

        return [
            'success' => true,
            'data' => [],
            'message' => 'Product deleted successfully.',
            'code' => 200
        ];
    }
}
