<?php 
function dbcon(){
    $username = 'souhail';
    $host = 'localhost';
    $password = 'souhail123';
    
    return new PDO ("mysql:host=$host;dbname=forum",$username,$password);

}

