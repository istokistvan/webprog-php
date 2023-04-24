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
    <title>Szavazat leadása</title>
</head>

<body>
    <?php

    $poll = [];

    if (isset($_GET["poll"])) {
        $poll =  $_SESSION["polls"][$_GET["poll"]];
    }

    if ($poll["isMultiple"]) {
        $type = "checkbox";
    } else {
        $type = "radio";
    }

    if (isset($_SESSION["msg"])) {
    ?>
        <div class="message">
            <p><?= $_SESSION["msg"] ?></p>
        </div>
    <?php
    }

    ?>
    <form method="POST" action="./validate_answer.php" novalidate>
        <h1><?= $poll["question"] ?></h1>

        <?php

        foreach ($poll["options"] as $index => $answer) { ?>
            <input type="<?= $type ?>" value="<?= $answer ?>" id="<?= $answer ?>" name="<?= $index ?>_answer_id">
            <label for="<?= $answer ?>"><?= $answer ?></label>
            <br>
        <?php } ?>
        <input type="hidden" name="target" value="<?= $_GET["poll"] ?>">
        <input type="submit">
    </form>

</body>

</html>