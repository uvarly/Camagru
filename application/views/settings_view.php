<?php

echo <<<SETTINGS
    <link type="text/css" rel="stylesheet" href="/css/settings.css">
    <div class="settings">
        <h1>SETTINGS</h1>
        <hr>
        <p>Change profile image</p>
        <form action="/settings/image/" method="post" enctype="multipart/form-data">
            <input type="file" name="profile_image">
            <br>
            <input type="submit" name="submit" value="Apply">
        </form>
SETTINGS;
    switch ($data) {
        case 'no_image':
            echo "<p style='color: darkred; font-style: italic'>This field cannot be empty</p>";
            break;
        case 'forbidden_image_type':
            echo "<p style='color: darkred; font-style: italic'>Forbidden image type</p>";
    }
echo <<<SETTINGS
        <hr>
        <p>Allow email notifications</p>
        <form action="/settings/notifications/" method="post">
            <input type="radio" name="notifications" value="Enable" checked="checked"> Enable
            <input type="radio" name="notifications" value="Disable"> Disable
            <br>
            <input type="submit" name="submit" value="Apply">
        </form>
        <hr>
        <p>Change login</p>
        <form action="/settings/login" method="post">
            <input type="text" name="login" placeholder="New login">
            <br>
            <input type="submit" name="submit" value="Apply changes">
        </form>
SETTINGS;
    switch ($data) {
        case 'bad_login':
            echo "<p style='color: darkred; font-style: italic'>This field cannot be empty</p>";
            break;
        case 'login_exists':
            echo "<p style='color: darkred; font-style: italic'>Login exists</p>";
            break;
    }
echo <<<SETTINGS
        <hr>
        <p>Change email</p>
        <form action="/settings/email" method="post">
            <input type="text" name="email" placeholder="New email">
            <br>
            <input type="submit" name="submit" value="Apply changes">
        </form>
SETTINGS;
        switch ($data) {
            case 'no_email':
                echo "<p style='color: darkred; font-style: italic'>This field cannot be empty</p>";
                break;
            case 'email_exists':
                echo "<p style='color: darkred; font-style: italic'>Email exists</p>";
                break;
        }
echo <<<SETTINGS
        <hr>
        <p>Change password</p>
        <form action="/settings/passw" method="post">
            <input type="password" name="passw" placeholder="New password">
            <br>
            <input type="submit" name="submit" value="Apply changes">
        </form>
SETTINGS;
        switch ($data) {
            case 'no_passw':
                echo "<p style='color: darkred; font-style: italic'>This field cannot be empty</p>";
                break;
            case 'weak_passw':
                echo "<p style='color: darkred; font-style: italic'>This password is too weak</p>";
                break;
        }