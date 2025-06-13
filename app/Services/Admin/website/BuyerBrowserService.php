<?php

namespace App\Services\Admin\website;

use App\Models\BuyerBrowser;
use Illuminate\Support\Facades\Storage;

class BuyerBrowserService
{
    /**
     * Store a newly created BuyerBrowser.
     */
    public function store(array $data): BuyerBrowser
    {        
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('buyer_browser', 'public');
        }
        $buyer = BuyerBrowser::create($data);
        return $buyer;
    }

    /**
     * Update the given BuyerBrowser.
     */
    public function update(BuyerBrowser $buyer, array $data): bool
    {
        if (isset($data['image'])) {
            if ($buyer->image) {
                Storage::disk('public')->delete($buyer->image);
            }

            $data['image'] = $data['image']->store('buyer_browser', 'public');
        }

        return $buyer->update($data);
    }

    /**
     * Soft delete a BuyerBrowser.
     */
    public function delete(BuyerBrowser $buyer): bool
    {
        return $buyer->delete();
    }

    /**
     * Restore a soft deleted BuyerBrowser.
     */
    public function restore($id): bool
    {
        $buyer = BuyerBrowser::withTrashed()->findOrFail($id);
        return $buyer->restore();
    }
}
