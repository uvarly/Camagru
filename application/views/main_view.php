<style></style>
<header></header>
<main>
    <?php
    echo <<<LINKS
    <a href='/main'>Main</a>
    <a href='/profile'>Profile</a>
    <a href='/create'>Create</a>
    <a href='/signup'>Sign up</a>
LINKS;
    if (!isset($_SESSION['Logged_user']) && empty($_SESSION['Logged_user']))
        echo "<a href=/signin>Sign in</a>";
    else
        echo "<a href=/main/signout>Sign out</a>";

    /** DUMPS */
    var_dump($_SESSION);
    foreach ($data as $post)
        var_dump($post);
    // var_dump($_SERVER);
    /** */

    foreach ($data['posts'] as $post)
    {
        echo <<<POST
            <article>
                <section class="post-user">
                    <img src=/main/get_profile_image/{$post['Profile_Image']}><br />
                    <p>{$post['Login']}</p>
                    <p>{$post['Creation_Date']}</p>
                </section>
                <section class="post-message">
                    <p>{$post['Message']}</p>
                </section>
                <section class="post-image">
                    <img src=/main/get_post_image/{$post['Post_Image']}><br />
                </section>
                <section class="post-comments">
POST;
        if (isset($_SESSION['Logged_user_ID']) && !empty($_SESSION['Logged_user_ID']))
            echo <<<LIKE
                <form action=/main/like/{$post['Post_ID']}/{$_SESSION['Logged_user_ID']} method=POST>
                    <input type="submit" class="post-like" name="like" value="like">
                </form>
LIKE;
        foreach ($data['likes'] as $likes)
            if ($likes['Post_ID'] == $post['Post_ID'])
                echo "<p>{$likes['Likes']} people liked this post</p>";

        $comments = $data['comments'];
        foreach ($comments as $comment)
        {
            if ($post['Post_ID'] == $comment['Post_ID'])
                echo <<<COMMENT
                <p>{$comment['Login']}</p>
                <p>{$comment['Message']}</p>
                <p>{$comment['Creation_Date']}</p>
COMMENT;
        }
        if (isset($_SESSION['Logged_user_ID']) && !empty($_SESSION['Logged_user_ID']))
            echo <<<POST
                </section>
                <section class="post-add-comment">
                    <form action=/main/comment/{$post['Post_ID']}/{$_SESSION['Logged_user_ID']} method=POST>
                        <input type="text" placeholder="Your commentary" name="comment" required>
                        <input type="submit" name="submit" value="OK">
                    </form>
                </section>
            </article>
POST;
    }
    ?>
</main>
<footer></footer>