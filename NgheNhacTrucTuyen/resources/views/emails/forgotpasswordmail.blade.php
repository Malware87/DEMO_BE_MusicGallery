<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
<p>Hello {{ $user->username }},</p>

<p>Your password has been reset. Here is your new password:</p>

<p><strong>New Password:</strong> {{ $newPassword }}</p>

<p>For security reasons, please log in and change your password as soon as possible.</p>

<p>Thank you!</p>
</body>
</html>
