<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Camagru</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
    <?php
    echo <<<LINKS
    <a href='/main'>Main</a>
    <a href='/profile'>Profile</a>
    <a href='/create'>Create</a>
    <a href='/signup'>Sign up</a>
LINKS;
//     if (!isset($_SESSION['Logged_user']))
//         echo <<<NOAUTH
//             <form action='http://{$_SERVER['HTTP_HOST']}/main/authorize' method='POST'>
//                 <input type="text" name="login"><br />
//                 <input type="text" name="passw"><br />
//             </form>
// NOAUTH;
//     else
//         echo <<<AUTH
//             <p>Logged_user: {$_SESSION['Logged_user']}</p>
// AUTH;
    require 'application/views/' . $content_view; ?>
</body>
</html>