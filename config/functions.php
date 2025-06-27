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

/**
 * Ajoute un auteur
 * @param PDO $pdo
 * @param string $nom
 * @param string $prenom
 * @return bool
 */
function ajouterAuteur(PDO $pdo, $nom, $prenom) {
    $stmt = $pdo->prepare('INSERT INTO auteurs(nom_auteur, prenom_auteur) VALUES(:nom, :prenom)');
    return $stmt->execute(['nom' => $nom, 'prenom' => $prenom]);
}

/**
 * Modifie un auteur
 * @param PDO $pdo
 * @param int $id
 * @param string $nom
 * @param string $prenom
 * @return bool
 */
function modifierAuteur(PDO $pdo, $id, $nom, $prenom) {
    $stmt = $pdo->prepare('UPDATE auteurs SET nom_auteur=:nom, prenom_auteur=:prenom WHERE id_auteur=:id');
    return $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'id' => $id]);
}

/**
 * Supprime un auteur
 * @param PDO $pdo
 * @param int $id
 * @return bool
 */
function supprimerAuteur(PDO $pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM auteurs WHERE id_auteur=:id');
    return $stmt->execute(['id' => $id]);
}

/**
 * Ajoute un livre
 * @param PDO $pdo
 * @param string $titre
 * @param int $annee
 * @param int $auteur
 * @param int $genre
 * @return bool
 */
function ajouterLivre(PDO $pdo, $titre, $annee, $auteur, $genre) {
    $stmt = $pdo->prepare('INSERT INTO livres(titre, annee_publication, fk_id_auteur, fk_id_genre) VALUES(:titre, :annee, :auteur, :genre)');
    return $stmt->execute(['titre' => $titre, 'annee' => $annee, 'auteur' => $auteur, 'genre' => $genre]);
}

/**
 * Modifie un livre
 * @param PDO $pdo
 * @param int $id
 * @param string $titre
 * @param int $annee
 * @param int $auteur
 * @param int $genre
 * @return bool
 */
function modifierLivre(PDO $pdo, $id, $titre, $annee, $auteur, $genre) {
    $stmt = $pdo->prepare('UPDATE livres SET titre=:titre, annee_publication=:annee, fk_id_auteur=:auteur, fk_id_genre=:genre WHERE id_livre=:id');
    return $stmt->execute(['titre' => $titre, 'annee' => $annee, 'auteur' => $auteur, 'genre' => $genre, 'id' => $id]);
}

/**
 * Supprime un livre
 * @param PDO $pdo
 * @param int $id
 * @return bool
 */
function supprimerLivre(PDO $pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM livres WHERE id_livre=:id');
    return $stmt->execute(['id' => $id]);
}

/**
 * Ajoute un membre
 * @param PDO $pdo
 * @param string $nom
 * @param string $prenom
 * @param string $email
 * @param string $dateinscription
 * @return bool
 */
function ajouterMembre(PDO $pdo, $nom, $prenom, $email, $dateinscription) {
    $stmt = $pdo->prepare('INSERT INTO membres(nom_membre, prenom_membre, email, date_inscription) VALUES(:nom, :prenom, :email, :dateinscription)');
    return $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'dateinscription' => $dateinscription]);
}

/**
 * Modifie un membre
 * @param PDO $pdo
 * @param int $id
 * @param string $nom
 * @param string $prenom
 * @param string $email
 * @return bool
 */
function modifierMembre(PDO $pdo, $id, $nom, $prenom, $email) {
    $stmt = $pdo->prepare('UPDATE membres SET nom_membre=:nom, prenom_membre=:prenom, email=:email WHERE id_membre=:id');
    return $stmt->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'id' => $id]);
}

/**
 * Supprime un membre
 * @param PDO $pdo
 * @param int $id
 * @return bool
 */
function supprimerMembre(PDO $pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM membres WHERE id_membre=:id');
    return $stmt->execute(['id' => $id]);
}

/**
 * Ajoute un emprunt
 * @param PDO $pdo
 * @param string $date_emprunt
 * @param string $date_retour
 * @param int $livre
 * @param int $membre
 * @return bool
 */
function ajouterEmprunt(PDO $pdo, $date_emprunt, $date_retour, $livre, $membre) {
    $stmt = $pdo->prepare('INSERT INTO emprunts(date_emprunt, date_retour_prevu, fk_id_livre, fk_id_membre) VALUES(:date_emprunt, :date_retour, :livre, :membre)');
    return $stmt->execute(['date_emprunt' => $date_emprunt, 'date_retour' => $date_retour, 'livre' => $livre, 'membre' => $membre]);
}

/**
 * Met à jour la date de retour réelle d'un emprunt
 * @param PDO $pdo
 * @param int $id
 * @param string $date_retour
 * @return bool
 */
function rendreEmprunt(PDO $pdo, $id, $date_retour) {
    $stmt = $pdo->prepare('UPDATE emprunts SET date_retour_reel=:date_retour WHERE id_emprunt=:id');
    return $stmt->execute(['date_retour' => $date_retour, 'id' => $id]);
}

// Vous pouvez ajouter ici d'autres fonctions réutilisables pour les auteurs, livres, membres, etc.
