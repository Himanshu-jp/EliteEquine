<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::with('category')->where('deleted_at', null);
        if ($request->has('search') && $request->search !== null) {
            $blogs->where('title', 'like', '%' . $request->search . '%');
        }
        $blogs = $blogs->orderBy('id', 'desc')->paginate(9)->appends($request->all()); // keep search on pagination links        
        return view('front/blog', compact('blogs'));
    }

    public function blogDetails($id)
    {
        $blogs = Blog::with('category')->where(['deleted_at' => null, 'id' => $id])->first();
        $latestBlogs = Blog::with('category')->where('id','!=',$id)->where('deleted_at', null)->orderBy('id', 'desc')->take(4)->get();
        return view('front/blogDetails', compact(['blogs','latestBlogs']));
    }
}
