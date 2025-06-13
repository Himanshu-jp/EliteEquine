<?php

namespace App\Services\Admin\website;

use App\Models\About;
use App\Models\AboutSellerBusiness;
use Illuminate\Support\Facades\Storage;

class AboutService
{
    protected $sections = ['listing', 'track', 'featured', 'post'];

    public function create(array $data): About
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('about', 'public');
        }

        return About::create($data);
    }

    public function update(About $about, array $data): About
    {
        if (isset($data['image'])) {
            if ($about->image && Storage::disk('public')->exists($about->image)) {
                Storage::disk('public')->delete($about->image);
            }

            $data['image'] = $data['image']->store('about', 'public');
        }

        $about->update($data);
        return $about;
    }

    public function delete($id): bool
    {
        $item = $this->find($id);
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        return $item->delete();
    }

    public function find($id): About
    {
        return About::findOrFail($id);
    }

    // about seller business
    public function sellerCreate(array $data): AboutSellerBusiness
    {
        // Handle main image upload
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('about_seller_business', 'public');
        }

        // Handle each section icon upload
        foreach ($this->sections as $section) {
            $iconKey = $section . '_icon';
            if (isset($data[$iconKey])) {
                $data[$iconKey] = $data[$iconKey]->store('about_seller_business/icons', 'public');
            }
        }

        return AboutSellerBusiness::create($data);
    }

    public function sellerUpdate($id, array $data)
    {
        // Handle main image replacement
        $aboutSellerBusiness = AboutSellerBusiness::findOrFail($id);
        if (isset($data['image'])) {
            if ($aboutSellerBusiness->image && Storage::disk('public')->exists($aboutSellerBusiness->image)) {
                Storage::disk('public')->delete($aboutSellerBusiness->image);
            }
            $data['image'] = $data['image']->store('seller_business', 'public');
        }

        // Handle each section icon replacement
        foreach ($this->sections as $section) {
            $iconKey = $section . '_icon';
            if (isset($data[$iconKey])) {
                // Delete old icon if exists
                if ($aboutSellerBusiness->{$iconKey} && Storage::disk('public')->exists($aboutSellerBusiness->{$iconKey})) {
                    Storage::disk('public')->delete($aboutSellerBusiness->{$iconKey});
                }
                $data[$iconKey] = $data[$iconKey]->store('seller_business/icons', 'public');
            }
        }

        $aboutSellerBusiness->update($data);
        return $aboutSellerBusiness;
    }

    public function sellerDelete(int $id): bool
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

    public function sellerFind(int $id): AboutSellerBusiness
    {
        return AboutSellerBusiness::findOrFail($id);
    }
}
