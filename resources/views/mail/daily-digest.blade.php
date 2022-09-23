<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Digest</title>
</head>
<body>
<h1>The following users Attempt Quizzes:</h1>
<div class="list-group mb-4">
    @foreach($users as $user)
        <a href="javascript:void (0)" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{$user->name}}</h5>
            </div>
        </a>
    @endforeach

</div>

</body>
</html>

