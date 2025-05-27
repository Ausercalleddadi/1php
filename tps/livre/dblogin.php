<?php
function connexion(){
$username = 'souhail';
$db = 'localhost';
$password = 'souhail123';
return new PDO("mysql:host=$db;dbname=tps",$username,$password);
}

function ttafficher($conn){
    ?>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>titre</th>
        <th>auteur</th>
        <th>date de pub</th>
        <th>genre</th>
        <th>Actions</th>
    </tr>
    <?php
    $query = $conn->prepare("SELECT * from livre");
    $query -> execute();
    printt($query ->fetchall());
}

function ttafficherdate($conn){
    ?>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>titre</th>
        <th>auteur</th>
        <th>date de pub</th>
        <th>genre</th>
        <th>Actions</th>
    </tr>
    <?php
    $query = $conn->prepare("SELECT * from livre ORDER BY datepub");
    $query -> execute();
    printt($query ->fetchall());
}

function ttafficherauteur($conn){
    ?>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>titre</th>
        <th>auteur</th>
        <th>date de pub</th>
        <th>genre</th>
        <th>Actions</th>
    </tr>
    <?php
    $query = $conn->prepare("SELECT * from livre ORDER BY auteur");
    $query -> execute();
    printt($query ->fetchall());
}

function search($conn,$post)
{   if($post != ""){
    ?>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>titre</th>
        <th>auteur</th>
        <th>date de pub</th>
        <th>genre</th>
        <th>Actions</th>
    </tr>
    <?php
    $nm = "%".$post."%";
    $query = $conn->prepare("SELECT * from livre WHERE titre LIKE :titre ");
    $query->bindParam(':titre',$nm);
    $query -> execute();
    printt( $query ->fetchall());}
    
}

function printt($res)
{
    foreach ($res as $c){ 
       ?>
    <tr>
        <td><?= $c['id'] ?></td>
        <td><?= $c['titre'] ?></td>
        <td><?= $c['auteur'] ?></td>
        <td><?= $c['datepub'] ?></td>
        <td><?= $c['genre'] ?></td>
        <td>
            <form method="post">
            <button type="submit" name="m" value=<?php echo $c['id']; ?>>modifier</button>
            </form>
            <form method="post">
            <button type="submit" name="p" value=<?php echo $c['id']; ?>>supprimer</button>
            </form>
        </td>
    </tr>
    <?php  
    }
    ?>
</table>
<?php
}

function delete($conn,$id){
    $query = $conn->prepare("DELETE FROM livre WHERE id=:id;");
    $query->bindParam(':id',$id);
    $query->execute();
}

function mod($conn,$id){
        $query = $conn->prepare("SELECT * FROM livre WHERE id=:id;");
        $query->bindParam(':id',$id);
        $query->execute();
        $res = $query->fetch();
?>

<form method="post">
    <input name="id"   hidden       value=<?php echo $res['id']?>>
    <input name="titre"               value=<?php echo $res['titre']?>>
    <input name="auteur"                  value=<?php echo $res['auteur']?>>
    <input name="datepub" type="number"   value=<?php echo $res['datepub']?>>
    <input name="genre"            value=<?php echo $res['genre']?>>
    <button type="submit" name="j" value="maj">mise a jour</button>
</form>

<?php
    
}

function add(){  
?> 
<form method="post">
    <input name="titre" placeholder="titre" required>
    <input name="auteur" placeholder="auteur" required>
    <input name="datepub" type="number" placeholder="datepub" required>
    <input name="genre" placeholder="genre" required>
    <button type="submit" name="addd" value="ad">Ajouter</button>
</form>
<?php

}

function drop($conn){
?>  
    <form method="post">
    <label for="genres">Genre de livre:</label>
    <select name="genres">
<?php
    $query = $conn -> prepare("SELECT DISTINCT genre FROM livre ORDER BY genre;");
    $query->execute();
    $res = $query->fetchAll();
    foreach ($res as $re){
?>
    <option value=<?php echo $re[0] ?>><?php echo $re[0] ?></option>
<?php
    }
?>
    </select>
    <button type="submit" name="drop" value="drop">chercher</button>
    </form>
<?php

}

function genre($conn,$genres){
    ?>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>titre</th>
        <th>auteur</th>
        <th>date de pub</th>
        <th>genre</th>
        <th>Actions</th>
    </tr>
    <?php
    $query = $conn -> prepare("SELECT * FROM livre where genre=:genre ORDER BY titre;");
    $query->bindParam(":genre",$genres);
    $query->execute();
    printt($query->fetchAll());
}