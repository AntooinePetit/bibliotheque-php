<?php 
require_once('../config/db.php'); 
$ajout = $_GET['ajout'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Emprunts - Ajouter un emprunt</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <?php include_once('../public/header.php'); ?>
  
  <main>
    <?php
    if($ajout === ''):
    ?>
    <form action="?ajout=oui" method="post">
      <label for="member">Membre :</label>
      <select name="member" id="member">
        <?php
        $stmt = $pdo->prepare('SELECT id_membre, nom_membre, prenom_membre FROM membres');
        $stmt->execute();

        $members = $stmt->fetchAll();
        foreach($members as $member):
        ?>
          <option value="<?= $member['id_membre'] ?>"><?= $member['prenom_membre'].' '.$member['nom_membre'] ?></option>
        <?php 
        endforeach;
        ?>
      </select>

      <label for="book">Livre :</label>
      <select name="book" id="book">
        <?php
        $stmt = $pdo->prepare('SELECT id_livre, titre FROM livres');
        $stmt->execute();

        $books = $stmt->fetchAll();
        foreach($books as $book):
        ?>
          <option value="<?= $book['id_livre'] ?>"><?= $book['titre'] ?></option>
        <?php
        endforeach;
        ?>
      </select>

      <label for="date_retour">Date de retour prévue :</label>
      <input type="date" name="date_retour" id="date_retour">

      <input type="submit" value="Emprunter un livre">
    </form>
    <?php
    endif; // Fin if ajout === ''

    if($ajout === 'oui'):
      $member = $_POST['member'];
      $book = $_POST['book'];
      $dateRetour = $_POST['date_retour'];

      if(empty($member) || empty($book) || empty($dateRetour)): ?>
        <p class="retour error">Veuillez au moins sélectionner un membre, un livre et une date de retour.</p>
        <div class="next-step">
          <a href="liste.php">Retourner à la liste des emprunts.</a>
          <a href="ajouter.php">Réessayer d'ajouter un emprunt.</a>
        </div>
        <?php die();
      endif;

      $stmt = $pdo->prepare('INSERT INTO emprunts(date_emprunt, date_retour_prevu, fk_id_livre, fk_id_membre) VALUES(:date_emprunt, :date_retour, :livre, :membre)');
      $stmt->execute(array(
        'date_emprunt' => date('Y-m-d'),
        'date_retour' => $dateRetour,
        'livre' => $book,
        'membre' => $member
      ));

      $retour = $stmt->rowCount() > 0 ? 'Emprunt ajouté !' : "Erreur d'ajout !";
    ?>
      <p class="retour <?= $retour === 'Emprunt ajouté !' ? 'success' : 'error' ?>"><?= $retour ?></p>
      <div class="next-step">
        <a href="liste.php">Retourner à la liste des emprunts.</a>
        <a href="ajouter.php">Ajouter un autre emprunt.</a>
      </div>
    <?php
    endif; // Fin if ajout === 'oui'
    ?>
  </main>

  <?php include_once('../public/footer.php'); ?>
</body>
</html>