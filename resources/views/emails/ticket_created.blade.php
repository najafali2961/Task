<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>New Ticket Created</title>
</head>

<body>
    <p>Hello Admin,</p>

    <p>A new ticket (ID: {{ $ticket->id }}) has been created.</p>
    <p>You can edit this ticket by clicking the link below:</p>
    <p><a href="{{ $editLink }}">Edit Ticket</a></p>

    <p>Thank you!</p>
</body>

</html>
