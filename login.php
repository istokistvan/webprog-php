<?php

session_start();

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Bejelentkezés</title>
</head>

<body>
    <h1>Bejelentkezés</h1>
    <form novalidate>
        <input type="text" name="username" id="username" placeholder="Felhasználónév">
        <br>
        <input type="password" name="password" id="password" placeholder="Jelszó">
        <br>
        <input type="submit">
        <br>
        <p>Még nincs fiókja? </p>
        <a href="./register.php">Regisztráljon egyet!</a>
    </form>

    <?php

    $username = "";
    $password = "";
    $actual = false;
    $errors = [];

    if (isset($_GET["username"])) {
        $username = $_GET["username"];
    }

    if (isset($_GET["password"])) {
        $password = $_GET["password"];
    }

    $usernames = array_column($_SESSION["alluser"], "username", "id");
    if (!empty($username)) {
        $actual = array_search($username, $usernames);
        if (!$actual) {
            $errors[] = "Hibás felhasználónév!";
        }
    }

    if ($actual) {
        if ($_SESSION["alluser"][$actual]["password"] === $password && count($errors) == 0) {
            $_SESSION["user"] = $_SESSION["alluser"][$actual]["username"];
            $_SESSION["userid"] = $_SESSION["alluser"][$actual]["id"];
        } else {
            $errors[] = "Hibás jelszó!";
        }
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo '<p>' . $error . '</p>';
        }
    }

    if (isset($_SESSION["user"])) {
        header("Location: index.php");
    }
    ?>
</body>

</html>