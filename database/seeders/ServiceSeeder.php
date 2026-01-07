<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'name' => 'Free WiFi',
                'description' => 'High-speed internet connection throughout the hotel',
            ],
            [
                'name' => 'Swimming Pool',
                'description' => 'Indoor/outdoor swimming pool with sun loungers',
            ],
            [
                'name' => 'Spa & Massage',
                'description' => 'Full spa services and therapeutic massage',
            ],
            [
                'name' => 'Gym & Fitness Center',
                'description' => 'Fully equipped gym with modern equipment',
            ],
            [
                'name' => 'Restaurant',
                'description' => '24-hour restaurant serving local and international cuisine',
            ],
            [
                'name' => 'Room Service',
                'description' => '24-hour room service with extensive menu',
            ],
            [
                'name' => 'Parking',
                'description' => 'Free secured parking for guests',
            ],
            [
                'name' => 'Laundry & Dry Cleaning',
                'description' => 'Daily laundry and dry cleaning services',
            ],
            [
                'name' => 'Airport Shuttle',
                'description' => 'Complimentary airport pick-up and drop-off',
            ],
            [
                'name' => 'Business Center',
                'description' => 'Fully equipped business center with meeting rooms',
            ],
            [
                'name' => 'Concierge',
                'description' => '24-hour concierge service for tour bookings and reservations',
            ],
            [
                'name' => 'Minibar',
                'description' => 'In-room minibar with snacks and beverages',
            ],
            [
                'name' => 'Safe Deposit Box',
                'description' => 'In-room safe for valuables',
            ],
            [
                'name' => 'TV with Cable Channels',
                'description' => 'Flat-screen TV with international channels',
            ],
            [
                'name' => 'Air Conditioning',
                'description' => 'Individual climate control in all rooms',
            ],
            [
                'name' => 'Pet Friendly',
                'description' => 'Pet-friendly rooms with special amenities',
            ],
            [
                'name' => 'Kids Club',
                'description' => 'Supervised activities and play area for children',
            ],
            [
                'name' => 'Beach Access',
                'description' => 'Direct private beach access with beach service',
            ],
            [
                'name' => 'All-Inclusive Package',
                'description' => 'All-inclusive food and beverage packages',
            ],
            [
                'name' => 'Conference Facilities',
                'description' => 'Conference and banquet halls for events',
            ],
        ];

        $roomtypes = DB::table('room_types')->pluck('id')->toArray();

        // Insert services
        foreach ($services as $service) {
            $serviceModel = Service::create($service);
            $serviceModel->roomTypes()->attach(array_rand(array_flip($roomtypes), rand(1, 4)));
        }

        $this->command->info('✅ Services seeded successfully!');
    }
}
