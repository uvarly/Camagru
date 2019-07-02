<style></style>
<header></header>
<main>
    <?php
    foreach ($data as $post)
    {
        echo <<<POST
            <div>
                <p>{$post['Login']}</p>
                <img src=http://192.168.99.100:8080/main/get_profile_image/{$post['Profile_Image']}><br />
                <img src=http://192.168.99.100:8080/main/get_post_image/{$post['Post_Image']}><br />
                <p>{$post['Message']}</p>
                <p>{$post['Creation_Date']}</p>
            <div>
POST;
    }
    ?>
</main>
<footer></footer>