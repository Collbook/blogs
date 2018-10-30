<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // approved is scope function in post fronend model
        // function scopeApproved get only post is is_approved = 1

        // published is scope function in post fronend model
        // function scopePublished get only post is status = 1

        $posts = Post::latest()->approved()->published()->paginate(6);
        return view('posts',compact('posts'));
    }

    public function details($slug)
    {
        $post = Post::where('slug',$slug)->approved()->published()->first();
        //$randomPosts = Post::all()->random(3);
        $randomPosts = Post::approved()->published()->take(3)->inRandomOrder()->get();

        // view count
        $blogkey = 'blog_'.$post->id;
        if(!Session::has($blogkey))
        {
            $post->increment('view_count');
            Session::put($blogkey,1);
        }
        return view('post',compact('post','randomPosts'));
    }

    // post by category
    public function postByCategory($slug)
    {
        //$category  = Category::where('slug',$slug)->first();
        //$posts  = Category::where('slug',$slug)->first()->posts;
        $categories  = Category::where('slug',$slug)->first();
        
        //get post in category witdh status and approved equal "1"
        $posts = $categories->posts()->approved()->published()->get();

        return view('category',compact('categories','posts'));
        
    }

    public function postByTag($slug)
    {
        $tags  = Tag::where('slug',$slug)->first();
        //dd($categories);

        //get post in category witdh status and approved equal "1"
        $posts = $tags->posts()->approved()->published()->get();

        //return $tags;
        return view('tag',compact('tags','posts'));
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
