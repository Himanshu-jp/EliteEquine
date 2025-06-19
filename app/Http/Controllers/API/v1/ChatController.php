<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Services\API\v1\CategoryService;
use App\Http\Controllers\API\v1\BaseController;
use App\Jobs\EmailSendJob;

use App\Models\{User,Conveniencs,ChatUser,Chat};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\API\v1\user\ThreadResource;
use App\Http\Resources\API\v1\user\ChatCollection;
use Auth;
use App\Helpers\Helper;
use App\Http\Resources\API\v1\user\ChatResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use FFMpeg;

class ChatController extends BaseController
{
   
    public function getUser(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'convenience_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 200);
        }

 
        try {
            $input = $request->all();
            $data = User::with(['chatuser' => function ($q) use ($input) {
                $q->where('convenience_id', $input['convenience_id'])
                    ->whereNot('user_id', $input['user_id']);
            }])->whereHas('chatuser', function ($q) use ($input) {
                $q->where('convenience_id', $input['convenience_id'])
                    ->whereNot('user_id', $input['user_id']);
            })->get();

            if (isset($data)) {
                return $this->sendResponse($data, 'User get successfully.');
            } else {
                return $this->sendError('User not found.', null, 200);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Oppes! Something went wrong.', null, 200);
        }
    }
    
    public function userOnOff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status'           => 'required|in:0,1',
            'socket_id'        => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),null,200);
        } 
         
        try 
        {           
            if($request->status==1)
            {
                $user = User::where('id',$request->user_id)->update(['is_online'=>$request->status,'socket_id'=>$request->socket_id]);
                $data = User::where('id',$request->user_id)->select('id', 'name', 'username', 'email', 'is_online', 'socket_id','profile_photo_path')->first();
                
                return $this->sendResponse($data, 'Your are online.');
            }
            else
            {
                $user = User::where('socket_id',$request->socket_id)->update(['is_online'=>$request->status,'socket_id'=>$request->socket_id]);
                $data = User::where('socket_id',$request->socket_id)->select('id', 'name', 'username', 'email', 'is_online', 'socket_id','profile_photo_path')->first();
                
                $chatuser = ChatUser::where('user_id',$data->id)->where('is_user_online',1)->first();
                if($chatuser){
                    $chatuser->is_user_online = 0;
                    $chatuser->save();
                }
                return $this->sendResponse($data, 'Your are offline.');
            }
       
        } catch (\Throwable $th) {
            // return $this->sendError('Oops! Something went wrong.', [
            //     'error' => $th->getMessage(),
            //     'file' => $th->getFile(),
            //     'line' => $th->getLine(),
            // ], 500);
            return $this->sendError('Oppes! Something went wrong.',null,200);
        } 
    }

    public function roomCreate(Request $request)
    {
        $q = Conveniencs::with('chatuser')->where(['ticket_type' => $request['ticket_type'], 'ticket_id' => $request['ticket_id'] ?? 0]);
    
        $q->whereHas('chatuser', function($q) use($request) {
            $q->where('user_id', $request['sender_id']);
        })->whereHas('chatuser', function($q) use($request) {
            $q->where('user_id', $request['receiver_id']);
        });
        
 
        $convenien = $q->first();
        if (!isset($convenien)) {
            $convenien = new Conveniencs;
            $convenien->type = 'SINGLE';
            $convenien->group_name = 'Elite Equine';
            $convenien->ticket_type = 'Single';
            $convenien->ticket_id = 0;
            $convenien->last_message = '';
            $convenien->save();
        }else{
            ChatUser::where('convenience_id', $convenien->id)->update(['is_user_delete' => 0]);
            return $this->sendResponse($convenien->id, 'Thread is already exists.');
        }
        
        // Add the from_id user
        $chatUser = ChatUser::where('convenience_id', $convenien->id)->where('user_id', $request['sender_id'])->first();
        if (!isset($chatUser)) {
            $chatUser = new ChatUser;
            $chatUser->convenience_id = $convenien->id;
            $chatUser->user_id = $request['sender_id'];
            $chatUser->save();
        }
     
        // Single user case
        $chatUser = ChatUser::where('convenience_id', $convenien->id)->where('user_id', $request['receiver_id'])->first();
        if (!isset($chatUser)) {
            $chatUser = new ChatUser;
            $chatUser->convenience_id = $convenien->id;
            $chatUser->user_id = $request['receiver_id'];
            $chatUser->save();
        }
        return $this->sendResponse($convenien->id, 'Thread Created successfully.');
    }

    public function threadList(Request $request)
    {
        Log::info(request()->all());
        
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 200);
        }

        $limit = $request->limit;
        $offset = 0;
        $page = $request->page;
        $offset = ($request->page - 1) * $limit;

        $user_id = $request->user_id;
        $chatList = ChatUser::where('user_id',$user_id)->pluck('convenience_id');
        $list = ChatUser::with(['getUser','room'])
            ->where('user_id','!=',$user_id)
            ->where('is_user_delete', 0)
            ->whereIn('convenience_id',$chatList->toArray())
            ->withCount(['chat as total_unread' => function ($q) use ($user_id) {
                    $q->whereRaw('NOT FIND_IN_SET(?, is_read)', [$user_id]);
                }]);

        if(isset($request->search) && !empty($request->search) && $request->search != 'all') {
            $search = $request->search;
            $list->where(function ($q) use ($search) {
                return $q->orWhereRelation('getUser', 'username', 'like', '%' . $search . '%');
            });
        }

        $list = $list->orderBy('updated_at', 'desc');
        $list = $list->limit($limit);
        $list = $list->offset($offset);
        $list = $list->get();        

        if ($list) {
            $list = ThreadResource::collection($list);
            return $this->sendResponse($list, 'Thread list successfully submitted.');
        } else {
            return $this->sendError('User Not Found.', null, 200);
        }
    }

    public function sendMessage(Request $request)
    {
        Log::info($request->all());
        $validator = Validator::make($request->all(), [
            'user_id'          => 'required',
            'to_id'          => 'required',
            'convenience_id'    => 'required',
            'message'           => '',
            'type'              => 'required'
            //'file'
            //'file_type'
            //'reply_id'
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),null,200);
        } 
         
        try 
        {  
            $chat=  new Chat;
            $chat->convenience_id = $request->convenience_id;
            $chat->chat_user_id = 0;
            $chat->from_id = $request->user_id ?? 0;
            $chat->to_id = $request->to_id  ?? 0;
            $chat->message = $request->message ?? ''; 
            $chat->is_read = '0,' . $request->user_id;
            $chat->file = ($request->file)?$request->file:'';
            $chat->thumbnail = ($request->thumbnail)?$request->thumbnail:'';
            $chat->file_type = $request->type;
            
            
            
            $usre_id=$request->user_id;
            $Senderdetails=User::where('id',$usre_id)->first();
$snder_name=$Senderdetails->name;

            $receiverr=$request->to_id;

$userdetails=User::where('id',$receiverr)->first();
    $mainUseData = ['FirstName'=>$userdetails->name,'snder_name'=>$snder_name];


           $data=array('code'=>'new_messsage','email'=>$userdetails->email,'dataArray'=>$mainUseData,'name'=>$userdetails->name);
                EmailSendJob::dispatch($data);


            // if($request->type == 'IMAGE'){
            //     $imagePath = $request->file->store('chat/images', 'public');
            //     $chat->file = $imagePath;
            // }
            // else if($request->type == 'VIDEO'){

            //     $videoPath = $request->file->store('chat/videos', 'public');
            //     $thumbnailFilename = Str::uuid() . '.jpg';
            //     $thumbnailPath = 'chat/thumbnails/' . $thumbnailFilename;

            //     // Generate Thumbnail using FFmpeg
            //     FFMpeg::fromDisk('public')
            //         ->open($videoPath)
            //         ->getFrameFromSeconds(1)
            //         ->export()
            //         ->toDisk('public')
            //         ->save($thumbnailPath);

            //     $chat->file = $videoPath;
            //     $chat->thumbnail = $thumbnailPath;
            // }
            // if($request->type == 'DOC'){

            //     $imagePath = $request->file->store('chat/doc', 'public');
            //     $chat->file = $imagePath;
            //     $chat->thumbnail = "chat/thumbnails/default.png";
            // }
            $chat->save();

            // $deleteon = ChatUser::where('convenience_id',$request->convenience_id)->where('user_id','<>',$request->user_id)->first();
            // $deleteon->is_user_delete = 0;
            // $deleteon->save();
            
            // $chatcount = ChatUser::where('convenience_id',$request->convenience_id)->where('user_id','<>',$request->user_id)->get();
            // foreach($chatcount as $chatvalue){
            //     $userrecord = User::where('id',$chatvalue->user_id)->first();
            //     if($userrecord->is_online == 0){
            //         $chatvalue->chat_user = 1;
            //         $chatvalue->save();
            //     }
            // }

            // $updata = ChatUser::where('convenience_id',$request->convenience_id)->where('user_id','<>',$request->user_id)->get();
           
            // if ($updata->isNotEmpty()) {
            //     foreach ($updata as $value) {
            //         if ($value->is_user_online) {
            //             $upchat = Chat::find($chat->id);
            //             $upchat->is_read .= ',' . $value->user_id;
            //             $upchat->save();
            //         }
            //     }
            // }

            
            $conv = Conveniencs::find($request->convenience_id);
            if(isset($conv))
            {

                $conv->last_message= $request->message ?? $request->type;
                $conv->updated_at = date('Y-m-d H:i:s');
                $conv->save();

                //notification
                // if($conv->type == 'SINGLE'){
                //     $touser = User::where('id', $request->to_id)->first();
                //     $device_token = $touser->fcm_token;
                //     $fromuser = User::where('id',$request->user_id)->first();
                //     $title = $fromuser->username;
                //     $bodyMsg = $request->message ?? $request->type;
                //     if($touser->is_notification == '1'){
                //         Helper::sendFcmNotfication($device_token,$bodyMsg,$title);
                //     }
                // }else{
                //     $touserdata = ChatUser::where('convenience_id', $conv->id)->where('user_id','<>',$request->user_id)->get();
                //     foreach($touserdata as $touser){
                //         $touserrecord = User::where('id', $touser->user_id)->first();
                //         $device_token = $touserrecord->fcm_token;
                //         if($device_token){
                //             $fromuser = User::where('id',$request->user_id)->first();
                //             $title = $fromuser->username;
                //             $bodyMsg = $request->message ?? $request->type;
                //             if($touserrecord->is_notification == '1'){
                //                 Helper::sendFcmNotfication($device_token,$bodyMsg,$title);
                //             }
                //         }
                //     }
                // }

            }
           
            $data = Chat::with('sender')->where('id',$chat->id)->first();
            return $this->sendResponse($data, 'Message send successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Oppes! Something went wrong.',null,200);
        } 
    }

    public function chatDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'          => 'required',
            'convenience_id'    => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),null,200);
        } 
         
        try { 

            $limit = ($request->limit)?$request->limit:10;
            $offset = 0;
            $page = ($request->page)?$request->page:1;
            $offset = ($page - 1) * $limit;


            $chatuser = ChatUser::where('user_id',$request->user_id)->where('is_user_online',1)->first();
            if($chatuser){
                $chatuser->is_user_online = 0;
                $chatuser->save();
            }
            $newchatuser = ChatUser::where('user_id',$request->user_id)->where('convenience_id',$request->convenience_id)->first();
            if($newchatuser){
                $newchatuser->is_user_online = 1;
                $newchatuser->save();
            }

            $data = Chat::with(['sender','receiver'])
            ->whereRaw('NOT FIND_IN_SET(?, is_clear)', [$request->user_id])
            ->where('convenience_id',$request->convenience_id)
            ->orderBy('created_at','DESC')
            ->limit($limit)
            ->offset($offset)
            ->get();

            if($data[0])
            {
                $data = new ChatCollection($data);
                return $this->sendResponse($data, 'Chat List fetch successfully');
            }
            else
            {
                return $this->sendResponse($data, 'Chat not found.');               
            }
       

        } catch (\Throwable $th) {
            return $this->sendError('Oppes! Something went wrong.',null,200);
        } 
    }

    public function messageRead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'          => 'required',
            'convenience_id'    => 'required',
            'type'           => ['required','in:all,single'],
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),null,200);
        } 
         
        try 
            {
                $data = Chat::whereRaw('NOT FIND_IN_SET(?, is_read)', [$request->user_id])->where('convenience_id',$request->convenience_id)->get();
                foreach($data as $value){
                    $ex_is_read = explode(',', $value->is_read);
                    $ex_is_read[] = $request->user_id;
                    $ex_is_read = array_unique($ex_is_read);
                    $value->is_read = implode(',',$ex_is_read);
                    $value->save();

                }  
                return $this->sendResponse($data, 'Chat read successfully');
            
            } catch (\Throwable $th) {
            return $this->sendError('Oppes! Something went wrong.',null,200);
        } 
    }

    public function messageDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'          => 'required',
            'convenience_id'   => 'required',
            'type'           => ['required','in:all,single'],
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),null,200);
        } 
         
        try 
        {
            if($request->type=='all')
            {
                $currentValue = Chat::where('convenience_id', $request->convenience_id)->whereRaw('NOT FIND_IN_SET(?, is_clear)', [$request->user_id])->get();
                if(isset($currentValue[0])){
                    foreach($currentValue as $currentdata){
                        $currentdata->is_clear = implode(',',array_unique(explode(',',$currentdata->is_clear.','.$request->user_id)));
                        $currentdata->save();
                    }

                }
                $Convenien = Conveniencs::where('id',$request->convenience_id)->update(['last_message' => '']);
                $data = [
                    'sender_id' => $request->user_id,
                ];   
            }  
            else
            {
                $Convenien = Conveniencs::where('id',$request->convenience_id)->update(['last_message' => '']);
                $currentValue = Chat::where('convenience_id', $request->convenience_id)->value('is_clear');
                $currentIds = $currentValue ? explode(',', $currentValue) : [];
                if (!in_array($request->user_id, $currentIds)) {
                    $currentIds[] = $request->user_id;
                }
                $newValue = implode(',', $currentIds);
                $data = Chat::where('convenience_id', $request->convenience_id)->update(['is_clear' => $newValue]);         
            }  
            return $this->sendResponse($data, 'Chat deleted successfully');                 
        } catch (\Throwable $th) {
            return $this->sendError('Oppes! Something went wrong.',null,200);
        } 
    }

    public function singlemessageDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'          => 'required',
            'convenience_id'   => 'required',
            'message_id'   => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),null,200);
        } 
         
        try 
        {
            $lastmsg = Chat::where('convenience_id', $request->convenience_id)->orderBy('id','desc')->first();
            if($lastmsg->id == $request->message_id){
                $Convenien = Conveniencs::where('id',$request->convenience_id)->update(['last_message' => '']);
            }

            $currentValue = Chat::where('convenience_id', $request->convenience_id)->where('id', $request->message_id)->delete();
           
            $data = [
                'sender_id' => $request->user_id,
                'messageId' => $request->message_id,
            ];   
            return $this->sendResponse($data, 'Message deleted successfully');                 
        } catch (\Throwable $th) {
            return $this->sendError('Oppes! Something went wrong.',null,200);
        } 
    }

     // ------------------------------------------------------------------

    //----for deleting an user -----//
    public function deletemychat(Request $request){
        $validator = Validator::make($request->all(), [
            'roomId'          => 'required',
            'user_id'          => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),null,200);
        } 
        $roomid = $request->roomId;
        $authUserId = $request->user_id;

        $currentValue = Chat::where('convenience_id', $roomid)->whereRaw('NOT FIND_IN_SET(?, is_clear)', [$authUserId])->get();
        if(isset($currentValue[0])){
            foreach($currentValue as $currentdata){
                $currentdata->is_clear = implode(',',array_unique(explode(',',$currentdata->is_clear.','.$authUserId)));
                $currentdata->save();
            }

        }

        $data = ChatUser::where('convenience_id',$roomid)->where('user_id','!=',$authUserId)->first();
        $data->is_user_delete = 1;
        $data->save();
        return response()->json(['status' => true, 'message' => 'Chat Deleted', 'responsecode' => 200], 200);
    }

    //----for deleting an multiple user -----//
    public function deleteMultipleUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roomId'   => 'required|array',
            'user_id'  => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), null, 200);
        }

        $roomIds = $request->roomId;
        $authUserId = $request->user_id;

        foreach ($roomIds as $roomid) {
            // Update is_clear for Chat records
            $chatItems = Chat::where('convenience_id', $roomid)
                ->whereRaw('NOT FIND_IN_SET(?, is_clear)', [$authUserId])
                ->get();

            foreach ($chatItems as $chat) {
                $chat->is_clear = implode(',', array_unique(explode(',', $chat->is_clear . ',' . $authUserId)));
                $chat->save();
            }

            // Mark user as deleted in ChatUser
            $chatUser = ChatUser::where('convenience_id', $roomid)
                ->where('user_id', '!=', $authUserId)
                ->first();

            if ($chatUser) {
                $chatUser->is_user_delete = 1;
                $chatUser->save();
            }
        }

        return response()->json([
            'status'       => true,
            'message'      => 'Selected chats deleted successfully',
            'responsecode' => 200
        ], 200);
    }


    //----for restore an user -----//
    public function onbackthreadupdate(Request $request){
        $validated = Validator::make($request->all(), [
            'roomId' => 'required',
            'user_id' => 'required',
        ]);
        if ($validated->fails() == true) {
            $errors = $validated->errors();
            return response()->json(['status' => False, 'message' => $errors->first(), 'errors' => $errors,'responsecode' => 422], 422);
        }
        $data = ChatUser::where('user_id',$request->user_id)->where('convenience_id',$request->roomId)->first();
        $data->is_user_delete = 0;
        $data->save();
        return response()->json(['status' => true, 'message' => 'user back for this thread', 'responsecode' => 200], 200);
    }

    public function fileUpload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'attachment' => 'required|mimes:jpg,jpeg,png,gif,webp,svg,mp4,mov,doc,docx,pdf|max:15360',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(),null,200);
        }
        try 
        {
            if(isset($request->attachment))
            {
                // $imageName = 'review_' . time() . '.' . $request->attachment->extension();
                $type = 'IMAGE';
                $imageName="";
                $thumbnailPath="";
                // ----------------------------------------------------------------------------------
                if(in_array($request->attachment->extension(),['jpg','JPG','jpeg','JPEG','png','PNG','gif','GIF','webp','svg']))
                {
                    $type = 'IMAGE';
                    $imageName = $request->attachment->store('chat/images', 'public');
                }
                else if(in_array($request->attachment->extension(),['mp4','Mp4','mov','MOV']))
                {
                    $type = 'VIDEO';

                    $videoPath = $request->attachment->store('chat/videos', 'public');
                    $thumbnailFilename = Str::uuid() . '.jpg';
                    $thumbnailPath = 'chat/thumbnails/' . $thumbnailFilename;

                    // Generate Thumbnail using FFmpeg
                    FFMpeg::fromDisk('public')
                        ->open($videoPath)
                        ->getFrameFromSeconds(1)
                        ->export()
                        ->toDisk('public')
                        ->save($thumbnailPath);

                    $imageName = $videoPath;
                    $thumbnailPath = $thumbnailPath;
                }
                if(in_array($request->attachment->extension(),['doc','docx','xls','xls','pdf'])){

                    $type = 'DOC';
                    $imagePath = $request->attachment->store('chat/doc', 'public');
                    $imageName = $imagePath;
                    $thumbnailPath = "chat/thumbnails/default.png";
                }
                // ----------------------------------------------------------------------------------
                return $this->sendResponse(array(
                    'image'=>$imageName,
                    'thumbnail'=>$thumbnailPath,
                    'type'=>$type
                ), 'Media upload successfully');                 
            }   
        } catch (\Throwable $th) {
            return $this->sendError('Oppes! Something went wrong.',null,200);
        }
    }
    
}
