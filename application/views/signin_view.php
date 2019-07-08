<style></style>
<header></header>
<main>
    <?php
        echo <<<LINKS
        <a href='/main'>Main</a>
        <a href='/profile'>Profile</a>
        <a href='/create'>Create</a>
LINKS;
        switch ($data) {
            case 'success':
                echo '<h1>LOGGED IN<h1>';
                break;
            case 'fail':
                echo '<h1>STOP RIGHT THERE CRIMINAL SCUM<h1>';
                break;
            case 'bad_login':
                echo '<h1>BAD LOGIN<h1>';
                break;
            case 'bad_passw':
                echo '<h1>BAD PASSWORD<h1>';
                break;
            default:
                echo <<<FORM
                <form action="/signin/authorize" method="POST">
                    <input type="text" placeholder="Login" name="login" required><br />
                    <input type="text" placeholder="Password" name="passw" required><br />
                    <input type="submit" value="OK">
                </form>
FORM;
                break;
        }
    ?>
</main>
<footer></footer>