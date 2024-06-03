<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Notification</title>
</head>
<body>
    <h3>{{ $mailData['title'] }}</h3>
    <p>
        <strong>Username:</strong> {{ $mailData['username'] }}<br \>
        <strong>Password:</strong> {{ $mailData['password'] }}
    </p>
    <p>
        {{ $mailData['message'] }}
    </p>

    <h4>Best Regards, <br/>{{ $mailData['footer'] }}</h4>
</body>
</html>