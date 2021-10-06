<?php
require_once "../partial/header.php";
require_once "../private.php";

$db = new PDO("mysql:host=" . BDD["addr"] . ";dbname=" . BDD["db"], BDD["user"], BDD["pwd"]);


$client = new Google_Client();
$client->setDeveloperKey(YOUTUBE_API_KEY);
$youtube = new Google_Service_YouTube($client);


$response = $youtube->playlistItems->listPlaylistItems("snippet", ["playlistId" => PLAYLIST_ID, "maxResults" => 50]);
$finalList = $response["items"];
while ($response["nextPageToken"] != null) {
    $response = $youtube->playlistItems->listPlaylistItems("snippet", ["playlistId" => PLAYLIST_ID, "maxResults" => 50, "pageToken" => $response["nextPageToken"]]);
    foreach ($response["items"] as $key => $value) {
        array_push($finalList, $value);
    }
}

$idColection = "";

foreach ($finalList as $key => $value) {
    if ($value["modelData"]["snippet"]["title"] != "Deleted video") {
        $id = $value["modelData"]["snippet"]["resourceId"]["videoId"];
        $thumbnails = $value["modelData"]["snippet"]["thumbnails"]["default"]["url"];


        $title = $db->quote($value["modelData"]["snippet"]["title"]);
        $position = $value["modelData"]["snippet"]["position"];

        $idColection .= " `id` = '$id' OR";

        $query = $db->query("SELECT `position` FROM Video where id = '$id'");
        $result = $query->fetchAll();


        if (empty($result)) {

            $db->query("INSERT INTO `video`(`id`, `thumbnails`, `title`, `position`) VALUES ('$id','$thumbnails',$title,'$position')");
        } else {

            if ($result[0]["position"] != $position) {
                $db->query("UPDATE `video` SET `position`= '$position' WHERE `id` = '$id'");
            }
        }
    }
}

$idColection = substr($idColection, 0, -2);

$delete = $db->query("DELETE FROM `video` WHERE NOT ($idColection)");
/*
var_dump($delete);
*/

header("location:../../");
require_once "../partial/footer.php";





