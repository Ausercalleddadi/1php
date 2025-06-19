<?php 
include 'postdb.php';

vues($_GET['id']);

$post = getpostsbyid($_GET['id']);

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST[$post["id_post"]]) && $_POST[$post["id_post"]] == "delete"){
        deletepost($post["id_post"]);
}
        ?>

        <div style="border: 2px solid black;">

            <h3>titre : <?php echo $post["titre"];?></h3>
            <h3>descirption :<?php echo $post["description"];?></h3>
            <h3>categorie :<?php echo $post["cat"];?></h3>
            <h3>vues <?php echo $post["vues"];?></h3>
            <h3>made by :<?php echo $post["username"];?></h3>

            <?php if(isset($_SESSION['id']) && ($post["id_user"] == $_SESSION['id'] || $_SESSION['role'] == 'admn')){ ?>
            <form method="post">
                <input type="submit" name="<?php echo $post["id_post"];?>" value="delete">
            </form>
            <form method="get" action="modpost.php">
                <input type="text" name="idpost" value="<?php //echo $post["id_post"];?>" hidden>
                <input type="submit" name="modifier" value="modifier">
            </form>
            <?php } ?>

        </div><br><br>
        <?php

        getreplies($_GET['id']); 

        if(isset($_SESSION['id'])){ ?>

            <form method="post">
                <input type="text" name="reply" placeholder="reply" required>
                <input type="submit" value="repondre">
            </form>

        <?php
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply'])){
        reply($_GET['id']);
        }
        }
        ?>