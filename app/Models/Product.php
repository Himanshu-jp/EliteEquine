<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'sale_method',
        'return_available',
        'return_days',
        'title',
        'slug',
        'price',
        'is_negotiable',
        'is_motivated_seller',
        'price_reduced',
        'currency',
        'description',
        'transaction_method',
        'auc_winner_pay_in',
        'bid_end_days',
        'mark_as',
        'product_status',
        'feature'
    ];
protected $appends = ['disciplines_names'];
    public function productDetail()
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function productBids()
    {
        return $this->hasMany(ProductBid::class)->orderBy('id', 'desc');
    }

    public function highestBid()
    {
        return $this->hasOne(ProductBid::class)->orderByDesc('amount');
    }

    public function image()
    {
        return $this->hasMany(ProductImage::class)->select('id', 'product_id', 'image');
    }

   
    public function subcategory()
    {
        return $this->hasMany(ProductSubCategory::class)->select('id', 'product_id', 'category_id');
    }
    
    public function externalLink()
    {
        return $this->hasMany(ProductLink::class)->select('id', 'product_id', 'link')->where('type', 'web');
    }

    public function videoLink()
    {
        return $this->hasMany(ProductLink::class)->select('id', 'product_id', 'link')->where('type', 'video');
    }

    public function video()
    {
        return $this->hasMany(ProductVideo::class)->select('id', 'product_id', 'video_url', 'thumbnail');
    }

    public function document()
    {
        return $this->hasMany(ProductDocument::class)->select('id', 'product_id', 'file');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name', 'profile_photo_path', 'email', 'phone_no');
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id', 'name');
    }

    public function disciplines()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'disciplines')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function breeds()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'breeds')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function colors()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'colors')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function trainingShowExperiences()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'training_show_experiences')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function qualifies()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'qualifies')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function currentFenceHeight()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'current_fence_height')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function potentialFenceHeight()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'potential_fence_height')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function triedUpcomingShows()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'tried_upcoming_shows')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function height()
    {
        return $this->hasOne(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'heights')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function sex()
    {
        return $this->hasOne(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'sexes')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function greenEligibilities()
    {
        return $this->hasOne(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'green_eligibilities')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function horseApparels()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'horse_apparel')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function horseTacks()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'horse_tack')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function trailerTrucks()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'trailer_trucks')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function riderApparels()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'rider_apparel')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function forBarns()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'for_barns')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function equineSupplements()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'equine_supplements')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function brands()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'brands')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function horseSizes()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'horse_sizes')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function riderSizes()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'rider_sizes')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function exchangedUpcomingHorseShows()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'exchanged_upcoming_horse_shows')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function conditions()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'conditions')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function propertyTypes()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'property_types')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function stableAmenities()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'stable_amenities')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function housingAmenities()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'housing_amenities')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function housingStablesAroundHorseShows()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'housing_stables_around_horse_shows')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function jobListingType()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'job_listing_type')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function service()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'service')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function contractTypes()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'contract_types')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function assistanceUpcomingShows()
    {
        return $this->hasMany(ProductRelation::class)
            ->with(['commonMaster:id,name'])
            ->where('type', 'assistance_upcoming_shows')
            ->select('id', 'product_id', 'common_master_id', 'type');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'product_id');
    }
    public function comments()
    {
        return $this->hasMany(ProductComment::class, 'product_id')
            ->whereNull('product_comment_id')
            ->with('children')
            ->orderBy('id', 'desc');
    }
    public function getDisciplinesNamesAttribute()
    {
        return $this->disciplines
            ->pluck('commonMaster.name')   // Extract the names
            ->filter()                     // Remove nulls if any
            ->implode(', ');              // Join by comma
    }

    protected $casts = [
        'price' => 'decimal:2',
        'return_available' => 'boolean',
        'is_negotiable' => 'boolean',
        'is_motivated_seller' => 'boolean',
        'price_reduced' => 'boolean',
        'auc_winner_pay_in' => 'boolean',
        'bid_end_days' => 'integer',
        'product_status' => 'string',
    ];
}
