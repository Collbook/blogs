<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\User;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $popular_posts      = Post::withCount('comments')
                              ->withCount('favorite_to_users') // relation ship in POST model
                              ->orderBy('view_count','desc')  // field in db
                              ->orderBy('comments_count','desc')
                              ->orderBy('favorite_to_users_count','desc')
                              ->take(5)->get();

        $total_pending_posts = Post::where('is_approved',false)->count();
        $all_views           = Post::sum('view_count');
        
        $new_authors_today  = User::where('role_id',2)
                              ->whereDate('created_at',Carbon::today())->count();

        $active_authors     = User::where('role_id',2)
                              ->withCount('posts') // relation ship in model
                              ->withCount('comment')
                              ->withCount('favorite_posts')
                              ->orderBy('posts_count','desc')
                              ->orderBy('comment_count','desc')
                              ->orderBy('favorite_posts_count','desc')->get();

        $author_count       = User::where('role_id',2)->count();
        $category_count     = Category::all()->count();
        $tag_count          = Tag::all()->count();

        //dd($author_count);
        return view('admin.dashboard',compact('posts','popular_posts','total_pending_posts','all_views','author_count','new_authors_today','active_authors','category_count','tag_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
