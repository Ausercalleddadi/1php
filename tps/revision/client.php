<?php 

function addClient($nom,$prenom,$nai){
    include 'dbconn.php'; 
    $conn = dbcon();
    $stmt = $conn -> prepare("INSERT INTO client (nom,prenom,date_naissance) VALUE (:n,:p,:d);");
    $stmt->bindParam(":n",$nom);
    $stmt->bindParam(":p",$prenom);
    $stmt->bindParam(":d",$nai); 
    try{
        $stmt->execute();
        return true;
    }catch(PDOException $error){
        return false;
    }
}


function updateClient($nom,$prenom,$nai,$id){
    include 'dbconn.php'; 
    $conn = dbcon();
    $stmt = $conn -> prepare("UPDATE client SET nom=:n,prenom=:p,date_naissance=:d WHERE id=:id;");
    $stmt->bindParam(":n",$nom);
    $stmt->bindParam(":p",$prenom);
    $stmt->bindParam(":d",$nai);
    $stmt->bindParam(":id",$id); 
    try{
        $stmt->execute();
        return true;
    }catch(PDOException $e){
        return false;
    }
}


function deleteClient($id){
    include 'dbconn.php'; 
    $conn = dbcon();
    $stmt = $conn -> prepare("DELETE FROM client WHERE id=:id;");
    $stmt->bindParam(":id",$id); 
    try{
        $stmt->execute();
        return true;
    }catch(PDOException $e){
        return false;
    }
}

function getClient($id){
    include 'dbconn.php'; 
    $conn = dbcon();
    $stmt = $conn -> prepare("SELECT * FROM client"); 
    try{
        $stmt->execute();
        return $stmt->fetchall();
    }catch(PDOException $e){
        return false;
    }
}