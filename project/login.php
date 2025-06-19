<?php

include 'logindb.php';

session_start();
 if(isset($_SESSION['id'])){
    header("location: index.php");
 }else{
?>

<form method="post">
<label>username or email: </label>
<input type="text" name="username" placeholder="username" required><br>
<label>password : </label>
<input type="text" name="password"  placeholder="password" required><br>
<input type="submit" value="login">
</form>
<?php 



if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])){
  login();
}

}
