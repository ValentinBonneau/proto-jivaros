<?php
require_once "../private.php";

$currentID = filter_input(INPUT_GET, "id");

$db = new PDO("mysql:host=" . BDD["addr"] . ";dbname=" . BDD["db"], BDD["user"], BDD["pwd"]);
$query = $db->query("SELECT `tag`.id, `tag`.title FROM `tag` WHERE `tag`.id NOT IN (SELECT `tag`.id FROM `tag` INNER JOIN `tagtovideo` ON `tag`.id = `tagtovideo`.`idTag` WHERE `tagtovideo`.`idVideo` = '$currentID') ");
$TagVideo = $query->fetchAll();
?>

<script>
    function editTag(tagTitle,tagID){
        document.getElementById("modifTagTitle").value = tagTitle
        document.getElementById("modifTagId").value = tagID
    }
</script>

<?php
foreach ($TagVideo

         as $key => $tag) {
    ?>
    <span id="Tag<?= $tag["id"] ?>" class="badge bg-secondary" style="font-size: medium">
                                <?= $tag["title"] ?>
                                <button class="btn position-absolute translate-middle badge rounded-pill bg-success"
                                        style="display: none" onclick="addTag('<?= $tag["title"] ?>')"><b>+</b></button>
                        </span>
    <script>

        /* hover pour le bouton avec la fleche */
        tagBadge<?= $tag["id"] ?> = document.getElementById("Tag<?= $tag["id"] ?>");
        tagBadge<?= $tag["id"] ?>.addEventListener("mouseover", function (event) {
            event.target.children[0].style.display = "inline-block"
        })
        tagBadge<?= $tag["id"] ?>.addEventListener("mouseleave", function (event) {
            event.target.children[0].style.display = "none"
        })
    </script>
    <?php
}
?>
