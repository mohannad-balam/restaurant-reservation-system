<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;
use Exception;

class ReservationController extends Controller
{

    public function createReservation(ReservationStoreRequest $request)
    {

        try {
            $table = Table::find($request->table_id);
            if (! $table) {
                return response()->json('table not found', 404);
            }
            if ($request->guest_number > $table->guest_number) {
                return response()->json('Choose a Table Based On The Guest Number!', 400);
            }
            $reserv_date = Carbon::parse($request->res_date);
            foreach ($table->reservations as $reservation) {
                if ($reservation->res_date->format('Y-m-d') == $reserv_date->format('Y-m-d')) {
                    return response()->json('This Table Is Reserved For This Day!', 400);
                }
            }
            Reservation::create($request->validated());

            return response()->json('', 201);
        } catch (Exception $e) {
            return response()->json('something went wrong', 400);
        }
    }

    public function getUserReservation()
    {
        $reservations = Reservation::with('table')
            ->where('email', '=', auth()->user()->email)
            ->orderBy('updated_at', 'DESC')
            ->get();

        $reservations = $reservations->map(function ($reservation) {
            $reservationArray          = $reservation->toArray();
            $reservationArray['table'] = isset($reservationArray['table']['name'])
            ? $reservationArray['table']['name']
            : null;
            return $reservationArray;
        });

        return response()->json($reservations);

    }

    public function destroy($id)
    {
        try {
            $reservation = Reservation::find($id);
            $reservation->delete();
            // $reservation->save();
            return response()->json('deleted');
        } catch (Exception $e) {
            return response()->json("something went wrong", 400);
        }
    }

}
