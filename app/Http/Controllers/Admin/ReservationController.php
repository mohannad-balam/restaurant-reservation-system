<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::orderBy('updated_at', 'DESC')->get();
        return response()->json($reservations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tables = Table::where('status', TableStatus::Available)->get();
        return view('admin.reservations.create', compact('tables'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationStoreRequest $request)
    {
        try{
            $table = Table::findOrFail($request->table_id);
        if($request->guest_number > $table->guest_number){
            return response()->json('Please Choose The Table Based On The Guest Number!',400);
        }
        $reserv_date = Carbon::parse($request->res_date);
        foreach($table->reservations as $reservation){
            if($reservation->res_date->format('Y-m-d') == $reserv_date->format('Y-m-d')){
                return response()->json('This Table Is Reserved For This Day!',400);
            }
        }
        Reservation::create($request->validated());

        return response()->json('',201);
        }catch(Exception $e){
            return response()->json('something went wrong', 400);
        }
        // return to_route('admin.reservations.index')->with('success', 'Reservation Has Been Made Successfully!');
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
    public function edit(Reservation $reservation)
    {
        $tables = Table::where('status', TableStatus::Available)->get();
        return view('admin.reservations.edit', compact('reservation', 'tables'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationStoreRequest $request, $id)
    {
        try{
            $reservation = Reservation::find($id);
        $table = Table::find($request->table_id);
        if($request->guest_number > $table->guest_number){
            return response()->json('Please Choose The Table Based On The Guest Number!',400);
        }
        $reserv_date = Carbon::parse($request->res_date);
        //we loop through each reservation except the one we have recieved (we reserved) in the function
        $reservations = $table->reservations()->where('id', '!=', $reservation->id);
        foreach($reservations as $reservation){
            if($reservation->res_date->format('Y-m-d') == $reserv_date->format('Y-m-d')){
                return response()->json('This Table Is Reserved For This Day!',400);
            }
        }
        $reservation->update($request->validated());

        return response()->json('updated');
        }catch(Exception $e){
            return response()->json('someting went wrong', 400);
        }

        // return to_route('admin.reservations.index')->with('success', 'Reservation Has Been Updated Successfully!');
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
            $reservation = Reservation::find($id);
        $reservation->delete();
        // $reservation->save();
        return response()->json('deleted');
        }catch(Exception $e){
            return response()->json("something went wrong",400);
        }
        // return to_route('admin.reservations.index')->with('danger', 'Reservation Has Been Deleted Successfully!');
    }
}
