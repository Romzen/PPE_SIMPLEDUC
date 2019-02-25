<?php

class Entreprise{
    
    private $db;
    private $insert;
    private $select;
    private $selectById;
    private $update;
    private $delete;
    
    public function __construct($db){
        $this->db = $db;
        $this->insert = $db->prepare("insert into entreprise(nom, tel, adresse) values (:nom, :tel, :adresse)");
        $this->select = $db->prepare("select id, nom, tel, adresse from entreprise order by nom");
        $this->selectById = $db->prepare("select * from entreprise where id=:id");
        $this->update = $db->prepare("update entreprise set nom=:nom, tel=:tel, adresse=:adresse where id=:id");
        $this->delete = $db->prepare("delete from entreprise where id=:id");
        
        }
    public function insert($nom, $tel, $adresse){
        $r = true;
        $this->insert->execute(array(':nom'=>$nom, ':tel'=>$tel, ':adresse'=>$adresse));
        if ($this->insert->errorCode()!=0){
             print_r($this->insert->errorInfo());  
             $r=false;
        }
        return $r;
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
    
    public function update($id, $nom, $tel, $adresse){
        $r = true;
        $this->update->execute(array(':id'=>$id, ':nom'=>$nom, ':tel'=>$tel, ':adresse'=>$adresse));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
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
    
}

?>