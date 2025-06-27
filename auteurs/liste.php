<?php
// Lister les auteurs
require_once('../config/db.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Auteurs - Liste</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include('../public/header.php') ?>

  <main>
    <h1>Auteurs</h1>
    <?php 
    // Récupérer tous les auteurs dans la base de données
    $stmt = $pdo->prepare('SELECT * FROM auteurs');
    $stmt->execute();
    $autors = $stmt->fetchAll();
    ?>
    <div class="table_component" role="region" tabindex="0">
      <table>
        <caption>Liste des auteurs</caption>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        foreach($autors as $autor):
        ?>
          <tr>
            <td><?= $autor['nom_auteur'] ?></td>
            <td><?= $autor['prenom_auteur'] ?></td>
            <td><a href="modifier.php?id=<?= $autor['id_auteur'] ?>" class="edit">Modifier</a> | <a href="supprimer.php?id=<?= $autor['id_auteur']?>" class="del">Supprimer</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <a href="ajouter.php" class="ajout">Ajouter un auteur</a>
    </div>
  </main>

  <?php include('../public/footer.php') ?>
</body>
</html>