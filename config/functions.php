<?php
// Fichier de fonctions utilitaires pour la bibliothèque
require_once('db.php');

/**
 * Récupère l'historique des emprunts (emprunts rendus)
 * @return array
 */
function getEmpruntsHistoriques(PDO $pdo) {
    $stmt = $pdo->prepare('SELECT id_emprunt, date_emprunt, date_retour_prevu, date_retour_reel, titre, nom_membre, prenom_membre FROM emprunts LEFT JOIN livres on fk_id_livre=id_livre LEFT JOIN membres on fk_id_membre=id_membre WHERE date_retour_reel IS NOT NULL');
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Récupère la liste de tous les auteurs
 * @param PDO $pdo
 * @return array
 */
function getAllAuteurs(PDO $pdo) {
    $stmt = $pdo->prepare('SELECT * FROM auteurs');
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Récupère la liste de tous les membres
 * @param PDO $pdo
 * @return array
 */
function getAllMembres(PDO $pdo) {
    $stmt = $pdo->prepare('SELECT * FROM membres');
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Récupère la liste de tous les livres avec auteur et genre
 * @param PDO $pdo
 * @return array
 */
function getAllLivres(PDO $pdo) {
    $stmt = $pdo->prepare('SELECT id_livre, titre, annee_publication, nom_auteur, prenom_auteur, nom_genre FROM livres LEFT JOIN auteurs on fk_id_auteur=id_auteur LEFT JOIN genres on fk_id_genre=id_genre ');
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * Récupère la liste de tous les emprunts (avec info livre et membre)
 * @param PDO $pdo
 * @return array
 */
function getAllEmprunts(PDO $pdo) {
    $stmt = $pdo->prepare('SELECT id_emprunt, date_emprunt, date_retour_prevu, date_retour_reel, titre, nom_membre, prenom_membre FROM emprunts LEFT JOIN livres on fk_id_livre=id_livre LEFT JOIN membres on fk_id_membre=id_membre ');
    $stmt->execute();
    return $stmt->fetchAll();
}

// Vous pouvez ajouter ici d'autres fonctions réutilisables pour les auteurs, livres, membres, etc.
