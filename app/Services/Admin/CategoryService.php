<?php

namespace App\Services\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    // Store a new category
    public function store($data)
    {
        $data['slug'] = $this->generateUniqueSlug($data['name']);
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
        // if ($data['name'] !== $category->name) {
        //     $data['slug'] = $this->generateUniqueSlug($data['name']);
        // }
        
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

    protected function generateUniqueSlug($name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
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
