<?php include "dblogin.php";
$conn = connexion();
?>

<h2>Répertoire de contacts</h2>
<form method="post">
    <input type="text" name="search">
    <button type="submit" name="se" value="ch">chercher</button>
</form>
<form method="post">
    <button type="submit" name="tt" value="kk">afficher tout les contacts</button>
</form>
<form method="post">
    <button type="submit" name="aj" value="ac">ajouter contact</button>
</form>

<?php
if($_POST!=NULL){
    $tst = $_POST;
    
    if(in_array("kk",$tst)){
    ttafficher($conn);
    $tst = NULL;}
        
    else if(in_array("ch",$tst)){
    search($conn,$tst['search']);
    $tst = NULL;    
    }

    else if(in_array("ac",$tst)){
    add($conn);
    }

    else if(in_array("ad",$tst)){
    $name1 = $_POST['prenom'];
    $name2 = $_POST['nom'];
    $email = $_POST['email'];
    $phone = $_POST['telephone'];
    $query = $conn->prepare("INSERT INTO CONTACT (prenom, nom, email, telephone) VALUES (:prenom, :nom, :email, :telephone)");
    $query->bindParam(':prenom', $name1);
    $query->bindParam(':nom', $name2);
    $query->bindParam(':email', $email);
    $query->bindParam(':telephone', $phone);
    $query->execute();
    $tst = NULL;  
    }

    else if(array_key_exists("p",$_POST)){
    delete($conn,$_POST['p']);
    $_POST = NULL;
    }

    else if(array_key_exists("m",$_POST)){
    mod($conn,$_POST['m']);
    $_POST = NULL;
    }

    else if(in_array("maj",$_POST)){
    $name1 = $_POST['prenom'];
    $name2 = $_POST['nom'];
    $email = $_POST['email'];
    $phone = $_POST['telephone'];
    $id = $_POST['id'];
    $query = $conn->prepare("UPDATE CONTACT SET prenom=:prenom ,nom=:nom ,email=:email ,telephone=:telephone WHERE id=:id;");
    $query->bindParam(':prenom',$name1);
    $query->bindParam(':nom',$name2);
    $query->bindParam(':email',$email);
    $query->bindParam(':telephone',$phone);
    $query->bindParam(':id',$id); 
    $query->execute();
    
    }
} 