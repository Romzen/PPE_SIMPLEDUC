<?php
 
class Contrat {
 
    private $db;
    private $select;
    private $selectById;
    private $insert;
    private $delete;
    private $update;
    private $deleteP;
    private $selectPourSupp;
    private $selectByEntreprise;

 
    public function __construct($db) {
       
        $this->db = $db;
        $this->select = $db->prepare("select * from contrat");
        $this->selectByEntreprise = $db->prepare("SELECT c.intitule, c.paiement, e.nom FROM contrat c inner join entreprise e on c.id_entreprise = e.id WHERE e.id =:id");
        $this->selectById = $db->prepare("select numCont, intitule, paiement from contrat where numCont=:numCont order by intitule");
        $this->insert = $db->prepare("insert into contrat(intitule, paiement, id_entreprise, date_contrat) values(:intitule, :paiement, :id_entreprise, :date_contrat)");
        $this->delete = $db->prepare("delete from contrat where numCont=:numCont");
        $this->update = $db->prepare("update contrat set intitule=:intitule, paiement=:paiement where numCont=:numCont");
        $this->deleteP = $db->prepare("delete from projet where id_contrat=:numCont");
        $this->selectPourSupp = $db->prepare("select c.*, p.* from contrat c inner join projet p ");
       
    }
 
    public function select() {
        $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
   
    public function selectById($numCont){
        $this->selectById->execute(array(':numCont'=>$numCont));
        if ($this->selectById->errorCode()!=0){
             print_r($this->selectById->errorInfo());  
        }
        return $this->selectById->fetch();
    }
    
    public function selectByEntreprise($id){
        $this->selectByEntreprise->execute(array(':id'=>$id));
        if ($this->selectByEntreprise->errorCode()!=0){
             print_r($this->selectByEntreprise->errorInfo());  
        }
        return $this->selectByEntreprise->fetch();
    }
   
    public function insert($intitule, $paiement, $id_entreprise, $date_contrat){
        $r = true;
        $this->insert->execute(array(':intitule'=>$intitule, ':paiement'=>$paiement, ':id_entreprise'=>$id_entreprise, ':date_contrat'=>$date_contrat));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
   
    public function delete($numCont){
        $r = true;
        $this->delete->execute(array(':numCont'=>$numCont));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }
   
    public function update($numCont, $intitule, $paiement){
        $r = true;
        $this->update->execute(array(':numCont'=>$numCont, ':intitule'=>$intitule, ':paiement'=>$paiement));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function deleteP($numCont) {
        $r = true;
        $this->deleteP->execute(array(':numCont' => $numCont));
        if ($this->deleteP->errorCode() != 0) {
            print_r($this->deleteP->errorInfo());
            $r = false;
        }
        return $r; 
    }
    
     public function selectPourSupp(){
        $this->selectPourSupp->execute();
        if ($this->selectPourSupp->errorCode()!=0){
             print_r($this->selectPourSupp->errorInfo());  
        }
        return $this->selectPourSupp->fetchAll();
    }
    
  
}