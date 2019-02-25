<?php

class Projet {

    private $db;
    private $select;
    private $selectById;
    private $delete;
    private $insert;
    private $update;
    private $updateT;

    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * from projet");
        $this->selectById = $db->prepare("select * from projet where id=:id");
        $this->delete = $db->prepare("delete from projet where id=:id");
        $this->insert = $db->prepare("insert into projet (libelle, id_contrat, date_debut) values (:libelle, :id_contrat, :date_debut)");
        $this->update = $db->prepare("update projet set libelle=:libelle, id_contrat=:id_contrat, date_debut=:date_debut, date_fin=:date_fin where id=:id");
        $this->updateT = $db->prepare("update projet set date_fin=:date_fin, cout=:cout, termine=:termine where id=:id");
    }

    public function selectById($id) {
        $this->selectById->execute(array(':id' => $id));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function select() {
        $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
    
    public function delete($id) {
        $r = true;
        $this->delete->execute(array(':id' => $id));
        if ($this->delete->errorCode() != 0) {
            print_r($this->delete->errorInfo());
            $r = false;
        }
        return $r; 
    }
    
     public function insert( $libelle, $id_contrat, $date_debut){
        $r = true;
        $this->insert->execute(array(':libelle'=>$libelle, ':id_contrat'=>$id_contrat, ':date_debut'=>$date_debut));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
        public function update($id, $libelle, $id_contrat, $date_debut, $date_fin){
        $r = true;
        $this->update->execute(array(':id'=>$id, ':libelle'=>$libelle, ':id_contrat'=>$id_contrat, ':date_debut'=>$date_debut, ':date_fin'=>$date_fin));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function updateT($id,$date_fin, $cout, $termine){
        $r = true;
        $this->updateT->execute(array(':id'=>$id, ':date_fin'=>$date_fin,':cout'=>$cout,':termine'=>$termine));
        if ($this->updateT->errorCode()!=0){
             print_r($this->updateT->errorInfo());  
             $r=false;
        }
        return $r;
    }

}
