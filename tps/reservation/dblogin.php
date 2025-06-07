<?php
function connexion(){
$username = 'souhail';
$db = 'localhost';
$password = 'souhail123';
return new PDO("mysql:host=$db;dbname=tps",$username,$password);
}

function ttafficher($conn){
    ?>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>user</th>
        <th>date res</th>
        <th>heure debut</th>
        <th>heure fin</th>
        <th>description</th>
        <th>Actions</th>
    </tr>
    <?php
    $query = $conn->prepare("SELECT * from reservation");
    $query -> execute();
    printt($query ->fetchall());
}

function printt($res)
{
    foreach ($res as $c){ 
       ?>
    <tr>
        <td><?= $c['id'] ?></td>
        <td><?= $c['nom'] ?></td>
        <td><?= $c['date'] ?></td>
        <td><?= $c['debut'] ?></td>
        <td><?= $c['fin'] ?></td>
        <td><?= $c['description'] ?></td>
        <td>
            <form method="post">
            <button type="submit" name="m" value=<?php echo $c['id']; ?>>modifier</button>
            </form>
            <form method="post">
            <button type="submit" name="p" value=<?php echo $c['id']; ?>>supprimer</button>
            </form>
        </td>
    </tr>
    <?php  
    }
    ?>
</table>
<?php
}

function delete($conn,$id){
    $query = $conn->prepare("DELETE FROM reservation WHERE id=:id;");
    $query->bindParam(':id',$id);
    $query->execute();
}

function mod($conn,$id){
        $query = $conn->prepare("SELECT * FROM reservation WHERE id=:id;");
        $query->bindParam(':id',$id);
        $query->execute();
        $res = $query->fetch();
?>

<form method="post">
    <input name="id" hidden  value=<?php echo $res['id']?>>
    <input name="nom" type="text" value=<?php echo $res['nom']?>>
    <input name="date" type="date" value=<?php echo $res['date']?>>
    <input name="debut" type="time" value=<?php echo $res['debut']?>>
    <input name="fin" type="time" value=<?php echo $res['fin']?>>
    <input name="description"  type="textaera" value=<?php echo $res['description']?>>
    <button type="submit" name="j" value="maj">mise a jour</button>
</form>

<?php
    
}

function add(){  
?> 
<form method="post">
    <input name="nom" type="text" placeholder="nom" required>
    <input name="date" type="date" placeholder="date" required>
    <input name="debut" type="time" placeholder="debut" required>
    <input name="fin" type="time" placeholder="fin" required>
    <input name="description" type="textaera" placeholder="description" required>
    <button type="submit" name="addd" value="ad">Ajouter</button>
</form>
<?php

}


function testinput($conn,$in,$out,$date){
    $tet = true;
    $query = $conn->prepare("SELECT debut,fin FROM reservation");
    $query -> execute();
    $times = $query -> fetchall();
    foreach($times as $time){
        var_dump($time);
        if($time['fin']>$time['debut'])
         echo "true";
        echo "<br>";
    }
}



