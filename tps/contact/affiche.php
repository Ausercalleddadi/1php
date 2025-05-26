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
    $tst = NULL;    
    }}

if($_GET!=NULL){
     if(array_key_exists("p",$_GET)){
    delete($conn,$_GET['p']);
    $_GET = NULL;
    }

    else if(array_key_exists("m",$_GET)){
    mod($conn,$_GET['m']);
    $_GET = NULL;
    }}
 ?>
 