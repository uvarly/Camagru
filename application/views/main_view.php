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

    foreach ($data as $post)
        var_dump($post);
    foreach ($data['posts'] as $post)
    {
        echo <<<POST
            <article>
                <section class="post-user">
                    <img src=http://192.168.99.100:8080/main/get_profile_image/{$post['Profile_Image']}><br />
                    <p>{$post['Login']}</p>
                    <p>{$post['Creation_Date']}</p>
                </section>
                <section class="post-image">
                    <img src=http://192.168.99.100:8080/main/get_post_image/{$post['Post_Image']}><br />
                </section>
                <section class="post-message">
                    <p>{$post['Message']}</p>
                </section>
                <section class="post-comments">
POST;
        $comments = $data['comments'];
        foreach ($data['comments'] as $comment)
        {
            if ($post['Post_ID'] == $comment['Post_ID'])
                echo <<<COMMENT
                <p>{$comment['Login']}</p>
                <p>{$comment['Message']}</p>
                <p>{$comment['Creation_Date']}</p>
COMMENT;
        }
        echo <<<POST
                </section>
            </article>
POST;
    }
    ?>
</main>
<footer></footer>