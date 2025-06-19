<?php 
include 'postdb.php';


 if(!isset($_SESSION['id']) || $_SESSION['role'] != 'admn'){
    header("location: login.php");
 }else{
    echo 'admin';
    if(isset($_GET['abt']) && $_GET['abt'] == 'user' && $_GET['act'] == 'denied'){
                        blockuser($_GET['id'],$_GET['act']);
                       header("location: adminpannel.php?fct=2");
                    }elseif(isset($_GET['abt']) && $_GET['abt'] == 'user' && $_GET['act'] == 'granted'){
                        blockuser($_GET['id'],$_GET['act']);
                        header("location: adminpannel.php?fct=2");
                    }elseif(isset($_GET['abt']) && $_GET['abt'] == 'user' && $_GET['act'] == 'delete'){
                        deleteuser($_GET['id']);
                        header("location: adminpannel.php?fct=2");
                    }elseif(isset($_GET['abt']) && $_GET['abt'] == 'post' && $_GET['act'] == 'delete'){
                        deletepost($_GET['id']);
                        header("location: adminpannel.php?fct=1");
                    }

    ?>
    <a href="adminpannel.php?fct=1">posts</a>
    <a href="adminpannel.php?fct=2">users</a>
    <a href="adminpannel.php?fct=3">categorie</a>
    <a href="index.php">home</a>
    <?php
    if(isset($_GET['fct'])){
    switch ($_GET['fct']){
        case 1:
                adminposts();break;
        case 2:
                adminusers();break;
        case 3:
                admincat();break;
        
    }
        
 }
}

