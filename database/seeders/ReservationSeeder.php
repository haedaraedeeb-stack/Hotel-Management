<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation; // <--- تصحيح الاسم للمفرد
use App\Models\Invoice;     // <--- سنحتاج لإنشاء فواتير للحجوزات!
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
        for ($i = 0; $i < 100; $i++) { // زدنا العدد لـ 100 لتظهر بيانات أكثر
            $user = $users->random();
            $room = $rooms->random();

            // --- التعديل الجوهري هنا ---
            // نختار شهراً عشوائياً من السنة الحالية (من 1 إلى 12)
            $randomMonth = rand(1, 12);
            // نختار يوماً عشوائياً في ذلك الشهر
            $randomDay = rand(1, 28);

            // تاريخ البداية
            $startDate = Carbon::create(date('Y'), $randomMonth, $randomDay);
            // مدة الإقامة
            $endDate = (clone $startDate)->addDays(rand(1, 7));

            $status = $statuses[array_rand($statuses)];

            // منطق الدخول والخروج (كما هو)
            $checkIn = null;
            $checkOut = null;

            // إذا كان التاريخ في الماضي، نعتبر أنه اكتمل ودفع
            if ($endDate < now()) {
                $status = 'confirmed'; // لضمان احتساب الفاتورة
                $checkIn = $startDate;
                $checkOut = $endDate;
            }

            // إنشاء الحجز
            // ملاحظة: نعدل created_at ليكون في نفس شهر الحجز لكي يظهر في الرسم البياني حسب تاريخ الإنشاء
            $reservation = Reservation::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'status' => $status,
                'created_at' => $startDate, // حيلة ذكية: نجعل تاريخ الإنشاء هو تاريخ الحجز
            ]);

            // إنشاء الفاتورة
            $pricePerNight = $room->current_price ?? 150;
            $totalAmount = $pricePerNight * $startDate->diffInDays($endDate);

            Invoice::create([
                'reservation_id' => $reservation->id,
                'total_amount' => $totalAmount,
                // الفاتورة مدفوعة فقط إذا كان التاريخ في الماضي (اكتملت)
                'payment_status' => ($endDate < now()) ? 'paid' : 'unpaid',
                'payment_method' => 'cash',
                'created_at' => $startDate, // مهم جداً: الفاتورة أيضاً بتاريخ قديم
            ]);
        }

        $this->command->info('Reservations & Invoices Seeded Successfully!');
    }
}
