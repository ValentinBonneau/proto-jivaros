<?php
require_once "../private.php";

$idTag = filter_input(INPUT_POST,"tag");

$db = new PDO("mysql:host=" . BDD["addr"] . ";dbname=" . BDD["db"], BDD["user"], BDD["pwd"]);

$query = $db->prepare("DELETE FROM `tag` WHERE `id` = :id");
$query->bindParam(":id",$idTag, PDO::PARAM_INT);
$query->execute();
