<?php

session_start();

$errors = [
    "username" => "",
    "email" => "",
    "password" => "",
    "again" => "",
    "form" => ""
];

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Regisztráció</title>
</head>

<body>
    <h1>Regisztráció</h1>
    <form method="POST" novalidate>
        <p><?= $errors["form"] ?></p>


        <label for="username"><?= $errors["username"] ?></label>
        <input type="text" name="username" id="username" placeholder="Felhasználónév" value=<?= $_POST['username'] ?? '' ?>>
        <br>
        <label for="email"><?= $errors["email"] ?></label>
        <input type="email" name="email" id="email" placeholder="Email" value=<?= $_POST['email'] ?? '' ?>>
        <br>
        <label for="password"><?= $errors["password"] ?></label>
        <input type="password" name="password" id="password" placeholder="Jelszó" value=<?= $_POST['password'] ?? '' ?>>
        <br>
        <label for="again"><?= $errors["again"] ?></label>
        <input type="password" name="again" id="again" placeholder="Jelszó újra" value=<?= $_POST['again'] ?? '' ?>>
        <br>
        <input type="submit">
        <?= registerValidate() ?>
        <br>
        <p>Már van fiókja? </p>
        <a href="./login.php">Jelentkezzen be!</a>
    </form>

    <?php
    function isValidEmail($email)
    {
        $v = "/[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z]+/";

        return (bool) preg_match($v, $email);
    }

    function registerValidate()
    {
        if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email']) || !isset($_POST['again'])) return;

        global $error_logs;

        $users = $_SESSION['alluser'];

        $check = false;

        if (strlen($_POST['username']) == 0) {
            $error_logs['username'] = 'Nem adta meg a felhasználónevét!';
            $check = true;
        }

        if (strlen($_POST['password']) == 0) {
            $error_logs['password'] = 'Nem adta meg a jelszavát!';
            $check = true;
        }

        if (strlen($_POST['email']) == 0) {
            $error_logs['email'] = 'Nem adta meg az email címét!';
            $check = true;
        }

        if (strlen($_POST['again']) == 0) {
            $error_logs['again'] = 'Nem erősítette meg a jelszavát!';
            $check = true;
        }

        if ($check) return;

        foreach ($users as $user) {
            if ($_POST['username'] == $user['username']) {
                $error_logs['username'] = 'Ez a felhasználónév már foglalt!';
                break;
            }

            if ($_POST['email'] == $user['email']) {
                $error_logs['email'] = 'Ez az email-cím már foglalt!';
                break;
            }
        }

        if (!isValidEmail($_POST['email'])) {
            $error_logs['email'] = 'Az email-cím nem megfelelő!';
            return;
        }

        if ($_POST['password'] != $_POST['again']) {
            $error_logs['password'] = 'A jelszavak nem egyeznek meg!';
            $error_logs['again'] = 'A jelszavak nem egyeznek meg!';
            return;
        }

        $_SESSION['alluser']['userid' . count($users) + 1] = [
            'id' => 'userid' . count($users) + 1,
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'isAdmin' => false,
        ];

        file_put_contents("./Storage/users.json", json_encode($_SESSION["alluser"]));
        header('Location: login.php');
    }

    ?>
</body>

</html>