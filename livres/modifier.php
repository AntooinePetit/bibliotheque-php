<?php 
require_once('../config/db.php'); 
$edit = $_GET['edit'] ?? '';
$id = $_GET['id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Livres - Modifier</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include_once('../public/header.php'); ?>

  <main>
    <?php
    if($id <= 0):
    ?>
      <p class="retour error">Livre inconnu !</p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des livres.</a>
      </div>
    <?php
    endif;

    if($edit === 'oui' && $id > 0){
      $nouveauTitre = $_POST['titre'];
      $nouvelleAnnee = $_POST['annee'] ?? 0000;
      $nouvelAuteur = $_POST['auteur'];
      $nouveauGenre = $_POST['genre'];

      if(empty($nouveauTitre) || empty($nouvelAuteur) || empty($nouveauGenre)){
        ?>
        <p class="retour error">Veuillez remplir au moins les champs de titre, auteur et genre !</p>
        <div class="next-step">
          <a href="liste.php">Retourner à la liste des livres.</a>
          <a href="modifier.php?id=<?=$id?>">Retourner à la modification du livre.</a>
        </div>
        </main>
        <?php include('../public/footer.php'); ?>
        <?php
        die();
      }

      $stmt = $pdo->prepare('UPDATE livres SET titre=:titre, annee_publication=:annee, fk_id_auteur=:auteur, fk_id_genre=:genre WHERE id_livre=:id');
      $stmt->execute(array(
        'titre' => $nouveauTitre,
        'annee' => $nouvelleAnnee,
        'auteur' => $nouvelAuteur,
        'genre' => $nouveauGenre,
        'id' => $id
      ));

      $retour = $stmt->rowCount() > 0 ? 'Livre modifié !' : "Erreur de modification !";
      ?>
      <p class="retour <?= $retour === 'Livre modifié !' ? 'success' : 'error' ?>"><?= $retour ?></p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des livres.</a>
      </div>
      <?php
    }

    if($edit != 'oui' && $id > 0):
      $stmt = $pdo->prepare('SELECT * FROM livres WHERE id_livre=:id');
      $stmt->execute(array(
        'id' => $id
      ));

      $book = $stmt->fetch();
      ?>
      <form action="?id=<?=$id?>&edit=oui" method="post">
        <label for="titre">Titre :</label>
        <input type="text" name="titre" id="titre" value="<?= $book['titre'] ?>">

        <label for="annee">Année de publication :</label>
        <input type="number" name="annee" id="annee" value="<?= $book['annee_publication'] ?>">

        <label for="auteur">Auteur : </label>
        <select name="auteur" id="auteur">
          <?php 
          $stmt = $pdo->prepare('SELECT * FROM auteurs');
          $stmt->execute();
          $auteurs = $stmt->fetchAll();
          foreach($auteurs as $auteur){
            if($auteur['id_auteur'] == $book['fk_id_auteur']){
              ?> 
              <option value="<?= $auteur['id_auteur'] ?>"><?= $auteur['prenom_auteur'].' '.$auteur['nom_auteur'] ?></option>
              <?php
            }
          }
          foreach($auteurs as $auteur):
            if($auteur['id_auteur'] != $book['fk_id_auteur']){
            ?>
              <option value="<?= $auteur['id_auteur']?>"><?= $auteur['prenom_auteur'].' '.$auteur['nom_auteur'] ?></option>
            <?php
            }
          endforeach; ?>
        </select>

        <label for="genre">Genre :</label>
        <select name="genre" id="genre">
          <?php
          $stmt = $pdo->prepare('SELECT * from genres');
          $stmt->execute();
          $genres = $stmt->fetchAll();
          foreach($genres as $genre){
            if($genre['id_genre'] == $book['fk_id_genre']){
              ?>
              <option value="<?= $genre['id_genre']?>"><?= $genre['nom_genre'] ?></option>
              <?php
            }
          }
          foreach($genres as $genre):
            if($genre['id_genre'] != $book['fk_id_genre']){
            ?>
              <option value="<?= $genre['id_genre']?>"><?= $genre['nom_genre'] ?></option>
            <?php 
            }
          endforeach; ?>
        </select>

        <input type="submit" value="Modifier un livre">
      </form>
    <?php endif; // fin if edit != 'oui' && id > 0?>
  </main>

  <?php include('../public/footer.php'); ?>
</body>
</html>