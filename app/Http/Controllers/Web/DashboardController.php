<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'reservations_count' => Reservation::count(),
            'revenue' => Invoice::where('payment_status', 'paid')->sum('total_amount'),
            'guests_count' => User::whereDoesntHave('roles', fn ($q) => $q->whereIn('name', ['admin', 'manager', 'receptionist']))->count(),
            'occupancy' => $this->calculateOccupancy(),
        ];

        $recentBookings = Reservation::with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();

        $chartData = $this->getMonthlyRevenue();

        $roomTypeStats = $this->getRoomTypeStats();

        return view('dashboard', compact('stats', 'recentBookings', 'chartData', 'roomTypeStats'));
    }

    private function calculateOccupancy()
    {
        $total = Room::count();
        $occupied = Room::where('status', 'occupied')->count();

        return $total > 0 ? round(($occupied / $total) * 100) : 0;
    }

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
}
