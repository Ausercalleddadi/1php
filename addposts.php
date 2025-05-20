
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Poster un Sujet - Forum Étudiant</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Poster un Sujet</h1>
    <nav>
      <a href="index.html">Accueil</a>
      <a href="inscription.html">Inscription</a>
      <a href="connexion.html">Connexion</a>
      <a href="sujets.html">Sujets</a>
    </nav>
  </header>
  <main class="container">
    <section class="section">
      <form action="traitement_post.php" method="POST">
        <div class="form-group">
          <input type="text" name="titre" placeholder="Titre du sujet" required>
        </div>
        <div class="form-group">
          <select name="categorie" required>
            <option value="">Choisir une catégorie</option>
            <option value="dev">Développement</option>
            <option value="reseau">Réseau</option>
            <option value="cours">Cours</option>
          </select>
        </div>
        <div class="form-group">
          <textarea name="description" placeholder="Décrivez votre sujet..." rows="6" required></textarea>
        </div>
        <button type="submit">Publier</button>
      </form>
    </section>
  </main>
  <footer>&copy; 2025 Forum Étudiant</footer>
</body>
</html>