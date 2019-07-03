<style></style>
<header></header>
<main>
    <h1>This is the post creation page</h1>
    <?php
    if ($data != 'error')
        echo <<<FORM
        <form action="http://{$_SERVER['HTTP_HOST']}/create/new_post" method="POST" enctype="multipart/form-data">
            Post_Image: <input type="file" accept="image/*" name="Post_Image"><br />
            Message: <input type="text" name="Message">
            <input type="submit" name="Submit" value="Submit">
        </form>
FORM;
    else
        echo "KEK";
    ?>
</main>
<footer></footer>