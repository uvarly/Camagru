<style></style>
<header></header>
<main>
    <?php
        echo <<<FORM
        <form action="http://{$_SERVER['HTTP_HOST']}/signup/insert" method="POST">
            <input type="text" name="login"><br />
            <input type="text" name="passw"><br />
            <input type="text" name="email"><br />
            <input type="text" name="image"><br />
            <input type="submit" value="OK">
        </form>
FORM;
    ?>
</main>
<footer></footer>