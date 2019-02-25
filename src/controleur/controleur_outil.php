<?php

function actionOutil($twig, $db) {
    $outil = new Outil($db);

    if (isset($_POST['btAjouter'])) {
        $libelle = $_POST['libelle'];
        $exec = $outil->insert($libelle);
        if (!$exec) {
            $form['message'] = 'Problème d\insertion dans la table outil.';
        } else {
            $form['message'] = 'Insertion réussie.';
        }
    }

    if (isset($_GET['id'])) {
        $exec = $outil->delete($_GET['id']);

        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Utilisateur supprimé avec succès';
        }
    }

    $liste = $outil->select();
    echo $twig->render('outil.html.twig', array('liste' => $liste));
}

function actionModifOutil($twig, $db) {
    $form = array();
    $outil = new Outil($db);
    if (isset($_GET['id'])) {
        
        $unOutil = $outil->selectById($_GET['id']);

        if ($unOutil != null) {
            $form['outil'] = $unOutil;
        } else {
            $form['message'] = 'Outil incorrect';
        }
    }
    if (isset($_POST['btModifier'])) {
        $id = $_POST['id'];
        $libelle = $_POST['libelle'];
        $exec = $outil->update($id, $libelle);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Echec de la modification des données. ';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Modification des données réussie. ';
        }
    } else {
        $form['message'] = 'Outil non précisé';
    }

    echo $twig->render('outil-modif.html.twig', array('form' => $form));
}
