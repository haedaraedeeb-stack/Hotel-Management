<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the table first
        DB::table('rating')->truncate();
        
        // Get some existing reservations
        $reservations = Reservation::take(20)->get();
        
        // If no reservations exist, create random ratings
        if ($reservations->isEmpty()) {
            $this->createRandomRatings();
            return;
        }
        
        // Create ratings for existing reservations
        $ratings = [];
        $descriptions = [
            'Excellent experience, service was outstanding',
            'Good level, but some things could be improved',
            'Amazing, I will definitely repeat this experience',
            'Good service but prices are a bit high',
            'Unforgettable experience, professional team',
            'Excellent, I recommend this service to everyone',
            'Good but needs improvement in some areas',
            'More than excellent, exceeded my expectations',
            'Acceptable service but could be better',
            'Not bad, meets basic needs',
            'Amazing, everything was perfect',
            'Very good, I recommend it',
            'Average experience, nothing special',
            'Poor, I didn\'t like the service level',
            'Excellent, professional team and fast service',
        ];
        
        foreach ($reservations as $reservation) {
            $score = rand(3, 5); // Scores between 3-5 (focus on good ratings)
            
            // 20% chance for a low rating
            if (rand(1, 100) <= 20) {
                $score = rand(1, 2);
            }
            
            $ratings[] = [
                'reservation_id' => $reservation->id,
                'score' => $score,
                'description' => $descriptions[array_rand($descriptions)],
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now()->subDays(rand(1, 60)),
            ];
        }
        
        // Insert data into ratings table
        DB::table('rating')->insert($ratings);
        
        $this->command->info('Successfully created ' . count($ratings) . ' ratings!');
    }
    
    /**
     * Create random ratings if no reservations exist
     */
    private function createRandomRatings()
    {
        $ratings = [];
        $descriptions = [
            'Excellent experience, service was outstanding',
            'Good level, but some things could be improved',
            'Amazing, I will definitely repeat this experience',
            'Good service but prices are a bit high',
            'Unforgettable experience, professional team',
        ];
        
        for ($i = 1; $i <= 50; $i++) {
            $score = rand(3, 5);
            
            // 20% chance for a low rating
            if (rand(1, 100) <= 20) {
                $score = rand(1, 2);
            }
            
            $ratings[] = [
                'reservation_id' => $i, // Dummy IDs
                'score' => $score,
                'description' => $descriptions[array_rand($descriptions)],
                'created_at' => now()->subDays(rand(1, 60)),
                'updated_at' => now()->subDays(rand(1, 60)),
            ];
        }
        
        DB::table('rating')->insert($ratings);
        
        $this->command->info('Successfully created ' . count($ratings) . ' random ratings!');
    }
}