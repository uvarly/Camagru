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
    foreach ($data['posts'] as $post)
    {
        echo <<<POST
        <article class="post">
            <section class="post-user">
                <a href=/profile/user/{$post['Login']}><p>{$post['Login']}</p>
                <img class="post-user-image" src=/main/get_profile_image/{$post['Profile_Image']}></a><br />
                <p>{$post['Creation_Date']}</p>
            </section>
            <section class="post-message">
                <p>{$post['Message']}</p>
            </section>
            <section class="post-image">
                <img src=/main/get_post_image/{$post['Post_Image']}><br />
            </section>
            <secion class="post-comments-link">
                <a href=/main/post/{$post['Post_ID']}>Open comments</a>
            </section>
            <section class="post-comments">
POST;
        if (isset($_SESSION['Logged_user_ID']) && !empty($_SESSION['Logged_user_ID']))
            echo <<<LIKES
                <form action=/main/like/{$post['Post_ID']}/{$_SESSION['Logged_user_ID']} method=POST>
                    <input type="submit" class="post-like" name="like" value="like">
                </form>
LIKES;
        foreach ($data['likes'] as $likes)
            if ($likes['Post_ID'] == $post['Post_ID'])
                echo "<p>{$likes['Likes']} like(s)</p>";
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
        else
            echo "</section></article>";
    }