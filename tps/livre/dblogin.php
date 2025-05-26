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
        <th>annees pub</th>
        <th>Téléphone</th>
        <th>genre</th>
    </tr>
    <?php
    $query = $conn->prepare("SELECT * from livre");
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
    $query = $conn->prepare("SELECT * from livre WHERE nom LIKE :nom or email like :email");
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
            <form method="get">
            <button type="submit" name="m" value=<?php echo $c['id']; ?>>modifier</button>
            </form>
            <form method="get">
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
    <input name="prenom"               value=<?php echo $res['prenom']?>>
    <input name="nom"                  value=<?php echo $res['nom']?>>
    <input name="email" type="text"   value=<?php echo $res['email']?>>
    <input name="telephone"            value=<?php echo $res['telephone']?>>
    <button type="submit" name="j" value="maj">mise a jour</button>
</form>

<?php
    if(in_array("maj",$_POST)){
    $name1 = $_POST['prenom'];
    $name2 = $_POST['nom'];
    $email = $_POST['email'];
    $phone = $_POST['telephone'];
    $query = $conn->prepare("UPDATE livre SET titre=:prenom ,auteur=:nom ,datepub=:email ,genre=:telephone WHERE id=:id;");
    $query->bindParam(':prenom',$name1);
    $query->bindParam(':nom',$name2);
    $query->bindParam(':email',$email);
    $query->bindParam(':telephone',$phone);
    $query->bindParam(':id',$id); 
    $query->execute();
    header("location:affiche.php");
    }
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
$name1 = $_POST['prenom'];
$name2 = $_POST['nom'];
$email = $_POST['email'];
$phone = $_POST['telephone'];
$query = $conn->prepare("INSERT INTO CONTACT (titre,auteur,datepub,genre)  values (:prenom,:nom,:email,:telephone);");
$query->bindParam(':prenom',$name1);
$query->bindParam(':nom',$name2);
$query->bindParam(':email',$email);
$query->bindParam(':telephone',$phone);
echo $query->execute();
    
    

}
?>