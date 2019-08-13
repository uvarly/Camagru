<style></style>
<header></header>
<main>
    <?php
        echo <<<LINKS
        <a href='/main'>Main</a>
        <a href='/profile'>Profile</a>
        <a href='/create'>Create</a>
LINKS;
        echo <<<FORM
            <form action="/signin/authorize" method="POST">
                <input type="text" placeholder="Login" name="login"><br />
                <input type="password" placeholder="Password" name="passw"><br />
                <input type="submit" name="submit" value="OK">
            </form>
            <a href="/recover">Forgot a password?</a>
FORM;
        switch ($data) {
            case 'bad_login':
                echo "<p style='color: darkred; font-style: italic'>Please, enter a valid login</p>";
                break;
            case 'bad_passw':
                echo "<p style='color: darkred; font-style: italic'>Please, enter a valid password</p>";
                break;
            case 'bad_submit':
                echo "
                 ____                                        __         __                  __        _           __                         
                /  _/  _____ ___   ___     _      __ ____ _ / /_ _____ / /_   ____ _   ____/ /____   (_)____     / /_   ___   _____ ___      
                / /   / ___// _ \ / _ \   | | /| / // __ `// __// ___// __ \ / __ `/  / __  // __ \ / // __ \   / __ \ / _ \ / ___// _ \     
              _/ /   (__  )/  __//  __/   | |/ |/ // /_/ // /_ / /__ / / / // /_/ /  / /_/ // /_/ // // / / /  / / / //  __// /   /  __/     
             /___/  /____/ \___/ \___/    |__/|__/ \__,_/ \__/ \___//_/ /_/ \__,_/   \__,_/ \____//_//_/ /_/  /_/ /_/ \___//_/    \___/      
                                                    __  __ ___    ______ __ __  ______ ____   ____   ____   ____                             
               _____ _____ _____ _____ _____ _____ / / / //   |  / ____// //_/ / ____// __ \ / __ ) / __ \ /  _/_____ _____ _____ _____ _____
              /____//____//____//____//____//____// /_/ // /| | / /    / ,<   / __/  / /_/ // __  |/ / / / / / /____//____//____//____//____/
             /____//____//____//____//____//____// __  // ___ |/ /___ / /| | / /___ / _, _// /_/ // /_/ /_/ / /____//____//____//____//____/ 
                                                /_/ /_//_/  |_|\____//_/ |_|/_____//_/ |_|/_____/ \____//___/                                
                                                                                                                                             
             ";
                break;
        }
    ?>
</main>
<footer></footer>