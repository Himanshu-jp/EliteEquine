<?php
namespace App\Services\Admin;

use App\Models\SocailLink;

class SocialLinkService
{
    public function update(array $data): bool
    {
        $link = SocailLink::first(); 
        if (!$link) {
            $link = SocailLink::create($data);
            return (bool) $link;
        }

        return $link->update($data);
    }

    public function get()
    {
        return SocailLink::first();
    }
}
