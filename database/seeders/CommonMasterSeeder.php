<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CommonMaster;

class CommonMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commonMasters = [
            "1" => [
                "disciplines" => ["Equitation", "Hunter", "Jumper"],
                "heights" => ["Below 11", "11.1", "11", "11.2", "11.3", "12", "12.1", "12.2", "12.3", "13", "13.1", "13.1 ⅞h", "13.2", "13.3", "14", "14.1", "14.2", "14.3", "15.3", "15.2", "15", "15.1", "16", "16.1", "16.2", "16.3", "17", "17.1", "17.2", "17.3", "18", "18.1", "18.2", "18.3", "19"],
                "sexes" => ["Gelding", "Mare", "Stallion", "Colt", "Filly"],
                "breeds" => ["All Warmbloods", "All Thoroughbreds", "All Ponies", "Argentinian Warmblood", "American Warmblood", "Appendix Quarter Horse", "Belgian Warmblood", "Brandenburger", "Canadian Sport Horse", "Canadian Warmblood", "Cleveland Bay", "Czech Warmblood", "Crossbred", "Danish Warmblood", "Dutch Warmblood", "English Thoroughbred", "French Thoroughbred", "German Warmblood", "Hanovarian", "Holsteiner", "Hungarian Warmblood", "Irish Sport horse", "Irish Thoroughbred", "Oldenburg", "Paint", "Quarter Horse", "Quarter Pony", "Selle Francais Warmblood", "Shetland Pony", "Thoroughbred Cross", "Swedish Warmblood", "Warmblood Cross", "Welsh Cob", "Welsh Pony", "Welsh Cross", "Westphalian", "Zangersheide", "Other Breed", "Hanovarian Warmblood", "German Riding Pony"],
                "colors" => ["Bay", "Black", "Buckskin", "Chestnut", "Dark Bay", "Dun", "Gray", "Other", "Paint", "Palomino", "Pinto", "Roan"],
                "training_show_experiences" => ["Prospect - Not Backed", "Prospect - Green Backed", "Prospect - In Training", "<1 Year Showing", "1-2 Years Showing", "3+ Years Showing"],
                "green_eligibilities" => ["First Year Green", "Pre-Green", "Second Year Green"],
                "qualifies" => ["Junior Hunter Finals", "Pony Finals"],
                "current_fence_height" => ["0”", "2’0”", "2’3” / 0.70m", "2’6” / 0.75 - 0.80m", "2’9” / 0.85m", "3’0” / 0.90 - 0.95m", "3’3” / 1.0m", "3’6” / 1.05 - 1.10m", "3’9” / 1.15m", "4’0” / 1.20 - 1.25m", "4’3’ / 1.30m", "4’6” / 1.35 - 1.40m", "4’9” / 1.45m", "5’0” / 1.50 - 1.55m"],
                "potential_fence_height" => ["0", "2’0", "2’3” / 0.70", "2’6” / 0.75 - 0.80", "2’9” / 0.85", "3’0” / 0.90 - 0.95", "3’3” / 1.0", "3’6” / 1.05 - 1.10", "3’9” / 1.15", "4’0” / 1.20 - 1.25", "4’3’ / 1.30", "4’6” / 1.35 - 1.40", "4’9” / 1.45", "5’0” / 1.50 - 1.55"],
                "tried_upcoming_shows" => ["I WEF", "LAEC", "Westpalm events or Gold Coast horse shows", "Lexington National", "Tryon Fall Finale I", "WEC Winter Classic 15 & 16"]
            ],
            "2" => [
                "horse_apparels" => ["Bell Boots", "Blanket", "Cooler", "Fly Bonnet", "Fly Mask", "Fly Sheet", "Grooming Supplies", "Halter", "Lead Rope", "Polo Wraps", "Rain Sheet", "Saddle Pad", "Scrim", "Shipping Wraps", "Splint Boots"],
                "rider_apparels" => ["Backpack", "Bag", "Belt", "Breeches", "Chaps", "Equestrian Gifts", "Gloves", "Hat", "Helmet", "Jewelry", "Kids", "Muck Boots", "Outwear", "Paddock Boots", "Scarf", "Shadbelly", "Show Jacket", "Show Shirt", "Spur Straps", "Sweater", "Tall boots"],
                "horse_tacks" => ["Bit", "Breastplate", "Bridle", "Browband", "Girth", "Leathers", "Martingale", "Reins", "Saddle", "Spurs", "Stirrup Leathers", "Stirrups"],
                "trailer_trucks" => ["Bumper Pull", "Gooseneck", "Horse Trailer", "Horse Trailer with Living Quarter", "Truck", "Truck & Trailer"],
                "for_barns" => ["4-Wheeler", "Arena Footing", "Barn Signage", "Bike", "Bridle Rack", "Custom Drapery", "Dirtbike", "Feed Bucket", "Fencing", "Golf Cart", "Hay", "Horse Feed", "Jumps", "Lawn Mower", "Mounting Block", "Saddle Rack", "Stall Flooring", "Stall Gates", "Tack Trunk", "Tack Trunk Cover", "Tractor", "Tractor Drag"],
                "equine_supplements" => ["Calm & Focus", "Coat", "Gastric Health", "Hoof", "Immunity", "Joint", "Mane & Tail", "Performance", "Senior", "Treats"],
                "conditions" => ["Brand New (with Tags)", "Rental", "Used", "Used (Like New)"],
                "brands" => ["Amerigo Pinerolo", "Charles Owen", "CWD", "Erreplus", "F. Fabbri"],
                "horse_sizes" => ["84"],
                "rider_sizes" => ['17.5" Seat', '2', '38 Tall Large Calf'],
                "exchanged_upcoming_horse_shows" => ["Tryon - April 28 - May 11"]
            ],
            "3" => [
                "property_types" => ["Living Quarters", "Rental Stables", "Living Quarters + Stables", "Groom Quarters", "Boarding Barn"],
                "stable_amenities" => ["Flexible Turnout", "Groom Service", "Tack Room", "Climate Control", "Courtyard Access", "Indoor Arena", "Outdoor Arena", "Hay & Feed Storage", "Trails on the Property", "Security Cameras on Property", "Full Service Care"],
                "housing_stables_around_horse_shows" => ["WEC Ocala", "WEC Wilmington", "WEF"],
                "housing_amenities" => ["Pet’s allowed", "Wifi", "Washer and Dryer", "Kitchen", "Kitchenware", "Dishwasher", "parking_onsite", "Pool", "Hot Tub", "Security cameras on property", "Other", "Maid services if desired (additional fee)"],
                "realtors" => [],
                "property_manager" => []
            ],
            "4" => [
                "job_listing_types" => ["Hiring", "Offering Service", "Seeking Employment"],
                "services" => ["Animal Communication", "Arena Construction", "Arena Footing", "Barn / Farmhouse Construction", "Barn Management", "Barnhand", "Blanket Cleaning", "Braiding", "Brand Rep", "Breeder", "Business Services", "Clinic", "Emergency Services (ex: Hauling)", "Equine Art", "Equine Chiropractor", "Equine Facility", "Equine Insurance", "Equine Media", "Equine Veterinarian", "Equine Volunteering", "Farrier", "Feed Delivery", "Fencing", "Financial Services", "Graphic Design / Web Design / Logo Creation", "Grooming", "Hay Delivery", "Horse Camp", "Horse Clipping", "Horse Wellness", "House Sitting / Pet Sitting", "Jump Rentals", "Landscaping", "Legal Services", "Manure Removal", "Marketing & Advertising", "Non-Profit Work / Donations", "Nutrition", "PEMF Specialist", "Photography & Videography", "Professional Hauling", "Retail", "Retirement Facility", "Rider", "Rider Wellness", "Saddle Fitting", "Shaving Delivery", "Tack Repair", "Technology Provider", "therapy services", "Trainer"],
                "contract_types" => ["Full Time", "Part Time", "Apprenticeship", "Contract", "Volunteer"],
                "assistance_upcoming_shows" => ["Tryon Fall Finale II"]
            ],
        ];

        foreach ($commonMasters as $type => $groups) {
            foreach ($groups as $groupKey => $values) {
                foreach ($values as $value) {
                    CommonMaster::create([
                        'type' => $groupKey,
                        'name' => $value,
                        'category_id' => $type
                    ]);
                }
            }
        }
    }
}
