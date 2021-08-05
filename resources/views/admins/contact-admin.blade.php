<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GES | Kindly Contact Admin</title>
</head>
<body>
    @if(session()->has('message'))
        {{session('message')}}

        <h1>Sir's Contact Details</h1>
    @endif

<a href="/logout">Logout</a>
</body>
</html>
