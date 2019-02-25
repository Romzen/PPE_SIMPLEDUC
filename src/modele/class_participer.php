<?php

class Participer{
private $db;
private $delete;
private $deleteP;
private $insert;
private $select;

    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select * from participer");
        $this->delete = $db->prepare("delete from participer where id_dev=:id");
        $this->deleteP = $db->prepare("delete from participer where id_projet=:id_projet and id_dev=:id_dev");
        $this->insert = $db->prepare("insert into participer (id_dev, id_projet, responsable) values (:id_dev, :id_projet, :responsable)");
    }
    
    public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
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
    
     public function deleteP($id_projet,$id_dev){
        $r = true;
        $this->deleteP->execute(array(':id_projet'=>$id_projet,':id_dev'=>$id_dev));
        if ($this->deleteP->errorCode()!=0){
             print_r($this->deleteP->errorInfo());  
             $r=false;
        }
        return $r;
    }
     public function insert( $id_dev, $id_projet, $responsable){
        $r = true;
        $this->insert->execute(array(':id_dev'=>$id_dev, ':id_projet'=>$id_projet, ':responsable'=>$responsable));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
}

