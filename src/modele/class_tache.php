<?php

class Tache{
    
    private $db;
    private $select;
    private $selectById;
    private $delete;
    private $update;
    private $updateCout;
    private $insert;
  
    
    public function __construct($db){
        $this->db = $db;  
        $this->select = $db->prepare("select * from tache ");
        $this->selectById = $db->prepare("select id, libelle, nbHeureTache, termine from tache where id=:id order by libelle");
        $this->delete = $db->prepare("delete from tache where id=:id");
        $this->update = $db->prepare("update tache set libelle=:libelle, nbHeureTache=:nbHeureTache where id=:id");
        $this->updateCoutetHeures = $db->prepare("update tache set cout=:cout, nbHeureTache=:nbHeureTache, date_fin=:date_fin, termine=:termine where id=:id");
        $this->insert = $db->prepare("insert into tache(libelle, nbHeureTache, id_projet, date_debut) values(:libelle, :nbHeureTache, :id_projet, :date_debut)");
    }
      
    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    public function selectById($id){
        $this->selectById->execute(array(':id'=>$id));
        if ($this->selectById->errorCode()!=0){
             print_r($this->selectById->errorInfo());  
        }
        return $this->selectById->fetch();
    }
    
    public function delete($id){
        $r = true;
        $this->delete->execute(array(':id'=>$id));
        if ($this->delete->errorCode()!=0){
             print_r($this->delete->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function update($id, $libelle, $nbHeureTache){
        $r = true;
        $this->update->execute(array(':id'=>$id, ':libelle'=>$libelle, ':nbHeureTache'=>$nbHeureTache));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
     public function updateCoutetHeures($id, $cout, $nbHeureTache, $date_fin, $termine){
        $r = true;
        $this->updateCoutetHeures->execute(array(':id'=>$id, ':cout'=>$cout, ':nbHeureTache'=>$nbHeureTache, ':date_fin'=>$date_fin, ':termine'=>$termine));
        if ($this->updateCoutetHeures->errorCode()!=0){
             print_r($this->updateCoutetHeures->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function insert($libelle, $nbHeureTache, $id_projet, $date_debut){
        $r = true;
        $this->insert->execute(array(':libelle'=>$libelle, ':nbHeureTache'=>$nbHeureTache, ':id_projet'=>$id_projet, ':date_debut'=>$date_debut));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }    
}

