<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * This controller manages the dashboard view for different user roles,
 * providing relevant statistics and recent activity data.
 * Summary of DashboardController
 */
class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics based on user roles
     * Summary of index
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();

        // Shared Data for everyone
        $recentBookings = Reservation::with(['user', 'room'])
            ->latest()
            ->take(10)
            ->get();

        $roomTypeStats = $this->getRoomTypeStats();
        $monthlyReservations = $this->getMonthlyReservations();

        // Default Values
        $stats = [];
        $chartData = [
            'labels' => [],
            'values' => [],
        ];

        // admin & manager

            $stats = [
                'reservations_count' => Reservation::count(),
                'revenue' => Invoice::where('payment_status', 'paid')->sum('total_amount'),
                'guests_count' => User::whereDoesntHave(
                    'roles',
                    fn ($q) => $q->whereIn('name', ['admin', 'manager', 'receptionist'])
                )->count(),
                'occupancy' => $this->calculateOccupancy(),
            ];

            $chartData = $this->getMonthlyRevenue();


        return view('dashboard', compact(
            'stats',
            'recentBookings',
            'roomTypeStats',
            'monthlyReservations',
            'chartData'
        ));
    }

    /**
     * Calculate the current occupancy rate of rooms
     * Summary of calculateOccupancy
     *
     * @return int
     */
    private function calculateOccupancy()
    {
        $total = Room::count();
        $occupied = Room::where('status', 'occupied')->count();
        return $total > 0 ? round(($occupied / $total) * 100) : 0;

    }

    /**
     * Retrieve monthly revenue data for the current year
     * Summary of getMonthlyRevenue
     *
     * @return array
     */
    private function getMonthlyRevenue()
    {
        $data = Invoice::select(
            DB::raw('SUM(total_amount) as total'),
            DB::raw("DATE_FORMAT(created_at, '%M') as month_name"),
            DB::raw('MONTH(created_at) as month_num')
        )
            ->where('payment_status', 'paid')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month_name', 'month_num')
            ->orderBy('month_num')
            ->get();

        return [
            'labels' => $data->pluck('month_name'),
            'values' => $data->pluck('total'),
        ];
    }
    
    /**
     * Retrieve room type statistics based on reservations
     * Summary of getRoomTypeStats
     *
     * @return array
     */
    private function getRoomTypeStats()
    {
        $data = Reservation::join('rooms', 'reservations.room_id', '=', 'rooms.id')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->select('room_types.type', DB::raw('count(*) as total'))
            ->groupBy('room_types.type')
            ->get();

        return [
            'labels' => $data->pluck('type'),
            'values' => $data->pluck('total'),
        ];
    }

    /**
     * Retrieve monthly reservation counts for the current year
     * Summary of getMonthlyReservations
     *
     * @return \Illuminate\Support\Collection
     */
    private function getMonthlyReservations()
    {
        $data = Reservation::select(
            DB::raw('COUNT(*) as total'),
            DB::raw('MONTH(created_at) as month_num')
        )
            ->whereYear('created_at', Carbon::now()->year)
            // ->where('status', 'confirmed')
            ->groupBy('month_num')
            ->orderBy('month_num')
            ->get();

        $months = collect(range(1, 12))->map(function ($month) use ($data) {
            $record = $data->firstWhere('month_num', $month);

            return $record ? $record->total : 0;
        });

        return $months;
    }
}
