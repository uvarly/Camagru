<?php
    echo <<<LINKS
        <a href='/main'>Main</a>
        <a href='/profile'>Profile</a>
        <a href='/camera'>Camera</a>
        <a href='/settings'>Settings</a>
LINKS;
    echo <<<MAIN
        <script src="js/camera.js"></script>
        <div id="create_post">
            <div id=" image_field">
            <form id="upload_form" enctype="multipart/form-data" action="/camera/upload/" method="post">
                <input type="file" onchange="readURL();" id="file_up" name="image" accept="image/jpeg, image/png, image/gif">
                <video id="video" width="640" height="480" autoplay></video>
                <canvas id="canvas" width="640" height="480"></canvas>
            </form>
        </div>
        <div id="side_menu">
            <div id="sticker_bar">
                <img src="/images/stickers/jotaro_test.png">
                <img src="/images/stickers/kakyoin_test.png">
                <img src="/images/stickers/jotaro_hat.png">
                <hr>
                <button id="del_stick" style="display: none" onclick="delete_sticker()">DELETE STICKER</button>
            </div>
            <div id="description" style="text-align: center">Description<br><input type="text" form="upload_form" maxlength="250" name="description"></div>
            <input style="display: none" id="submit" type="submit" form="upload_form">
            <button id="biba">START VIDEO</button>
            <button id="bsubmit" style="display: none" onclick="submit();" id="buba">SEND IMAGE</button>
        </div>
        </div>
        <canvas id="hide_canv" style="display: none" width="640" height="480"></canvas>
MAIN;
