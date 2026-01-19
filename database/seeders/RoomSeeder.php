<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            // Create default room types if they don't exist
            $roomTypes1 = [
                ['base_price' => 1, 'type' => 'Single Room', 'description' => 'Room suitable for one person'],
                ['base_price' => 2, 'type' => 'Double Room', 'description' => 'Room suitable for two people'],
                ['base_price' => 3, 'type' => 'Executive Suite', 'description' => 'Luxury suite with premium services'],
                ['base_price' => 4, 'type' => 'Presidential Suite', 'description' => 'Most luxurious rooms in the hotel'],
                ['base_price' => 5, 'type' => 'Family Room', 'description' => 'Room suitable for families'],
            ];
            
            foreach ($roomTypes1 as $type) {
                RoomType::create($type);
            }
            
            $roomTypes = RoomType::all();
        

        // Rooms data
        $rooms = [
            // First Floor - Single Rooms
            [
                'room_number' => '101',
                'room_type_id' => $roomTypes->where('type', 'Single Room')->first()->id,
                'status' => 'available',
                'price_per_night' => 250.00,
                'floor' => 1,
                'view' => 'City Street',
            ],
            [
                'room_number' => '102',
                'room_type_id' => $roomTypes->where('type', 'Single Room')->first()->id,
                'status' => 'available',
                'price_per_night' => 250.00,
                'floor' => 1,
                'view' => 'City Street',
            ],
            [
                'room_number' => '103',
                'room_type_id' => $roomTypes->where('type', 'Single Room')->first()->id,
                'status' => 'maintenance',
                'price_per_night' => 250.00,
                'floor' => 1,
                'view' => 'Pool',
            ],

            // Second Floor - Double Rooms
            [
                'room_number' => '201',
                'room_type_id' => $roomTypes->where('type', 'Double Room')->first()->id,
                'status' => 'available',
                'price_per_night' => 400.00,
                'floor' => 2,
                'view' => 'Sea',
            ],
            [
                'room_number' => '202',
                'room_type_id' => $roomTypes->where('type', 'Double Room')->first()->id,
                'status' => 'available',
                'price_per_night' => 400.00,
                'floor' => 2,
                'view' => 'Sea',
            ],
            [
                'room_number' => '203',
                'room_type_id' => $roomTypes->where('type', 'Double Room')->first()->id,
                'status' => 'available',
                'price_per_night' => 450.00,
                'floor' => 2,
                'view' => 'Mountain',
            ],
            [
                'room_number' => '204',
                'room_type_id' => $roomTypes->where('type', 'Double Room')->first()->id,
                'status' => 'available',
                'price_per_night' => 400.00,
                'floor' => 2,
                'view' => 'Pool',
            ],

            // Third Floor - Family Rooms
            [
                'room_number' => '301',
                'room_type_id' => $roomTypes->where('type', 'Family Room')->first()->id,
                'status' => 'available',
                'price_per_night' => 600.00,
                'floor' => 3,
                'view' => 'Sea',
            ],
            [
                'room_number' => '302',
                'room_type_id' => $roomTypes->where('type', 'Family Room')->first()->id,
                'status' => 'available',
                'price_per_night' => 650.00,
                'floor' => 3,
                'view' => 'Mountain and Sea',
            ],

            // Fourth Floor - Executive Suites
            [
                'room_number' => '401',
                'room_type_id' => $roomTypes->where('type', 'Executive Suite')->first()->id,
                'status' => 'available',
                'price_per_night' => 1200.00,
                'floor' => 4,
                'view' => 'Sea',
            ],
            [
                'room_number' => '402',
                'room_type_id' => $roomTypes->where('type', 'Executive Suite')->first()->id,
                'status' => 'available',
                'price_per_night' => 1200.00,
                'floor' => 4,
                'view' => 'City',
            ],

            // Fifth Floor - Presidential Suite
            [
                'room_number' => '501',
                'room_type_id' => $roomTypes->where('type', 'Presidential Suite')->first()->id,
                'status' => 'available',
                'price_per_night' => 2500.00,
                'floor' => 5,
                'view' => '360° Panorama',
            ],
        ];

        // Create rooms
        foreach ($rooms as $room) {
            Room::create($room);
        }

        // Or use Factory if you want random data
        // Room::factory()->count(20)->create();
    }
}