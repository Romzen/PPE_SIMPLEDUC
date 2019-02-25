<?php

function actionEntreprise($twig, $db) {
    $form = array();
    $entreprise = new Entreprise($db);

    if (isset($_POST['btAjouterE'])) {
        $nom = $_POST['nom'];
        $tel = $_POST['tel'];
        $adresse = $_POST['adresse'];
        $exec = $entreprise->insert($nom, $tel, $adresse);
        if (!$exec) {
            $form['message'] = 'Problème d\insertion dans la table entreprise.';
        } else {
            $form['message'] = 'Insertion réussie.';
        }
    }
    if (isset($_GET['id'])) {

        $exec = $entreprise->delete($_GET['id']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table entreprise';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Entreprise supprimé avec succès';
        }
    }

    $liste = $entreprise->select();
    echo $twig->render('entreprise.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionEntrepriseModif($twig, $db) {
    $form = array();
    $entreprise = new Entreprise($db);
    if (isset($_GET['id'])) {
        $uneEntreprise = $entreprise->selectById($_GET['id']);

        if ($uneEntreprise != null) {
            $form['entreprise'] = $uneEntreprise;
        } else {
            $form['message'] = 'Entreprise incorrecte';
        }
    } else {
        if (isset($_POST['btModifierE'])) {
            $id = $_POST['id'];
            $nom = $_POST['inputNom'];
            $tel = $_POST['inputTel'];
            $adresse = $_POST['inputAdresse'];
            $exec = $entreprise->update($id, $nom, $tel, $adresse);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] .= 'Echec de la modification des tâches';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Modification réussie';
            }
        } else {
            $form['message'] = 'Entreprise non précisé';
        }
    }
    echo $twig->render('entreprise-modif.html.twig', array('form' => $form));
}

function actionConsultationEntreprise($twig, $db) {
     $form = array();
     $entreprise = new Entreprise($db);
     $contrat = new Contrat($db);
     $projet = new Projet($db);

    if (isset($_GET['id'])) {
        $uneEntreprise = $entreprise->selectById($_GET['id']);
      
        $form['entreprise']= $uneEntreprise;
        $form['valide'] = true;
 
    }else {
        $form['valide']=false;
        $form['message']='entreprise non disponible';
    }

    $liste = $contrat->select();
    $listeP = $projet->select();

    echo $twig->render('consultation_entreprise.html.twig', array('form' => $form, 'liste' => $liste,'listeP'=>$listeP));
}
?>

