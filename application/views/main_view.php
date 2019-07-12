<style></style>
<header></header>
<main>
    <?php
    foreach ($data as $post)
        var_dump($post);
    if (isset($_SESSION['Logged_user']) && !empty($_SESSION['Logged_user']))
        echo <<< SIGNOUT
            <a href='http://{$_SERVER['HTTP_HOST']}/main/sign_out'>Sign out</a>
SIGNOUT;
    foreach ($data['posts'] as $post)
    {
        echo <<< POST
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
        foreach ($comments as $comment)
        {
            if ($post['Post_ID'] == $comment['Post_ID'])
                echo <<< COMMENT
                <p>{$comment['Login']}</p>
                <p>{$comment['Message']}</p>
                <p>{$comment['Creation_Date']}</p>
COMMENT;
        }
        echo <<< POST
                </section>
            </article>
POST;
    }
    ?>
</main>
<footer></footer>