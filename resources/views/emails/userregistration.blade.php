<!DOCTYPE html>
<html>
<head>
    <title>{{ $emailData['subject'] }}</title>
</head>
<body>
    <p> Dear Administrator ABM Procurement Dashboard, </p>
    <p><br></p>
    <p> Mohon di berikan hak akses role untuk user di bawah ini : </p>
    <p> Nama : {{ $emailData['user_name'] }} </p>
    <p> Email : {{ $emailData['user_email'] }} </p>
    <p><br></p>
    <p> Terima kasih.  </p>
    <p><br></p>
    <p> <strong>Regards,</strong> </p>
    <p><br></p>
    <p> <strong>ABM Procurement Dashboard System</strong> </p>
    <p> <strong><i>(This email is generated automatically by system, please do not reply)</i></strong> </p>
</body>
</html>