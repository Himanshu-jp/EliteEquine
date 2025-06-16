<?php

namespace App\Services\Front;

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
use FFMpeg;

class ProductService
{
    public function createProduct($data,$user)
    {
        if (isset($data['id'])) {
            $product = Product::where(['id' => $data['id'], 'user_id' => $user->id])->first();
        } else {
            $product = new Product();
            $product->user_id = $user->id;
        }
        // $product->category_id = $data['category_id'];
        // $product->sub_category = $data['sub_category'];
        $product->sale_method = $data['sale_method'];
        $product->transaction_method = $data['transaction_method'];
        $product->bid_expire_date = $data['bid_end_date'];
        $product->category_id = $data['category'];
        // $product->return_available = $data['return_available'];                 
        // $product->return_days = $data['return_days'];
        $product->title = $data['title'];
        $product->slug = Str::slug($data['title'], '-');
        $product->price = $data['price'];
        $product->is_negotiable = (isset($data['is_negotiable']) && $data['is_negotiable'] == 'on') ? 'yes' : 'no';
        // $product->is_motivated_seller = ($data['is_motivated_seller'] == 'on') ? 1 : 0;
        // $product->price_reduced = ($data['price_reduced'] == 'on') ? 1 : 0;
        $product->currency = $data['currency'];
        $product->description = $data['description'];
        $product->external_link = $data['external_link'];
        // $product->transaction_method = $data['transaction_method'];
        // $product->auc_winner_pay_in = ($data['auc_winner_pay_in'] == 'on') ? 1 : 0;
        // $product->bid_end_days = $data['bid_end_days'];
        // $product->mark_as = $data['mark_as'];
        // $product->product_status = 'live';
        $product->created_at = Carbon::now();
        $product->updated_at = Carbon::now();
        $product->save();


        // Handle file uploads
        $imagePaths = [];
        if (isset($data['image'])) {

            // $existingImages = ProductImage::where('product_id', $product->id)->get();
            // foreach ($existingImages as $video) {
            //     // Delete the file from storage
            //     if ($video->image && Storage::disk('public')->exists($video->image)) {
            //         Storage::disk('public')->delete($video->image);
            //     }
            // }
            // Delete existing images for the product
            // ProductImage::where('product_id', $product->id)->delete();

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

        $videoPaths = [];
        if (isset($data['video'])) {

            // $existingVideos = ProductVideo::where('product_id', $product->id)->get();
            // foreach ($existingVideos as $video) {
            //     // Delete the file from storage
            //     if ($video->video_url && Storage::disk('public')->exists($video->video_url)) {
            //         Storage::disk('public')->delete($video->video_url);
            //     }
            //     if ($video->thumbnail && Storage::disk('public')->exists($video->thumbnail)) {
            //         Storage::disk('public')->delete($video->thumbnail);
            //     }
            // }
            // Delete existing video for the product
            // ProductVideo::where('product_id', $product->id)->delete();

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

            // $existingdocuments = ProductDocument::where('product_id', $product->id)->get();
            // foreach ($existingdocuments as $video) {
            //     // Delete the file from storage
            //     if ($video->file && Storage::disk('public')->exists($video->file)) {
            //         Storage::disk('public')->delete($video->file);
            //     }
            // }
            // Delete existing document for the product
            // ProductDocument::where('product_id', $product->id)->delete();

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
        $product->external_link = $data['external_link'] ?? $product->external_link;
        $product->is_negotiable = (isset($data['is_negotiable']) && $data['is_negotiable'] == 'on') ? 'yes' : 'no';
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
            Storage::disk('public')->delete($oldFile->$column);
            $oldFile->delete();
        }

        // Upload new files
        foreach ($newFiles as $file) {
            $modelClass::create([
                'product_id' => $productId,
                $column => $file->store($path, 'public')
            ]);
        }
    }

    //----- Horse data store----//
    public function createProductHorseDetails($data,$user)
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
        $productDetail->bid_min_price = $data['bid_min_price'];
        $productDetail->sale_price = $data['sale_price'];
        $productDetail->lease_price = $data['lease_price'];
        $productDetail->trainer = $data['trainer'];
        $productDetail->facility = $data['facility'];
        $productDetail->sirebloodline = $data['sirebloodline'];
        $productDetail->dambloodline = $data['dambloodline'];
        $productDetail->usef = $data['usef'];
        $pedigree_chart = (isset($data['pedigree_chart']))?$data['pedigree_chart']->store('products/pedigree_chart', 'public'):$productDetail['pedigree_chart'];
        $productDetail->pedigree_chart = $pedigree_chart;
        $productDetail->created_at = Carbon::now();
        $productDetail->updated_at = Carbon::now();


        $userDetail = UserDetails::where(['user_id' => $user->id])->first();
        if(@$data['contactSet']){
            $phone = $userDetail->phone;
        }else{
            $phone = $data['phone'];
        }
        if(@$data['addressSet']){
            $precise_location = $userDetail->precise_location;
            $country = $userDetail->country;
            $state = $userDetail->state;
            $city = $userDetail->city;
            $street = $userDetail->street;
            $latitude = $userDetail->latitude;
            $longitude = $userDetail->longitude;
        }else{
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
        $productDetail->street = $street;
        $productDetail->banner = $data['banners'];
        $productDetail->agree = $data['agree'];
        $productDetail->save();


        //-------save product table data & enable product status as live----------------//
        $product = Product::where(['id' => $data['productId'], 'user_id' => $user->id])->first();
        // $product->category_id = $data['category'];
        $product->sub_category = $data['sub_category'];
        $product->product_status = 'live';
        $product->updated_at = Carbon::now();
        $product->save();


        //-------save product details mulitple data----------------//
        $productId = $product->id;
        $productRemove = ProductRelation::where('product_id',$productId)->delete();
        $insertData = [];

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
        
        // Handle sex_id single option --09--
        if (isset($data['sex_id'])) {
            $insertData[] = [
                'product_id' => $productId,
                'common_master_id' => $data['sex_id'],
                'type' => 'sexes',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
       
        // Handle sex_id single option --09--
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
    public function createProductEquipmentDetails($data,$user)
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
        if(@$data['contactSet']){
            $phone = $userDetail->phone;
        }else{
            $phone = $data['phone'];
        }
        if(@$data['addressSet']){
            $precise_location = $userDetail->precise_location;
            $country = $userDetail->country;
            $state = $userDetail->state;
            $city = $userDetail->city;
            $latitude = $userDetail->latitude;
            $longitude = $userDetail->longitude;
            $street = $userDetail->street;
        }else{
            $precise_location = $data['precise_location'];
            $country = $data['country'];
            $state = $data['state'];
            $city = $data['city'];
            $street = $data['street'];
            $latitude = $data['latitude'];
            $longitude = $data['longitude'];
        }

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
        // $product->category_id = $data['category'];
        // $product->sub_category = $data['sub_category'];
        $product->product_status = 'live';
        $product->updated_at = Carbon::now();
        $product->save();


        //-------save product details mulitple data----------------//
        $productId = $product->id;
        $productRemove = ProductRelation::where('product_id',$productId)->delete();
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
    public function createProductBarnsDetails($data,$user)
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
        $productDetail->bid_min_price = $data['bid_min_price'];
        $productDetail->daily_board_rental_rate = $data['daily_board_rental_rate'];
        $productDetail->monthly_board_rental_rate = $data['monthly_board_rental_rate'];
        $productDetail->weekly_board_rental_rate = $data['weekly_board_rental_rate'];
        $productDetail->sale_cost = $data['sale_cost'];
        $productDetail->realtor = $data['realtor'];
        $productDetail->property_manager = $data['property_manager'];
        $productDetail->created_at = Carbon::now();
        $productDetail->updated_at = Carbon::now();

        $userDetail = UserDetails::where(['user_id' => $user->id])->first();
        if(@$data['contactSet']){
            $phone = $userDetail->phone;
        }else{
            $phone = $data['phone'];
        }
        if(@$data['addressSet']){
            $precise_location = $userDetail->precise_location;
            $country = $userDetail->country;
            $state = $userDetail->state;
            $city = $userDetail->city;
            $street = $userDetail->street;
            $latitude = $userDetail->latitude;
            $longitude = $userDetail->longitude;
        }else{
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
        // $product->category_id = $data['category'];
        $product->sub_category = $data['sub_category'];
        $product->product_status = 'live';
        $product->updated_at = Carbon::now();
        $product->save();


        //-------save product details mulitple data----------------//
        $productId = $product->id;
        $productRemove = ProductRelation::where('product_id',$productId)->delete();
        $insertData = [];

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
    public function createProductServiceJobsDetails($data,$user)
    {
        $productDetail = ProductDetail::where(['product_id' => $data['productId']])->first();
        if (!$productDetail) {
            $productDetail = new ProductDetail();
            $productDetail->product_id = $data['productId'];
        }
        
        //-------save product details table data----------------//
        $productDetail->fromdate = $data['fromdate'];
        $productDetail->todate = $data['todate'];
        $productDetail->haulings_location_from = $data['haulings_location_from'];
        $productDetail->haulings_location_to = $data['haulings_location_to'];
        $productDetail->stalls_available_haulings = $data['stalls_available_haulings'];
        $productDetail->salary = $data['salary'];
        $productDetail->hourly_price = $data['hourly_price'];
        $productDetail->fixed_price = $data['fixed_price'];
        $productDetail->created_at = Carbon::now();
        $productDetail->updated_at = Carbon::now();

        $userDetail = UserDetails::where(['user_id' => $user->id])->first();
        if(@$data['contactSet']){
            $phone = $userDetail->phone;
        }else{
            $phone = $data['phone'];
        }
        
        if(@$data['addressSet']){
            $precise_location = $userDetail->precise_location;
            $country = $userDetail->country;
            $state = $userDetail->state;
            $city = $userDetail->city;
            $street = $userDetail->street;
            $latitude = $userDetail->latitude;
            $longitude = $userDetail->longitude;
        }else{
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
        $productDetail->street = $street;
        $productDetail->banner = $data['banners'];
        $productDetail->agree = $data['agree'];
        $productDetail->save();


        //-------save product table data & enable product status as live----------------//
        $product = Product::where(['id' => $data['productId'], 'user_id' => $user->id])->first();
        // $product->category_id = $data['category'];
        $product->product_status = 'live';
        $product->updated_at = Carbon::now();
        $product->save();


        //-------save product details mulitple data----------------//
        $productId = $product->id;
        $productRemove = ProductRelation::where('product_id',$productId)->delete();
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

    public function getSoldProducts(int $limit = 12)
    {
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
        ])->where('product_status', 'sold');

        $total = $data->get()->count();
        $data = $data->paginate($limit);

        return [
                'success' => true,
                'data' => $data,
                'total' => $total
            ];
    }
}
