<?php
include 'connexiondb.php';

function login(){

$conn = dbcon();
$stmt = $conn->prepare("SELECT * FROM users where  (username=:user or email=:user)");
$stmt->bindParam(':user',$_POST['username']); 
$stmt->execute();
$log = $stmt->fetch();
if($log){
    if(password_verify($_POST['password'], $log['password'])){
        if($log['access'] == 'denied'){

            echo 'access blocked by admin';

        }else{

            session_start();
            $_SESSION = ['id' => $log['id'],'nom' => $log['nom'], 'prenom' => $log['prenom'],'username' => $log['username'],'email' => $log['email'],'role' =>$log['role'],'idpost'=>[]];
            header("location: index.php");}
    }else echo "<p style='color:red;'>Incorrect password.</p>";
}else echo"<p style='color:red;'>No user found with that username or email.</p>";

}
