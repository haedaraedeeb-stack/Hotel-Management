<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservations;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get users and rooms from database
        $users = User::all();
        $rooms = Room::all();
        
        // If no users or rooms exist, create some dummy data
        if ($users->isEmpty() || $rooms->isEmpty()) {
            $this->command->warn('No users or rooms found. Please seed Users and Rooms first!');
            return;
        }
        
        $reservations = [];
        $statuses = ['pending', 'confirmed', 'cancelled', 'rejected'];
        
        // Create 50 sample reservations
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $room = $rooms->random();
            
            // Generate random dates
            $startDate = Carbon::now()->addDays(rand(-30, 60)); // Past and future dates
            $endDate = $startDate->copy()->addDays(rand(1, 14)); // 1-14 days stay
            
            // For check-in/check-out (actual dates, can be null if not checked in yet)
            $checkIn = null;
            $checkOut = null;
            
            $status = $statuses[array_rand($statuses)];
            
            // Set check-in/check-out based on status
            if (in_array($status, ['checked_in', 'checked_out'])) {
                $checkIn = $startDate;
                if ($status === 'checked_out') {
                    $checkOut = $endDate;
                }
            }
            
            $reservations[] = [
                'user_id' => $user->id,
                'room_id' => $room->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => $status,
                'created_at' => now()->subDays(rand(0, 90)),
                'updated_at' => now()->subDays(rand(0, 90)),
            ];
        }
        
        // Insert data
        DB::table('reservations')->insert($reservations);
        
        $this->command->info('Successfully created ' . count($reservations) . ' reservations!');
    }
}