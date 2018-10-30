<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Post;
use App\Category;
use Carbon\Carbon;
use App\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Notifications\NewPostNotify;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AuthorPostApproved;
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
        $posts = Post::latest()->get();
        return view('admin.post.index',compact('posts'));
    }

     /**
     * Pending the form for Pending 
     *
     * @return \Illuminate\Http\Response
     */
    public function pending()
    {
        $pending = Post::where('is_approved',false)->latest()->get();
        return view('admin.post.pending',compact('pending'));
    }

    public function penddingPost($id)
    {
        $post = Post::find($id);
        if($post->is_approved == true)
        {
            $post->is_approved = false;
            $post->save();
            Toastr::success('Post pendding saved','Success');
        }
        else
        {
            Toastr::error('Post aleary approved saved','Error');
        }
        return redirect()->back();
    }

    public function approve($id)
    {
        $post = Post::find($id);
        //return $post;
        if($post->is_approved == false)
        {
            $post->is_approved = true;
            $post->save();

            // 1. comfirm notification to author
            // Admin comfirm request from author and send message to Author
            $post->user->notify(new AuthorPostApproved($post));
            // end notification 

            // 2 send notification to subscriber when approved post
            $subscribers = Subscriber::all();
            foreach($subscribers as $subscriber)
            {
                Notification::route('mail',$subscriber->email)
                            ->notify(new NewPostNotify($post));
            }
            // end notification to subscriber



            Toastr::success('Post approved saved','Success');
        }
        else
        {
            Toastr::error('Post aleary approved saved','Error');
        }
        return redirect()->back();
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
        return view('admin.post.create',compact('tags','categories'));
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

            if(!Storage::disk('public')->exists('post'))
            {
                Storage::disk('public')->makeDirectory('post');
            }

            $postImage = Image::make($image)->resize(1600,1066)->stream();
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

        $post->is_approved = true;

        $post->save();

        $post->categories()->attach($request->categories); 
        $post->tags()->attach($request->tags);

        // notification to subscriber
        $subscribers = Subscriber::all();

        foreach($subscribers as $subscriber)
        {
            Notification::route('mail',$subscriber->email)
                        ->notify(new NewPostNotify($post));
        }
        // end notification to subscriber

        Toastr::success('Post succesfully saved','Success');
        return redirect()->back()->with('status','Post created success!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.post.show',compact('tags','categories','post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.post.edit',compact('tags','categories','post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
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
        return redirect()->route('admin.post.index')->with('status','Post Updated success!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        
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
