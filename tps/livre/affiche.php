<?php include "dblogin.php";
$conn = connexion();
?>

<h2>gestion de livre</h2>

<form method="post">
    <input type="text" name="search">
    <button type="submit" name="se" value="ch">chercher</button>
</form>

<form method="post">
    <button type="submit" name="tt" value="kk">afficher tout les livres</button>
</form>

<form method="post">
    <button type="submit" name="tt1" value="kk1">afficher tout les livres par date</button>
</form>

<form method="post">
    <button type="submit" name="tt2" value="kk2">afficher tout les livres par auteur</button>
</form>

<form method="post">
    <button type="submit" name="aj" value="ac">ajouter un livre</button>
</form>

<?php
    drop($conn);
?>




<?php
if($_POST!=NULL){
    $tst = $_POST;
    

    if(in_array("kk",$tst)){
    ttafficher($conn);
    $tst = NULL;}

    else if(in_array("kk1",$tst)){
    ttafficherdate($conn);
    $tst = NULL;}

    else if(in_array("kk2",$tst)){
    ttafficherauteur($conn);
    $tst = NULL;}
        
    else if(in_array("ch",$tst)){
    search($conn,$tst['search']);
    $tst = NULL;    
    }

    else if(in_array("ac",$tst)){
    add();
    }

    else if(in_array("ad",$_POST)){
    $name1 = $_POST['titre'];
    $name2 = $_POST['auteur'];
    $email = $_POST['datepub'];
    $phone = $_POST['genre'];
    $query = $conn->prepare("INSERT INTO livre (titre, auteur, datepub, genre) VALUES (:titre, :auteur, :datepub, :genre);");
    $query->bindParam(':titre', $name1);
    $query->bindParam(':auteur', $name2);
    $query->bindParam(':datepub', $email);
    $query->bindParam(':genre', $phone);
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
    $name1 = $_POST['titre'];
    $name2 = $_POST['auteur'];
    $email = $_POST['datepub'];
    $phone = $_POST['genre'];
    $id = $_POST['id'];
    $query = $conn->prepare("UPDATE livre SET titre=:titre ,auteur=:auteur ,datepub=:datepub ,genre=:genre WHERE id=:id;");
    $query->bindParam(':titre',$name1);
    $query->bindParam(':auteur',$name2);
    $query->bindParam(':datepub',$email);
    $query->bindParam(':genre',$phone);
    $query->bindParam(':id',$id); 
    $query->execute();
    
    }

    else if(in_array("drop",$_POST)){
        genre($conn,$_POST['genres']);
    }
} 