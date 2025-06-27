<?php
// Lister les emprunts
require_once('../config/db.php');
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
    // Récupérer tous les emprunts dans la base de données
    $stmt = $pdo->prepare('SELECT id_emprunt, date_emprunt, date_retour_prevu, date_retour_reel, titre, nom_membre, prenom_membre FROM emprunts LEFT JOIN livres on fk_id_livre=id_livre LEFT JOIN membres on fk_id_membre=id_membre WHERE date_retour_reel IS NOT NULL');
    $stmt->execute();
    $loans = $stmt->fetchAll();
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