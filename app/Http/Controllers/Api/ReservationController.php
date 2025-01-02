<?php

namespace App\Http\Controllers\Api;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Models\Table;
use App\Rules\DateBetween;
use App\Rules\TimeBetween;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function storeFirst(Request $request)
    {

        $reservation = Reservation::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'tel_number' => $request->tel_number,
            'guest_number' => $request->guest_number,
            'res_date' => $request->res_date,
            'table_id'=> $request->table_id
        ]);
        $reserved_tables_ids = Reservation::orderBy('res_date')->get()->filter(function ($value) use ($reservation) {
            return $value->res_date->format('Y-m-d') == $reservation->res_date->format('Y-m-d');
        })->pluck('table_id');
        $tables = Table::where('status', TableStatus::Available)
            ->where('guest_number', '>=', $reservation->guest_number)
            ->whereNotIn('id', $reserved_tables_ids)
            ->get();

            $table = Table::findOrFail($request->table_id);
            if($request->guest_number > $table->guest_number){
                return response()->json(['warning' => 'Please Choose The Table Based On The Guest Number!']);
            }
            $reserv_date = Carbon::parse($request->res_date);
            //we loop through each reservation except the one we have recieved (we reserved) in the function
            $reservations = $table->reservations();
            return response()->json($reservations);
            foreach($reservations as $res){
                if($res->res_date->format('Y-m-d') == $reserv_date->format('Y-m-d')){
                    $reservation->delete();
                    return response()->json(['warning' => 'This Table Is Reserved For This Day!']);
                }
            }

            return response()->json($reservation);
    }


    public function storeStepTwo(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $table = Table::findOrFail($request->table_id);
        if($request->guest_number > $table->guest_number){
            return response()->json(['warning' => 'Please Choose The Table Based On The Guest Number!']);
        }
        $reserv_date = Carbon::parse($request->res_date);
        //we loop through each reservation except the one we have recieved (we reserved) in the function
        $reservations = $table->reservations()->where('id', '!=', $reservation->id);
        foreach($reservations as $reservation){
            if($reservation->res_date->format('Y-m-d') == $reserv_date->format('Y-m-d')){
                return response()->json(['warning' => 'This Table Is Reserved For This Day!']);
            }
        }
        $reservation->update($request);

        return response()->json($reservation);
    }
}
