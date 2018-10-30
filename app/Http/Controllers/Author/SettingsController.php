<?php

namespace App\Http\Controllers\Author;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('author.setting.index');
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
    public function updateprofile(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'required|image',
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->name);
        $user = User::findOrFail(Auth::id());

        if(isset($image))
        {
             // make uniqe name for image
             $currentDate = Carbon::now()->toDateString();
             $imageName = $slug.'-'.$currentDate.'-'.uniqid().'-'.$image->getClientOriginalName();
 
             if(!Storage::disk('public')->exists('profile'))
             {
                 Storage::disk('public')->makeDirectory('profile');
             }
             // delete old image for profile
             if(Storage::disk('public')->exists('profile/'.$user->image))
             {
                 Storage::disk('public')->delete('profile/'.$user->image);
             }
 
             $profile = Image::make($image)->resize(1600,1066)->stream();
             Storage::disk('public')->put('profile/'.$imageName,$profile);
        }
        else
        {
            $imageName = $user->image;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->image = $imageName;
        $user->about = $request->about;
        $user->save();
        Toastr::success('Profile successfully Updated','Success');
        return redirect()->back();
    }

    public function updatepassword(Request $request, $id)
    {

        $this->validate($request,[
            'old_password' => 'required',
            'password'     => 'required|confirmed'
        ]);

        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->old_password,$hashedPassword))
        {
            if(!Hash::check($request->password,$hashedPassword))
            {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Profile successfully Updated','Success');
                //Auth::logout();
                return redirect()->back();
            }
            else
            {
                Toastr::error('New password cannot be the same as old password','Error');
                return redirect()->back();
            }
        }
        else
        {
            Toastr::error('Current old password not match','Error');
            return redirect()->back();
        }
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
