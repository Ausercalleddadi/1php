<?php include "dblogin.php";
$conn = connexion();
?>

<h2>gestion de reservation</h2>

<form method="post">
    <button type="submit" name="tt" value="kk">afficher tout les reservations</button>
</form>

<form method="post">
    <button type="submit" name="aj" value="ac">ajouter une reservation</button>
</form>




<?php
if($_POST!=NULL){
    $tst = $_POST;
    
    if(in_array("kk",$tst)){
    ttafficher($conn);
    $tst = NULL;}

    else if(in_array("ac",$tst)){
    add();
    
    }

    else if(in_array("ad",$_POST)){
    testinput($conn,$_POST['debut'],$_POST['fin'],$_POST['date']);
    $name1 = $_POST['nom'];
    $name2 = $_POST['date'];
    $email = $_POST['debut'];
    $phone = $_POST['fin'];
    $desc = $_POST['description'];
    $query = $conn->prepare("INSERT INTO reservation (nom, date, debut, fin,description) VALUES (:nom, :date, :debut, :fin,:description);");
    $query->bindParam(':nom', $name1);
    $query->bindParam(':date', $name2);
    $query->bindParam(':debut', $email);
    $query->bindParam(':fin', $phone);
    $query->bindParam(':description', $desc);
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
    $name1 = $_POST['nom'];
    $name2 = $_POST['date'];
    $email = $_POST['debut'];
    $phone = $_POST['fin'];
    $desc = $_POST['description'];
    $id = $_POST['id'];
    $query = $conn->prepare("UPDATE reservation SET nom=:nom ,date=:datee ,debut=:debut ,fin=:fin , description=:de  WHERE id=:id;");
    $query->bindParam(':nom', $name1);
    $query->bindParam(':datee', $name2);
    $query->bindParam(':debut', $email);
    $query->bindParam(':fin', $phone);
    $query->bindParam(':de', $desc);
    $query->bindParam(':id',$id); 
    $query->execute();
    
    }

    
} 