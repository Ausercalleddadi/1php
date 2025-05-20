<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription - Forum Étudiant</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- inscription.html -->
  <header>
    <h1>Inscription</h1>
    <nav>
      <a href="index.html">Posts</a>
      <a href="sujets.html">Subjects</a>
      <a href="poster.html">Add Post</a>
      <a href="connexion.html">sign up / login</a>
    </nav>
  </header>

  <main class="container">
    <section class="section">

      <div class="sign-text-main">
        <h1 class="phrase1">Creater your account</h1>
        <p class="phrase2">Join the rest of the students</p>
      </div>

      <form class="for" action="traitement_inscription.php" method="POST">

        <div class="form-group name">
          <div>
            <label>first name</label><br>
            <input type="text" name="nom" placeholder="your first Name" required>
          </div>
          <div>
            <label>last name</label><br>
            <input type="text" name="prenom" placeholder="your last name" required>
          </div>
        </div>

        <div class="form-group email">
          <label>email</label><br>
          <input type="email" name="email" placeholder="youremail@email.com" required>
        </div>

        <div class="form-group password">
          <label>password</label><br>
          <input type="password" name="password" placeholder="your password" required>
          <ul>
            <li>at least 8 characters</li>
            <li>at least 1 uppercase character</li>
            <li>at least 1 number</li>
          </ul>
        </div>

        <button type="submit">Sign up</button>
      </form>
    </section>
    <section class="section1">
    </section>
  </main>
  <footer>&copy; 2025 Forum Étudiant</footer>
</body>
</html>