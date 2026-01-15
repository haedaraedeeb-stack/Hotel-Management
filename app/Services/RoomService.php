<?php

namespace App\Services;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use App\Models\Room;

/**
 * This service handles operations related to rooms.
 * Summary of RoomService
 * @package App\Services
 */
class RoomService
{
    /**
     * Retrieve all rooms with their associated room types
     * Summary of showAllRooms
     * @return \Illuminate\Database\Eloquent\Collection<int, Room>
     */
    public function showAllRooms()
    {
        try{
            return Room::with('roomType')->get();
        }
        catch(\Exception $e) {
            Log::error('Error fetching rooms :'. $e->getMessage());
        
        throw new HttpResponseException(
            response()->json([
                'success'=>false,
                'message'=>'Error',
            ],500)
        );
    }       
       }

    /**
     * Retrieve detailed information about a specific room
     * Summary of roomDetails
     * @param Room $room
     * @return Room
     */
    public function roomDetails(Room $room)
    {
        try{
            return $room->load(['roomType','images']);
        }
        catch(\Exception $e) {
            Log::error('Error fetching room details:'. $e->getMessage());
        
        throw new HttpResponseException(
            response()->json([
                'success'=>false,
                'message'=>'Error',
            ],500)
        );
   }   
        } 
           }
