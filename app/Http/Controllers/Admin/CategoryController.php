<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('updated_at', 'DESC')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        // Store the file in the 'public' disk
        $path = $request->file('image')->store('photos', 'public');

        // Return the full URL of the uploaded image
        $url = Storage::url($path);

        $newImageName = uniqid() . '-' . $request->name . '.' . $request->image->extension();
        $request->image->move(public_path('categories'), $newImageName);

        Category::create([
            'name' => $request->name,
            'image' => asset($newImageName),
            'description' => $request->description,
        ]);

        return response('',201);
        // return to_route('admin.categories.index')->with('success', 'Category Created Successfully!');
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
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'image' => ['image','required']
        ]);
        $newImageName = $category->image;
        if ($request->hasFile('image')) {
            Storage::delete(public_path('categories/'.$newImageName));
            $newImageName = uniqid() . '-' . $request->name . '.' . $request->image->extension();
            $request->image->move(public_path('categories'), $newImageName);
        }
        // $newImageName = uniqid() . '-' . $request->name . '.' . $request->image->extension();
        // $request->image->move(public_path('images'), $newImageName);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $newImageName,
        ]);

        return response()->json('updated');
        // return to_route('admin.categories.index')->with('success', 'Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Storage::delete(public_path('images/'.$category->image));
        $category->menus()->detach();
        $category->delete();

        return response()->json('deleted');
        // return to_route('admin.categories.index')->with('danger', 'Category Deleted Successfully!');
    }
}
