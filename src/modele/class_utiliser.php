<?php

class Utiliser{
private $db;
private $delete;
private $deleteO;
private $select;
private $insert;

    public function __construct($db){
        $this->db = $db;
        $this -> select = $db->prepare("select * from utiliser");
        $this -> selectbyIdOutil = $db->prepare("select * from utiliser where id_outil=:id_outil");
        $this->delete = $db->prepare("delete from utiliser where id_dev=:id");
        $this->deleteO = $db->prepare("delete from utiliser where id_outil=:id_outil and id_dev =:id_dev");
        $this->insert = $db->prepare("insert into utiliser (id_dev, id_outil) values(:id_dev, :id_outil)");
        
    }
    
     public function select(){
        $this->select->execute();
        if ($this->select->errorCode()!=0){
             print_r($this->select->errorInfo());  
        }
        return $this->select->fetchAll();
    }
    
    public function selectbyIdOutil($id_outil){ 
        $this->selectbyIdOutil->execute(array(':id_outil'=>$id_outil)); 
        if ($this->selectbyIdOutil->errorCode()!=0){
            print_r($this->selectbyIdOutil->errorInfo()); 
            
        }
        return $this->selectbyIdOutil->fetch(); 
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
    
    public function deleteO($id_outil, $id_dev){
        $r = true;
        $this->deleteO->execute(array(':id_outil'=>$id_outil, ':id_dev'=>$id_dev));
        if ($this->deleteO->errorCode()!=0){
             print_r($this->deleteO->errorInfo());  
             $r=false;
        }
        return $r;
    }

     public function insert($id_dev, $id_outil){
        $r = true;
        $this->insert->execute(array(':id_dev'=>$id_dev, ':id_outil'=>$id_outil));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
    }
    
}

