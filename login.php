<!-- connexion.html -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion - Forum Étudiant</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Connexion</h1>
    <nav>
      <a href="index.html">Accueil</a>
      <a href="inscription.html">Inscription</a>
      <a href="poster.html">Poster</a>
      <a href="sujets.html">Sujets</a>
    </nav>
  </header>
  <main class="container">
    <section class="section">
      <form action="traitement_connexion.php" method="POST">
        <div class="form-group">
          <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
          <input type="password" name="password" placeholder="Mot de passe" required>
        </div>
        <button type="submit">Se connecter</button>
      </form>
    </section>
  </main>
  <footer>&copy; 2025 Forum Étudiant</footer>
</body>
</html>