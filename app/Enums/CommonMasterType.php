<?php

namespace App\Enums;

enum CommonMasterType: string
{
    case disciplines = "disciplines";
    case heights = "heights";
    case sexes = "sexes";
    case breeds = "breeds";
    case colors = "colors";
    case training_show_experiences = "training_show_experiences";
    case green_eligibilities = "green_eligibilities";
    case qualifies = "qualifies";
    case current_fence_height = "current_fence_height";
    case potential_fence_height = "potential_fence_height";
    case tried_upcoming_shows = "tried_upcoming_shows";
    case property_types = "property_types";
    case stable_amenities = "stable_amenities";
    case housing_stables_around_horse_shows = "housing_stables_around_horse_shows";
    case housing_amenities = "housing_amenities";
    case realtors = "realtors";
    case property_manager = "property_manager";
    case job_listing_types = "job_listing_types";
    case services = "services";
    case contract_types = "contract_types";
    case assistance_upcoming_shows = "assistance_upcoming_shows";
    case horse_apparels = "horse_apparels";
    case rider_apparels = "rider_apparels";
    case horse_tacks = "horse_tacks";
    case trailer_trucks = "trailer_trucks";
    case for_barns = "for_barns";
    case equine_supplements = "equine_supplements";
    case conditions = "conditions";
    case brands = "brands";
    case horse_sizes = "horse_sizes";
    case rider_sizes = "rider_sizes";
    case exchanged_upcoming_horse_shows = "exchanged_upcoming_horse_shows";

    /**
     * Get all the values of the enum as an array
     *
     * @return array
     */
    public static function getValues(): array
    {
        // Use the `cases()` method to get all enum cases and then map them to their values
        return array_map(fn($case) => $case->value, self::cases());
    }
}
