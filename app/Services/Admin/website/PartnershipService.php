<?php

namespace App\Services\Admin\website;

use App\Models\PartnershipContent;
use App\Models\PartnerShipCollaborate;
use App\Models\PartnershipWay;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

class PartnershipService
{
    public function create(array $data): PartnershipContent
    {
        return PartnershipContent::create($data);
    }

    public function update(PartnershipContent $partnership, array $data): PartnershipContent
    {
        $partnership->update($data);
        return $partnership;
    }

    public function find($id): PartnershipContent
    {
        return PartnershipContent::findOrFail($id);
    }

    // partnership collaborate
    public function collaborateAll(): LengthAwarePaginator
    {
        return PartnerShipCollaborate::withoutTrashed()->latest()->paginate(10);
    }

    public function collaborateCreate(array $data): array
    {
        $created = [];

        if (isset($data['image']) && is_array($data['image'])) {
            foreach ($data['image'] as $file) {
                $path = $file->store('partnership_collaborate', 'public');

                $created[] = PartnerShipCollaborate::create([
                    'image' => $path,
                ]);
            }
        }

        return $created;
    }

    public function collaborateUpdate($id, array $data)
    {
        $partnershipCollaborate = PartnerShipCollaborate::findOrFail($id);

        if (isset($data['image']) && is_array($data['image']) && count($data['image']) > 0) {
            // Delete old image if exists
            if ($partnershipCollaborate->image && Storage::disk('public')->exists($partnershipCollaborate->image)) {
                Storage::disk('public')->delete($partnershipCollaborate->image);
            }

            // Store only the first uploaded image
            $data['image'] = $data['image'][0]->store('partnership_collaborate', 'public');
        }

        $partnershipCollaborate->update($data);

        return $partnershipCollaborate;
    }

    public function collaborateDestroy(int $id): bool
    {
        $item = PartnershipCollaborate::findOrFail($id);

        // Delete main image
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        return $item->delete();
    }

    public function collaborateRestore($id)
    {
        $addon = PartnerShipCollaborate::withTrashed()->findOrFail($id);
        $addon->restore();
    }

    public function collaborateFind(int $id): PartnershipCollaborate
    {
        return PartnerShipCollaborate::findOrFail($id);
    }

    // partnership ways to gate
    public function waysCreate(array $data): PartnershipWay
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('partnership_ways', 'public');
        }

        return PartnershipWay::create($data);
    }

    public function waysFind($id): PartnershipWay
    {
        return PartnershipWay::findOrFail($id);
    }

    public function waysUpdate(PartnershipWay $partnershipWay, array $data): PartnershipWay
    {
        if (isset($data['image'])) {
            // Delete old image if exists
            if ($partnershipWay->image && Storage::disk('public')->exists($partnershipWay->image)) {
                Storage::disk('public')->delete($partnershipWay->image);
            }
            $data['image'] = $data['image']->store('partnership_ways', 'public');
        }

        $partnershipWay->update($data);

        return $partnershipWay;
    }

    public function waysDelete($id): void
    {
        $partnershipWay = PartnershipWay::findOrFail($id);

        // Delete image if exists
        if ($partnershipWay->image && Storage::disk('public')->exists($partnershipWay->image)) {
            Storage::disk('public')->delete($partnershipWay->image);
        }

        $partnershipWay->delete();
    }
}
