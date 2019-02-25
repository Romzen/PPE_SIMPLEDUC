<?php

function actionUtilisateur($twig, $db) {
    $form = array();
    $utilisateur = new Utilisateur($db);
    $participer = new Participer($db);
    $effectuer = new Effectuer($db);
    $utiliser = new Utiliser($db);

    if (isset($_GET['id'])) {
        $execUtiliser = $utiliser->delete($_GET['id']);
        $execParticiper = $participer->delete($_GET['id']);
        $execEffectuer = $effectuer->delete($_GET['id']);
        $execUtilisateur = $utilisateur->deleteP($_GET['id']);

        if (!$execParticiper) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table utilisateur';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Utilisateur supprimé avec succès';
        }
        if (!$execUtiliser) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table utilisateur';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Utilisateur supprimé avec succès';
        }
        if (!$execEffectuer) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table utilisateur';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Utilisateur supprimé avec succès';
        }
        if (!$execUtilisateur) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table utilisateur';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Utilisateur supprimé avec succès';
        }
    }
    $liste = $utilisateur->select();
    echo $twig->render('utilisateur.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionUtilisateurModif($twig, $db) {
    $form = array();
    if (isset($_GET['id'])) {
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->selectById($_GET['id']);
        if ($unUtilisateur != null) {
            $form['utilisateur'] = $unUtilisateur;
            $role = new Role($db);
            $liste = $role->select();
            $form['roles'] = $liste;
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    }

    if (isset($_POST['btModifier'])) {
        $utilisateur = new Utilisateur($db);
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $role = $_POST['role'];
        $email = $_POST['email'];
        $exec = $utilisateur->update($email, $role, $nom, $prenom);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Echec de la modification des données. ';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification des données réussie. ';
        }
        if (!empty($_POST['inputPassword'])) {
            $p1 = $_POST['inputPassword'];
            $p2 = $_POST['inputPassword2'];
            if ($p1 == $p2) {
                $p1 = password_hash($p1, PASSWORD_DEFAULT);
                $exec = $utilisateur->updateMdp($email, $p1);
                if (!$exec) {
                    $form['valide'] = false;
                    $form['message'] .= 'Echec de la modification du mot de passe';
                } else {
                    $form['valide'] = true;
                    $form['message'] .= 'Modification réussie du mot de passe';
                }
            } else {
                $form['valide'] = false;
                $form['message'] .= 'Echec de la modification du mot de passe';
            }
        }
    } else {
        $form['message'] = 'Utilisateur non précisé';
    }

    echo $twig->render('utilisateur-modif.html.twig', array('form' => $form));
}

function actionInfoUtilisateur($twig, $db) {
    $form = array();
    if (isset($_GET['id_outil'])) {
        $utiliser = new Utiliser($db);
        $delete = $utiliser->deleteO($_GET['id_outil'], $_GET['id_dev']);
        if (!$delete) {
            $form['valide'] = false;
            $form['message'] = "Problème de suppression de l'outil";
        } else {
            $form['valide'] = true;
            $form['message'] = 'Outil supprimé avec succès';
        }
    }

    if (isset($_GET['id_projet'])) {
        $participer = new Participer($db);
        $delete = $participer->deleteP($_GET['id_projet'], $_GET['id_dev']);
        if (!$delete) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression du projet';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Projet supprimé avec succès';
        }
    }

    if (isset($_GET['id'])) {
        $utilisateur = new Utilisateur($db);
        $unUtilisateur = $utilisateur->selectById($_GET['id']);

        if ($unUtilisateur != null) {
            $role = new Role($db);
            $outil = new Outil($db);
            $utiliser = new Utiliser($db);
            $projet = new Projet($db);
            $participer = new Participer($db);

            $listeRole = $role->select();
            $listeOutil = $outil->select();
            $listeUtilisation = $utiliser->select();
            $listeProjet = $projet->select();
            $listeParticiper = $participer->select();

            $form['utilisateur'] = $unUtilisateur;
            $form['role'] = $listeRole;
            $form['outils'] = $listeOutil;
            $form['utiliser'] = $listeUtilisation;
            $form['projet'] = $listeProjet;
            $form['participer'] = $listeParticiper;
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    }
    echo $twig->render('utilisateur_info.html.twig', array('form' => $form));
}

function actionAjoutOutilUtilisateur($twig, $db) {
    $form = array();

    $utilisateur = new Utilisateur($db);
    $outil = new Outil($db);

    $listeU = $utilisateur->select($db);
    $listeO = $outil->select($db);

    $form['utilisateur'] = $listeU;
    $form['outil'] = $listeO;

    if (isset($_POST['btAjouter'])) {
        $utiliser = new Utiliser($db);
        $id_dev = $_POST['id_dev'];
        $id_outil = $_POST['id_outil'];

        $exec = $utiliser->insert($id_dev, $id_outil);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Echec de l\'ajout des données.';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Ajout réussi.';
        }
    }

    echo $twig->render('ajout-outil-utilisateur.html.twig', array('form' => $form));
}
?>

