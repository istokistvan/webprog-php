<?php

session_start();

$last_item = end($_SESSION["polls"]);
$last_id = (int)substr($last_item["id"], -1);

$res = [
    'id' => 'poll' . ++$last_id,
    'question' => $_POST["question"],
    'options' => explode(',', $_POST["options"]),
    'isMultiple' => isset($_POST["isMultiple"]),
    'createdAt' => date("Y-m-d"),
    'deadline' => $_POST["deadline"],
    'answers' => [],
    'voted' => []
];

$_SESSION["polls"]['poll' . $last_id] = $res;
file_put_contents("./Storage/polls.json", json_encode($_SESSION["polls"]));
header("Location: index.php");
