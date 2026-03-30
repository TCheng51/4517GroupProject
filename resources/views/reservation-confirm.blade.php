@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="panel">
        <p class="eyebrow">Reservation Guide</p>
        <h2 class="section-title">Review the evening before you book.</h2>
        <p class="page-intro">Fabel reservations are designed to make each session feel hosted, comfortable, and matched to your game.</p>

        <div class="cards-grid">
            <article class="info-box">
                <h3>Before arrival</h3>
                <ul class="check-list">
                    <li>Book at least one day ahead whenever possible for the best room choice.</li>
                    <li>Arrive a little early so your group can settle in before the first turn.</li>
                    <li>Choose the room theme that fits your boardgame and group size.</li>
                </ul>
            </article>

            <article class="info-box">
                <h3>During the session</h3>
                <p>You will have a dedicated table or room, access to Fabel cafe service, and a setting designed to support the tone of your evening.</p>
            </article>

            <article class="info-box">
                <h3>Need changes?</h3>
                <p>If plans shift, return to the reservation form and create a new booking that better matches your updated session.</p>
            </article>
        </div>

        <div class="navigation-buttons">
            <a href="{{ route('reservation') }}" class="btn btn-primary">Open Reservation Form</a>
            <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
        </div>
    </section>
</div>
@endsection
