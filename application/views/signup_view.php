<style></style>
<header></header>
<main>
    <?php
        echo <<<FORM
        <form action="http://{$_SERVER['HTTP_HOST']}/signup/insert" method="POST">
            <input type="text" placeholder="Login" name="login" required
                oninvalid="alert('Login is required. Please, try typing it this time')"><br />
            <input type="text" placeholder="Password" name="passw" required
                oninvalid="alert('It seems you didn't type in the password. That box is there for a reason, you know')"><br />
            <input type="text" placeholder="Email" name="email" required
                oninvalid="alert('Yep, I need your email, too. You can't weasel it out that simply')"><br />
            <input type="text" name="image"><br />
            <input type="submit" value="OK">
        </form>
FORM;
    ?>
</main>
<footer></footer>