@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <span class="status-pill success">Thank You</span>
        <h2 class="section-title">Your next chapter at Fabel is on the calendar.</h2>
        <div class="detail-grid">
            <article class="detail-item">
                <span>Email</span>
                <strong>{{ $email ?? 'example@email.com' }}</strong>
            </article>
            <article class="detail-item">
                <span>Date</span>
                <strong>{{ $date ?? '12 October 2026' }}</strong>
            </article>
            <article class="detail-item">
                <span>Time Slot</span>
                <strong>{{ $timeSlot ?? '6:00 PM to 9:00 PM' }}</strong>
            </article>
            <article class="detail-item">
                <span>Story Room</span>
                <strong>{{ $tableRoom ?? 'Fantasy Hearth' }}</strong>
            </article>
        </div>
        <div class="navigation-buttons">
            <a href="{{ route('index') }}" class="btn btn-primary">Back Home</a>
        </div>
    </section>
</div>
@endsection
