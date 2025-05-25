<?php include 'db.php';

$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM contacts WHERE nom LIKE :search OR email LIKE :search ORDER BY nom";
$stmt = $pdo->prepare($sql);
$stmt->execute(['search' => "%$search%"]);
$contacts = $stmt->fetchAll();
?>

<h2>Répertoire de contacts</h2>

<form method="get">
    <input type="text" name="search" placeholder="Rechercher par nom ou email" value="<?= htmlspecialchars($search) ?>">
    <button type="submit">Rechercher</button>
    <a href="create.php">Ajouter un contact</a>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($contacts as $c): ?>
    <tr>
        <td><?= $c['id'] ?></td>
        <td><?= $c['prenom'] ?></td>
        <td><?= $c['nom'] ?></td>
        <td><?= $c['email'] ?></td>
        <td><?= $c['telephone'] ?></td>
        <td>
            <a href="edit.php?id=<?= $c['id'] ?>">Modifier</a> |
            <a href="delete.php?id=<?= $c['id'] ?>" onclick="return confirm('Supprimer ce contact ?')">Supprimer</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "INSERT INTO contacts (prenom, nom, email, telephone) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['prenom'], $_POST['nom'], $_POST['email'], $_POST['telephone']]);
    header('Location: index.php');
}
?>
<h2>Ajouter un contact</h2>
<form method="post">
    <input name="prenom" placeholder="Prénom" required>
    <input name="nom" placeholder="Nom" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="telephone" placeholder="Téléphone" required>
    <button type="submit">Ajouter</button>
</form>
<a href="index.php">← Retour</a>

