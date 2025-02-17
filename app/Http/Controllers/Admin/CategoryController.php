<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Exception;
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
        return response()->json($categories);
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
        try{
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
        }catch(Exception $e){
            return response()->json("something went wrong",400);
        }
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
        try{
            $category = Category::find($id);
        $menus = $category->menus;
        return response()->json($menus);
        }catch(Exception $e){
            return response()->json("something went wrong", 400);
        }
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
    public function update(Request $request, $id)
    {
        try{
            if ($request->isMethod('put') || $request->isMethod('patch')) {
                $request->merge(['_method' => 'PUT']);
            }
            $category = Category::find($id);
            if(!$category){
                return response()->json([
                    'error' => 'category not found',
                ],400);
            }
            $request->validate([
                'name' => ['required'],
                'description' => ['required'],
                // 'image' => ['image','required']
            ]);
            $newImageName = $category->image;
            if ($request->hasFile('image')) {
                Storage::delete(public_path('categories/'.$newImageName));
                $newImageName = uniqid() . '-' . $request->name . '.' . $request->image->extension();
                $request->image->move(public_path('categories'), $newImageName);
            }

            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                // 'image' => $request->image,
                'image' => $newImageName,
            ]);
            $category->save();

            return response()->json('updated');
        }catch(Exception $e){
            return response()->json("something went wrong",400);
        }
        // return to_route('admin.categories.index')->with('success', 'Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    try {
        $category = Category::find($id);
        if (!$category) {
            return response()->json('Category not found', 404);
        }

        // Delete category image if needed
        Storage::delete(public_path('images/' . $category->image));

        // Get all menus associated with this category
        $menus = $category->menus;

        // Detach all menu relationships for this category
        $category->menus()->detach();

        // For each menu, check if it is still attached to any categories.
        // If not, delete it.
        foreach ($menus as $menu) {
            if ($menu->categories()->count() === 0) {
                $menu->delete();
            }
        }

        // Now delete the category itself
        $category->delete();

        return response()->json('deleted');
    } catch (Exception $e) {
        return response()->json("something went wrong", 400);
    }
}

}
