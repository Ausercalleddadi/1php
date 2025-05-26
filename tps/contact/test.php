<h2>Répertoire de contacts</h2>
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
    $username = 'souhail';
    $db = 'localhost';
    $password = 'souhail123';

    $conn = new PDO("mysql:host=$db;dbname=tps",$username,$password);

    $query = $conn->prepare("select * from contact");
    $query -> execute();
    $res = $query ->fetchall();
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
            <button type="submit" name="p" value=<?php echo $c['id']; ?>>supprimer</button>
            </form>
        </td>
    </tr>
    <?php  }
    ?>
</table>

<?php

        if($_GET['p']!=NULL){
        $query = $conn->prepare("DELETE FROM contact WHERE id=:id;");
        $query->bindParam(':id',$_GET['p']);
        $query->execute();
        $_GET = NULL;
        header("location:affiche.php");
        }


        if($_GET['m']!=NULL){
            $id = $_GET['m'];
            $query = $conn->prepare("SELECT * FROM contact WHERE id=:id;");
            $query->bindParam(':id',$id);
            $query->execute();
            $res = $query->fetch();
            $name1 = $res['prenom'];
            $name2 = $res['nom'];
            $email = $res['email'];
            $phone = $res['telephone'];
        ?>

<form method="post">
    <input name="prenom"               value=<?php echo $res['prenom']?>>
    <input name="nom"                  value=<?php echo $res['nom']?>>
    <input name="email" type="email"   value=<?php echo $res['email']?>>
    <input name="telephone"            value=<?php echo $res['telephone']?>>
    <button type="submit" name="j" value="l">mise a jour</button>
</form>

<?php

if($_POST['j']!='l'){
    $query = $conn->prepare("UPDATE CONTACT set prenom=:prenom,nom=:nom,email=:email,telephone=:telephone where id=:id  ;");
    $query->bindParam(':prenom',$name1);
    $query->bindParam(':nom',$name2);
    $query->bindParam(':email',$email);
    $query->bindParam(':telephone',$phone);
    $query->bindParam(':id',$id);
    $name1 = $_POST['prenom'];
    $name2 = $_POST['nom'];
    $email = $_POST['email'];
    $phone = $_POST['telephone'];
    var_dump($_POST);
    echo $name1;
    echo $name2;
    echo $email;
    echo $phone;
    $query->execute();
    header("location:affiche.php");

     }}
 ?>
 