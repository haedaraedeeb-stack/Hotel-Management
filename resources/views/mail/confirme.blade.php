<x-mail::message>
# Your Booking is Confirmed!

Hello {{ $user->name }},

Thank you for your reservation with us. Below are your booking details:

**Reservation Number:** #{{ $reservation->id }}  
**Room:** {{ $room->roomType->type ?? 'Standard Room' }} (ID: {{ $reservation->room_id }})  
**Check-in Date:** {{ \Carbon\Carbon::parse($reservation->start_date)->format('l, F j, Y') }}  
**Check-out Date:** {{ \Carbon\Carbon::parse($reservation->end_date)->format('l, F j, Y') }}  
**Total Nights:** {{ \Carbon\Carbon::parse($reservation->start_date)->diffInDays($reservation->end_date) }} nights

If you have any questions, please contact us.

Sincerely,<br>
The {{ config('app.name') }} Team
</x-mail::message>