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

                $image = $data['image']->store('community', 's3');

    // Make the file publicly accessible
    Storage::disk('s3')->setVisibility($image, 'public');

    // Get full URL
    $data['image'] = Storage::disk('s3')->url($image);

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
    // Delete old image from S3 if it exists
    if ($community->image && Storage::disk('s3')->exists($community->image)) {
        Storage::disk('s3')->delete($community->image);
    }

    // Store new image in S3
    $path = $data['image']->store('community', 's3');
    Storage::disk('s3')->setVisibility($path, 'public');

    // Save full S3 URL
    $data['image'] = Storage::disk('s3')->url($path);
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
