<?php

require 'database.php';

try {
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

try {
    $dio = '\'' . hash('whirlpool', 'muda') . '\'';
    $jotaro = '\'' . hash('whirlpool', 'ora') . '\'';
    $kakyoin = '\'' . hash('whirlpool', 'rero') . '\'';

    $pdo->exec("INSERT INTO `Users` (`Login`, `Password`, `Email`, `Image`, `Confirmed`)
                VALUES ('dio', $dio, 'dio@mail.kek', 'dio.jpeg', '1')");
    $pdo->exec("INSERT INTO `Users` (`Login`, `Password`, `Email`, `Image`, `Confirmed`)
                VALUES ('jotaro', $jotaro, 'jotaro@mail.kek', 'jotaro.jpeg', '1')");
    $pdo->exec("INSERT INTO `Users` (`Login`, `Password`, `Email`, `Image`, `Confirmed`)
                VALUES ('kakyoin', $kakyoin, 'kakyoin@mail.kek', 'kakyoin.jpeg', '1')");
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

try {
    $pdo->exec("INSERT INTO `Posts` (`User_ID`, `Image`, `Message`)
                VALUES ('1', 'nom.jpg', 'kek'),('3', 'polpyoin.png', 'RERO RERO RERO RERO')");
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

try {
    $pdo->exec("INSERT INTO `Comments` (`User_ID`, `Post_ID`, `Message`)
                VALUES ('3', '1', 'That hurts, ya know!')");
    $pdo->exec("INSERT INTO `Comments` (`User_ID`, `Post_ID`, `Message`)
                VALUES ('2', '2', 'Quit munching that stupid cherry, Kakyoin!!')");
    $pdo->exec("INSERT INTO `Comments` (`User_ID`, `Post_ID`, `Message`)
                VALUES ('1', '2', 'Who\'s Giorno btw?')");
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

?>