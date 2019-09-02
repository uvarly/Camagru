<style></style>
<header></header>
<main>
    <?php
        echo <<<LINKS
        <a href='/main'>Main</a>
LINKS;
        switch ($data) {
            case 'success':
            echo <<<SUCCESS
                <p style="text-align: center; font-size: larger">
                    Account created successfully! We've sent an email to verify your account.
                </p>
                <a  style="text-align: center;" href="/main">
                    <p>return to main page</p>
                </a>
SUCCESS;
                break;
            case 'user_exists':
                echo '<p style="text-align: center; font-size: larger">An account with this login already exists</p>';
                break;
            case 'email_exists':
                echo '<p style="text-align: center; font-size: larger">An account with this login already exists</p>';
                break;
            case 'confirm_bad_link':
                echo '<p style="text-align: center; font-size: larger">It appears you are using invalid link. Please, aquire a valid one or contact our support team</p>';
                break;
            default:
                echo <<<FORM
                <form action="/signup/new_user" method="POST" enctype="multipart/form-data">
                    <input type="text" placeholder="Login" name="login"><br />
                    <input type="password" placeholder="Password" name="passw"><br />
                    <input type="email" placeholder="Email" name="email"><br />
                    <input type="submit" name="submit" value="OK">
                </form>
FORM;
                switch ($data) {
                    case 'bad_login':
                        echo "<p style='color: darkred; font-style: italic'>Please, enter a login. It's probably hard to believe, but we really need it</p>";
                        break;
                    case 'bad_passw':
                        echo "<p style='color: darkred; font-style: italic'>Sorry, but seems your password is very weak. We expect a password of at least 7 characters and at least 1 uppercase symbol</p>";
                        break;
                    case 'bad_email':
                        echo "<p style='color: darkred; font-style: italic'>Correct e-mail address required</p>";
                        break;
                    case 'bad_submit':
                        echo "<p style='color: darkred; font-style: italic'>I see watcha doin' here hackerboi</p>";
                        break;
                }
                break;
        }
    ?>
</main>
<footer></footer>