<?php
include 'connexiondb.php';

session_start();

function posts(){
    $conn = dbcon();
    $stmt = $conn->prepare("INSERT INTO posts (titre,description,cat,id_user,vues) VALUES (:titre,:description,:cat,:id_user,'0');");
    $stmt->bindParam(":titre",$_POST['titre']);
    $stmt->bindParam(":description",$_POST['description']);
    $stmt->bindParam(":cat",$_POST['cat']);
    $stmt->bindParam(":id_user",$_SESSION['id']);
    $stmt->execute();


}


function showall($get){
    $conn = dbcon();
    if(!isset($get['by'])){$get['by'] = 'id';}
    if(!isset($get['order'])){$get['order'] = 'desc';}
    $sql ="SELECT posts.*,users.username FROM posts INNER JOIN users on posts.id_user=users.id ORDER BY ". $get['by'] . " " . $get['order'].";";
    $stmt = $conn ->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();

}


function myposts($get){
    $conn = dbcon();
    if(!isset($get['by'])){$get['by'] = 'id';}
    if(!isset($get['order'])){$get['order'] = 'desc';}
    $sql ="SELECT posts.*,users.username FROM posts INNER JOIN users on posts.id_user=users.id where users.id=:id ORDER BY ". $get['by'] . " " . $get['order'].";";
    $stmt = $conn ->prepare($sql);
    $stmt->bindParam("id",$_SESSION['id']);
    $stmt->execute();
    return $stmt->fetchAll();

   
}


function reply($id){

    $conn = dbcon();
    $stmt=$conn->prepare("INSERT INTO reponse (id_user,id_post,text) VALUES (:user,:post,:text); ");
    $stmt->bindParam(":user",$_SESSION['id']);
    $stmt->bindParam(":post",$id);
    $stmt->bindParam(":text",$_POST['reply']);
    $stmt->execute();
    header("location: aboutpost.php?id=".$id);

}

function getreplies($id){
$conn = dbcon();
$stmt=$conn->prepare("SELECT users.username,reponse.id_resp,reponse.text,reponse.id_user from reponse JOIN users on reponse.id_user=users.id WHERE reponse.id_post=:post; ");
$stmt->bindParam(":post",$id);
$stmt->execute();
$replies = $stmt->fetchAll();
 foreach($replies as $reply){

        ?>
        <div style="border: 2px solid black;">
            <h3><?php echo $reply["username"];?> : <?php echo $reply["text"];?></h3>
            <?php if(isset($_SESSION['id']) && ($reply["id_user"] == $_SESSION['id'] || $_SESSION['role'] == 'admn')){
                deleterep($reply["id_resp"],$id);
                modrep($reply["id_resp"],$id);
            }         
            ?>
        </div><br>

<?php
    }
}


function deletepost($idpost){
        $conn=dbcon();
        $stmt=$conn->prepare("DELETE FROM posts WHERE id_post=:post");
        $stmt->bindParam(":post",$idpost);
        $stmt->execute();
        $stmt=$conn->prepare("DELETE FROM reponse WHERE id_post=:post");
        $stmt->bindParam(":post",$idpost);
        $stmt->execute();
        header("location: index.php");
}


function deleterep($idrep,$idpost){

    ?>
        <form method="post">
            <input type="submit" name="<?php echo $idrep;?>" value="delete">
        </form>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST[$idrep]) && $_POST[$idrep] == "delete"){
        $conn=dbcon();
        $stmt=$conn->prepare("DELETE FROM reponse WHERE id_resp=:resp");
        $stmt->bindParam(":resp",$idrep);
        $stmt->execute();
        header("location: aboutpost.php?id=".$idpost);
}

}


function modrep($idrep,$idpost){
?>
        <form method="post">
            <input type="submit" name="<?php echo $idrep;?>" value="mod">
        </form>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST[$idrep]) && $_POST[$idrep] == "mod"){
    ?>
        <form method="post">
            <input type="text" name="modifier" placeholder="modifier" required>
            <input type="submit" name="<?php echo $idrep;?>" value="confirmer">
        </form>
<?php }

 
 if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST[$idrep]) && $_POST[$idrep] == "confirmer"){
    echo 'zsgf0';
    $conn=dbcon();
    $stmt=$conn->prepare("UPDATE reponse SET text=:text WHERE id_resp=:resp");
    $stmt->bindParam(":resp",$idrep);
    $stmt->bindParam(":text",$_POST['modifier']);
    $stmt->execute();
    header("location: aboutpost.php?id=".$idpost);
 }


}


function modpost($idpost){
?>
        <form method="get" action="modpost.php">
            <input type="text" name="idpost" value="<?php echo $idpost;?>" hidden>
            <input type="submit" name="modifier" value="modifier">
        </form>
<?php
}


function getcats(){
$conn = dbcon();
$stmt=$conn->prepare("SELECT * from cat ");
$stmt->execute();
return $stmt->fetchAll();

}


function vues($id){
$conn = dbcon();
if(isset($_SESSION['idpost']) && !in_array($id,$_SESSION['idpost'])){
$stmt = $conn ->prepare("UPDATE posts set vues = vues + 1 WHERE id_post=:id;");
$stmt->bindParam(":id",$id);
$stmt->execute();
array_push($_SESSION['idpost'],$id); 
}

}


function getpostsbyid($id) {
$conn = dbcon();
$stmt = $conn ->prepare("SELECT posts.*,users.username FROM posts INNER JOIN users on posts.id_user=users.id WHERE posts.id_post=:id;");
$stmt->bindParam(":id",$_GET['id']); 
$stmt->execute();
return $stmt->fetch();
}


function printpost($posts){
    foreach($posts as $post){

        ?>
        <div style="border: 2px solid black;">
            <h3><?php echo $post["titre"];?></h3>
            <p><?php echo $post["description"];?></p>
            <h3><?php echo $post["cat"];?></h3>
            <h3><?php echo $post["vues"];?></h3>
            <h3><?php echo $post["username"];?></h3>
            <a href="aboutpost.php?id=<?php echo $post["id_post"];?>">more...</a>

        </div><br><br>

<?php }
}


function getcat(){

    $conn = dbcon();
    $stmt = $conn->prepare("SELECT * FROM cat;");
    $stmt->execute();
    return $stmt->fetchAll();

}


function getusers(){

    $conn = dbcon();
    $stmt = $conn->prepare("SELECT id,nom,prenom,username,email,signup_time,role,access FROM users;");
    $stmt->execute();
    return $stmt->fetchAll();

}


function getposts(){

    $conn = dbcon();
    $stmt = $conn ->prepare("SELECT posts.*,users.username FROM posts INNER JOIN users on posts.id_user=users.id");
    $stmt->execute();
    return $stmt->fetchAll();

}


function adminusers(){
    
    $users = getusers();
    ?>
    <table border="1">
        <tr>
            <th>signp time</th>
            <th>id user</th>
            <th>username</th>
            <th>nom</th>
            <th>prenom</th>
            <th>email</th>
            <th>access</th>
            <th>role</th>
            <th>block</th>
            <th>delete</th>
        </tr>
        <?php
            foreach ($users as $user){
                ?>
                <tr>
                    <td><?php echo $user['signup_time'] ?></td>
                    <td><?php echo $user['id'] ?></td>
                    <td><?php echo $user['username'] ?></td>
                    <td><?php echo $user['nom'] ?></td>
                    <td><?php echo $user['prenom'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['access'] ?></td>
                    <td><?php echo $user['role'] ?></td>
                    <?php
                    if($_SESSION['username'] == $user['username']){
                    ?><td><?php 
                        if($user['access'] == 'granted'){?>
                        <a href="adminpannel.php?fct=2&abt=user&act=denied&id=<?php echo $user['id']?>">block</a></td>
                        <?php }elseif($user['access'] == 'denied'){?>
                        <a href="adminpannel.php?fct=2&abt=user&act=granted&id=<?php echo $user['id']?>">unblock</a></td>
                        <?php }?>
                    <td><a href="adminpannel.php?fct=2&abt=user&act=delete&id=<?php echo $user['id']?>">delete</a></td><?php } ?>
                </tr>
                <?php
            }
        ?>
    </table>


<?php   
            
}


function deleteuser($id){

$conn = dbcon();
$stmt = $conn->prepare("DELETE FROM users WHERE id=:post");
$stmt->bindParam(":post",$id);
$stmt->execute();

}


function blockuser($id,$act){
    $conn = dbcon();
    $stmt=$conn->prepare("UPDATE users set access=:act WHERE id=:id;");
    $stmt->bindParam(":act",$act);
    $stmt->bindParam(":id",$id);
    $stmt->execute();
}


function adminposts(){
    
    $posts = getposts();
    ?>
    <table border="1">
        <tr>
            <th>creation time</th>
            <th>id post</th>
            <th>id user</th>
            <th>username</th>
            <th>categorie</th>
            <th>title</th>
            <th>descirption</th>
            <th>vues</th>
            <th>modify</th>
            <th>delete</th>
            <th>see more</th>
        </tr>
        <?php
            foreach ($posts as $post){
                ?>
                <tr>
                    <td><?php echo $post['date_creation'] ?></td>
                    <td><?php echo $post['id_post'] ?></td>
                    <td><?php echo $post['id_user'] ?></td>
                    <td><?php echo $post['username'] ?></td>
                    <td><?php echo $post['cat'] ?></td>
                    <td><?php echo $post['titre'] ?></td>
                    <td><?php echo $post['description'] ?></td>
                    <td><?php echo $post['vues'] ?></td>
                    <td><a href="modpost.php?idpost=<?php echo $post['id_post'] ?>&modifier=modifier">modify</a></td>
                    <td><a href="adminpannel.php?fct=1&abt=post&act=delete&id=<?php echo $post['id_post']?>">delete</a></td>
                    <td><a href="aboutpost.php?id=<?php echo $post['id_post'] ?>">see reply</a></td>
                </tr>
                <?php
            }
        ?>
    </table>


<?php
}


function admincat(){
    
    $cats = getcat();
    ?>
    <table border="1">
        <tr>
            <th>categorie</th>
            <th>modify</th>
            <th>delete</th>
        </tr>
        <?php
            foreach ($cats as $cat){
                ?>
                <tr>
                    <td><?php echo $cat['categorie'] ?></td>
                    <td><a href="adminpannel.php?fct=3&abt=cat&act=delete&id=<?php echo $cat['id_cat']?>">delete</a></td>
                    <td><a href="adminpannel.php?fct=3&abt=cat&act=modify&id=<?php echo $cat['id_cat']?>">modify</a></td>
                </tr>
                <?php
            }
        ?>
    </table>
    <?php 
            if(isset($_GET['abt']) && $_GET['abt'] == 'cat' && $_GET['act'] == 'delete'){
                deletecat($_GET['id']);
            }elseif(isset($_GET['abt']) && $_GET['abt'] == 'cat' && $_GET['act'] == 'modify'){
                modifycat($_GET['id']);
            }elseif((isset($_GET['abt']) && $_GET['abt'] == 'cat' && $_GET['act'] == 'new') || $_GET['fct'] == '3' ){
                addcat();
}
}


function addcat(){

    ?>
<form method="post">
    <input type="text" name="newcat" placeholder="new categorie" required>
    <input type="submit" value="repondre">
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newcat'])){
    $conn = dbcon();
    $stmt=$conn->prepare("INSERT INTO cat (categorie) VALUES (:cat); ");
    $stmt->bindParam(":cat",$_POST['newcat']);
    $stmt->execute();
    header("location: adminpannel.php?fct=3");
}
}


function deletecat($id){

$conn = dbcon();
$stmt = $conn->prepare("DELETE FROM cat WHERE id_cat=:post");
$stmt->bindParam(":post",$id);
$stmt->execute();
header("location: adminpannel.php?fct=3");
}


function modifycat($id){

    ?>
<form method="post">
    <input type="text" name="modcat" placeholder="mod categorie" required>
    <input type="submit" value="repondre">
</form>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modcat'])){
    $conn = dbcon();
    $stmt=$conn->prepare("UPDATE cat set categorie=:cat WHERE id_cat=:id; ");
    $stmt->bindParam(":cat",$_POST['modcat']);
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    header("location: adminpannel.php?fct=3&abt=cat&act=new");

}
}