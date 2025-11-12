<?php 
function dbcon(){

        $host = "localhost";
        $dbname = "banque";
        $username = "souhail";
        $password = "souhail123";

        try {
            echo "Connected successfully";
            return new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
        }catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
}



