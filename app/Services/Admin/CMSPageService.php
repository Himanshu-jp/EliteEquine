<?php

namespace App\Services\Admin;

use App\Models\CMSPage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CMSPageService
{
    public function create(array $data)
    {
        $data['slug'] = $this->generateUniqueSlug($data['name']);

        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('pages', 'public');
        }

        return CMSPage::create($data);
    }

    public function update(CMSPage $cmsPage, $data)
    {
        if ($data['name'] !== $cmsPage->name) {
            $data['slug'] = $this->generateUniqueSlug($data['name'], $cmsPage->id);
        }

        if (isset($data['image'])) {
            if ($cmsPage->image) {
                Storage::disk('public')->delete($cmsPage->image);
            }
            $data['image'] = $data['image']->store('pages', 'public');
        }

        $cmsPage->update($data);
        return $cmsPage;
    }

    //cms page image delete
    public function deleteImage($id)
    {
        $page = CMSPage::findOrFail($id);

        if ($page->image) {
            Storage::disk('public')->delete($page->image);
            $page->update(['image' => null]); 
        }

        return $page;
    }


    // Fetch single CMS page by ID
    public function find($id)
    {
        return CMSPage::findOrFail($id); // or ->withTrashed()->findOrFail($id) if soft deletes
    }

    public function delete($id)
    {
        $page = CMSPage::findOrFail($id); 

        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }

        $page->delete();
    }

    protected function generateUniqueSlug(string $name, $excludeId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;

        while (
            CMSPage::where('slug', $slug)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}
