<?php

function actionProjet($twig, $db) {
    $form = array();
    $projet = new Projet($db);
    $participer = new Participer($db);
    $utilisateur = new Utilisateur($db);
    $leContrat = new Contrat($db);

    if (isset($_POST['btAjouter'])) {
        $libelle = $_POST['libelle'];
        $id_contrat = $_POST['id_contrat'];
        $date_debut = $_POST['date_debut'];


        $exec = $projet->insert($libelle, $id_contrat, $date_debut);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = "Problème d'insertion";
        } else {
            $form['valide'] = true;
            $form['message'] = "Insertion réussie";
        }
    }

    if (isset($_GET['id'])) {

        $exec = $projet->delete($_GET['id']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression du Projet ';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Projet supprimé avec succès';
        }
    }

    if (isset($_POST['btSupprimer'])) {

        $cocher = $_POST['cocher'];
        $form['valide'] = true;
        foreach ($cocher as $id) {
            $exec = $projet->delete($id);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression dans la table projet';
            }
        }
    }
    if (isset($_POST['btTerminer'])) {
        $date_fin = date('Y-m-d');
        $cocher = $_POST['cocher'];
        $form['valide'] = true;
        foreach ($cocher as $id) {
            $exec = $projet->updateT($id, $date_fin);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression dans la table projet';
            }
        }
    }

    $liste = $projet->select();
    $listeU = $utilisateur->select();
    $listeC = $leContrat->select();


    echo $twig->render('projet.html.twig', array('form' => $form, 'liste' => $liste, 'listeU' => $listeU, 'listeC' => $listeC));
}

function actionProjetModif($twig, $db) {
    $form = array();
    $projet = new Projet($db);

    if (isset($_GET['id'])) {
        $uneProjet = $projet->selectById($_GET['id']);

        if ($uneProjet != null) {
            $form['projet'] = $uneProjet;
        } else {
            $form['message'] = 'Projet incorrecte';
        }
    } else {
        if (isset($_POST['btModifierP'])) {
            $id = $_POST['id'];
            $libelle = $_POST['inputLibelle'];
            $id_contrat = $_POST['inputIdContrat'];
            $date_debut = $_POST['inputDateDebut'];
            $date_fin = $_POST['inputDateFin'];

            $exec = $projet->update($id, $libelle, $id_contrat, $date_debut, $date_fin);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] .= 'Echec de la modification des projets';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Modification réussie';
            }
        } else {
            $form['message'] = 'Projet non précisé';
        }
    }
    echo $twig->render('projet-modif.html.twig', array('form' => $form));
}

function actionConsultationProjet($twig, $db) {
    $form = array();
    $participation = new Participer($db);
    $utilisateur = new Utilisateur($db);
    $tache = new Tache($db);
    $effectuer = new Effectuer($db);
    $projet = new Projet($db);

    if (isset($_GET['id'])) {

        $unProjet = $projet->selectById($_GET['id']);

        if ($unProjet != null) {

            if (isset($_POST['btAjouterUser'])) {
                $id_dev = $_POST['id_dev'];
                $id_projet = $_GET['id'];
                if (isset($_POST['responsable'])) {
                    $responsable = 1;
                } else {
                    $responsable = 0;
                }
                $insertUser = $participation->insert($id_dev, $id_projet, $responsable);


                if (!$insertUser) {
                    $form['message'] = 'Ajout impossible';
                } else {
                    $form['message'] = 'Ajout réussi';
                }
            }
        } else {
            $form['message'] = 'Projet incorrect';
        }

        if (isset($_GET['id_dev'])) {
            $id_dev = $_GET['id_dev'];
            $id_projet = $_GET['id'];
            $exec = $participation->deleteP($id_projet, $id_dev);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression dans la table participer';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Participation supprimée avec succès';
            }
        }

        if (isset($_GET['id_tache'])) {
            $id = $_GET['id_tache'];
            $exec = $tache->delete($id);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression dans la table participer';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Participation supprimée avec succès';
            }
        }

        if (isset($_POST['btTerminer'])) {
            $id = $_GET['id'];
            $date_fin = date('Y-m-d');
            $cout = $_POST['cout'];
            $termine = 1;
            $exec = $projet->updateT($id, $date_fin, $cout, $termine);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème de suppression dans la table projet';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Projet terminé.';
            }
        }

        $uneParticipation = $participation->select();
        $unUtilisateur = $utilisateur->select();
        $uneTache = $tache->select();
        $uneRepartition = $effectuer->select();

        $form['effectuer'] = $uneRepartition;
        $form['projet'] = $unProjet;
        $form['participer'] = $uneParticipation;
        $form['utilisateur'] = $unUtilisateur;
        $form['tache'] = $uneTache;
    }

    echo $twig->render('consultation_projet.html.twig', array('form' => $form));
}

function actionAjoutUtilisateurProjet($twig, $db) {
    $form = array();
    if (isset($_GET['id'])) {
        $projet = new Projet($db);
        $utilisateur = new Utilisateur($db);
        $participation = new Participer($db);

        $liste = $utilisateur->select();
        $unProjet = $projet->selectById($_GET['id']);

        if (isset($_POST['btAjouterUser'])) {
            $id_dev = $_POST['id_dev'];
            $id_projet = $_GET['id'];
            if (isset($_POST['responsable'])) {
                $responsable = 1;
            } else {
                $responsable = 0;
            }
            $insertUser = $participation->insert($id_dev, $id_projet, $responsable);

            if (!$insertUser) {
                $form['valide'] = false;
                $form['message'] = 'Ajout impossible';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Ajout réussi';
            }
        }
        $form['projet'] = $unProjet;
    } else {
        $form['message'] = 'Pas de projet';
    }
    echo $twig->render('ajout-utilisateurProjet.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionAjoutTacheProjet($twig, $db) {
    $form = array();
    if (isset($_GET['id'])) {
        $projet = new Projet($db);
        $tache = new Tache($db);

        $unProjet = $projet->selectById($_GET['id']);

        if (isset($_POST['btAjouterTache'])) {
            $libelle = $_POST['libelle'];
            $nbHeureTache = $_POST['nbHeureTache'];
            $id_projet = $_GET['id'];
            $date_debut = date('Y-m-d');

            $insertTache = $tache->insert($libelle, $nbHeureTache, $id_projet, $date_debut);

            if (!$insertTache) {
                $form['valide'] = false;
                $form['message'] = 'Ajout impossible';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Ajout réussi';
            }
        }
        $form['projet'] = $unProjet;
    } else {
        $form['message'] = 'Pas de projet';
    }
    echo $twig->render('ajout-tacheProjet.html.twig', array('form' => $form));
}

function actionListeProjetPdf($twig, $db) {
    $projet = new Projet($db);
    $contrat = new Contrat($db);
    $liste = $unProjet = $projet->select();
    $listeC = $contrat->select();
    $html = $twig->render('projet-liste-pdf.html.twig', array('liste' => $liste, 'listeC'=>$listeC)); // Nous envoyons notre liste de produit dans le moteur de template TWIG.
    try {
        ob_end_clean(); // Cette commande s'assure de ne pas envoyer de données avant le fichier PDF
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'fr'); // Création d'une page au format A4 de langue française orienté en mode portrait.
        $html2pdf->writeHTML($html); //Nous écrivons le résultat de twig dans la variable html2pdf
        $html2pdf->output('listedesprojets.pdf'); // Nous écrivons dans un fichier PDF nommé listedesproduits
    } catch (Html2PdfException $e) {
        echo 'erreur ' . $e;
    }
}
