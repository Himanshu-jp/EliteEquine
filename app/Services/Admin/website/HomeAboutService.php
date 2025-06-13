<?php

namespace App\Services\Admin\website;

use App\Models\HomeAbout;
use Illuminate\Support\Facades\Storage;

class HomeAboutService
{
    public function create(array $data): HomeAbout
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('home_about', 'public');
        }

        return HomeAbout::create($data);
    }

    public function update(HomeAbout $homeAbout, array $data): HomeAbout
    {
        if (isset($data['image'])) {
            if ($homeAbout->image && Storage::disk('public')->exists($homeAbout->image)) {
                Storage::disk('public')->delete($homeAbout->image);
            }

            $data['image'] = $data['image']->store('home_about', 'public');
        }

        $homeAbout->update($data);
        return $homeAbout;
    }

    public function delete($id): bool
    {
        $item = $this->find($id);
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        return $item->delete();
    }

    public function find($id): HomeAbout
    {
        return HomeAbout::findOrFail($id);
    }
}
