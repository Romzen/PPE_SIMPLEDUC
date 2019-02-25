<?php

class Effectuer {

    private $db;
    private $delete;
    private $insert;
    private $update;
    private $updateDateFinParticipation;

    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * from effectuer");
        $this->delete = $db->prepare("delete from effectuer where id_dev=:id");
        $this->insert = $db->prepare("insert into effectuer(id_dev, id_tache, nbHeures, date_debut) values (:id_dev, :id_tache, :nbHeures, :date_debut)");
        $this->update = $db->prepare("update effectuer set date_fin=:date_fin where id_tache=:id");
        $this->updateDateFinParticipation = $db->prepare('update effectuer set date_fin=:date_fin where id_tache=:id and id_dev=:id_dev');
        
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

    public function select() {
        $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
    
    public function insert($id_dev, $id_tache, $nbHeures, $date_debut){
        $r = true;
        $this->insert->execute(array(':id_dev'=>$id_dev, ':id_tache'=>$id_tache, ':nbHeures'=>$nbHeures, ':date_debut'=>$date_debut));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function update($id ,$date_fin){
        $r = true;
        $this->update->execute(array(':id'=>$id, ':date_fin'=>$date_fin));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
    public function updateDateFinParticipation($id ,$id_dev,$date_fin){
        $r = true;
        $this->updateDateFinParticipation->execute(array(':id'=>$id,':id_dev'=>$id_dev, ':date_fin'=>$date_fin));
        if ($this->updateDateFinParticipation->errorCode()!=0){
             print_r($this->updateDateFinParticipation->errorInfo());  
             $r=false;
        }
        return $r;
    }

}
