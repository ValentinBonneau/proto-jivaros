<?php
require_once "../private.php";

$newTagName = ucfirst( strtolower( filter_input( INPUT_POST,"newTag")));
$videoId = filter_input(INPUT_POST, "videoID");

$db = new PDO("mysql:host=" . BDD["addr"] . ";dbname=" . BDD["db"], BDD["user"], BDD["pwd"]);

$query = $db->query("SELECT id FROM `tag` WHERE `title` = '$newTagName'");
$result = $query->fetchAll();

if(empty($result)){
    $query = $db->prepare("INSERT INTO `tag` (`title`) VALUES (:newtagname);");
    $query->bindParam(":newtagname",$newTagName);
    $query->execute();
    $query = $db->query("SELECT id FROM `tag` WHERE `title` = '$newTagName'");
    $result = $query->fetchAll();
}

$query = $db->prepare("INSERT INTO `tagtovideo`(`idVideo`, `idTag`) VALUES (:idVideo,:idTag)");
$query->bindParam(":idVideo",$videoId);
$query->bindParam(":idTag",$result[0]["id"]);
$query->execute();




