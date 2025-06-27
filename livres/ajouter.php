<?php 
require_once('../config/db.php'); 
require_once('../config/functions.php'); // Ajout de l'import des fonctions utilitaires
$ajout = $_GET['ajout'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Livres - Ajout</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include_once('../public/header.php'); ?>
  
  <main>
    <?php
    if($ajout === ''):
    ?>
    <form action="?ajout=oui" method="post">
      <label for="titre">Titre :</label>
      <input type="text" name="titre" id="titre">

      <label for="annee">Année de publication :</label>
      <input type="number" name="annee" id="annee">

      <label for="auteur">Auteur : </label>
      <select name="auteur" id="auteur">
        <?php 
        $auteurs = getAllAuteurs($pdo); // Utilisation de la fonction utilitaire
        foreach($auteurs as $auteur):
        ?>
          <option value="<?= $auteur['id_auteur']?>"><?= $auteur['prenom_auteur'].' '.$auteur['nom_auteur'] ?></option>
        <?php endforeach; ?>
      </select>

      <label for="genre">Genre :</label>
      <select name="genre" id="genre">
        <?php
        $stmt = $pdo->prepare('SELECT * from genres');
        $stmt->execute();
        $genres = $stmt->fetchAll();
        foreach($genres as $genre):
        ?>
          <option value="<?= $genre['id_genre']?>"><?= $genre['nom_genre'] ?></option>
        <?php endforeach; ?>
      </select>

      <input type="submit" value="Ajouter un livre">
    </form>
    <?php
    endif; // Fin if ajout === ''

    if($ajout === 'oui'):
      $titre = $_POST['titre'];
      $anneePublication = $_POST['annee'] ?? 0000;
      $idAuteur = $_POST['auteur'];
      $idGenre = $_POST['genre'];

      if(empty($titre) || empty($idAuteur) || empty($idGenre) || strlen($anneePublication) != 4): ?>
        <p class="retour error">Veuillez au moins remplir le titre, l'auteur et le genre. L'année de publication doit contenir 4 caractères</p>
        <div class="next-step">
          <a href="liste.php">Retourner à la liste des livres.</a>
          <a href="ajouter.php">Réessayer d'ajouter un livre.</a>
        </div>
        <?php die();
      endif;

      // Utilisation de la fonction utilitaire pour ajouter un livre
      $result = ajouterLivre($pdo, $titre, $anneePublication, $idAuteur, $idGenre);
      $retour = $result ? 'Livre ajouté !' : "Erreur d'ajout !";
    ?>
      <p class="retour <?= $retour === 'Livre ajouté !' ? 'success' : 'error' ?>"><?= $retour ?></p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des livres.</a>
        <a href="ajouter.php">Ajouter un autre livre</a>
      </div>
    <?php endif; ?>
  </main>

  <?php include('../public/footer.php'); ?>
</body>
</html>