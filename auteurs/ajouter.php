<?php 
require_once('../config/db.php'); 
require_once('../config/functions.php'); // Ajout de l'import des fonctions utilitaires
$ajout = $_GET['ajout'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Auteurs - Ajout</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include_once('../public/header.php'); ?>
  
  <main>
    <?php
    if($ajout === ''):
    ?>
    <form action="?ajout=oui" method="post">
      <label for="nom">Nom :</label>
      <input type="text" name="nom" id="nom">

      <label for="prenom">Prénom</label>
      <input type="text" name="prenom" id="prenom">

      <input type="submit" value="Ajouter un auteur">
    </form>
    <?php
    endif; // Fin if ajout === ''

    if($ajout === 'oui'):
      $nom = $_POST['nom'];
      $prenom = $_POST['prenom'];

      if(empty($nom) || empty($prenom)): ?>
        <p class="retour error">Veuillez au moins remplir le nom et le prénom du nouvel auteur.</p>
        <div class="next-step">
          <a href="liste.php">Retourner à la liste des auteurs.</a>
          <a href="ajouter.php">Réessayer d'ajouter un auteur.</a>
        </div>
        <?php die();
      endif;

      // Utilisation de la fonction utilitaire pour ajouter un auteur
      $result = ajouterAuteur($pdo, $nom, $prenom);
      $retour = $result ? 'Auteur ajouté !' : "Erreur d'ajout !";
    ?>
      <p class="retour <?= $retour === 'Auteur ajouté !' ? 'success' : 'error' ?>"><?= $retour ?></p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des auteurs.</a>
        <a href="ajouter.php">Ajouter un autre auteur</a>
      </div>
    <?php endif; // Fin if ajout === 'oui' ?>
  </main>

  <?php include_once('../public/footer.php'); ?>
</body>
</html>