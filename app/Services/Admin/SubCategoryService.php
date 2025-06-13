<?php

namespace App\Services\Admin;

use App\Models\SubCategory;
use Illuminate\Support\Collection;

class SubCategoryService
{
    public function create(array $data): SubCategory
    {
        return SubCategory::create($data);
    }

    public function update(SubCategory $subCategory, array $data): SubCategory
    {
        $subCategory->update($data);
        return $subCategory;
    }

    public function delete(SubCategory $subCategory): void
    {
        $subCategory->delete();
    }
}
