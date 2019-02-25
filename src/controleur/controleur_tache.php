<?php

function actionTacheModif($twig, $db) {
    $form = array();
    $tache = new Tache($db);

    if (isset($_GET['id'])) {
        $uneTache = $tache->selectById($_GET['id']);

        if ($uneTache != null) {
            $form['tache'] = $uneTache;
        } else {
            $form['message'] = 'Tâche incorrecte';
        }
    } else {
        if (isset($_POST['btModifierT'])) {
            $id = $_POST['id'];
            $libelle = $_POST['inputLibelle'];
            $nbHeureTache = $_POST['inputNbHeureTache'];

            $exec = $tache->update($id, $libelle, $nbHeureTache);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Echec de la modification des tâches';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Modification réussie';
            }
        } else {
            $form['message'] = 'Tâche non précisé';
        }
    }
    echo $twig->render('tache-modif.html.twig', array('form' => $form));
}

function actionConsultationTache($twig, $db) {
    $form = array();
    $tache = new Tache($db);
    $effectuer = new Effectuer($db);
    $utilisateur = new Utilisateur($db);
    $projet = new Projet($db);
    $participer = new Participer($db);

    if (isset($_GET['id'])) {
        $uneTache = $tache->selectById($_GET['id']);
        $unProjet = $projet->selectById($_GET['id_projet']);

        if (isset($_POST['btAjouterUser'])) {
            $id_dev = $_POST['id_dev'];
            $id_tache = $_GET['id'];
            $nbHeures = $_POST['nbHeures'];
            $date_debut = date('Y-m-d');
            $exec = $effectuer->insert($id_dev, $id_tache, $nbHeures, $date_debut);

            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Echec de l\'ajout de l\'utilisateur';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Ajout réussi';
            }
        }

        if (isset($_POST['btTerminer'])) {
            $id = $_GET['id'];
            $cout = $_POST['cout'];
            $nbHeureTache = $_POST['nbHeureTache'];
            $date_fin = date('Y-m-d');
            $termine = 1;
            $exec = $tache->updateCoutetHeures($id, $cout, $nbHeureTache, $date_fin, $termine);

            if (!$exec) {
                $form['termine'] = false;
                $form['message'] = 'Echec de l\'ajout du prix';
            } else {
                $form['termine'] = true;
                $form['message'] = 'Tache terminée';
            }
        }

        if (isset($_POST['btFinParticipation'])) {
            $id = $_GET['id'];
            $date_fin = date('Y-m-d');
            $cocher = $_POST['cocher'];
            $form['finUser'] = true;
            foreach ($cocher as $id_dev) {
                $exec = $effectuer->updateDateFinParticipation($id, $id_dev, $date_fin);
                if (!$exec) {
                    $form['finUser'] = false;
                    $form['message'] = 'Problème de suppression dans la table projet';
                }
            }
        }
        
        if(isset($_GET['id_utilisateur'])){ 
            $exec = $effectuer->delete($_GET['id_utilisateur']);
            if(!$exec){
                $form['valide'] = false;
                $form['message'] = "Probleme de suppression dans la table effectuer";        
            }else{
               $form['valide'] = true;
               $form['message'] = "Suppression réussie";        

            }
            
        }
        $unTravail = $effectuer->select();
        $listeU = $utilisateur->select();
        $listePA = $participer->select();
        $form['tache'] = $uneTache;
        $form['effectuer'] = $unTravail;
        $form['utilisateur'] = $listeU;
        $form['projet'] = $unProjet;
        $form['participer']=$listePA;
    }

    echo $twig->render('consultation_tache.html.twig', array('form' => $form));
}

?>
