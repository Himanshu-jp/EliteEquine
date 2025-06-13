<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesData = [
            ['name' => 'Horses', 'slug' => 'horses', 'image' => public_path('/admin_assets/default_categories/horse.png')],
            ['name' => 'Equipment & Apparel', 'slug' => 'equipment-apparel', 'image' => public_path('/admin_assets/default_categories/equipment-apparel.jpg')],
            ['name' => 'Barns & Housing', 'slug' => 'barns-housing', 'image' => public_path('/admin_assets/default_categories/barns-housing.jpg')],
            ['name' => 'Services & Jobs', 'slug' => 'services-jobs', 'image' => public_path('/admin_assets/default_categories/services-jobs.jpg')],
            // ['name' => 'Community & Events', 'slug' => 'community-events', 'image' => public_path('/admin_assets/default_categories/community-events.png')],
        ];

        $uploadPath = 'categories';
        Storage::disk('public')->makeDirectory($uploadPath);

        foreach ($categoriesData as $data) {
            if (File::exists($data['image'])) {
                $extension = File::extension($data['image']);
                $filename = Str::uuid() . '.' . $extension;
                Storage::disk('public')->put($uploadPath . '/' . $filename, File::get($data['image']));

                // Save to DB
                Category::create([
                    'name' => $data['name'],
                    'slug' => $data['slug'],
                    'image' => $uploadPath . '/' . $filename,
                ]);
            }
        }
    }
}
