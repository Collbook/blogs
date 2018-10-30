<?php

namespace App\Http\Controllers\Author;

use App\Tag;
use App\Post;
use App\User;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewAuthorPost;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('user_id',Auth::id())->latest()->get();
        return view('author.post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('author.post.create',compact('tags','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'image' => 'required',
            'categories' => 'required',
            'tags' => 'required',
            'body'  => 'required'
        ]);


        $image = $request->file('image');
        $slug = str_slug($request->title);
        if(isset($image))
        {
            // make uniqe name for image
            $currentDate = Carbon::now()->toDateString();

            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'-'.$image->getClientOriginalName();
            
            // check exists folder
            if(!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }

            // rezie image for post
            $postImage = Image::make($image)->resize(1600,1066)->stream();
            // move image to folder
            Storage::disk('public')->put('post/'.$imageName,$postImage);
        }
        else
        {
            $imageName = "default.png";
        }


        $post = new Post();
        $post->title = $request->title;
        $post->user_id = Auth::id();
        $post->slug    = $slug;
        $post->image   = $imageName;
        $post->body    = $request->body;
        if(isset($request->status))
        {
            $post->status = true;
        }
        else
        {
            $post->status = false;
        }

        $post->is_approved = false;

        $post->save();

        $post->categories()->attach($request->categories); 
        $post->tags()->attach($request->tags);

        // notifications
        $users = User::where('role_id','1')->get();
        Notification::send($users,new NewAuthorPost($post));
        // end notifications


        Toastr::success('Post succesfully saved','Success');
        return redirect()->back()->with('status','Post created success!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if($post->user_id != Auth::id())
        {
            Toastr::error('Your are not authorized to access to this post','Error');
            return redirect()->back();
        }
        $tags = Tag::all();
        $categories = Category::all();
        return view('author.post.show',compact('tags','categories','post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if($post->user_id != Auth::id())
        {
            Toastr::error('Your are not authorized to access to this post','Error');
            return redirect()->back();
        }
        
        $tags = Tag::all();
        $categories = Category::all();
        return view('author.post.edit',compact('tags','categories','post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if($post->user_id != Auth::id())
        {
            Toastr::error('Your are not authorized to access to this post','Error');
            return redirect()->back();
        }

        $this->validate($request,[
            'title' => 'required',
            'image' =>'image|mimes:jpeg,jpg,png,gif|required|max:10000',
            'categories' => 'required',
            'tags' => 'required',
            'body'  => 'required'
        ]);

        //dd($request);

        $image = $request->file('image');
        $slug = str_slug($request->title);
        if(isset($image))
        {
            // make uniqe name for image
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'-'.$image->getClientOriginalName();

            if(!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }
            // delete old image for post
            if(Storage::disk('public')->exists('post/'.$post->image))
            {
                Storage::disk('public')->delete('post/'.$post->image);
            }

            $postImage = Image::make($image)->resize(1600,1066)->stream();
            Storage::disk('public')->put('post/'.$imageName,$postImage);
        }
        else
        {
            $imageName = $post->image;
        }


        $post->title = $request->title;
        $post->user_id = Auth::id();
        $post->slug    = $slug;
        $post->image   = $imageName;
        $post->body    = $request->body;
        if(isset($request->status))
        {
            $post->status = true;
        }
        else
        {
            $post->status = false;
        }

        $post->is_approved = true;

        $post->save();

        $post->categories()->sync($request->categories); 
        $post->tags()->sync($request->tags);


        Toastr::success('Post succesfully Updated','Success');
        return redirect()->route('author.post.index')->with('status','Post Updated success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->user_id != Auth::id())
        {
            Toastr::error('Your are not authorized to access to this post','Error');
            return redirect()->back();
        }

        if(Storage::disk('public')->exists('post/'.$post->image))
        {
            Storage::disk('public')->delete('post/'.$post->image);
        }

        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Post delete success','Success');
        return redirect()->back();
    }
}
