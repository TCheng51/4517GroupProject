@extends('layouts.app')

@section('content')
<div class="shell page">
    <section class="split-panel">
        <div class="form-panel">
            <p class="eyebrow">Member Login</p>
            <h2 class="section-title">Sign in to reserve your next table.</h2>
            <p class="page-intro">Use your Fabel membership to book themed rooms and manage your next visit.</p>

            <form action="{{ route('login.submit') }}" method="post">
                @csrf
                <div class="field-grid">
                    <div class="form-group form-span-2">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" required placeholder="your@email.com" value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group form-span-2">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="Enter your password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Enter Fabel</button>
                </div>
            </form>
        </div>

        <aside class="side-panel">
            <article class="info-box">
                <p class="story-meta">Before You Reserve</p>
                <h3>Your membership keeps the evening moving.</h3>
                <p>Once you sign in, you can choose the room that fits your game and head straight into planning the session.</p>
            </article>

            <article class="info-box">
                <p class="story-meta">New Here</p>
                <h3>Create a membership first.</h3>
                <p>Registration only takes a moment and gives you access to table and room reservations across the cafe.</p>
            </article>

            <div class="inline-links">
                <a href="{{ route('register') }}" class="btn btn-outline">Create Membership</a>
                <a href="{{ route('index') }}" class="btn btn-outline">Back Home</a>
            </div>
        </aside>
    </section>
</div>
@endsection
