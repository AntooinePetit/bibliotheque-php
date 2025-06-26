<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bibliotheque</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body id="index">
  <?php include('header.php') ?>

  <main class="container-1440">
    <h1>Bibliothèque</h1>
    <p>Que voulez-vous consulter ?</p>
    <ul>
      <li><a href="../livres/liste.php">Livres</a></li>
      <li><a href="../auteurs/liste.php">Auteurs</a></li>
      <li><a href="../emprunts/liste.php">Emprunts</a></li>
      <li><a href="../membres/liste.php">Membres</a></li>
    </ul>
  </main>
  
  <?php include('footer.php') ?>
</body>
</html>