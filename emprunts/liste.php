<?php
// Lister les emprunts
require_once('../config/db.php');
require_once('../config/functions.php'); // Ajout de l'import des fonctions utilitaires
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Emprunts - Liste</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include('../public/header.php') ?>

  <main>
    <h1>Emprunts</h1>
    <?php 
    // Utilisation de la fonction utilitaire pour récupérer tous les emprunts
    $loans = getAllEmprunts($pdo);
    ?>
    <div class="table_component" role="region" tabindex="0">
      <table>
        <caption>Liste des emprunts</caption>
        <thead>
          <tr>
            <th>Titre du livre</th>
            <th>Emprunté par</th>
            <th>Date d'emprunt</th>
            <th>Date de retour prévue</th>
            <th>Rendu</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        foreach($loans as $loan):
        ?>
          <tr>
            <td><?= $loan['titre'] ?></td>
            <td><?= $loan['prenom_membre'].' '.$loan['nom_membre'] ?></td>
            <td><?= $loan['date_emprunt'] ?></td>
            <td><?= $loan['date_retour_prevu'] ?></td>
            <td><?= is_null($loan['date_retour_reel']) ? 'Non rendu' : 'Rendu' ?></td>
            <td><a href="rendre.php?id=<?= $loan['id_emprunt'] ?>" class="edit"><?= is_null($loan['date_retour_reel']) ? 'Rendre' : '' ?></a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <div class="next-step">
        <a href="emprunter.php" class="ajout">Ajouter un emprunt</a>
        <a href="historique.php" class="ajout">Historique des emprunts</a>
      </div>
    </div>
  </main>

  <?php include('../public/footer.php') ?>
</body>
</html>