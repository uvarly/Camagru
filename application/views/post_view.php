<?php
    echo <<<LINKS
    <div style='display: inline-flex; margin-left: 25vw;'>
        <div class="navigation-buttons"><a href='/main'>Main</a></div>
        <div class="navigation-buttons"><a href='/profile'>Profile</a></div>
        <div class="navigation-buttons"><a href='/camera'>Camera</a></div>
        <div class="navigation-buttons"><a href='/settings'>Settings</a></div>
LINKS;
    if (!isset($_SESSION['Logged_user']) && empty($_SESSION['Logged_user'])) {
        echo " <div class='navigation-buttons'><a href=/signin>Sign in</a></div>";
        echo " <div class='navigation-buttons'><a href='/signup'>Sign up</a></div></div>";
    }
    else
        echo " <div class='navigation-buttons'><a href=/main/signout>Sign out</a></div></div>";

    $post = $data['post'];
    echo <<<POST
        <article class="post">
            <section class="post-user">
                <img class="post-user-image" src=/main/get_profile_image/{$post['Profile_Image']}><br />
                <a class="post-username" href=/profile/user/{$post['Login']}><p>{$post['Login']}</p></a>
                <p class="post-creation-date">{$post['Creation_Date']}</p>
            </section>
            <section class="post-message">
                <p>{$post['Message']}</p>
            </section>
            <section class="post-image">
                <img src=/main/get_post_image/{$post['Post_Image']}><br />
            </section>
POST;
    if (isset($_SESSION['Logged_user_ID']) && $post['User_ID'] == $_SESSION['Logged_user_ID'])
        echo <<<DELETE_POST
                <a href=/main/delete_post/{$post['Post_ID']}>delete post</a>
DELETE_POST;
    echo <<<POST
            <section class="post-comments">
POST;
    if (isset($_SESSION['Logged_user_ID']) && !empty($_SESSION['Logged_user_ID']))
        echo <<<LIKES
            <form action=/main/like/{$post['Post_ID']}/{$_SESSION['Logged_user_ID']} method=POST>
                <input type="submit" class="post-like" name="like" value="like">
            </form>
LIKES;
    $comments = $data['comments'];
    foreach ($comments as $comment) {
        if (isset($_SESSION['Logged_user_ID']) && $comment['User_ID'] == $_SESSION['Logged_user_ID'])
            echo <<<DELETE_COMMENT
                <a href=/main/delete_comment/{$comment['Comment_ID']}>delete comment</a>
DELETE_COMMENT;
        echo <<<COMMENT
        <p>{$comment['Login']}: {$comment['Message']}</p>
COMMENT;
    }
    if (isset($_SESSION['Logged_user_ID']) && !empty($_SESSION['Logged_user_ID']))
        echo <<<POST
            </section>
            <section class="post-add-comment">
                <form action=/main/comment/{$post['Post_ID']} method=POST>
                    <input type="text" placeholder="Your commentary" name="comment" required>
                    <input type="submit" name="submit" value="OK">
                </form>
            </section>
        </article>
POST;
