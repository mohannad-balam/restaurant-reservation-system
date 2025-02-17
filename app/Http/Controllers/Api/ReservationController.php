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
use Exception;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    public function createReservation(Request $request)
    {

        try{
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

                $table = Table::find($request->table_id);
                if(!$table){
                    return response()->json('table not found',404);
                }
                if($request->guest_number > $table->guest_number){
                    return response()->json('Choose a Table Based On The Guest Number!',400);
                }
                $reserv_date = Carbon::parse($request->res_date);
                //we loop through each reservation except the one we have recieved (we reserved) in the function
                $reservations = $table->reservations->where('id', '!=', $reservation->id);

                foreach($reservations as $res){
                    if($res->res_date->format('Y-m-d') == $reserv_date->format('Y-m-d')){
                        $reservation->delete();
                        return response()->json('This Table Is Reserved For This Day!',400);
                    }
                }

                return response()->json("reservation created successfully",201);
        }catch(Exception $e){
            return response()->json("something went wrong", 400);
        }
    }

    public function getUserReservation(){
        $reservations = Reservation::with('table')
        ->where('email', '=', auth()->user()->email)
        ->orderBy('updated_at', 'DESC')
        ->get();

    $reservations = $reservations->map(function ($reservation) {
        $reservationArray = $reservation->toArray();
        $reservationArray['table'] = isset($reservationArray['table']['name'])
            ? $reservationArray['table']['name']
            : null;
        return $reservationArray;
    });

    return response()->json($reservations);

    }

}
