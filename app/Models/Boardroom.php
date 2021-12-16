<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boardroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',

    ];

    //Checar reservacion
    public function isAvailable(){
        $reservations = Reservation::where('boardroom_id', $this->id)
                                    ->whereBetween('start_time', [request()->start_time, request()->end_time])
                                    ->get();
        $reservations2 = Reservation::where('boardroom_id', $this->id)
                                    ->whereBetween('end_time', [request()->start_time, request()->end_time])
                                    ->get();
        if (count($reservations) > 0 || count($reservations2) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
