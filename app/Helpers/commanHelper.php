<?php

use App\Models\Category;
use App\Models\CommonMaster;
use App\Models\ProductDetail;
use App\Models\SubCategory;
use App\Models\UserDetails;
use App\Models\SocailLink;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


if (!function_exists('social_links')) {
    function social_links($type) {
       $social = SocailLink::first();
	   return @$social->$type;
    }
}

if (!function_exists('checkProfileSettingUpdate')) {
    function checkProfileSettingUpdate($user) {
        if($user->phone_no =="" || $user->country =="" || $user->state=="" || $user->city=="" ){
            return ['success' => false, 'message' => 'Please first complete your Profile details.', 'code' => 422];
        }        
        $settingDetails = UserDetails::where('user_id',$user->id)->where('phone','!=',null)->first();
        if(!$settingDetails)
        {
            return ['sauccess' => false, 'message' => 'Please first complete your Settings details.', 'code' => 422];
        }

		return ['success' => true, 'message' => 'success', 'code' => 200];
    }
}

if (!function_exists('format_date')) {
    function format_date($date, $format = 'd-m-Y') {
        return Carbon::parse($date)->format($format);
    }
}


if (!function_exists('__categoryData')) {
    function __categoryData($index = '')
    {
		$data = Category::where(['deleted_at' => null])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__subCategoryHorseData')) {
    function __subCategoryHorseData($index = '')
    {
        $data = SubCategory::where(['category_id'=> '1','deleted_at'=>null])->pluck('name','id');
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__subCategoryBarnsData')) {
    function __subCategoryBarnsData($index = '')
    {
        $data = SubCategory::where(['category_id'=> '3','deleted_at'=>null])->pluck('name','id');
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__disciplinesData')) {
    function __disciplinesData($index = '')
    {
		$data= CommonMaster::where(['deleted_at' => null,'type'=>'disciplines'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__heightsData')) {
    function __heightsData($index = '')
    {
		$data= CommonMaster::where(['deleted_at' => null,'type'=>'heights'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__sexesData')) {
    function __sexesData($index = '')
    {
		$data= CommonMaster::where(['deleted_at' => null,'type'=>'sexes'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}
if (!function_exists('__breedsData')) {
    function __breedsData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'breeds'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__colorsData')) {
    function __colorsData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'colors'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__trainingShowExperiencesData')) {
    function __trainingShowExperiencesData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'training_show_experiences'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__qualifiesData')) {
    function __qualifiesData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'qualifies'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__currentFenceHeightData')) {
    function __currentFenceHeightData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'current_fence_height'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__potentialFenceHeightData')) {
    function __potentialFenceHeightData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'potential_fence_height'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__triedUpcomingShowsData')) {
    function __triedUpcomingShowsData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'tried_upcoming_shows'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__greenEligibilitiesData')) {
    function __greenEligibilitiesData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'green_eligibilities'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__trainerData')) {
    function __trainerData($index = '')
    {
		$data = ProductDetail::whereNull('deleted_at')
            ->select('trainer')
            ->groupBy('trainer')
            ->pluck('trainer')
            ->toArray();

    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getHaulingLocationFromData')) {
    function __getHaulingLocationFromData($index = '')
    {
		$data = ProductDetail::whereNull('deleted_at')
            ->select('haulings_location_from')
            ->groupBy('haulings_location_from')
            ->pluck('haulings_location_from')
            ->toArray();

    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getHaulingLocationToData')) {
    function __getHaulingLocationToData($index = '')
    {
		$data = ProductDetail::whereNull('deleted_at')
            ->select('haulings_location_to')
            ->groupBy('haulings_location_to')
            ->pluck('haulings_location_to')
            ->toArray();

    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__facilityData')) {
    function __facilityData($index = '')
    {
		$data = ProductDetail::whereNull('deleted_at')
            ->select('facility')
            ->groupBy('facility')
            ->pluck('facility')
            ->toArray();

    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__sireBloodData')) {
    function __sireBloodData($index = '')
    {
		$data = ProductDetail::whereNull('deleted_at')
            ->select('sirebloodline')
            ->groupBy('sirebloodline')
            ->pluck('sirebloodline')
            ->toArray();

    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__damBloodData')) {
    function __damBloodData($index = '')
    {
		$data = ProductDetail::whereNull('deleted_at')
            ->select('dambloodline')
            ->groupBy('dambloodline')
            ->pluck('dambloodline')
            ->toArray();

    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__usefData')) {
    function __usefData($index = '')
    {
		$data = ProductDetail::whereNull('deleted_at')
            ->select('usef')
            ->groupBy('usef')
            ->pluck('usef')
            ->toArray();

    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}


if (!function_exists('__getHorseApparealsData')) {
    function __getHorseApparealsData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'horse_apparels'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getRiderApparealsData')) {
    function __getRiderApparealsData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'rider_apparels'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getHorseTacksData')) {
    function __getHorseTacksData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'horse_tacks'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getTrailerTrucksData')) {
    function __getTrailerTrucksData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'trailer_trucks'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getForBarnsData')) {
    function __getForBarnsData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'for_barns'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getEquineSupplementsData')) {
    function __getEquineSupplementsData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'equine_supplements'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getConditionsData')) {
    function __getConditionsData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'conditions'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getBrandsData')) {
    function __getBrandsData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'brands'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getHorseSizesData')) {
    function __getHorseSizesData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'horse_sizes'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getRiderSizesData')) {
    function __getRiderSizesData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'rider_sizes'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getExchangedUpcomingHorseShows')) {
    function __getExchangedUpcomingHorseShows($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'exchanged_upcoming_horse_shows'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getPropertytypesData')) {
    function __getPropertytypesData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'property_types'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getStableAmenitiesData')) {
    function __getStableAmenitiesData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'stable_amenities'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getHousingAmenitiesData')) {
    function __getHousingAmenitiesData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'housing_amenities'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getHousingStable')) {
    function __getHousingStable($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'housing_stables_around_horse_shows'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getJobListingTypeData')) {
    function __getJobListingTypeData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'job_listing_types'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getServicesData')) {
    function __getServicesData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'services'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getContractTypesData')) {
    function __getContractTypesData($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'contract_types'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

if (!function_exists('__getAssistanceUpcomingShows')) {
    function __getAssistanceUpcomingShows($index = '')
    {
		$data = CommonMaster::where(['deleted_at' => null,'type'=>'assistance_upcoming_shows'])->pluck('name','id')->toArray();
    	if(!empty($index)){
			return $data[$index];
		}else{
			return $data;
		}
    }
}

?>