<!DOCTYPE html>
<html lang="en">
<body>
    <h1>Your Fable membership is ready</h1>
    <p>Hello {{ $member->first_name }} {{ $member->last_name }},</p>
    <p>Your member number is {{ $member->member_number }}.</p>
    <p>You can now sign in and reserve a story room for your next boardgame session.</p>
    <p>Fable Boardgame Cafe</p>
</body>
</html>
