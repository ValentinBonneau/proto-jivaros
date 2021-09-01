<?php
require_once "../private.php";

$idVideo = filter_input(INPUT_POST, "video");
$idTag = filter_input(INPUT_POST,"tag");


$db = new PDO("mysql:host=" . BDD["addr"] . ";dbname=" . BDD["db"], BDD["user"], BDD["pwd"]);

$query = $db->prepare("DELETE FROM `tagtovideo` WHERE `idVideo`= :video AND `idTag`= :tag ");
$query->bindParam(":video",$idVideo);
$query->bindParam(":tag", $idTag);
$query->execute();
