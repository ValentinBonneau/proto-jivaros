<?php
require_once "partial/header.php";
require_once "private.php";

$db = new PDO("mysql:host=" . BDD["addr"] . ";dbname=" . BDD["db"], BDD["user"], BDD["pwd"]);
$query = $db->query("SELECT * FROM `video` ORDER BY `position`");

$result = $query->fetchAll();

$currentID = filter_input(INPUT_GET, "id");

$error404 = false
?>
<div class="container mt-2">
    <div class="row ">
        <div class="col-9 container d-grid gap-3">
            <div class="row">
                <?php
                if ($currentID) {   /*:miaou:*/
                    $query = $db->query("SELECT * FROM `video` WHERE `id` = '$currentID'");
                    $verifVideo = $query->fetchAll();
                    $error404 = empty($verifVideo);
                    if ($error404) {
                        ?>
                        <iframe id="video" style="width: 100%;height: 75vh"
                                src="https://www.youtube.com/embed/_QhaQA6_Kv0?&autoplay=1"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        <h1>404 - C'est pas dans la playlist ça ?</h1>
                        <?php
                    } else {
                        ?>
                        <iframe id="video" style="width: 100%;height: 75vh"
                                src="https://www.youtube.com/embed/<?= $currentID ?>?&autoplay=1"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        <?php
                    }
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
            <?php
            if (!$error404) {
                ?>
                <div class="row">
                    <h2>Pourquoi elle a été ajouté ?</h2>
                    <textarea rows="5" id="reason" class="form-control"></textarea>
                </div>
                <div class="row">
                    <h2>Tag</h2>
                    <p id="tagList"></p>
                    <script>

                        $("#tagList").load("./partial/tagList.php?id=<?= $currentID ?>");
                    </script>
                    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="AddTag"
                         aria-labelledby="offcanvasBottomLabel" style="height: 35vh">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasBottomLabel">Ajouter un Tag ?</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body container">
                            <div class="row">
                                <div class="col-8 card mx-1">
                                    <div class="card-body">
                                        <h5 class="card-title">Ajouter un Tag existant</h5>
                                        <p id="unsetTagList" class="card-text"></p>
                                        <script>
                                            $("#unsetTagList").load("./partial/unsetTagList.php?id=<?= $currentID ?>");
                                        </script>
                                    </div>
                                </div>
                                <div class="col-3 card mx-1">
                                    <div class="card-body">
                                        <h5 class="card-title">Créer un Tag</h5>
                                        <input type="text" id="newTag" class="form-control mb-2" placeholder="Tag...">
                                        <button class="btn btn-success" onclick="addNewTag()">Ajouter</button>
                                        <script>
                                            function addTag(tag) {
                                                $.post("./action/addNewTag.act.php", {
                                                    videoID: "<?= $currentID ?>",
                                                    newTag: tag
                                                },
                                                    function (){

                                                    $("#tagList").load("./partial/tagList.php?id=<?= $currentID ?>");
                                                $("#unsetTagList").load("./partial/unsetTagList.php?id=<?= $currentID ?>");
                                            }

                                            )
                                            }

                                            function addNewTag() {
                                                let newTagName = document.getElementById("newTag").value;
                                                $.post("./action/addNewTag.act.php", {
                                                        videoID: "<?= $currentID ?>",
                                                        newTag: newTagName
                                                    },
                                                    function () {
                                                        $("#tagList").load("./partial/tagList.php?id=<?= $currentID ?>");
                                                        $("#unsetTagList").load("./partial/unsetTagList.php?id=<?= $currentID ?>");
                                                    }
                                                )
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <?php
            }
            ?>
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


<!-- Modal pour les tags -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Editer un Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" id="modifTagTitle" class="form-control" placeholder="Tag..." aria-label="TagName"
                           aria-describedby="button-addon2">
                    <input type="hidden" id="modifTagId" class="form-control">
                    <script>
                        function renameTag() {
                            tagTitle = document.getElementById("modifTagTitle").value
                            tagId = document.getElementById("modifTagId").value
                            $.post("./action/renameTag.act.php", {
                                    title: tagTitle,
                                    id: tagId
                                },
                                function () {
                                    $("#tagList").load("./partial/tagList.php?id=<?= $currentID ?>");
                                    $("#unsetTagList").load("./partial/unsetTagList.php?id=<?= $currentID ?>");
                                }
                            )
                        }
                    </script>
                    <button class="btn btn-outline-primary" type="button" id="button-addon2" onclick="renameTag()"
                            data-bs-dismiss="modal">Modifier
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal" onclick="deleteFromVideo()">Supprimer de la vidéo
                </button>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" onclick="deleteTag()">Supprimer le Tag</button>
                <script>
                    function deleteFromVideo(){
                        tagId = document.getElementById("modifTagId").value
                        $.post("./action/deleteFromVideo.act.php", {
                            video: "<?= $currentID ?>",
                            tag: tagId
                        },function () {
                            $("#tagList").load("./partial/tagList.php?id=<?= $currentID ?>");
                            $("#unsetTagList").load("./partial/unsetTagList.php?id=<?= $currentID ?>");
                        })
                    }
                    function deleteTag(){
                        tagId = document.getElementById("modifTagId").value;
                        $.post("./action/deleteTag.act.php",{
                            tag: tagId
                        },function () {

                            $("#tagList").load("./partial/tagList.php?id=<?= $currentID ?>");
                            $("#unsetTagList").load("./partial/unsetTagList.php?id=<?= $currentID ?>");
                        })
                    }
                </script>
            </div>
        </div>
    </div>
</div>

<?php
require_once "partial/footer.php";
?>
