<style></style>
<header></header>
<main>
    <?php
    foreach ($data as $post)
    {
        echo <<<POST
        <div>
            <p>{$post['Login']}</p>
            <img src=http://192.168.99.100:8080/main/profile_image/{$post['Profile_Image']}><br />
            <img src=http://192.168.99.100:8080/main/post_image/{$post['Post_Image']}><br />
            <p>{$post['Message']}</p>
            <p>{$post['Creation_Date']}</p>
        <div>
POST;
    }
    ?>
</main>
<footer></footer>