<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina las reservas que ya han pasado';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reservations = Reservation::where('start_time', '<', Carbon::now())
                                    ->where('end_time', '<', Carbon::now())
                                    ->get();
        foreach($reservations as $reservation) {
            $reservation->delete();
        }
        return true;
    }
}
