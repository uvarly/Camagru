<style></style>
<header></header>
<main>
    <?php
        echo <<<LINKS
        <a href='/main'>Main</a>
        <a href='/profile'>Profile</a>
        <a href='/create'>Create</a>
LINKS;
        var_dump($_FILES);
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
            case 'bad_submit':
                echo '<h1>BAD SUBMIT<h1>';
                break;
            case 'user_exists':
                echo '<h1>USER EXISTS<h1>';
                break;
            case 'email_exists':
                echo '<h1>EMAIL EXISTS<h1>';
                break;
            case 'mailicious_file':
                echo '<h1>DON\'T YOU DARE BRING THAT SHIT HERE, DAWG</h1>';
                break;
            default:
                echo <<<FORM
                <form action="/signup/insert" method="POST" enctype="multipart/form-data">
                    <input type="text" placeholder="Login" name="login" required><br />
                    <input type="text" placeholder="Password" name="passw" required><br />
                    <input type="text" placeholder="Email" name="email" required><br />
                    <input type="file" accept="image/*" name="image"><br />
                    <input type="submit" name="submit" value="OK">
                </form>
FORM;
                break;
        }
    ?>
</main>
<footer></footer>