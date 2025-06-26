<?php
$mode = $_GET['mode'] ?? 'lecture';

// Lister les livres
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

  <main></main>

  <?php include('../public/footer.php') ?>
</body>
</html>