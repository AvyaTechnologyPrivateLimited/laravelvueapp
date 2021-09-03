<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, user-scalable=false;">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <title>{{env('APP_NAME')}}</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  
</head>
<body>
@if (Auth::check())
    <script>
        window.Laravel = {!!json_encode([
               'isLoggedin' => true,
               'user' => Auth::user()
           ])!!}
    </script>
@else
    <script>
        window.Laravel = {!!json_encode([
                'isLoggedin' => false
            ])!!}
    </script>
@endif
<div id="app">
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>
