<?php
 
function actionContrat($twig, $db){
    $form = array();
    $contrat = new Contrat($db);
    $entreprise = new Entreprise ($db);
    $partiper = new Participer($db);
    $projet = new Projet($db);
    $tache = new Tache($db);
   

    if(isset($_POST['btAjouterC'])){
        $intitule = $_POST['intitule'];
        $paiement = $_POST['paiement'];
        $id_entreprise = $_POST['id_entreprise'];
        $date_contrat = date('Y-m-d');
        $exec = $contrat->insert($intitule,$paiement,$id_entreprise,$date_contrat);
        if(!$exec){
            $form['message']='Problème d\insertion dans la table contrat.';
        }
        else{
            $form['message']='Insertion réussie.';
        }
    }
   
    if(isset($_GET['numCont'])){
        $exec=$contrat->delete($_GET['numCont']);
        
        if (!$exec && $deleteP && $deletePa){
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table contrat';
        }
        else{
            $form['valide'] = true;
        }
        $form['message'] = 'Contrat supprimée avec succès';
     }
     $unProjet = $projet->select();
     $form['projet'] = $unProjet;
     
     $uneParticipation = $partiper->select();
     $form['participer'] = $uneParticipation;
     
     $uneTache = $tache->select();
     $form['tache'] = $uneTache;
   
    
    $liste = $contrat->select();
    $listeContratPS = $contrat->selectPourSupp();
    $liste_e = $entreprise->select();
    
  
    echo $twig->render('contrat.html.twig', array('form'=>$form,'liste'=>$liste,'liste_e'=>$liste_e, 'listeContratPS'=>$listeContratPS));
}
function actionContratModif($twig, $db){
    $form = array();  
    $contrat = new Contrat($db);
   
    if(isset($_GET['numCont'])){
        $unContrat = $contrat->selectById($_GET['numCont']);  
       
        if ($unContrat!=null){
            $form['contrat'] = $unContrat;
           
        }
        else{
            $form['message'] = 'Contrat incorrecte';  
        }
    }
    else{
        if(isset($_POST['btModifierC'])){
          $numCont = $_POST['numCont'];
          $intitule = $_POST['inputIntitule'];  
          $paiement = $_POST['inputPaiement'];
         
         
          $exec = $contrat->update($numCont, $intitule, $paiement);
          if(!$exec){
                $form['valide'] = false;  
                $form['message'] = 'Echec de la modification des contrats';
          }
          else{
            $form['valide'] = true;  
            $form['message'] = 'Modification réussie';  
          }
         
        }
        else{
            $form['message'] = 'Contrat non précisé';
        }    
     
    }
    echo $twig->render('contrat-modif.html.twig', array('form'=>$form));
}
 
?>