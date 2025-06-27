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
  <title>Auteurs - Modifier</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include_once('../public/header.php'); ?>

  <main>
    <?php
    if($id <= 0):
    ?>
      <p class="retour error">Auteur inconnu !</p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des auteurs.</a>
      </div>
    <?php
    endif;

    if($edit === 'oui' && $id > 0){
      $nouveauNom = $_POST['nom'];
      $nouveauPrenom = $_POST['prenom'];

      if(empty($nouveauNom) || empty($nouveauPrenom)){
        ?>
        <p class="retour error">Veuillez remplir au moins les champs de nom et de prénom !</p>
        <div class="next-step">
          <a href="liste.php">Retourner à la liste des auteurs.</a>
          <a href="modifier.php?id=<?=$id?>">Retourner à la modification du auteur.</a>
        </div>
        </main>
        <?php include('../public/footer.php'); ?>
        <?php
        die();
      }

      $stmt = $pdo->prepare('UPDATE auteurs SET nom_auteur=:nom, prenom_auteur=:prenom WHERE id_auteur=:id');
      $stmt->execute(array(
        'nom' => $nouveauNom,
        'prenom' => $nouveauPrenom,
        'id' => $id
      ));

      $retour = $stmt->rowCount() > 0 ? 'Auteur modifié !' : "Erreur de modification !";
      ?>
      <p class="retour <?= $retour === 'Auteur modifié !' ? 'success' : 'error' ?>"><?= $retour ?></p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des auteurs.</a>
      </div>
      <?php
    }

    if($edit != 'oui' && $id > 0):
      $stmt = $pdo->prepare('SELECT * FROM auteurs WHERE id_auteur=:id');
      $stmt->execute(array(
        'id' => $id
      ));

      $member = $stmt->fetch();
      ?>
      <form action="?id=<?=$id?>&edit=oui" method="post">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= $member['nom_auteur'] ?>">

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="<?= $member['prenom_auteur'] ?>">

        <input type="submit" value="Modifier un auteur">
      </form>
    <?php endif; // fin if edit != 'oui' && id > 0?>
  </main>

  <?php include('../public/footer.php'); ?>
</body>
</html>