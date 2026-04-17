<?php

namespace Tests\Feature;

use App\Mail\RegistrationConfirmationMail;
use App\Mail\ReservationConfirmationMail;
use App\Models\Member;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\TimeSlot;
use Database\Seeders\MenuItemSeeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\TimeSlotSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ReservationFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            RoomSeeder::class,
            TimeSlotSeeder::class,
            MenuItemSeeder::class,
        ]);
    }

    public function test_guest_can_create_reservation_with_menu_order_and_simulated_email(): void
    {
        Mail::fake();

        $room = Room::where('slug', 'fantasy-hearth')->firstOrFail();
        $timeSlot = TimeSlot::orderBy('sort_order')->firstOrFail();
        $menuItem = MenuItem::firstOrFail();

        $response = $this->post(route('reservation.submit'), [
            'guest_name' => 'Guest Player',
            'guest_email' => 'guest@example.com',
            'guest_phone' => '85212345678',
            'reservation_date' => now()->addDays(2)->toDateString(),
            'time_slot' => $timeSlot->label,
            'table_room' => $room->slug,
            'menu_items' => [$menuItem->id => 2],
        ]);

        $response->assertRedirect(route('reservation.success'));
        $response->assertSessionHas('reservation_id');
        $response->assertSessionHas('email_simulated');

        $reservation = Reservation::with('reservationMenuItems')->firstOrFail();
        $this->assertSame($room->id, $reservation->room_id);
        $this->assertSame($timeSlot->id, $reservation->time_slot_id);
        $this->assertNotEmpty($reservation->confirmation_code);
        $this->assertSame(1, $reservation->reservationMenuItems->count());

        Mail::assertSent(ReservationConfirmationMail::class, function ($mail) use ($reservation) {
            return $mail->reservation->id === $reservation->id && $mail->action === 'created';
        });
    }

    public function test_reservation_creation_rejects_fully_booked_room_slot(): void
    {
        Mail::fake();

        $room = Room::where('slug', 'fantasy-hearth')->firstOrFail();
        $timeSlot = TimeSlot::orderBy('sort_order')->firstOrFail();
        $date = now()->addDays(3)->toDateString();

        for ($i = 0; $i < $room->capacity; $i++) {
            Reservation::create([
                'room_id' => $room->id,
                'time_slot_id' => $timeSlot->id,
                'reservation_date' => $date,
                'time_slot' => $timeSlot->label,
                'table_room' => $room->slug,
                'status' => 'pending',
                'confirmation_code' => 'TESTFULL' . $i,
                'is_guest' => true,
                'guest_name' => 'Guest ' . $i,
                'guest_email' => 'guest' . $i . '@example.com',
                'guest_phone' => '85212345678',
            ]);
        }

        $response = $this->post(route('reservation.submit'), [
            'guest_name' => 'Late Guest',
            'guest_email' => 'late@example.com',
            'guest_phone' => '85212345678',
            'reservation_date' => $date,
            'time_slot' => $timeSlot->label,
            'table_room' => $room->slug,
        ]);

        $response->assertSessionHasErrors('table_room');
        $this->assertSame($room->capacity, Reservation::count());
        Mail::assertNothingSent();
    }

    public function test_member_can_view_update_and_cancel_own_reservation(): void
    {
        Mail::fake();

        $member = Member::create([
            'first_name' => 'Test',
            'last_name' => 'Member',
            'email' => 'member@example.com',
            'phone' => '85212345678',
            'address' => 'Test address',
            'password' => 'password123',
        ]);
        $room = Room::where('slug', 'fantasy-hearth')->firstOrFail();
        $newRoom = Room::where('slug', 'mythic-garden')->firstOrFail();
        $timeSlot = TimeSlot::orderBy('sort_order')->firstOrFail();

        $reservation = Reservation::create([
            'member_id' => $member->id,
            'room_id' => $room->id,
            'time_slot_id' => $timeSlot->id,
            'reservation_date' => now()->addDays(4)->toDateString(),
            'time_slot' => $timeSlot->label,
            'table_room' => $room->slug,
            'status' => 'confirmed',
            'confirmation_code' => 'MEMBER0001',
        ]);

        $this->actingAs($member)
            ->get(route('my-reservations'))
            ->assertOk()
            ->assertSee('MEMBER0001');

        $this->patch(route('my-reservations.update', $reservation), [
            'reservation_date' => now()->addDays(5)->toDateString(),
            'time_slot' => $timeSlot->label,
            'table_room' => $newRoom->slug,
        ])->assertRedirect(route('my-reservations'));

        $reservation->refresh();
        $this->assertSame('pending', $reservation->status);
        $this->assertSame($newRoom->id, $reservation->room_id);

        $this->post(route('my-reservations.cancel', $reservation))
            ->assertRedirect(route('my-reservations'));

        $this->assertSame('cancelled', $reservation->refresh()->status);
        Mail::assertSent(ReservationConfirmationMail::class, 2);
    }

    public function test_room_status_requires_admin_and_supports_admin_updates(): void
    {
        Mail::fake();

        $member = Member::create([
            'first_name' => 'Regular',
            'last_name' => 'Member',
            'email' => 'regular@example.com',
            'phone' => '85212345678',
            'address' => 'Test address',
            'password' => 'password123',
        ]);
        $admin = Member::create([
            'first_name' => 'Admin',
            'last_name' => 'Member',
            'email' => 'admin@example.com',
            'phone' => '85200000000',
            'address' => 'Test address',
            'password' => 'password123',
            'is_admin' => true,
        ]);
        $room = Room::firstOrFail();
        $timeSlot = TimeSlot::firstOrFail();
        $reservation = Reservation::create([
            'member_id' => $member->id,
            'room_id' => $room->id,
            'time_slot_id' => $timeSlot->id,
            'reservation_date' => today()->toDateString(),
            'time_slot' => $timeSlot->label,
            'table_room' => $room->slug,
            'status' => 'pending',
            'confirmation_code' => 'ADMIN0001',
        ]);

        $this->actingAs($member)->get(route('room-status'))->assertForbidden();

        $this->actingAs($admin)
            ->get(route('room-status', ['date' => today()->toDateString()]))
            ->assertOk()
            ->assertSee('ADMIN0001');

        $this->actingAs($admin)
            ->post(route('room-status.update', $reservation), ['status' => 'confirmed'])
            ->assertRedirect();

        $this->assertSame('confirmed', $reservation->refresh()->status);
        Mail::assertSent(ReservationConfirmationMail::class);
    }

    public function test_registration_confirmation_sends_simulated_email(): void
    {
        Mail::fake();

        $this->post(route('register.store'), [
            'first_name' => 'New',
            'last_name' => 'Member',
            'email' => 'new@example.com',
            'phone' => '85212345678',
            'address' => 'Test address',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertRedirect(route('register.confirm'));

        $this->post(route('register.confirm.submit'))
            ->assertRedirect(route('register.success'))
            ->assertSessionHas('email_simulated');

        $this->assertDatabaseHas('members', ['email' => 'new@example.com']);
        Mail::assertSent(RegistrationConfirmationMail::class);
    }
}
