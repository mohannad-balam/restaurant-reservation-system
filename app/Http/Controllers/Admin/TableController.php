<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TableStoreRequest;
use App\Models\Table;
use Exception;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::orderBy('updated_at', 'DESC')->get();
        return response()->json($tables);
        // return view('admin.tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tables.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TableStoreRequest $request)
    {
        try{
            Table::create([
                'name' => $request->name,
                'guest_number' =>  $request->guest_number,
                'status' => $request->status,
                'location' => $request->location,
            ]);

            return response()->json('',201);
        }catch(Exception $e){
            return response()->json('something went wrong', 400);
        }
        // return to_route('admin.tables.index')->with('success', 'Table Added Successfully!');
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
    public function edit(Table $table)
    {
        return view('admin.tables.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TableStoreRequest $request, $id)
    {
        try{
            $table = Table::find($id);
        $table->update($request->validated());
        return response()->json('updated');
        }catch(Exception $e){
            return response()->json('something went wrong', 400);
        }
        // return to_route('admin.tables.index')->with('success', 'Table Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $table = Table::find($id);
        $table->delete();
        $table->reservations()->delete();

        response()->json('deleted');
        }catch(Exception $e){
            return response()->json('something went wrong', 400);
        }
        // return to_route('admin.tables.index')->with('danger', 'Table Deleted Successfully!');
    }
}
