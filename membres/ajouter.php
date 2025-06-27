<?php 
require_once('../config/db.php'); 
$ajout = $_GET['ajout'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Membres - Ajout</title>
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

      <label for="email">Adresse email : </label>
      <input type="email" name="email" id="email">

      <input type="submit" value="Ajouter un membre">
    </form>
    <?php
    endif; // Fin if ajout === ''

    if($ajout === 'oui'):
      $nom = $_POST['nom'];
      $prenom = $_POST['prenom'];
      $email = $_POST['email'];

      if(empty($nom) || empty($prenom) || empty($email)): ?>
        <p class="retour error">Veuillez au moins remplir le nom, prénom et adresse email du nouveau membre.</p>
        <div class="next-step">
          <a href="liste.php">Retourner à la liste des membres.</a>
          <a href="ajouter.php">Réessayer d'ajouter un membre.</a>
        </div>
        <?php die();
      endif;

      $stmt = $pdo->prepare('INSERT INTO membres(nom_membre, prenom_membre, email, date_inscription) VALUES(:nom, :prenom, :email, :dateinscription)');
      $stmt->execute(array(
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'dateinscription' => date('Y-m-d')
      ));

      $retour = $stmt->rowCount() > 0 ? 'Membre ajouté !' : "Erreur d'ajout !";
    ?>
      <p class="retour <?= $retour === 'Membre ajouté !' ? 'success' : 'error' ?>"><?= $retour ?></p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des membres.</a>
        <a href="ajouter.php">Ajouter un autre membre.</a>
      </div>
    <?php
    endif; // Fin if ajout === 'oui'
    ?>
  </main>

  <?php include_once('../public/footer.php'); ?>
</body>
</html>