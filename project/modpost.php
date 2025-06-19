<?php

include 'postdb.php';


$postid=$_GET['idpost'];

$conn=dbcon();
$stmt = $conn ->prepare("SELECT posts.*,users.username FROM posts INNER JOIN users on posts.id_user=users.id WHERE posts.id_post=:id;");
$stmt->bindParam(":id",$postid); 
$stmt->execute();
$post = $stmt->fetch();

    ?>
        <form method="post">
        <label>title :</label>
        <input type="text" name="titre" value="<?php echo $post["titre"] ?>" required><br>
        <label>description :</label>
        <input type="textarea" name="description" value="<?php echo $post["description"] ?>" required><br>
        <label>catégorie :</label>
        <select name="cat" required><?php
        $cats = getcats();
            foreach($cats as $cat){?>
            <option value="<?php echo $cat['categorie'] ?>" <?php if($post['cat'] == $cat['categorie']){echo 'selected';}?>><?php echo $cat['categorie'] ?></option>
        <?php } ?>
        </select><br>
        <input type="submit" name='modpost' value="mod post">
        </form>
<?php 

 
 if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modpost']) && $_POST['modpost'] == "mod post"){
    $conn=dbcon();
    $stmt=$conn->prepare("UPDATE posts SET titre=:titre,description=:description,cat=:cat WHERE id_post=:post");
    $stmt->bindParam(":post",$postid);
    $stmt->bindParam(":titre",$_POST['titre']);
    $stmt->bindParam(":cat",$_POST['cat']);
    $stmt->bindParam(":description",$_POST['description']);
    $stmt->execute();
    header("location: aboutpost.php?id=".$postid);
 }


