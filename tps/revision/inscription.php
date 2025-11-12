<form method="post">
    <input type="text" name="nom">
    <input type="text" name="prenom">
    <input type="date" name="nai">
    <input type="submit" value="create">    
</form>

<?php
 
 if($_SERVER['REQUEST_METHOD'] == "POST"){
    include 'client.php';

    $test = addClient($_POST['nom'],$_POST['prenom'],$_POST['nai']);

    if($test == true){
        session_start();
        $_SESSION=['nom'=>$_POST['nom'],'prenom'=>$_POST['prenom'] ];
        var_dump($_SESSION);
    }else{
        var_dump($test);

    }

 }