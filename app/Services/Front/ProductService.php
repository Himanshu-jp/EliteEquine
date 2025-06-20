<?php

namespace App\Services\Front;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductDocument;
use App\Models\ProductImage;
use App\Models\ProductLink;
use App\Models\ProductRelation;
use App\Models\ProductSubCategory;
use App\Models\ProductVideo;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Jobs\EmailSendJob;

use DateTime;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Storage;
use FFMpeg;

class ProductService
{
    public function createProduct($data, $user)
    {
        if (isset($data['id'])) {
            $product = Product::where(['id' => $data['id'], 'user_id' => $user->id])->first();
        } else {
            $product = new Product();
            $product->user_id = $user->id;
        }
        $product->sale_method = $data['sale_method'];
        $product->transaction_method = $data['transaction_method'];
        $product->bid_expire_date = $data['bid_end_date'];
        $product->category_id = $data['category'];
        // $product->return_available = $data['return_available'];                 
        // $product->return_days = $data['return_days'];
        $product->title = $data['title'];
        $product->slug = Str::slug($data['title'], '-');
        $product->price = $data['price'];
        $product->is_negotiable = (isset($data['is_negotiable']) && $data['is_negotiable'] == 1) ? 'yes' : 'no';
        $product->is_motivated_seller = (isset($data['is_motivated_seller']) && $data['is_motivated_seller'] == 1) ? 'yes' : 'no';
        $product->price_reduced = (isset($data['price_reduced']) && $data['price_reduced'] == 1) ? 'yes' : 'no';
        $product->currency = $data['currency'];
        $product->description = $data['description'];
        $product->product_status = ($product->product_status) ? $product->product_status : 'pending';
        $product->created_at = Carbon::now();
        $product->updated_at = Carbon::now();
        $product->save();


        if ($data['bid_min_price'] != "") {
            $productDetail = ProductDetail::where('product_id', $product->id)->first();
            if (!$productDetail) {
                $productDetail = new ProductDetail();
                $productDetail->product_id = $product->id;
                $productDetail->bid_min_price = $data['bid_min_price'];
                $productDetail->created_at = Carbon::now();
                $productDetail->updated_at = Carbon::now();
                $productDetail->save();
            } else {
                $productDetail->bid_min_price = $data['bid_min_price'];
                $productDetail->created_at = Carbon::now();
                $productDetail->updated_at = Carbon::now();
                $productDetail->save();
            }
        }

        $externalLink = [];
        if (!empty($data['external_link']) && is_array($data['external_link']) && count($data['external_link']) > 0 && !empty($data['external_link'][0])) {
            foreach ($data['external_link'] as $key => $link) {
                $externalLink[$key]['product_id'] = $product->id;
                $externalLink[$key]['link'] = $link;
                $externalLink[$key]['type'] = "web";
                $externalLink[$key]['created_at'] = Carbon::now();
                $externalLink[$key]['updated_at'] = Carbon::now();
            }
            ProductLink::where('product_id', $product->id)->where('type', 'web')->delete();
            $linkResult = ProductLink::insert($externalLink);
        }

        $videoLink = [];
        if (!empty($data['video_link']) && is_array($data['video_link']) && count($data['video_link']) > 0 && !empty($data['video_link'][0])) {
            foreach ($data['video_link'] as $key => $link) {
                $videoLink[$key]['product_id'] = $product->id;
                $videoLink[$key]['link'] = $link;
                $videoLink[$key]['type'] = "video";
                $videoLink[$key]['created_at'] = Carbon::now();
                $videoLink[$key]['updated_at'] = Carbon::now();
            }
            ProductLink::where('product_id', $product->id)->where('type', 'video')->delete();
            $videoLinkResult = ProductLink::insert($videoLink);
        }



        // Handle file uploads
        $imagePaths = [];
        if (isset($data['image_uploads'])) {

            $key = 0;
            foreach ($data['image_uploads'] as $image) {
                $imagePaths[$key]['product_id'] = $product->id;
                $imagePaths[$key]['image'] = $image;
                $imagePaths[$key]['created_at'] = Carbon::now();
                $imagePaths[$key]['updated_at'] = Carbon::now();
                $key++;
            }
        }
        // Store the image paths in the database
        $imageResult = ProductImage::insert($imagePaths);

        $videoPaths = [];
        if (isset($data['video_uploads'])) {


            $key = 0;

            foreach ($data['video_uploads'] as $video) {
                $videoPaths[$key]['product_id'] = $product->id;
                $videoPaths[$key]['video_url'] = $video['video_url'] ?? $video->video_url;
                $videoPaths[$key]['thumbnail'] = $video['thumbnail_url'] ?? $video->thumbnail_url;
                $videoPaths[$key]['created_at'] = Carbon::now();
                $videoPaths[$key]['updated_at'] = Carbon::now();
                $key++;

            }
        }

        // Store the vidoe paths in the database
        $videoResult = ProductVideo::insert($videoPaths);

        $documentPaths = [];
        if (isset($data['document_uploads'])) {
            $key = 0;

            foreach ($data['document_uploads'] as $document) {

                $documentPaths[$key]['product_id'] = $product->id;
                $documentPaths[$key]['file'] = $document;
                $documentPaths[$key]['created_at'] = Carbon::now();
                $documentPaths[$key]['updated_at'] = Carbon::now();
            }
            $key++;

        }
        // Store the document paths in the database
        $documentResult = ProductDocument::insert($documentPaths);



        return $product;
    }

    public function updateProduct($data)
    {
        $product = Product::find($data['product_id']);

        // Update basic fields
        $product->sale_method = $data['sale_method'] ?? $product->sale_method;
        $product->transaction_method = $data['transaction_method'] ?? $product->transaction_method;
        $product->bid_expire_date = $data['bid_end_date'] ?? $product->bid_expire_date;
        $product->title = $data['title'] ?? $product->title;
        $product->slug = Str::slug($product->title, '-');
        $product->price = $data['price'] ?? $product->price;
        $product->currency = $data['currency'] ?? $product->currency;
        $product->description = $data['description'] ?? $product->description;
        // $product->external_link = $data['external_link'] ?? $product->external_link;
        $product->is_negotiable = (isset($data['is_negotiable']) && $data['is_negotiable'] == 1) ? 'yes' : 'no';
        $product->is_motivated_seller = (isset($data['is_motivated_seller']) && $data['is_motivated_seller'] == 1) ? 'yes' : 'no';
        $product->price_reduced = (isset($data['price_reduced']) && $data['price_reduced'] == 1) ? 'yes' : 'no';
        $product->updated_at = now();
        $product->save();

        // --- Handle Images ---
        if (!empty($data['image'])) {
            $this->replaceFiles(
                ProductImage::class,
                $product->id,
                'images',
                $data['image'],
                'products/images',
                'image'
            );
        }

        // --- Handle Videos ---
        if (!empty($data['video'])) {
            $this->replaceFiles(
                ProductVideo::class,
                $product->id,
                'video_url',
                $data['video'],
                'products/videos',
                'video_url'
            );
        }

        // --- Handle Documents ---
        if (!empty($data['document'])) {
            $this->replaceFiles(
                ProductDocument::class,
                $product->id,
                'file',
                $data['document'],
                'products/documents',
                'file'
            );
        }

        return $product;
    }

    protected function replaceFiles($modelClass, $productId, $relation, $newFiles, $path, $column)
    {
        // Delete existing files (if any)
        foreach ($modelClass::where('product_id', $productId)->get() as $oldFile) {
            // Delete file from S3
            Storage::disk('s3')->delete($oldFile->$column);

            // Delete DB record
            $oldFile->delete();
        }

        // Upload new files to S3
        foreach ($newFiles as $file) {
            $storedPath = $file->store($path, 's3'); // Upload to S3

            // (Optional) Make file public
            Storage::disk('s3')->setVisibility($storedPath, 'public');

            $modelClass::create([
                'product_id' => $productId,
                $column =>  Storage::disk('s3')->url($storedPath)
            ]);

            
        }
    }

    //----- Horse data store----//
    public function createProductHorseDetails($data, $user)
    {
         $productDetail = ProductDetail::where(['product_id' => $data['productId']])->first();
        if (!$productDetail) {
            $productDetail = new ProductDetail();
            $productDetail->product_id = $data['productId'];
        }

        //-------save product details table data----------------//
        $productDetail->age = $data['age'];
        $productDetail->height_id = $data['height_id'];
        $productDetail->sex_id = $data['sex_id'];
        $productDetail->green_eligibilitie_id = $data['green_eligibilitie_id'];
        $productDetail->fromdate = $data['fromdate'];
        $productDetail->todate = $data['todate'];
        $productDetail->sale_price = $data['sale_price'];
        $productDetail->lease_price = $data['lease_price'];
        $productDetail->trainer = $data['trainer'];
        $productDetail->facility = $data['facility'];
        $productDetail->sirebloodline = $data['sirebloodline'];
        $productDetail->dambloodline = $data['dambloodline'];
        $productDetail->usef = $data['usef'];
      if (isset($data['pedigree_chart'])) {
    // Store file in S3
    $pedigree_chart = $data['pedigree_chart']->store('products/pedigree_chart', 's3');

    // Make the file publicly accessible
    Storage::disk('s3')->setVisibility($pedigree_chart, 'public');

    // Get full URL
    $pedigree_chart = Storage::disk('s3')->url($pedigree_chart);

} else {
    $pedigree_chart = $productDetail['pedigree_chart'];
}

        $productDetail->pedigree_chart = $pedigree_chart;
        $productDetail->created_at = Carbon::now();
        $productDetail->updated_at = Carbon::now();


        $userDetail = UserDetails::where(['user_id' => $user->id])->first();
        if (@$data['contactSet']) {
            $phone = $userDetail->phone;
        } else {
            $phone = $data['phone'];
        }
        if (@$data['addressSet']) {
            $precise_location = $userDetail->precise_location;
            $country = $userDetail->country;
            $state = $userDetail->state;
            $city = $userDetail->city;
            $street = $userDetail->street;
            $latitude = $userDetail->latitude;
            $longitude = $userDetail->longitude;
        } else {
            $precise_location = $data['precise_location'];
            $country = $data['country'];
            $state = $data['state'];
            $city = $data['city'];
            $street = $data['street'];

            $latitude = $data['latitude'];
            $longitude = $data['longitude'];
        }
 $productDetail->trial_location = @$data['trial_location'];
        $productDetail->trail_latitude = @$data['trail_latitude'];
        $productDetail->trail_longitude = @$data['trail_longitude'];
        $productDetail->phone = $phone;
        $productDetail->precise_location = $precise_location;
        $productDetail->country = $country;
        $productDetail->state = $state;
        $productDetail->city = $city;
        $productDetail->latitude = $latitude;
        $productDetail->longitude = $longitude;
        $productDetail->street = $street;
        $productDetail->banner = $data['banners'];
        $productDetail->agree = $data['agree'];
        $productDetail->save();


        //-------save product table data & enable product status as live----------------//
        $product = Product::where(['id' => $data['productId'], 'user_id' => $user->id])->first();
        $product->product_status = ($product->product_status == "pending") ? 'live' : $product->product_status;
        $product->updated_at = Carbon::now();
        $product->save();


        //-------save product details mulitple data----------------//
        $productId = $product->id;
        $productRemove = ProductRelation::where('product_id', $productId)->delete();
        $insertData = [];

        // Handle sub_category --00--
        if (isset($data['sub_category'])) {
            foreach ($data['sub_category'] as $key => $category) {
                $externalLink[$key]['product_id'] = $productId;
                $externalLink[$key]['category_id'] = $category;
                $externalLink[$key]['created_at'] = Carbon::now();
                $externalLink[$key]['updated_at'] = Carbon::now();
            }
            ProductSubCategory::where('product_id', $product->id)->delete();
            $subCategory = ProductSubCategory::insert($externalLink);
        }

        // Handle disciplines --01--
        if (isset($data['disciplines'])) {
            $insertData = array_merge($insertData, array_map(function ($disciplineId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $disciplineId,
                    'type' => 'disciplines',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['disciplines']));
        }

        // Handle breeds --02--
        if (isset($data['breeds'])) {
            $insertData = array_merge($insertData, array_map(function ($breedId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $breedId,
                    'type' => 'breeds',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['breeds']));
        }

        // Handle colors --03--
        if (isset($data['colors'])) {
            $insertData = array_merge($insertData, array_map(function ($colorId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $colorId,
                    'type' => 'colors',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['colors']));
        }

        // Handle training show experience --04--
        if (isset($data['training_show_experiences'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'training_show_experiences',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['training_show_experiences']));
        }

        // Handle qualifies --05--
        if (isset($data['qualifies'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'qualifies',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['qualifies']));
        }

        // Handle current fence heights --06--
        if (isset($data['current_fence_heights'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'current_fence_height',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['current_fence_heights']));
        }

        // Handle potential fence height --07--
        if (isset($data['potential_fence_heights'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'potential_fence_height',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['potential_fence_heights']));
        }

        // Handle tried upcoming shows --08--
        if (isset($data['tried_upcoming_shows'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'tried_upcoming_shows',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['tried_upcoming_shows']));
        }

        // Handle height_id single option --09--
        if (isset($data['height_id'])) {
            $insertData[] = [
                'product_id' => $productId,
                'common_master_id' => $data['height_id'],
                'type' => 'heights',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Handle sex_id single option --10--
        if (isset($data['sex_id'])) {
            $insertData[] = [
                'product_id' => $productId,
                'common_master_id' => $data['sex_id'],
                'type' => 'sexes',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Handle sex_id single option --11--
        if (isset($data['green_eligibilitie_id'])) {
            $insertData[] = [
                'product_id' => $productId,
                'common_master_id' => $data['green_eligibilitie_id'],
                'type' => 'green_eligibilities',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert all the data at once
        $relationResult = ProductRelation::insert($insertData);

        return $product;
    }

    //----- Equipment data store------//
    public function createProductEquipmentDetails($data, $user)
    {
        $productDetail = ProductDetail::where(['product_id' => $data['productId']])->first();
        if (!$productDetail) {
            $productDetail = new ProductDetail();
            $productDetail->product_id = $data['productId'];
        }

        //-------save product details table data----------------//
        $productDetail->price = $data['price'];
        $productDetail->hourly_price = $data['hourly_price'];
        $productDetail->fixed_price = $data['fixed_price'];
        $productDetail->created_at = Carbon::now();
        $productDetail->updated_at = Carbon::now();

        $userDetail = UserDetails::where(['user_id' => $user->id])->first();
        if (@$data['contactSet']) {
            $phone = $userDetail->phone;
        } else {
            $phone = $data['phone'];
        }
        if (@$data['addressSet']) {
            $precise_location = $userDetail->precise_location;
            $country = $userDetail->country;
            $state = $userDetail->state;
            $city = $userDetail->city;
            $latitude = $userDetail->latitude;
            $longitude = $userDetail->longitude;
            $street = $userDetail->street;
        } else {
            $precise_location = $data['precise_location'];
            $country = $data['country'];
            $state = $data['state'];
            $city = $data['city'];
            $street = $data['street'];
            $latitude = $data['latitude'];
            $longitude = $data['longitude'];
        }
 $productDetail->trial_location = @$data['trial_location'];
        $productDetail->trail_latitude = @$data['trail_latitude'];
        $productDetail->trail_longitude = @$data['trail_longitude'];
        $productDetail->latitude = $latitude;
        $productDetail->longitude = $longitude;
        $productDetail->phone = $phone;
        $productDetail->precise_location = $precise_location;
        $productDetail->country = $country;
        $productDetail->state = $state;
        $productDetail->city = $city;
        $productDetail->street = $street;
        $productDetail->banner = $data['banners'];
        $productDetail->agree = $data['agree'];
        $productDetail->save();


        //-------save product table data & enable product status as live----------------//
        $product = Product::where(['id' => $data['productId'], 'user_id' => $user->id])->first();
        $product->product_status = ($product->product_status == "pending") ? 'live' : $product->product_status;
        $product->updated_at = Carbon::now();
        $product->save();


        //-------save product details mulitple data----------------//
        $productId = $product->id;
        $productRemove = ProductRelation::where('product_id', $productId)->delete();
        $insertData = [];

        // Handle horse_apparel --01--
        if (isset($data['horse_apparel'])) {
            $insertData = array_merge($insertData, array_map(function ($disciplineId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $disciplineId,
                    'type' => 'horse_apparel',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['horse_apparel']));
        }

        // Handle rider_apparel --02--
        if (isset($data['rider_apparel'])) {
            $insertData = array_merge($insertData, array_map(function ($breedId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $breedId,
                    'type' => 'rider_apparel',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['rider_apparel']));
        }

        // Handle horse_tack --03--
        if (isset($data['horse_tack'])) {
            $insertData = array_merge($insertData, array_map(function ($colorId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $colorId,
                    'type' => 'horse_tack',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['horse_tack']));
        }

        // Handle trailer_trucks --04--
        if (isset($data['trailer_trucks'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'trailer_trucks',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['trailer_trucks']));
        }

        // Handle for_barns --05--
        if (isset($data['for_barns'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'for_barns',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['for_barns']));
        }

        // Handle equine_supplements --06--
        if (isset($data['equine_supplements'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'equine_supplements',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['equine_supplements']));
        }

        // Handle conditions --07--
        if (isset($data['conditions'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'conditions',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['conditions']));
        }

        // Handle brands --08--
        if (isset($data['brands'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'brands',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['brands']));
        }

        // Handle horse_sizes --09--
        if (isset($data['horse_sizes'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'horse_sizes',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['horse_sizes']));
        }

        // Handle rider_sizes --10--
        if (isset($data['rider_sizes'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'rider_sizes',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['rider_sizes']));
        }

        // Handle exchanged_upcoming_horse_shows --11--
        if (isset($data['exchanged_upcoming_horse_shows'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'exchanged_upcoming_horse_shows',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['exchanged_upcoming_horse_shows']));
        }


        // Insert all the data at once
        $relationResult = ProductRelation::insert($insertData);

        return $product;
    }

    //----- Barns data store------//
    public function createProductBarnsDetails($data, $user)
    {
        $productDetail = ProductDetail::where(['product_id' => $data['productId']])->first();
        if (!$productDetail) {
            $productDetail = new ProductDetail();
            $productDetail->product_id = $data['productId'];
        }

        //-------save product details table data----------------//
        $productDetail->stalls_available = $data['stalls_available'];
        $productDetail->fromdate = $data['fromdate'];
        $productDetail->todate = $data['todate'];
        $productDetail->sleeps = $data['sleeps'];
        $productDetail->daily_board_rental_rate = $data['daily_board_rental_rate'];
        $productDetail->monthly_board_rental_rate = $data['monthly_board_rental_rate'];
        $productDetail->weekly_board_rental_rate = $data['weekly_board_rental_rate'];
         $productDetail->trial_location = @$data['trial_location'];
        $productDetail->trail_latitude = @$data['trail_latitude'];
        $productDetail->trail_longitude = @$data['trail_longitude'];
        $productDetail->sale_cost = $data['sale_cost'];
        $productDetail->realtor = $data['realtor'];
        $productDetail->property_manager = $data['property_manager'];
        $productDetail->created_at = Carbon::now();
        $productDetail->updated_at = Carbon::now();

        $userDetail = UserDetails::where(['user_id' => $user->id])->first();
        if (@$data['contactSet']) {
            $phone = $userDetail->phone;
        } else {
            $phone = $data['phone'];
        }
        if (@$data['addressSet']) {
            $precise_location = $userDetail->precise_location;
            $country = $userDetail->country;
            $state = $userDetail->state;
            $city = $userDetail->city;
            $street = $userDetail->street;
            $latitude = $userDetail->latitude;
            $longitude = $userDetail->longitude;
        } else {
            $precise_location = $data['precise_location'];
            $country = $data['country'];
            $state = $data['state'];
            $city = $data['city'];
            $latitude = $data['latitude'];
            $longitude = $data['longitude'];
            $street = $data['street'];
        }

        $productDetail->phone = $phone;
        $productDetail->precise_location = $precise_location;
        $productDetail->country = $country;
        $productDetail->state = $state;
        $productDetail->city = $city;
        $productDetail->latitude = $latitude;
        $productDetail->longitude = $longitude;
        $productDetail->street = $street;
        $productDetail->banner = $data['banners'];
        $productDetail->agree = $data['agree'];
        $productDetail->save();


        //-------save product table data & enable product status as live----------------//
        $product = Product::where(['id' => $data['productId'], 'user_id' => $user->id])->first();
        $product->product_status = ($product->product_status == "pending") ? 'live' : $product->product_status;
        $product->updated_at = Carbon::now();
        $product->save();


        //-------save product details mulitple data----------------//
        $productId = $product->id;
        $productRemove = ProductRelation::where('product_id', $productId)->delete();
        $insertData = [];

        // Handle sub_category --00--
        if (isset($data['sub_category'])) {
            foreach ($data['sub_category'] as $key => $category) {
                $externalLink[$key]['product_id'] = $productId;
                $externalLink[$key]['category_id'] = $category;
                $externalLink[$key]['created_at'] = Carbon::now();
                $externalLink[$key]['updated_at'] = Carbon::now();
            }
            ProductSubCategory::where('product_id', $product->id)->delete();
            $subCategory = ProductSubCategory::insert($externalLink);
        }

        // Handle property_types --01--
        if (isset($data['property_types'])) {
            $insertData = array_merge($insertData, array_map(function ($disciplineId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $disciplineId,
                    'type' => 'property_types',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['property_types']));
        }

        // Handle stable_amenities --02--
        if (isset($data['stable_amenities'])) {
            $insertData = array_merge($insertData, array_map(function ($breedId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $breedId,
                    'type' => 'stable_amenities',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['stable_amenities']));
        }

        // Handle housing_stables_around_horse_shows --03--
        if (isset($data['housing_stables_around_horse_shows'])) {
            $insertData = array_merge($insertData, array_map(function ($colorId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $colorId,
                    'type' => 'housing_stables_around_horse_shows',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['housing_stables_around_horse_shows']));
        }

        // Handle housing_amenities --04--
        if (isset($data['housing_amenities'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'housing_amenities',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['housing_amenities']));
        }
        // Insert all the data at once
        $relationResult = ProductRelation::insert($insertData);

        return $product;
    }

    //----- Service & jobs data store------//
    public function createProductServiceJobsDetails($data, $user)
    {
        $productDetail = ProductDetail::where(['product_id' => $data['productId']])->first();
        if (!$productDetail) {
            $productDetail = new ProductDetail();
            $productDetail->product_id = $data['productId'];
        }

        //-------save product details table data----------------//
        $productDetail->fromdate = $data['fromdate'];
        $productDetail->todate = $data['todate'];
        $productDetail->time_slot = $data['time_slot'] ?? '';
        $productDetail->haulings_location_from = $data['haulings_location_from'];
        $productDetail->haulings_location_from_lat = $data['haulings_location_from_lat'];
        $productDetail->haulings_location_from_lng = $data['haulings_location_from_lng'];
        $productDetail->haulings_location_to = $data['haulings_location_to'];
        $productDetail->haulings_location_to_lat = $data['haulings_location_to_lat'];
        $productDetail->haulings_location_to_lng = $data['haulings_location_to_lng'];

        $productDetail->stalls_available_haulings = $data['stalls_available_haulings'];
        $productDetail->salary = $data['salary'];
        $productDetail->hourly_price = $data['hourly_price'];
        $productDetail->fixed_price = $data['fixed_price'];
        $productDetail->created_at = Carbon::now();
        $productDetail->updated_at = Carbon::now();

        $userDetail = UserDetails::where(['user_id' => $user->id])->first();
        if (@$data['contactSet']) {
            $phone = $userDetail->phone;
        } else {
            $phone = $data['phone'];
        }

        if (@$data['addressSet']) {
            $precise_location = $userDetail->precise_location;
            $country = $userDetail->country;
            $state = $userDetail->state;
            $city = $userDetail->city;
            $street = $userDetail->street;
            $latitude = $userDetail->latitude;
            $longitude = $userDetail->longitude;
        } else {
            $precise_location = $data['precise_location'];
            $country = $data['country'];
            $state = $data['state'];
            $city = $data['city'];
            $street = $data['street'];
            $latitude = $data['latitude'];
            $longitude = $data['longitude'];
        }


        $productDetail->phone = $phone;
        $productDetail->precise_location = $precise_location;
        $productDetail->country = $country;
        $productDetail->state = $state;
        $productDetail->city = $city;
        $productDetail->latitude = $latitude;
        $productDetail->longitude = $longitude;
        $productDetail->trial_location = @$data['trial_location'];
        $productDetail->trail_latitude = @$data['trail_latitude'];
        $productDetail->trail_longitude = @$data['trail_longitude'];



        $productDetail->street = $street;
        $productDetail->banner = $data['banners'];
        $productDetail->agree = $data['agree'];
        $productDetail->save();


        //-------save product table data & enable product status as live----------------//
        $product = Product::where(['id' => $data['productId'], 'user_id' => $user->id])->first();
        $product->product_status = ($product->product_status == "pending") ? 'live' : $product->product_status;
        $product->updated_at = Carbon::now();
        $product->save();


        //-------save product details mulitple data----------------//
        $productId = $product->id;
        $productRemove = ProductRelation::where('product_id', $productId)->delete();
        $insertData = [];

        // Handle job_listing_type --01--
        if (isset($data['job_listing_type'])) {
            $insertData = array_merge($insertData, array_map(function ($disciplineId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $disciplineId,
                    'type' => 'job_listing_type',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['job_listing_type']));
        }

        // Handle service --02--
        if (isset($data['service'])) {
            $insertData = array_merge($insertData, array_map(function ($breedId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $breedId,
                    'type' => 'service',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['service']));
        }

        // Handle contract_types --03--
        if (isset($data['contract_types'])) {
            $insertData = array_merge($insertData, array_map(function ($colorId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $colorId,
                    'type' => 'contract_types',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['contract_types']));
        }

        // Handle assistance_upcoming_shows --04--
        if (isset($data['assistance_upcoming_shows'])) {
            $insertData = array_merge($insertData, array_map(function ($pId) use ($productId) {
                return [
                    'product_id' => $productId,
                    'common_master_id' => $pId,
                    'type' => 'assistance_upcoming_shows',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $data['assistance_upcoming_shows']));
        }
        // Insert all the data at once
        $relationResult = ProductRelation::insert($insertData);

        return $product;
    }

    public function getSoldProducts($data)
    {

        $xArray = array('Horses' => 1, 'Equipment' => 2, 'Housing' => 3, 'Services' => 4);
        $data = Product::withoutTrashed()->with([
            'user',
            'productDetail',
            'image',
            'video',
            'document',
            'category',
            'subcategory',
            'disciplines',
            'breeds',
            'colors',
            'trainingShowExperiences',
            'qualifies',
            'currentFenceHeight',
            'potentialFenceHeight',
            'triedUpcomingShows',
            'height',
            'sex',
            'greenEligibilities'
        ])
            ->where('category_id', $xArray[$data['type']])
            ->whereNotIn('product_status', ['pending', 'live', 'expire']);

        $total = $data->get()->count();
        $data = $data->paginate(12);

        return [
            'success' => true,
            'data' => $data,
            'total' => $total
        ];
    }
}
