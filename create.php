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
    <title>Szavazás létrehozása</title>
</head>

<body>

    <h1>Új szavazás létrehozása</h1>
    <form method="POST" action="./validate_creation.php" novalidate>

        <input type="text" name="question" id="question" placeholder="Kérdés">
        <br>

        <input type="text" name="options" id="options" placeholder="Válaszok">

        <br>

        <input type="checkbox" name="isMultiple" id="isMultiple" value="1">
        <label for="isMultiple">Megjelölhető több is?</label>

        <br>

        <input type="date" name="deadline" id="deadline" placeholder="Határidő">

        <br>

        <input type="submit">

    </form>

</body>

</html>