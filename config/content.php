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

    $pdo->exec("INSERT INTO `Users` (`Login`, `Password`, `Email`, `Image`)
                VALUES ('dio', $dio, 'dio@mail.kek', 'dio.jpeg')");
    $pdo->exec("INSERT INTO `Users` (`Login`, `Password`, `Email`, `Image`)
                VALUES ('jotaro', $jotaro, 'jotaro@mail.kek', 'jotaro.jpeg')");
    $pdo->exec("INSERT INTO `Users` (`Login`, `Password`, `Email`, `Image`)
                VALUES ('kakyoin', $kakyoin, 'kakyoin@mail.kek', 'kakyoin.jpeg')");
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
} catch (Exception $exc) {
    die ("Exception caught: " . $exc->getMessage());
}

?>