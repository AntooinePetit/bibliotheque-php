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
  <title>Membres - Modifier</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include_once('../public/header.php'); ?>

  <main>
    <?php
    if($id <= 0):
    ?>
      <p class="retour error">Membre inconnu !</p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des membres.</a>
      </div>
    <?php
    endif;

    if($edit === 'oui' && $id > 0){
      $nouveauNom = $_POST['nom'];
      $nouveauPrenom = $_POST['prenom'];
      $nouvelEmail = $_POST['email'];

      if(empty($nouveauNom) || empty($nouvelEmail) || empty($nouveauPrenom)){
        ?>
        <p class="retour error">Veuillez remplir au moins les champs de nom, prénom et adresse email !</p>
        <div class="next-step">
          <a href="liste.php">Retourner à la liste des membres.</a>
          <a href="modifier.php?id=<?=$id?>">Retourner à la modification du membre.</a>
        </div>
        </main>
        <?php include('../public/footer.php'); ?>
        <?php
        die();
      }

      $stmt = $pdo->prepare('UPDATE membres SET nom_membre=:nom, prenom_membre=:prenom, email=:email WHERE id_membre=:id');
      $stmt->execute(array(
        'nom' => $nouveauNom,
        'prenom' => $nouveauPrenom,
        'email' => $nouvelEmail,
        'id' => $id
      ));

      $retour = $stmt->rowCount() > 0 ? 'Membre modifié !' : "Erreur de modification !";
      ?>
      <p class="retour <?= $retour === 'Membre modifié !' ? 'success' : 'error' ?>"><?= $retour ?></p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des membres.</a>
      </div>
      <?php
    }

    if($edit != 'oui' && $id > 0):
      $stmt = $pdo->prepare('SELECT * FROM membres WHERE id_membre=:id');
      $stmt->execute(array(
        'id' => $id
      ));

      $member = $stmt->fetch();
      ?>
      <form action="?id=<?=$id?>&edit=oui" method="post">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" value="<?= $member['nom_membre'] ?>">

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" id="prenom" value="<?= $member['prenom_membre'] ?>">

        <label for="email">Adresse email : </label>
        <input type="email" name="email" id="email" value="<?= $member['email'] ?>">

        <input type="submit" value="Modifier un membre">
      </form>
    <?php endif; // fin if edit != 'oui' && id > 0?>
  </main>

  <?php include('../public/footer.php'); ?>
</body>
</html>