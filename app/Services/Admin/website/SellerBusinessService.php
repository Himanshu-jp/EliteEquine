<?php

namespace App\Services\Admin\website;

use App\Models\SellerBusiness;
use Illuminate\Support\Facades\Storage;

class SellerBusinessService
{
    protected $sections = ['listing', 'track', 'featured', 'post'];

    public function create(array $data): SellerBusiness
    {
        // Handle main image upload
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('seller_business', 'public');
        }

        // Handle each section icon upload
        foreach ($this->sections as $section) {
            $iconKey = $section . '_icon';
            if (isset($data[$iconKey])) {
                $data[$iconKey] = $data[$iconKey]->store('seller_business/icons', 'public');
            }
        }

        return SellerBusiness::create($data);
    }

    public function update($id, array $data)
    {
        // Handle main image replacement
        $sellerBusiness = SellerBusiness::findOrFail($id);
        if (isset($data['image'])) {
            if ($sellerBusiness->image && Storage::disk('public')->exists($sellerBusiness->image)) {
                Storage::disk('public')->delete($sellerBusiness->image);
            }
            $data['image'] = $data['image']->store('seller_business', 'public');
        }

        // Handle each section icon replacement
        foreach ($this->sections as $section) {
            $iconKey = $section . '_icon';
            if (isset($data[$iconKey])) {
                // Delete old icon if exists
                if ($sellerBusiness->{$iconKey} && Storage::disk('public')->exists($sellerBusiness->{$iconKey})) {
                    Storage::disk('public')->delete($sellerBusiness->{$iconKey});
                }
                $data[$iconKey] = $data[$iconKey]->store('seller_business/icons', 'public');
            }
        }

        $sellerBusiness->update($data);
        return $sellerBusiness;
    }

    public function delete(int $id): bool
    {
        $item = $this->find($id);

        // Delete main image
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        // Delete section icons
        foreach ($this->sections as $section) {
            $iconKey = $section . '_icon';
            if ($item->{$iconKey} && Storage::disk('public')->exists($item->{$iconKey})) {
                Storage::disk('public')->delete($item->{$iconKey});
            }
        }

        return $item->delete();
    }

    public function find(int $id): SellerBusiness
    {
        return SellerBusiness::findOrFail($id);
    }
}
