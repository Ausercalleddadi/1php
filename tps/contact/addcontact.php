<?php
    $username = 'souhail';
    $db = 'localhost';
    $password = 'souhail123';

    $conn = new PDO("mysql:host=$db;dbname=tps",$username,$password);
    
    $query = $conn->prepare("INSERT INTO CONTACT (prenom,nom,email,telephone)  values (:prenom,:nom,:email,:telephone);");
    $query->bindParam(':prenom',$name1);
    $query->bindParam(':nom',$name2);
    $query->bindParam(':email',$email);
    $query->bindParam(':telephone',$phone);
?>

<h2>Ajouter un contact</h2>

<form method="get">
    <input name="prenom" placeholder="Prénom" required>
    <input name="nom" placeholder="Nom" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="telephone" placeholder="Téléphone" required>
    <button type="submit">Ajouter</button>
</form>

<?php
if($_GET!=NULL){
    $name1 = $_GET['prenom'];
    $name2 = $_GET['nom'];
    $email = $_GET['email'];
    $phone = $_GET['telephone'];
    $query->execute();
    header("location:addcontact.php");}
?>

