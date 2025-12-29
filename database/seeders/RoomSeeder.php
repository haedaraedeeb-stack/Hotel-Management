<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\RoomType;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $roomTypes = RoomType::all();

        foreach ($roomTypes as $type) {
            for ($i = 1; $i <= 3; $i++) {
                Room::create([
                    'room_number' => $type->id * 100 + $i,
                    'room_type_id' => $type->id,
                    'status' => 'available',
                    'price_per_night' => $type->base_price,
                    'floor' => rand(1, 5),
                    'view' => ['sea', 'city', 'garden'][array_rand(['sea', 'city', 'garden'])],
                ]);
            }
        }
    }
}
