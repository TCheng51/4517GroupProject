<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $selectedType = $request->query('type');
        $validTypes   = ['dnd_night', 'tournament', 'game_night', 'workshop', 'special'];

        if (! in_array($selectedType, $validTypes, true)) {
            $selectedType = null;
        }

        $featuredEvents = Event::active()
            ->upcoming()
            ->featured()
            ->with('room')
            ->orderBy('event_date')
            ->take(3)
            ->get();

        $upcomingEvents = Event::active()
            ->upcoming()
            ->with('room')
            ->when($selectedType, fn ($q) => $q->ofType($selectedType))
            ->orderBy('event_date')
            ->orderBy('sort_order')
            ->simplePaginate(9)
            ->withQueryString();

        $pastEvents = Event::active()
            ->past()
            ->with('room')
            ->orderByDesc('event_date')
            ->take(4)
            ->get();

        // If member is logged in, get their registrations
        $memberRegistrations = [];
        if (Auth::check()) {
            $memberRegistrations = EventRegistration::where('member_id', Auth::id())
                ->where('status', 'registered')
                ->pluck('event_id')
                ->toArray();
        }

        $eventTypes = [
            'dnd_night'  => 'D&D Nights',
            'tournament' => 'Tournaments',
            'game_night' => 'Game Nights',
            'workshop'   => 'Workshops',
            'special'    => 'Special Events',
        ];

        return view('events', compact(
            'featuredEvents',
            'upcomingEvents',
            'pastEvents',
            'memberRegistrations',
            'eventTypes',
            'selectedType'
        ));
    }

    public function show(Event $event): \Illuminate\View\View
    {
        $event->load(['room', 'registrations.member']);

        $isRegistered = false;
        if (Auth::check()) {
            $isRegistered = $event->registrations()
                ->where('member_id', Auth::id())
                ->where('status', 'registered')
                ->exists();
        }

        return view('event-detail', compact('event', 'isRegistered'));
    }

    public function register(Event $event): \Illuminate\Http\RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to register for events.');
        }

        if (! $event->is_active || ! $event->is_upcoming) {
            return back()->with('error', 'This event is no longer available for registration.');
        }

        if ($event->is_full) {
            return back()->with('error', 'This event is fully booked. Keep an eye out for future sessions.');
        }

        try {
            DB::transaction(function () use ($event) {
                // Re-check capacity inside transaction
                $registeredCount = $event->registrations()
                    ->where('status', 'registered')
                    ->lockForUpdate()
                    ->count();

                if ($event->max_participants > 0 && $registeredCount >= $event->max_participants) {
                    abort(409, 'event-full');
                }

                EventRegistration::updateOrCreate(
                    [
                        'event_id'  => $event->id,
                        'member_id' => Auth::id(),
                    ],
                    [
                        'status' => 'registered',
                    ]
                );
            });
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            if ($e->getMessage() === 'event-full') {
                return back()->with('error', 'This event just filled up. Try another event.');
            }
            throw $e;
        }

        return back()->with('success', 'You have been registered for "' . $event->title . '". See you there!');
    }

    public function cancelRegistration(Event $event): \Illuminate\Http\RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $registration = EventRegistration::where('event_id', $event->id)
            ->where('member_id', Auth::id())
            ->where('status', 'registered')
            ->first();

        if ($registration) {
            $registration->update(['status' => 'cancelled']);
        }

        return back()->with('success', 'Your registration for "' . $event->title . '" has been cancelled.');
    }
}
