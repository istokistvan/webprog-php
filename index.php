<?php

session_start();

if (isset($_GET["logout"])) {
    session_unset();
    header('Location: index.php');
}

if (isset($_GET["delete"])) {
    unset($_SESSION["polls"][$_GET["delete"]]);
    file_put_contents("./Storage/polls.json", json_encode($_SESSION["polls"]));
}

$polls = json_decode(file_get_contents("./Storage/polls.json"), true);
$users = json_decode(file_get_contents("./Storage/users.json"), true);

$_SESSION["polls"] = $polls;
$_SESSION["alluser"] = $users;

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/styles.css">
    <title>Szavazás</title>
</head>

<body>

    <header>
        <div class="nav">
            <?php

            if (isset($_SESSION["user"])) { ?>
                <h2><?= $_SESSION["user"] ?></h2>
                <a href="./index.php?logout=true">
                    <button>Kijelentkezés</button>
                </a>

                <?php

                if ($_SESSION["user"] === "admin") {
                ?>
                    <a href="./create.php">
                        <button>Szavazás létrehozása</button>
                    </a>
                <?php
                }
            } else { ?> <a href="./login.php">
                    <button>Bejelentkezés</button>
                </a>

                <a href="./register.php">
                    <button>Regisztráció</button>
                </a>

            <?php } ?>

        </div>

        <?php

        if (isset($_SESSION["msg"])) {

        ?>
            <div class="msg">
                <p><?= $_SESSION["msg"] ?></p>
            </div>

        <?php } ?>

    </header>

    <main>
        <h1>Szavazólapok</h1>
        <div id="polls">
            <h2>Aktuális szavazólapok</h2>
            <?php

            $actuals = array_filter($polls, function ($a) {
                return strtotime($a["deadline"]) >= time();
            });

            usort($actuals, function ($a, $b) {
                return strtotime($a['createdAt']) - strtotime($b['createdAt']);
            });

            foreach ($actuals as $actual) { ?>

                <div class="card">
                    <h3><?= $actual['id'] ?></h3>
                    <p><?= $actual['createdAt'] ?> - <?= $actual['deadline'] ?></p>

                    <?php

                    if (isset($_SESSION["user"]) && $_SESSION["user"] === "admin") {
                    ?>

                        <a href="./index.php?delete=<?= $actual["id"] ?>">
                            <button>Szavazás törlése</button>
                        </a>

                    <?php }  ?>


                    <?php

                    if (isset($_SESSION["user"])) {  ?>
                        <a href="vote.php?poll=<?= $actual["id"] ?>">
                            <button>

                                <?php
                                if (in_array($_SESSION["userid"], $actual["voted"])) { ?>

                                    Szavazat frissítése

                                <?php } else { ?>

                                    Szavazás

                                <?php } ?>

                            </button>
                        </a>

                    <?php } else {  ?>

                        <a href="./login.php">
                            <button>Szavazás</button>
                        </a>

                    <?php } ?>

                </div>

            <?php } ?>

            <h2>Lejárt szavazólapok</h2>
            <?php

            $expireds = array_filter($polls, function ($a) {
                return strtotime($a["deadline"]) < time();
            });

            usort($expireds, function ($a, $b) {
                return strtotime($a['createdAt']) - strtotime($b['createdAt']);
            });

            foreach ($expireds as $expired) { ?>

                <div class="card">
                    <h3><?= $expired['id'] ?></h3>
                    <p><?= $expired['createdAt'] ?> - <?= $expired['deadline'] ?></p>

                    <?php
                    foreach ($expired["answers"] as $key => $value) {
                        echo "$key:$value<br>";
                    } ?>

                </div>

            <?php } ?>

        </div>
    </main>

    <footer></footer>

</body>

</html>