<?php
require_once "partial/header.php";
require_once "private.php";

$db = new PDO("mysql:host=" . BDD["addr"] . ";dbname=" . BDD["db"], BDD["user"], BDD["pwd"]);
$query = $db->query("SELECT * FROM `video` ORDER BY `position`");

$result = $query->fetchAll();

$currentID = filter_input(INPUT_GET, "id");


?>
<div class="container mt-2">
    <div class="row ">
        <div class="col-9 container d-grid gap-3">
            <div class="row">
                <?php
                if ($currentID) {   /*:miaou:*/
                    ?>
                    <iframe id="video" style="width: 100%;height: 75vh"
                            src="https://www.youtube.com/embed/<?= $currentID ?>?&autoplay=1"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    <?php
                } else {
                    $currentID = $result[0]["id"];

                    ?>
                    <iframe id="video" style="width: 100%;height: 75vh"
                            src="https://www.youtube.com/embed/<?= $currentID ?>"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>

                    <?php
                }
                ?>
            </div>
            <div class="row">
                <h2>Pourquoi elle a été ajouté ?</h2>
                <textarea rows="5" id="reason" class="form-control"></textarea>
            </div>
            <div class="row">
                <h2>Tag</h2>
                <p>
                    <?php

                    $query = $db->query("SELECT `tag`.id, `tag`.title FROM `tag` INNER JOIN `tagtovideo` ON `tag`.id = `tagtovideo`.`idTag` WHERE `tagtovideo`.`idVideo` = '$currentID' ");
                    $TagVideo = $query->fetchAll();
                    foreach ($TagVideo as $key => $tag) {
                        ?>
                        <span id="Tag<?= $tag["id"] ?>" class="badge bg-secondary" style="font-size: medium">
                                <?= $tag["title"] ?>
                                <button class="btn position-absolute translate-middle badge rounded-pill bg-primary" style="display: none" onclick="alert('tagBadge<?= $tag["id"] ?>')">▼</button>
                        </span>
                        <script>

                            /* hover pour le bouton avec la fleche */
                            let tagBadge<?= $tag["id"] ?> = document.getElementById("Tag<?= $tag["id"] ?>");
                            tagBadge<?= $tag["id"] ?>.addEventListener("mouseover", function ( event ) {
                                event.target.children[0].style.display = "inline-block"
                            })
                            tagBadge<?= $tag["id"] ?>.addEventListener("mouseleave", function ( event ) {
                                event.target.children[0].style.display = "none"
                            })


                        </script>
                        <?php
                    }
                    ?>
                    <button class="badge btn btn-success" type="button" data-bs-toggle="collapse"
                            data-bs-target="#AddTag" aria-expanded="false" aria-controls="AddTag">+
                    </button>
                </p>
                <div class="collapse" id="AddTag">
                    <div class="card card-body">
                        Some placeholder content for the collapse component. This panel is hidden by default but
                        revealed when the user activates the relevant trigger.
                    </div>
                </div>

            </div>
        </div>
        <div class="col-3" style="max-height: 80vh">
            <!--                 ________________                        -->
            <!--                |                |_____    __            -->
            <!--                |  I Love You!   |     |__|  |_________  -->
            <!--                |________________|     |::|  |        /  -->
            <!--   /\**/\       |                \.____|::|__|      &lt; -->
            <!--  ( o_o  )_     |                      \::/  \._______\  -->
            <!--   (u--u   \_)  |                                        -->
            <!--    (||___   )==\                                        -->
            <!--  ,dP"/b/=( /P"/b\                                       -->
            <!--  |8 || 8\=== || 8                                       -->
            <!--  `b,  ,P  `b,  ,P                                       -->
            <!--    """`     """`                                        -->
            <!--                                                         -->
            <!--                     Le Tutute-chat                      -->
            <table class="table table-hover table-striped">
                <tbody>
                <?php
                foreach ($result as $key => $value) {
                    ?>


                    <tr onclick="document.location = '?id=<?= $value["id"] ?>'" style="cursor: pointer"
                        class="d-flex align-items-stretch <?php
                        if ($value["id"] == $currentID) {
                            echo "table-dark";
                        }
                        ?>">

                        <th scope="row"
                            class="align-self-stretch d-flex align-items-center"><?= $value["position"] ?></th>
                        <td class="align-self-stretch d-flex align-items-center"><img src="<?= $value["thumbnails"] ?>">
                        </td>
                        <td class="align-self-stretch d-flex align-items-center"><?php /*if(strlen($value["title"])>30){
                           echo substr($value["title"],0,30);
                        }else{
                            echo $value["title"];
                        }*/
                            echo $value["title"];
                            ?></td>
                    </tr>


                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
require_once "partial/footer.php";
?>
