<?php

namespace App\Http\Requests\API\v1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CommonMaster;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryIds = Category::pluck('id')->toArray();
        $productId = $this->input('product_id');

        $isUpdate = !empty($productId);

        $rules = [
            'sale_method' => 'required|in:standard,auction',
            'title' => 'required|string|max:500',
            'price' => 'required|numeric',
            'currency' => 'required|string|max:3',
            'description' => 'required|string|max:5000',
            'external_link' => 'nullable|url|max:400',

            'image' => [$isUpdate ? 'nullable' : 'required', 'array'],
            'image.*.in' => 'image|mimes:jpeg,png,jpg|max:4096',
            'video' => [$isUpdate ? 'nullable' : 'required', 'array'],
            'video.*.in' => 'mimes:mp4,mov,avi,wmv|max:20480',
            'document' => [$isUpdate ? 'nullable' : 'required', 'array'],
            'document.*.in' => 'mimes:pdf,doc,docx|max:4096',

            'phone' => 'nullable|regex:/^\+?[0-9]{10,15}$/',
            'addressSet' => 'nullable|boolean',
            'contactSet' => 'nullable|boolean',
            'category_id' => ['required', Rule::in($categoryIds)],
            'agree' => 'required|boolean',
            'banners' => 'required|string',
            'transaction_method' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ];

        $categoryId = $this->input('category_id');

        // Conditional Location Fields
        if (!$this->boolean('addressSet')) {
            $rules['precise_location'] = ['required', 'array'];
            $rules['precise_country'] = ['required', 'array'];
            $rules['precise_state'] = ['required', 'array'];
            $rules['precise_city'] = ['required', 'array'];
            $rules['precise_street'] = ['required', 'array'];
        }

        if ($categoryId) {
            // Subcategories
            if ($categoryId != 2 && $categoryId != 4) {
                $subCategories = SubCategory::where('category_id', $categoryId)->pluck('id')->toArray();
                if (!empty($subCategories)) {
                    $rules['subcategory_ids'] = ['required', 'integer', Rule::in($subCategories)];
                    // $rules['subcategory_ids.*.in'] = [Rule::in($subCategories)];
                }
            }

            // Common Master Data
            $commonMasterData = CommonMaster::where('category_id', $categoryId)->get()->groupBy('type');

            switch ($categoryId) {
                case 1:
                    $rules = array_merge($rules, $this->rulesForCategoryOne($commonMasterData));
                    break;
                case 2:
                    $rules = array_merge($rules, $this->rulesForCategoryTwo($commonMasterData));
                    break;
                case 3:
                    $rules = array_merge($rules, $this->rulesForCategoryThree($commonMasterData));
                    break;
                case 4:
                    $rules = array_merge($rules, $this->rulesForCategoryFour($commonMasterData));
                    break;
            }
        }

        return $rules;
    }

    protected function rulesForCategoryOne($commonMasterData): array
    {
        $rules = [];
        
        $rules['pedigree_chart'] = ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg', 'max:2048'];
        // Year Born
        $rules['year_born'] = ['required', 'digits:4', 'integer', 'min:1900', 'max:' . now()->year];

        // Disciplines
        if ($this->filled('disciplines') && isset($commonMasterData['disciplines'])) {
            $disciplineIds = $commonMasterData['disciplines']->pluck('id')->toArray();
            $rules['disciplines'] = ['required', 'array'];
            $rules['disciplines.*.in'] = [Rule::in($disciplineIds)];
        }

        // Heights (if not unknown)
        if (isset($commonMasterData['heights']) && empty($commonMasterData['heights'])) {
            $rules['heights'] = ['nullable'];
        }
        if (isset($commonMasterData['heights'])) {
            $heightIds = $commonMasterData['heights']->pluck('id')->toArray();
            $rules['heights'] = ['required', 'integer', Rule::in($heightIds)];
            // $rules['heights.*.in'] = [Rule::in($heightIds)];
        }

        // Sex
        if (isset($commonMasterData['sexes'])) {
            $sexIds = $commonMasterData['sexes']->pluck('id')->toArray();
            $rules['sexes'] = ['required', 'integer', Rule::in($sexIds)];
            // $rules['sexes.*.in'] = [Rule::in($sexIds)];
        }

        // USEF
        if (isset($commonMasterData['usef'])) {
            $rules['usef'] = ['required', 'array'];
        }

        // Breeds
        if (isset($commonMasterData['breeds'])) {
            $breedIds = $commonMasterData['breeds']->pluck('id')->toArray();
            $rules['breeds'] = ['nullable', 'array'];
            $rules['breeds.*.in'] = [Rule::in($breedIds)];
        }

        // Colors
        if (isset($commonMasterData['colors'])) {
            $colorIds = $commonMasterData['colors']->pluck('id')->toArray();
            $rules['colors'] = ['nullable', 'array'];
            $rules['colors.*.in'] = [Rule::in($colorIds)];
        }

        // Training Show Experiences
        if (isset($commonMasterData['training_show_experiences'])) {
            $ids = $commonMasterData['training_show_experiences']->pluck('id')->toArray();
            $rules['training_show_experiences'] = ['nullable', 'array'];
            $rules['training_show_experiences.*.in'] = [Rule::in($ids)];
        }

        // Green Eligibilities
        if (isset($commonMasterData['green_eligibilities'])) {
            $ids = $commonMasterData['green_eligibilities']->pluck('id')->toArray();
            $rules['green_eligibilities'] = ['nullable', Rule::in($ids)];
        }

        // Qualifies
        if (isset($commonMasterData['qualifies'])) {
            $ids = $commonMasterData['qualifies']->pluck('id')->toArray();
            $rules['qualifies'] = ['nullable', 'array'];
            $rules['qualifies.*.in'] = [Rule::in($ids)];
        }

        // Current Fence Height
        if (isset($commonMasterData['current_fence_height'])) {
            $ids = $commonMasterData['current_fence_height']->pluck('id')->toArray();
            $rules['current_fence_height'] = ['nullable', 'array'];
            $rules['current_fence_height.*.in'] = [Rule::in($ids)];
        }

        // Potential Fence Height
        if (isset($commonMasterData['potential_fence_height'])) {
            $ids = $commonMasterData['potential_fence_height']->pluck('id')->toArray();
            $rules['potential_fence_height'] = ['nullable', 'array'];
            $rules['potential_fence_height.*.in'] = [Rule::in($ids)];
        }

        // Tried Upcoming Shows
        if (isset($commonMasterData['tried_upcoming_shows'])) {
            $ids = $commonMasterData['tried_upcoming_shows']->pluck('id')->toArray();
            $rules['tried_upcoming_shows'] = ['nullable', 'array'];
            $rules['tried_upcoming_shows.*.in'] = [Rule::in($ids)];
        }

        // Trial Dates
        if (isset($commonMasterData['trial_date_from'])) {
            $rules['trial_date_from'] = ['nullable', 'date'];
        }
        if (isset($commonMasterData['trial_date_to'])) {
            $rules['trial_date_to'] = ['nullable', 'date'];
        }

        // Prices
        if (isset($commonMasterData['sale_price'])) {
            $rules['sale_price'] = ['nullable', 'integer'];
        }
        if (isset($commonMasterData['lease_price'])) {
            $rules['lease_price'] = ['nullable', 'integer'];
        }

        // Trainer / Facility
        if (isset($commonMasterData['trainer'])) {
            $rules['trainer'] = ['nullable', 'string'];
        }
        if (isset($commonMasterData['facility'])) {
            $rules['facility'] = ['nullable', 'string'];
        }

        // Bloodlines
        if (isset($commonMasterData['sire_bloodlines'])) {
            $rules['sire_bloodlines'] = ['nullable', 'string'];
        }
        if (isset($commonMasterData['dam_bloodlines'])) {
            $rules['dam_bloodlines'] = ['nullable', 'string'];
        }

        return $rules;
    }

    protected function rulesForCategoryTwo($commonMasterData): array
    {
        $rules = [];

        // Horse Apparels
        if (isset($commonMasterData['horse_apparels'])) {
            $ids = $commonMasterData['horse_apparels']->pluck('id')->toArray();
            $rules['horse_apparels'] = ['nullable', 'array'];
            $rules['horse_apparels.*.in'] = [Rule::in($ids)];
        }

        // Rider Apparels
        if (isset($commonMasterData['rider_apparels'])) {
            $ids = $commonMasterData['rider_apparels']->pluck('id')->toArray();
            $rules['rider_apparels'] = ['nullable', 'array'];
            $rules['rider_apparels.*.in'] = [Rule::in($ids)];
        }

        // Horse Tacks
        if (isset($commonMasterData['horse_tacks'])) {
            $ids = $commonMasterData['horse_tacks']->pluck('id')->toArray();
            $rules['horse_tacks'] = ['nullable', 'array'];
            $rules['horse_tacks.*.in'] = [Rule::in($ids)];
        }

        // Trailer Trucks
        if (isset($commonMasterData['trailer_trucks'])) {
            $ids = $commonMasterData['trailer_trucks']->pluck('id')->toArray();
            $rules['trailer_trucks'] = ['nullable', 'array'];
            $rules['trailer_trucks.*.in'] = [Rule::in($ids)];
        }

        // For Barns
        if (isset($commonMasterData['for_barns'])) {
            $ids = $commonMasterData['for_barns']->pluck('id')->toArray();
            $rules['for_barns'] = ['nullable', 'array'];
            $rules['for_barns.*.in'] = [Rule::in($ids)];
        }

        // Equine Supplements
        if (isset($commonMasterData['equine_supplements'])) {
            $ids = $commonMasterData['equine_supplements']->pluck('id')->toArray();
            $rules['equine_supplements'] = ['nullable', 'array'];
            $rules['equine_supplements.*.in'] = [Rule::in($ids)];
        }

        // Conditions
        if (isset($commonMasterData['conditions'])) {
            $ids = $commonMasterData['conditions']->pluck('id')->toArray();
            $rules['conditions'] = ['nullable', 'array'];
            $rules['conditions.*.in'] = [Rule::in($ids)];
        }

        // Brands
        if (isset($commonMasterData['brands'])) {
            $ids = $commonMasterData['brands']->pluck('id')->toArray();
            $rules['brands'] = ['nullable', 'array'];
            $rules['brands.*.in'] = [Rule::in($ids)];
        }

        // Horse Sizes
        if (isset($commonMasterData['horse_sizes'])) {
            $ids = $commonMasterData['horse_sizes']->pluck('id')->toArray();
            $rules['horse_sizes'] = ['nullable', 'array'];
            $rules['horse_sizes.*.in'] = [Rule::in($ids)];
        }

        // Exchanged Upcoming Horse Shows
        if (isset($commonMasterData['exchanged_upcoming_horse_shows'])) {
            $ids = $commonMasterData['exchanged_upcoming_horse_shows']->pluck('id')->toArray();
            $rules['exchanged_upcoming_horse_shows'] = ['nullable', 'array'];
            $rules['exchanged_upcoming_horse_shows.*.in'] = [Rule::in($ids)];
        }

        // Prices
        if (isset($commonMasterData['price'])) {
            $rules['price'] = ['nullable', 'integer'];
        }
        if (isset($commonMasterData['hourly_rental_price'])) {
            $rules['hourly_rental_price'] = ['nullable', 'integer'];
        }
        if (isset($commonMasterData['fixed_rental_price'])) {
            $rules['fixed_rental_price'] = ['nullable', 'integer'];
        }

        return $rules;
    }

    protected function rulesForCategoryThree($commonMasterData): array
    {
        $rules = [];

        // Property Types
        if (isset($this->property_types) && isset($commonMasterData['property_types'])) {
            $ids = $commonMasterData['property_types']->pluck('id')->toArray();
            $rules['property_types'] = ['required', 'array'];
            $rules['property_types.*.in'] = [Rule::in($ids)];
        }

        // Stalls Available
        if (isset($commonMasterData['stalls_available'])) {
            $rules['stalls_available'] = ['nullable', 'integer'];
        }

        // Stable Amenities
        if (isset($commonMasterData['stable_amenities'])) {
            $ids = $commonMasterData['stable_amenities']->pluck('id')->toArray();
            $rules['stable_amenities'] = ['nullable', 'array'];
            $rules['stable_amenities.*.in'] = [Rule::in($ids)];
        }

        // Housing Stables Around Horse Shows
        if (isset($commonMasterData['housing_stables_around_horse_shows'])) {
            $ids = $commonMasterData['housing_stables_around_horse_shows']->pluck('id')->toArray();
            $rules['housing_stables_around_horse_shows'] = ['nullable', 'array'];
            $rules['housing_stables_around_horse_shows.*.in'] = [Rule::in($ids)];
        }

        // Date Available From
        if (isset($commonMasterData['date_avalable_from'])) {
            $rules['date_avalable_from'] = ['nullable', 'date'];
        }

        // Date Available To
        if (isset($commonMasterData['date_avalable_to'])) {
            $rules['date_avalable_to'] = ['nullable', 'date'];
        }

        // Sleeps
        if (isset($commonMasterData['sleeps'])) {
            $rules['sleeps'] = ['nullable', 'integer'];
        }

        // Housing Amenities
        if (isset($commonMasterData['housing_amenities'])) {
            $ids = $commonMasterData['housing_amenities']->pluck('id')->toArray();
            $rules['housing_amenities'] = ['nullable', 'array'];
            $rules['housing_amenities.*.in'] = [Rule::in($ids)];
        }

        // Daily Board Rental Rate
        if (isset($commonMasterData['daily_board_rental_rate'])) {
            $rules['daily_board_rental_rate'] = ['nullable', 'integer'];
        }

        // Monthly Board Rental Rate
        if (isset($commonMasterData['monthly_board_rental_rate'])) {
            $rules['monthly_board_rental_rate'] = ['nullable', 'integer'];
        }

        // Weekly Board Rental Rate
        if (isset($commonMasterData['weekly_board_rental_rate'])) {
            $rules['weekly_board_rental_rate'] = ['nullable', 'integer'];
        }

        // Sale Cost
        if (isset($commonMasterData['sale_cost'])) {
            $rules['sale_cost'] = ['nullable', 'integer'];
        }

        // Realtor
        if (isset($commonMasterData['realtor'])) {
            // $ids = $commonMasterData['realtor']->pluck('id')->toArray();
            $rules['realtor'] = ['nullable'];
            // $rules['realtor.*.in'] = [Rule::in($ids)];
        }

        // Property Manager
        if (isset($commonMasterData['property_manager'])) {
            // $ids = $commonMasterData['property_manager']->pluck('id')->toArray();
            $rules['property_manager'] = ['nullable'];
            // $rules['property_manager.*.in'] = [Rule::in($ids)];
        }

        return $rules;
    }

    protected function rulesForCategoryFour($commonMasterData): array
    {
        $rules = [];

        // Job Listing Types
        if (isset($this->job_listing_types) && isset($commonMasterData['job_listing_types'])) {
            $ids = $commonMasterData['job_listing_types']->pluck('id')->toArray();
            $rules['job_listing_types'] = ['nullable', 'array'];
            $rules['job_listing_types.*.in'] = [Rule::in($ids)];
        }

        // Services
        if (isset($commonMasterData['services'])) {
            $ids = $commonMasterData['services']->pluck('id')->toArray();
            $rules['services'] = ['nullable', 'array'];
            $rules['services.*.in'] = [Rule::in($ids)];
        }

        // Contract Types
        if (isset($commonMasterData['contract_types'])) {
            $ids = $commonMasterData['contract_types']->pluck('id')->toArray();
            $rules['contract_types'] = ['nullable', 'array'];
            $rules['contract_types.*.in'] = [Rule::in($ids)];
        }

        // Assistance for Upcoming Shows
        if (isset($commonMasterData['assistance_upcoming_shows'])) {
            $ids = $commonMasterData['assistance_upcoming_shows']->pluck('id')->toArray();
            $rules['assistance_upcoming_shows'] = ['nullable', 'array'];
            $rules['assistance_upcoming_shows.*.in'] = [Rule::in($ids)];
        }

        // Date Available From
        if (isset($commonMasterData['date_avalable_from'])) {
            $rules['date_avalable_from'] = ['nullable', 'date'];
        }

        // Date Available To
        if (isset($commonMasterData['date_avalable_to'])) {
            $rules['date_avalable_to'] = ['nullable', 'date'];
        }

        // Haulings Location From
        if (isset($commonMasterData['haulings_location_from'])) {
            $rules['haulings_location_from'] = ['nullable', 'string'];
        }

        // Haulings Location To
        if (isset($commonMasterData['haulings_location_to'])) {
            $rules['haulings_location_to'] = ['nullable', 'string'];
        }

        // Stalls Available for Haulings
        if (isset($commonMasterData['stalls_available_haulings'])) {
            $rules['stalls_available_haulings'] = ['nullable', 'integer'];
        }

        // Salary
        if (isset($commonMasterData['salary'])) {
            $rules['salary'] = ['nullable', 'integer'];
        }

        // Fixed Pay
        if (isset($commonMasterData['fixed_pay'])) {
            $rules['fixed_pay'] = ['nullable', 'integer'];
        }

        // Hourly
        if (isset($commonMasterData['hourly'])) {
            $rules['hourly'] = ['nullable', 'integer'];
        }

        return $rules;
    }

    // public function withValidator($validator)
    // {
    //     $validator->sometimes('heights', 'required|min:1', function ($input) {
    //         return !$input->height_unknown;
    //     });
    // }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $firstErrorMessage = $errors->first();

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors occurred.',
            'data' => $firstErrorMessage,
        ], 422));
    }
}
