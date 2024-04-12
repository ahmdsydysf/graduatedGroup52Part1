<?php

namespace App\Http\Controllers\Dash;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::all();
        return view('dash.categories.all', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dash.categories.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'sub_title' => 'required|unique:categories,sub_title',
            'category_image' => 'required|image|mimes:png,jpg,svg,jpeg|max:2048',
        ]);

        $requested_data = $request->except('category_image');

        if($request->file('category_image')) {
            $imgName = uniqid() . $request->file('category_image')->getClientOriginalName();
            Image::make($request->file('category_image'))->resize(442, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/category/' .$imgName));
            $requested_data['category_image'] = $imgName;
        }

        Category::create($requested_data);

        return to_route('dashboard.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('dash.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'sub_title' => 'required|unique:categories,sub_title,'. $category->id,
            'category_image' => 'image|mimes:png,jpg,svg,jpeg|max:2048',
        ]);

        $requested_data = $request->except('category_image');

        if($request->file('category_image')) {
            $imgName = uniqid() . $request->file('category_image')->getClientOriginalName();
            Image::make($request->file('category_image'))->resize(442, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/category/' .$imgName));
            // unlink(public_path('uploads/category/' . $category->category_image));
            Storage::disk('public_uploads')->delete("/category/$category->category_image");
            $requested_data['category_image'] = $imgName;
        }

        $category->update($requested_data);

        return to_route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        unlink(public_path('uploads/category/' . $category->category_image));
        $category->delete();
        return to_route('dashboard.categories.index');
    }
}
