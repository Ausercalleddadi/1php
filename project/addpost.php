<?php
include 'postdb.php';


if(!isset($_SESSION['id'])){
    header("location: login.php");
}else{

?>

    <form method="post">

        <label>title :</label>
        <input type="text" name="titre" required><br>

        <label>description :</label>
        <input type="textarea" name="description" required><br>

        <label>catégorie :</label>
        <select name="cat" required> 
            <?php
            $cats = getcats();
            foreach($cats as $cat){?>
                <option value="<?php echo $cat['categorie'] ?>"><?php echo $cat['categorie']; ?></option>
            <?php } ?>
        </select><br>

        <input type="submit" value="add post">
    </form>
    
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['titre'])){
        posts();
    }}
    ?>

