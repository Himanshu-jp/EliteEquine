<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\IndustryMatric;

class IndustryMatricsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industryData = [
            ['title' => 'Hunter/Jumper Industry Expansion:', 'description' => '<p>The U.S. equine industry contributes approximately $177 billion to the economy and supports over 2.2 million jobs annually. (American Horse Council – Link to Report). Participation in hunter-jumper events has grown globally, with countries such as Germany, Belgium, and Australia boosting their competitive presence. (Fédération Equestre Internationale (FEI) –Link to Report). The global equine industry has a substantial economic impact, contributing approximately $300 billion annually.(Equine Business Association – Link to Report )</p>', 'image' => public_path('/admin_assets/default_industry_matrics/industvact_1.svg')],
            ['title' => 'The Importance of Bloodlines & Pedigree', 'description' => '<p>The U.S. equine industry contributes approximately $177 billion to the economy and supports over 2.2 million jobs annually. (American Horse Council – Link to Report). Participation in hunter-jumper events has grown globally, with countries such as Germany, Belgium, and Australia boosting their competitive presence. (Fédération Equestre Internationale (FEI) –Link to Report). The global equine industry has a substantial economic impact, contributing approximately $300 billion annually.(Equine Business Association – Link to Report )</p>', 'image' => public_path('/admin_assets/default_industry_matrics/industvact_2.svg')],
            ['title' => 'Leasing & Pre-Qualification Trends', 'description' => '<p>The U.S. equine industry contributes approximately $177 billion to the economy and supports over 2.2 million jobs annually. (American Horse Council – Link to Report). Participation in hunter-jumper events has grown globally, with countries such as Germany, Belgium, and Australia boosting their competitive presence. (Fédération Equestre Internationale (FEI) –Link to Report). The global equine industry has a substantial economic impact, contributing approximately $300 billion annually.(Equine Business Association – Link to Report )</p>', 'image' => public_path('/admin_assets/default_industry_matrics/industvact_3.svg')],
            ['title' => 'Hunter/Jumper Industry Expansion:', 'description' => '<p>The U.S. equine industry contributes approximately $177 billion to the economy and supports over 2.2 million jobs annually. (American Horse Council – Link to Report). Participation in hunter-jumper events has grown globally, with countries such as Germany, Belgium, and Australia boosting their competitive presence. (Fédération Equestre Internationale (FEI) –Link to Report). The global equine industry has a substantial economic impact, contributing approximately $300 billion annually.(Equine Business Association – Link to Report )</p>', 'image' => public_path('/admin_assets/default_industry_matrics/industvact_1.svg')],
        ];

        $uploadPath = 'industry_matric';
        Storage::disk('public')->makeDirectory($uploadPath);

        foreach ($industryData as $data) {
            if (File::exists($data['image'])) {
                $extension = File::extension($data['image']);
                $filename = Str::uuid() . '.' . $extension;
                Storage::disk('public')->put($uploadPath . '/' . $filename, File::get($data['image']));

                // Save to DB
                IndustryMatric::create([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'image' => $uploadPath . '/' . $filename,
                ]);
            }
        }
    }
}
