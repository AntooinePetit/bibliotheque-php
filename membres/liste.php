<?php
$mode = $_GET['mode'] ?? 'lecture';

// Lister les membres
require_once('../config/db.php');
require_once('../config/functions.php'); // Ajout de l'import des fonctions utilitaires
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Membres - Liste</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include('../public/header.php') ?>

  <main>
    <h1>Membres</h1>
    <?php 
    if($mode === 'lecture'): 
      // Utilisation de la fonction utilitaire pour récupérer tous les membres
      $members = getAllMembres($pdo);
      ?>
      <div class="table_component" role="region" tabindex="0">
        <table>
          <caption>Liste des membres</caption>
          <thead>
            <tr>
              <th>Nom</th>
              <th>Prenom</th>
              <th>Email</th>
              <th>Date d'inscription</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
          foreach($members as $member):
          ?>
            <tr>
              <td><?= $member['nom_membre'] ?></td>
              <td><?= $member['prenom_membre'] ?></td>
              <td><?= $member['email'] ?></td>
              <td><?= $member['date_inscription'] ?></td>
              <td><a href="modifier.php?id=<?= $member['id_membre'] ?>" class="edit">Modifier</a> | <a href="supprimer.php?id=<?= $member['id_membre']?>" class="del">Supprimer</a></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
        <a href="ajouter.php" class="ajout">Ajouter un membre</a>
      </div>
    <?php endif; ?>
  </main>

  <?php include('../public/footer.php') ?>
</body>
</html>