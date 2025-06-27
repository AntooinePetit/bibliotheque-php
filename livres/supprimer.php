<?php 
require_once('../config/db.php'); 
require_once('../config/functions.php'); // Ajout de l'import des fonctions utilitaires
$delete = $_GET['delete'] ?? '';
$id = $_GET['id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Livres - Supprimer</title>
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

    if($id > 0 && $delete === 'delete'):
      // Utilisation de la fonction utilitaire pour supprimer un livre
      $result = supprimerLivre($pdo, $id);
      $retour = $result ? 'Livre supprimé !' : "Erreur de suppresion !";
      ?>
      <p class="retour <?= $retour === 'Livre supprimé !' ? 'success' : 'error' ?>"><?= $retour ?></p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des livres.</a>
      </div>
      <?php
    endif; // fin if id > 0 et delete === 'delete'

    if($id > 0 && $delete != 'delete'):
    ?>
      <p class="retour">Êtes-vous sûr de vouloir supprimer ce livre ?</p>
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