

<?php
require_once "partial/header.php";
require_once "private.php";



$client = new Google_Client();
$client->setDeveloperKey(YOUTUBE_API_KEY);

$youtube = new Google_Service_YouTube($client);

$response = $youtube->playlistItems->listPlaylistItems("contentDetails,snippet",["playlistId" => PLAYLIST_ID,"maxResults"=>50]);
$totalVideoCount = $response["pageInfo"]["totalResults"];

$finalList = $response["items"];

while($response["nextPageToken"] != null){
    $response = $youtube->playlistItems->listPlaylistItems("contentDetails,snippet",["playlistId" => PLAYLIST_ID,"maxResults"=>50,"pageToken"=>$response["nextPageToken"]]);
    foreach ($response["items"] as $key => $value){
        array_push($finalList,$value);
    }
}
?>
<br><?= $response["pageInfo"]["totalResults"] ?><br>
    ----------------------------------------------------------------
    <pre>

        <?= var_dump($finalList) ?>

    </pre>
<?php
require_once "partial/footer.php";
?>
