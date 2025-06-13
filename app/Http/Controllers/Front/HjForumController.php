<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CommentRequest;
use App\Http\Requests\Front\ForumRequest;
use Illuminate\Http\Request;
use App\Models\HjForum;
use App\Models\HjForumComment;
use App\Services\Front\HJForumService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class HjForumController extends Controller
{
    protected $forumService;

    public function __construct(HJForumService $forumService)
    {
        $this->forumService = $forumService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $forum = HjForum::with('user')->where(['user_id'=>$user->id,'deleted_at'=>null]);
        if ($request->filled('search')) {
            $forum->where('title', 'like', '%' . $request->search . '%');
            $forum->Orwhere('description', 'like', '%' . $request->search . '%');
        }
        $forum = $forum->orderBy('id', 'desc');
        $forum = $forum->paginate(10)->appends($request->query());
        return view('frontauth/HJForum/index',compact('forum'));

    }

    public function create()
    {
        return view('frontauth/HJForum/create');
    }

    public function store(ForumRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $forum = $this->forumService->create($data,$user);

        return redirect()->route('hjForum.index')->with('success', 'Hj Forum created successfully.');
    }

    public function edit($id)
    {
        $forum = HjForum::where('id',$id)->first();
        return view('frontauth/HJForum/create',compact('forum'));
    }


    public function update(ForumRequest $request,$id)
    {        
        $data = $request->all();
        $result =  $this->forumService->update($id, $data);
        return redirect()->route('hjForum.index')->with('success', 'Hj Forum updated successfully.');
    }

    public function destroy($id)
    {
        $this->forumService->delete($id);
        return redirect()->route('hjForum.index')->with('success', 'Hj Forum deleted successfully.');
    }


    public function hjForumListing(Request $request)
    {
        $forum = HjForum::with('user')->where('deleted_at', null);
        if ($request->has('search') && $request->search !== null) {
            $forum->where('title', 'like', '%' . $request->search . '%');
        }
        $forum = $forum->orderBy('id', 'desc')->paginate(10)->appends($request->all()); // keep search on pagination links        
        return view('front/hjForum',compact('forum'));
    }

    public function hjForumDetails($id)
    {
        $forum = HjForum::with(['user'])->where(['deleted_at' => null, 'id' => $id])->first();
         //----guest user cookie---//
        $guest = json_decode(Cookie::get('guest', '[]'), true);
        return view('front/hjForumDetails', compact(['forum','guest']));
    }

     public function forumCommentListing(Request $request, $id)
    {
        $forumId = $id;
        $data = HjForumComment::with('children')
            ->where('forum_id', $forumId)
            ->whereNull('forum_comment_id')
            ->with('children')
            ->orderBy('id', 'desc');

        $total = $data->count();
        $data = $data->paginate(10);

        $html = "";
         //----guest user cookie---//
        $guest = json_decode(Cookie::get('guest', '[]'), true);
        if($data->count()>0){
            $html = view('front/forum-comment', compact(['data','forumId','guest']))->render();
        }
        $pagination = $data->withQueryString()->links('pagination::bootstrap-4')->render();
        $totalPages = ceil($total / 10);


        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'total' => $total,
            'totalPages'=>$totalPages
        ]);
    }

    
    //----store product comment---//
    public function forumComment(CommentRequest $request)
    {
        if(!Auth::user()){
            // \Log::info("message: Guest user comment");
            $compare = [
                'name'=> $request->name,
                'email'=> $request->email,
                'website'=> $request->website
            ];            
            // Set updated cookie (120 minutes lifetime)
            Cookie::queue('guest', json_encode($compare), 120);
        }
            
        $user = (Auth::user())? Auth::user() : null;
        $validatedData = $request->all();
        $comment = $this->forumService->storeComment($validatedData, $user);

        return response()->json([
            'status' => true,
            'comment' => "DONE",
            'guest'=> [
                'name'=> $request->name,
                'email'=> $request->email,
                'website'=> $request->website
            ]
        ]);
    }

    //----update product comment---//
    public function commentUpdate(Request $request)
    {
        $request->validate([
            'comment' => 'required|max:5000',
            'comment_id' => 'required|exists:product_comments,id',
        ]);

        $guest = json_decode(Cookie::get('guest', '[]'), true);            
        $user = (Auth::user())? Auth::user() : null;

        if($user && $user->id != HjForumComment::find($request->comment_id)->user_id){
            return response()->json([
                'status' => false,
                'message' => "You are not authorized to update this comment.",
            ]);
        }

        if(!$user && $guest['email'] != HjForumComment::find($request->comment_id)->email){
            return response()->json([
                'status' => false,
                'message' => "You are not authorized to update this comment.",
            ]);
        }
        
        $comment = HjForumComment::find($request->comment_id);
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['status' => true, 'message' => 'Comment updated.']);
    }
    
    //----store product comment---//
    public function forumCommentDelete($id)
    {
        $guest = json_decode(Cookie::get('guest', '[]'), true);            
        $user = (Auth::user())? Auth::user() : null;


        if($user && $user->id != HjForumComment::find($id)->user_id){
            return response()->json([
                'status' => false,
                'message' => "You are not authorized to delete this comment.",
            ]);
        }

        if(!$user && $guest['email'] != HjForumComment::find($id)->email){
            return response()->json([
                'status' => false,
                'message' => "You are not authorized to delete this comment.",
            ]);
        }

        // Check if the comment exists
        if (!HjForumComment::find($id)) {
            return response()->json([
                'status' => false,
                'message' => "Comment not found.",
            ]);
        }
        
        // Call the service to remove the comment
        if(!$this->forumService->removeComment($id, $user)){
            return response()->json([
                'status' => false,
                'message' => "Failed to delete comment.",
            ]);
        }else{   
            return response()->json([
                'status' => true,
                'message' => "Comment deleted.",
            ]);
        }
    }
}
