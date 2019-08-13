<?php
    echo <<<LINKS
        <a href='/main'>Main</a>
        <a href='/profile'>Profile</a>
        <a href='/create'>Create</a>
LINKS;
switch ($data) {
    case null:
        echo <<<FORM
            <p>Please, enter your email</p>
            <form action="/recover/check" method="post">
                <p><input type="email" placeholder="Email" name="email"></p>
                <p><input type="submit" name="submit" value="OK"></p>
            </form>
FORM;
        break;
    case 'email_success':
        echo "<p>We've sent you a new temporary password. Check your mailbox<p>";
        break;
    case 'email_fail':
        echo <<<FORM
            <p>Please, enter your email</p>
            <form action="/recover/check" method="post">
                <p><input type="email" placeholder="Email" name="email"></p>
                <p><input type="submit" name="submit" value="OK"></p>
            </form>
            <p>This email does not exist. Please, enter a valid one</p>
FORM;
        break;
}