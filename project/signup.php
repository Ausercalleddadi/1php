<?php
include 'signupdb.php';

session_start();
 if(isset($_SESSION['id'])){
    header("location: index.php");
 }else{


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Basic cleaner
    function clean($data) {
        return trim(strip_tags($data));
    }

    $errors = [];

    // Cleaned inputs
    $prenom = clean($_POST['prenom']);
    $nom = clean($_POST['nom']);
    $username = clean($_POST['username']);
    $email = clean($_POST['email']);
    $password = $_POST['password']; // Don't trim passwords
    $password2 = $_POST['password2'];

    // Validate nom & prenom: letters only
    if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/u', $nom)) {
        $errors[] = "Nom must contain only letters.";
    }

    if (!preg_match('/^[a-zA-ZÀ-ÿ\s]+$/u', $prenom)) {
        $errors[] = "Prénom must contain only letters.";
    }

    // Validate username
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        $errors[] = "Username must be alphanumeric with no spaces.";
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate password: multiple checks
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must contain at least one number.";
    }

    // Confirm password match
    if ($password !== $password2) {
        $errors[] = "Passwords do not match.";
    }

    // Show results or continue
    if (empty($errors)) {
        $conn = dbcon();
        $stmt = $conn->prepare("SELECT true FROM users where username=:user;");
        $stmt->bindParam(':user',$_POST['username']); 
        $stmt->execute();
        $us=$stmt->fetch();

        $stmt = $conn->prepare("SELECT true FROM users where email=:email;"); 
        $stmt->bindParam(':email',$_POST['email']);
        $stmt->execute();
        $em=$stmt->fetch();

        if($us){
            echo 'username<br>';
        }
        if($em){
            echo 'email';
        }

        if(!$us && !$em){
        // Hash password and proceed
        $_POST['password'] = password_hash($password, PASSWORD_DEFAULT);
        $_POST['nom'] = $nom;
        $_POST['prenom'] = $prenom;
        $_POST['username'] = $username;
        $_POST['email'] = $email;
        signup(); // Define signup()
        }
    } else {
        foreach ($errors as $err) {
            echo "<p style='color:red;'>$err</p>";
        }
    }
}

?>

<form method="post">
    <label>your first name : </label>
    <input type="text" name="prenom" value="<?php if(isset($_POST['prenom'])) echo $_POST['prenom']; ?>" required><br>
    <label>your last name : </label>
    <input type="text" name="nom" value="<?php if(isset($_POST['nom'])) echo $_POST['nom']; ?>" required><br>
    <label>your username : </label>
    <input type="text" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" required><br>
    <label>your email : </label>
    <input type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required><br>
    <label>your password : </label>
    <input type="text" id="password" name="password" required><br>
    <label>confirm your password : </label>
    <input type="text" id="password2" name="password2" required><br>
    <input type="submit"  value="signup">
</form>
<?php 




} 
