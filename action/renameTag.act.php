<?php
require_once "../private.php";

$title = ucfirst( strtolower( filter_input( INPUT_POST,"title")));
$id = filter_input(INPUT_POST, "id");

$db = new PDO("mysql:host=" . BDD["addr"] . ";dbname=" . BDD["db"], BDD["user"], BDD["pwd"]);

$query = $db->query("UPDATE `tag` SET `title`='$title' WHERE `id`=$id");