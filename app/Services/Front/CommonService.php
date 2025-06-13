<?php

namespace App\Services\Front;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CommonService
{
    // Store a new category
    public function store($data)
    {
        if (isset($data['image'])) {
            // Store the image and get the path
            $data['image'] = $data['image']->store('categories', 'public');
        }

        // Create the category
        return Category::create($data);
    }

    // Update an existing category
    public function update(Category $category, $data)
    {
        if (isset($data['image'])) {
            // Delete old image if exists
            if ($category->image) {
                Storage::delete('public/' . $category->image);
            }
            // Store the new image and get the path
            $data['image'] = $data['image']->store('categories', 'public');
        }

        if (isset($data['old_image'])) {
            $data['image'] = $data['old_image'];
        }

        // Update the category
        $category->update($data);

        return $category;
    }

    // Delete a category (soft delete)
    public function destroy(Category $category)
    {
        // Soft delete the category
        $category->delete();
    }

    // Restore a deleted category (soft delete)
    public function restore(Category $category)
    {
        $category->restore();
    }
}
