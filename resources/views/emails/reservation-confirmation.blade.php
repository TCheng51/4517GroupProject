<!DOCTYPE html>
<html lang="en">
<body>
    <h1>Fable reservation {{ $action }}</h1>
    <p>Hello {{ $reservation->customer_name }},</p>
    <p>Reference: {{ $reservation->confirmation_code }}</p>
    <p>Date: {{ optional($reservation->reservation_date)->format('Y-m-d') }}</p>
    <p>Time: {{ $reservation->time_slot_label }}</p>
    <p>Room: {{ $reservation->room_name }}</p>
    <p>Status: {{ ucfirst($reservation->status) }}</p>

    @if($reservation->reservationMenuItems->isNotEmpty())
        <h2>Pre-order</h2>
        <ul>
            @foreach($reservation->reservationMenuItems as $orderItem)
                <li>
                    {{ $orderItem->menuItem->name ?? 'Menu item' }} x {{ $orderItem->quantity }}
                    - HK$ {{ number_format((float) $orderItem->line_total, 2) }}
                </li>
            @endforeach
        </ul>
        <p>Total: HK$ {{ number_format($reservation->menu_total, 2) }}</p>
    @endif

    <p>Fable Boardgame Cafe</p>
</body>
</html>
