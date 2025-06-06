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
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Actions</th>
    </tr>
    <?php
    $query = $conn->prepare("SELECT * from contact");
    $query -> execute();
    printt($query ->fetchall());
}

function search($conn,$post)
{   if($post != ""){
    ?>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Actions</th>
    </tr>
    <?php
    $nm = "%".$post."%";
    $query = $conn->prepare("SELECT * from contact WHERE nom LIKE :nom or email like :email");
    $query->bindParam(':nom',$nm);
    $query->bindParam(':email',$nm);
    $query -> execute();
    printt( $query ->fetchall());}
    
}

function printt($res)
{
    foreach ($res as $c){ 
       ?>
    <tr>
        <td><?= $c['id'] ?></td>
        <td><?= $c['prenom'] ?></td>
        <td><?= $c['nom'] ?></td>
        <td><?= $c['email'] ?></td>
        <td><?= $c['telephone'] ?></td>
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
    $query = $conn->prepare("DELETE FROM contact WHERE id=:id;");
    $query->bindParam(':id',$id);
    $query->execute();
}

function mod($conn,$id){
        $query = $conn->prepare("SELECT * FROM contact WHERE id=:id;");
        $query->bindParam(':id',$id);
        $query->execute();
        $res = $query->fetch();
?>

<form method="post">
    <input name="id"   hidden       value=<?php echo $res['id']?>>
    <input name="prenom"               value=<?php echo $res['prenom']?>>
    <input name="nom"                  value=<?php echo $res['nom']?>>
    <input name="email" type="text"   value=<?php echo $res['email']?>>
    <input name="telephone"            value=<?php echo $res['telephone']?>>
    <button type="submit" name="j" value="maj">mise a jour</button>
</form>

<?php
    
}

function add($conn){  
?> 
<form method="post">
    <input name="prenom" placeholder="Prénom" required>
    <input name="nom" placeholder="Nom" required>
    <input name="email" type="text" placeholder="Email" required>
    <input name="telephone" placeholder="Téléphone" required>
    <button type="submit" name="addd" value="ad">Ajouter</button>
</form>
<?php
}