<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubCategory; // Import the model for Subcategory

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the subcategory data
        $subCategoryData = [
            "1" => [
                'For Sale',
                'For Lease',
                'Short-Term Lease Option',
                'Lease-To-Buy Option',
                'Half Lease Option',
                'In Search of Training Rides',
                'In Search of Catch Rides',
                'Show Lease Option'
            ],
            "3" => [
                'For Sale',
                'For Rent or Sublet',
                'Offering Horse Board',
                'Offering Board + Lessons'
            ]
        ];

        // Loop through each category and insert subcategories
        foreach ($subCategoryData as $categoryId => $subcategories) {
            foreach ($subcategories as $subcategoryName) {
                Subcategory::create([
                    'category_id' => $categoryId, // Assuming you have a category_id field
                    'name' => $subcategoryName // Assuming you have a name field
                ]);
            }
        }
    }
}
