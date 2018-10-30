<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Exists;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'name' => 'required|unique:categories|max:255',
            'image' =>'required|mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->name);

        if(isset($image))
        {
            //make unique for image
            $currentDate = Carbon::now()->toDateString();
            $imagename  = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalName();

            // check category dir is not exists
    
            if(!Storage::disk('public')->exists('category'))
            {
                // create category folder
                Storage::disk('public')->makeDirectory('category');    
            }
            
            // resize image for category and upload
            $category = Image::make($image)->resize(1468,468)->stream();

            Storage::disk('public')->put('category/'.$imagename,$category);

             // check category slider is not exists
    
            if(!Storage::disk('public')->exists('category/slider'))
            {
                // create category folder
                Storage::disk('public')->makeDirectory('category/slider');    
            }
            

             // resize image for category and upload
            $slider = Image::make($image)->resize(500,333)->stream();
            Storage::disk('public')->put('category/slider/'.$imagename,$slider);

        }
        else{
            $imagename = "default.jpg";
        }

        $categorie = new Category;
        $categorie->name = $request->name;
        $categorie->slug = $slug;
        $categorie->image = $imagename;
        $categorie->save();
        Toastr::success('Category successfully saved', 'Success');
        return redirect()->back();
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
        $categorie = Category::find($id);
        return view('admin.category.edit',compact('categorie'));
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
        $this->validate($request,[
            'name' => 'required|max:255',
            'image' =>'required|mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);

        $image = $request->file('image');
        $slug = str_slug($request->name);

        $category = Category::find($id);

        if(isset($image))
        {
            //make unique for image
            $currentDate = Carbon::now()->toDateString();
            $imagename  = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalName();

            // check category dir is not exists
            if(!Storage::disk('public')->exists('category'))
            {
                // create category folder
                Storage::disk('public')->makeDirectory('category');    
            }

            // check exists image and delete old image category
            if(Storage::disk('public')->exists('category/'.$category->image))
            {
                // delete old image
                Storage::disk('public')->delete('category/'.$category->image);
            }

            // resize image for category and upload
            $categoryImage = Image::make($image)->resize(1468,468)->stream();
            Storage::disk('public')->put('category/'.$imagename,$categoryImage);

             // check category slider is not exists
            if(!Storage::disk('public')->exists('category/slider'))
            {
                // create category folder
                Storage::disk('public')->makeDirectory('category/slider');    
            }
            
            // check exists image and delete old image category slider
            if(Storage::disk('public')->exists('category/slider/'.$category->image))
            {
                // delete old image
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }

             // resize image for category and upload
            $sliderImage = Image::make($image)->resize(500,333)->stream();
            Storage::disk('public')->put('category/slider/'.$imagename,$sliderImage);

        }
        else{
            $imagename = $category->image;
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imagename;
        $category->save();
        Toastr::success('Category successfully Updated', 'Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $category = Category::find($id);
         // check exists image and delete  image category
         if(Storage::disk('public')->exists('category/'.$category->image))
         {
             // delete old image
             Storage::disk('public')->delete('category/'.$category->image);
         }

         // check exists image and delete  image category slider
         if(Storage::disk('public')->exists('category/slider/'.$category->image))
         {
             // delete old image
             Storage::disk('public')->delete('category/slider/'.$category->image);
         }

         $category->delete();
         Toastr::success('Category successfully delete', 'Success');
         return redirect()->back();
    }
}
