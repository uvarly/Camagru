<style></style>
<header></header>
<main>
    <?php
        switch ($data) {
            case 'success':
                echo '<h1>AN ACCOUNT HAS BEEN CREATED<h1>';
                break;
            case 'bad_login':
                echo '<h1>BAD LOGIN<h1>';
                break;
            case 'bad_passw':
                echo '<h1>BAD PASSWORD<h1>';
                break;
            case 'bad_email':
                echo '<h1>BAD EMAIL<h1>';
                break;
            case 'user_exists':
                echo '<h1>USER EXISTS<h1>';
                break;
            case 'email_exists':
                echo '<h1>EMAIL EXISTS<h1>';
                break;
            default:
                echo <<<FORM
                <form action="/signup/insert" method="POST">
                    <input type="text" placeholder="Login" name="login" required><br />
                    <input type="text" placeholder="Password" name="passw" required><br />
                    <input type="text" placeholder="Email" name="email" required><br />
                    <input type="text" name="image"><br />
                    <input type="submit" value="OK">
                </form>
FORM;
                break;
        }
    ?>
</main>
<footer></footer>