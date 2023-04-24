<?php

session_start();

if (count($_POST) > 1) {
    if (!in_array($_SESSION["userid"], $_SESSION["polls"][$_POST["target"]]["voted"])) {
        foreach ($_SESSION["polls"][$_POST["target"]]["options"] as $index => $answer) {
            if (isset($_POST[$index . "_answer_id"])) {
                $_SESSION["polls"][$_POST["target"]]["answers"][$answer]++;
            }
        }

        $_SESSION["polls"][$_POST["target"]]["voted"][] = $_SESSION["userid"];
        file_put_contents("./Storage/polls.json", json_encode($_SESSION["polls"]));
        $_SESSION["msg"] = "Sikeres kitöltés!";
        header("Location: index.php");
    }
} else {
    $_SESSION["msg"] = "Kitöltetlen űrlap!";
    header("Location: vote.php?poll=" . $_POST["target"]);
}
