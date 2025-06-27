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
  <title>Emprunts - Historique</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include('../public/header.php') ?>

  <main>
    <?php 
    // Utilisation de la fonction utilitaire pour récupérer l'historique des emprunts
    $loans = getEmpruntsHistoriques($pdo);
    ?>
    <div class="table_component" role="region" tabindex="0">
      <table>
        <caption>Liste des emprunts rendus</caption>
        <thead>
          <tr>
            <th>Titre du livre</th>
            <th>Emprunté par</th>
            <th>Date d'emprunt</th>
            <th>Date de retour prévue</th>
            <th>Date de retour réelle</th>
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
            <td><?= $loan['date_retour_reel'] ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <a href="liste.php">Retour à la liste des emprunts</a>
    </div>
  </main>

  <?php include('../public/footer.php') ?>
</body>
</html>