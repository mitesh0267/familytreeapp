<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Family Tree</title>
</head>
<body>
    <style>
        .text-center {
            text-align: center !important;
        }
    </style>
    <p>Dear {{$data['name']}},</p>
    <h3 class="text-center"><b>You requested this link to reset your password:</b></h3>
    <a href="{{$data['link']}}" title="password rest link">{{$data['link']}}</a>
</body>
</html>