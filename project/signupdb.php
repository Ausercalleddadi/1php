<?php
include 'connexiondb.php';
function signup(){


    $conn = dbcon();
    $stmt = $conn->prepare("INSERT INTO users (nom,prenom,email,username,password,role) values (:nom,:prenom,:email,:user,:pass,'user');");
    $stmt->bindParam(':user',$_POST['username']); 
    $stmt->bindParam(':pass',$_POST['password']);
    $stmt->bindParam(':nom',$_POST['nom']); 
    $stmt->bindParam(':prenom',$_POST['prenom']); 
    $stmt->bindParam(':email',$_POST['email']); 
    $stmt->execute();

    $last_id = $conn->lastInsertId();

    session_start();
    $_SESSION = null;
    $_SESSION = ['id' => $last_id,'nom' => $_POST['nom'], 'prenom' => $_POST['prenom'],'username' => $_POST['username'],'email' => $_POST['email'],'role' =>'user','idpost'=>[]];
    header("location:index.php");

    }
