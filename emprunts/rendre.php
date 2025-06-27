<?php 
require_once('../config/db.php'); 
$endLoan = $_GET['endloan'] ?? '';
$id = $_GET['id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Emprunts - Rendre</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include_once('../public/header.php'); ?>

  <main>
    <?php
    if($id <= 0):
    ?>
      <p class="retour error">Emprunt inconnu !</p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des emprunts.</a>
      </div>
    <?php
    endif;

    if($endLoan === 'oui' && $id > 0){
      $stmt = $pdo->prepare('UPDATE emprunts SET date_retour_reel=:date_retour WHERE id_emprunt=:id');
      $stmt->execute(array(
        'date_retour' => date('Y-m-d'),
        'id' => $id
      ));

      $retour = $stmt->rowCount() > 0 ? 'Emprunt terminé !' : "Erreur !";
      ?>
      <p class="retour <?= $retour === 'Emprunt terminé !' ? 'success' : 'error' ?>"><?= $retour ?></p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des auteurs.</a>
      </div>
      <?php
    }

    if($endLoan != 'oui' && $id > 0):
      ?>
      <p class="retour">Êtes-vous sûr de vouloir mettre fin à cet emprunt ?</p>
      <div class="next-step">
        <a href="liste.php" class="button yes">NON</a>
        <a href="rendre.php?id=<?=$id?>&endloan=oui" class="button no">OUI</a>
      </div>
    <?php endif; // fin if edit != 'oui' && id > 0?>
  </main>

  <?php include('../public/footer.php'); ?>
</body>
</html>