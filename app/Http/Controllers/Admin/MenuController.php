<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuStoreRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::orderBy('updated_at', 'DESC')->get();
        return response()->json($menus);
        // return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('updated_at', 'DESC')->get();
        return view('admin.menus.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuStoreRequest $request)
    {
        $newImageName = uniqid() . '-' . $request->name . '.' . $request->image->extension();
        $request->image->move(public_path('menus'), $newImageName);

        $menu = Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $newImageName,
        ]);

        if($request->has('categories')){
            $menu->categories()->attach($request->categories);
        }

        return response()->json('',201);
        // return to_route('admin.menus.index')->with('success', 'Menu Created Successfully!');
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
    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
           'name' => 'required',
           'price' => 'required',
           'description' => 'required'
        ]);

        $newImageName = $menu->image;
        if ($request->hasFile('image')) {
            Storage::delete(public_path('menus/'.$newImageName));
            $newImageName = uniqid() . '-' . $request->name . '.' . $request->image->extension();
            $request->image->move(public_path('menus'), $newImageName);
        }

        $menu->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $newImageName,
        ]);

        if($request->has('categories')){
            $menu->categories()->sync($request->categories);
        }

        return response()->json('updated');
        // return to_route('admin.menus.index')->with('success', 'Menu Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //delete the relationship First
        $menu->categories()->detach();
        $menu->delete();
        return response()->json('deleted');
        // return to_route('admin.menus.index')->with('danger', 'Menu Deleted Successfully!');
    }
}
