<?php 
require_once('../config/db.php'); 
$delete = $_GET['delete'] ?? '';
$id = $_GET['id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Membres - Supprimer</title>
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

    if($id > 0 && $delete === 'delete'):
      $stmt = $pdo->prepare('DELETE FROM membres WHERE id_membre=:id');
      $stmt->execute(array(
        'id' => $id
      ));
      
      $retour = $stmt->rowCount() > 0 ? 'Membre supprimé !' : "Erreur de suppresion !";
      ?>
      <p class="retour <?= $retour === 'Membre supprimé !' ? 'success' : 'error' ?>"><?= $retour ?></p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des membres.</a>
      </div>
      <?php
    endif; // fin if id > 0 et delete === 'delete'

    if($id > 0 && $delete != 'delete'):
    ?>
      <p class="retour">Êtes-vous sûr de vouloir supprimer ce membre ?</p>
      <div class="next-step">
        <a href="liste.php" class="button no">NON</a>
        <a href="supprimer.php?id=<?=$id?>&delete=delete" class="button yes">OUI</a>
      </div>
    <?php
    endif; // Fin if id > 0 et $delete != 'delete'
    ?>
  </main>

  <?php include('../public/footer.php'); ?>
</body>
</html>