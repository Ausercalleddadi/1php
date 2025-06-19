<?php
include 'postdb.php';

    var_dump($_SESSION);
    echo "<br>home page<br>";

    if(!isset($_SESSION['id'])){
            ?><br>
            <a href="login.php">login</a><br>
            <a href="signup.php">signup</a><br>
            <?php 
    }else{

        if(isset($_SESSION['id']) && $_SESSION['role'] == 'admn'){
            ?>
            <a href="adminpannel.php?fct=2">admin dashboard</a><br>
            <?php
        }
            ?>
            <a href="addpost.php">add post</a><br>
            <a href="index.php?act=disconnect">disconnect</a><br>
            <?php
    }

            ?><br>
            <h2>filters</h2>
            <form method="get" action="index.php">
                <input type="radio" name="post" value="all">
                <label >all posts</label><br>
                <input type="radio" name="post" value="mine">
                <label >my posts</label><br>
                <input type="radio" name="by" value="id_post">
                <label >time</label><br>
                <input type="radio" name="by" value="vues">
                <label >vues</label><br>
                <input type="radio" name="by" value="username">
                <label >user</label><br>
                <input type="radio" name="by" value="cat">
                <label >categorie</label><br>
                <input type="radio" name="order" value="desc">
                <label >top to low</label><br>
                <input type="radio" name="order" value="asc">
                <label >low to top</label><br>
                <input type="submit" value="filter">
            </form>
            <?php 


    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['post'])){
        if($_GET['post'] == 'mine'){
        $posts = myposts($_GET);
    }
        if($_GET['post'] == 'all'){
        $posts = showall($_GET);
    }
        printpost($posts);
    }else{
        $_GET['post'] = 'all'; 
        $posts = showall($_GET);
        printpost($posts);

    }


    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['act']) && $_GET['act'] == 'disconnect' ){
        session_unset();
        session_destroy();
        header("location: index.php");}
    ?>