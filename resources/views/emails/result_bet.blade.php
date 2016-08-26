<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trans('label.title') }}</title>
</head>
<body id="app-layout">
    <h3>{{ ucfirst(trans('message.hi', ['name' => $name])) }}</h3>
    <h3>{{ trans('message.thanks') }}</h3>
    <p>{{ ucfirst(trans('message.bet_team', ['team' => $team]))}}</p>
    <p>{{ ucfirst(trans('message.bet_result', ['result' => $result])) }}</p>
    <p>{{ ucfirst(trans('message.bet_point', ['point' => $point])) }}</p>
</body>
</html>
