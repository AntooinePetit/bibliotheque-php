<?php
// Lister les livres
require_once('../config/db.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Livres - Liste</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include('../public/header.php') ?>

  <main>
    <h1>Livres</h1>
    <?php 
    // Récupérer tous les membres dans la base de données
    $stmt = $pdo->prepare('SELECT id_livre, titre, annee_publication, nom_auteur, prenom_auteur, nom_genre FROM livres LEFT JOIN auteurs on fk_id_auteur=id_auteur LEFT JOIN genres on fk_id_genre=id_genre ');
    $stmt->execute();
    $books = $stmt->fetchAll();
    ?>
    <div class="table_component" role="region" tabindex="0">
      <table>
        <caption>Liste des livres</caption>
        <thead>
          <tr>
            <th>Nom</th>
            <th>Année de publication</th>
            <th>Auteur</th>
            <th>Genre</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        foreach($books as $book):
          $anneePublication = $book['annee_publication'] == 0000 ? 'Année de publication inconnue' : $book['annee_publication'];
        ?>
          <tr>
            <td><?= $book['titre'] ?></td>
            <td><?= $anneePublication ?></td>
            <td><?= $book['prenom_auteur'].' '.$book['nom_auteur'] ?></td>
            <td><?= $book['nom_genre'] ?></td>
            <td><a href="modifier.php?id=<?= $book['id_livre'] ?>" class="edit">Modifier</a> | <a href="supprimer.php?id=<?= $book['id_livre']?>" class="del">Supprimer</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
      <a href="ajouter.php" class="ajout">Ajouter un livre</a>
    </div>
  </main>

  <?php include('../public/footer.php') ?>
</body>
</html>