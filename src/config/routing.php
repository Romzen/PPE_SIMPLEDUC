<?php
function getPage($db){

// Inscrire vos contrôleurs ici    
$lesPages['accueil'] = "actionAccueil;0";
$lesPages['inscrire'] = "actionInscrire;0";
$lesPages['mentions'] = "actionMentions;0";
$lesPages['connexion'] = "actionConnexion;0";
$lesPages['deconnexion'] = "actionDeconnexion;0";
$lesPages['apropos'] = "actionApropos;0";
$lesPages['maintenance'] = "actionMaintenance;0";
$lesPages['utilisateur'] = "actionUtilisateur;1";
$lesPages['utilisateurmodif'] = "actionUtilisateurModif;1";
$lesPages['equipe'] = "actionEquipe;1";
$lesPages['equipeajout'] = "actionEquipeAjout;1";
$lesPages['equipemodif'] = "actionEquipeModif;1";
$lesPages['equipews'] = "actionEquipeWS;0";
$lesPages['tachemodif'] = "actionTacheModif;1";
$lesPages['outil'] = "actionOutil;0";
$lesPages['entreprise'] = "actionEntreprise;0";
$lesPages['entreprisemodif'] ="actionEntrepriseModif;1";
$lesPages['outil-modif'] = "actionModifOutil;1";
$lesPages['utilisateur_info'] = "actionInfoUtilisateur;1";
$lesPages['ajout-outil-utilisateur'] = "actionAjoutOutilUtilisateur;1";
$lesPages['projet'] = "actionProjet;1";
$lesPages['projetmodif'] = "actionProjetModif;1";
$lesPages['consultation_projet'] = "actionConsultationProjet;1";
$lesPages['contrat'] = "actionContrat;1";
$lesPages['contratmodif']="actionContratModif;1";
$lesPages['ajout-utilisateurprojet']="actionAjoutUtilisateurProjet;1";
$lesPages['ajout-tacheProjet']="actionAjoutTacheProjet;1";
$lesPages['consultation_tache']="actionConsultationTache;1";
$lesPages['consultation_entreprise']="actionConsultationEntreprise;1";
$lesPages['listeprojetpdf'] = "actionListeProjetPdf;1";


if ($db!=null){
  if(isset($_GET['page'])){
    // Nous mettons dans la variable $page, la valeur qui a été passée dans le lien
    $page = $_GET['page']; }
  else{
    // S'il n'y a rien en mémoire, nous lui donnons la valeur « accueil » afin de lui afficher une page
    //par défaut
    $page = 'accueil';
  }

  if (!isset($lesPages[$page])){
    // Nous rentrons ici si cela n'existe pas, ainsi nous redirigeons l'utilisateur sur la page d'accueil
    $page = 'accueil'; 
  }
  
  $explose = explode(";",$lesPages[$page]);
  $role = $explose[1];
  
  // Si le rôle nécessite de contrôler les droits
  if ($role != 0){
      // Nous vérifions que la personne est connectée
      if(isset($_SESSION['login'])){
        //Nous vérifions qu'elle a un rôle
        if(isset($_SESSION['role'])){
            
            if($role!=$_SESSION['role']){
               //Nous redigeons la personne vers la page d'acccueil car elle n'a pas le bon rôle 
               $contenu = 'actionAccueil';  
            }
            else{
               // La personne est autorisée à récupérer  
               $contenu = $explose[0]; 
            }
        }
        else{
           // Dans la session le rôle n'existe pas donc on va sur la page d'accueil 
           $contenu = 'actionAccueil'; 
        }
      }
      else{
        // La personne n'est pas connectée, donc on va sur la page d'accueil  
        $contenu = 'actionAccueil';  
      }
    }else{
      // Nous donnons du contenu non protégé  
      $contenu = $explose[0];   
    }
}
else{
   // La base de données n'est pas accessible
   $contenu = 'actionMaintenance';
}
// La fonction envoie le contenu
return $contenu; 

}
?>