<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $rooms = Room::all();

        if ($users->isEmpty() || $rooms->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'confirmed', 'cancelled', 'rejected'];

        for ($i = 0; $i < 100; $i++) {
            $user = $users->random();
            $room = $rooms->random();


            $randomMonth = rand(1, 12);
            $randomDay = rand(1, 28);

            $startDate = Carbon::create(date('Y'), $randomMonth, $randomDay);
            $endDate = (clone $startDate)->addDays(rand(1, 7));

            $status = $statuses[array_rand($statuses)];

            $checkIn = null;
            $checkOut = null;

            if ($endDate < now()) {
                $status = 'confirmed';
                $checkIn = $startDate;
                $checkOut = $endDate;
            }

            $reservation = Reservation::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => $status,
                'created_at' => $startDate,
            ]);
            $pricePerNight = $room->current_price ?? 150;
            $totalAmount = $pricePerNight * $startDate->diffInDays($endDate);

            Invoice::create([
                'reservation_id' => $reservation->id,
                'total_amount' => $totalAmount,
                'payment_status' => ($endDate < now()) ? 'paid' : 'unpaid',
                'payment_method' => 'cash',
                'created_at' => $startDate,
            ]);
        }

        $this->command->info('Reservations & Invoices Seeded Successfully!');
    }
}
