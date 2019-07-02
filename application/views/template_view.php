<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Main page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php
    echo <<<LINKS
    <a href='http://{$_SERVER['HTTP_HOST']}/main'>Main</a>
    <a href='http://{$_SERVER['HTTP_HOST']}/profile'>Profile</a>
    <a href='http://{$_SERVER['HTTP_HOST']}/create'>Create</a>
    <a href='http://{$_SERVER['HTTP_HOST']}/signup'>Sign up</a>
LINKS;
    if (!isset($_SESSION['Logged_user']))
        echo <<<NOAUTH
            <form action='http://{$_SERVER['HTTP_HOST']}/main/authorize' method='POST'>
                <input type="text" name="login"><br />
                <input type="text" name="passw"><br />
            </form>
NOAUTH;
    else
        echo <<<AUTH
            <p>Logged_user: {$_SESSION['Logged_user']}</p>
AUTH;
    require 'application/views/' . $content_view; ?>
</body>
</html>