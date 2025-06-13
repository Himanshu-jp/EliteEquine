<?php
namespace App\Services\Front;

use App\Models\Community;
use App\Models\EventAttendees;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CommunityEventsService
{
    public function create($data,$user)
    {        
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('community', 'public');
        }
        $data['user_id'] = $user->id; // Assuming you pass the user object
        $community = Community::create($data);
        return $community;
    }

    public function update($id,$data)
    {
        $community = Community::where('id',$id)->first();
        // Handle image update
        if (isset($data['image'])) {
            if ($community->image && Storage::disk('public')->exists($community->image)) {
                Storage::disk('public')->delete($community->image);
            }
            $data['image'] = $data['image']->store('community', 'public');
        }        
        $community = $community->update($data);
        return $community;
    }

    public function delete($id)
    {
        $community = Community::where('id',$id)->delete();
    }


    // Store a new member into Event Attendees
    public function joinAnEvent($data,)
    {
        return EventAttendees::create($data);
    }
}
