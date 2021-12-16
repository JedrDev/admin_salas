<?php

namespace App\Http\Controllers;

use App\Models\Boardroom;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Environment\Console;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $boardrooms = Boardroom::all();
        if($user->isAdmin()) {
            $reservations = Reservation::all();
        } else {
            $reservations = $user->reservations;
        }
        return view('reservations.index', compact('reservations', 'boardrooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validamos los datos
        $request->validate([
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'boardroom_id' => 'required|exists:boardrooms,id',
        ]);

        //comprobamos que el tiempo de la reserva no sea mayor a 2 horas
        $diff = Carbon::parse($request->start_time)->diffInHours(Carbon::parse($request->end_time));
        if($diff >= 2) {
            return back()->with('error', 'La reserva no puede ser mayor a 2 horas');
        }


        $boardroom = Boardroom::find($request->boardroom_id);
        $user = Auth::user();
        //Llama al comando que limpia las reservas que ya han pasado
        Artisan::call('reservation:clean');

        //comprobamos que el usuario no tenga una reserva en ese tiempo
        if($boardroom->isAvailable()) {
            return back()->with('error', 'Ya existe una reserva en ese tiempo');
        }

        //creamos la reserva
        $reservation = Reservation::firstOrNew([
            'user_id' => $user->id,
            'boardroom_id' => $boardroom->id,
            'start_time' => Carbon::parse($request->start_time),
            'end_time' => Carbon::parse($request->end_time),
        ]);

        $reservation->save();

        return redirect()->route('reservations.index')->with('success', 'Reserva creada correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::find($id);
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reserva eliminada correctamente');
    }
}
