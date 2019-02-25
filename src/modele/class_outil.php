<?php

class Outil {

    private $db;
    private $select;
    private $insert;
    private $delete;
    private $selectById;
    private $update;

    public function __construct($db) {
        $this->db = $db;
        $this->select = $db->prepare("select * from outils order by libelle");
        $this->insert = $db->prepare("insert into outils(libelle) values(:libelle)");
        $this->delete = $db->prepare("delete from outils where id=:id");
        $this->selectById = $db->prepare("select id, libelle from outils where id=:id ");
        $this->update = $db->prepare("update outils set libelle=:libelle where id=:id");

    }

    public function select() {
        $this->select->execute();
        if ($this->select->errorCode() != 0) {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }

    public function insert($libelle) {
        $r = true;
        $this->insert->execute(array(':libelle' => $libelle));
        if ($this->insert->errorCode() != 0) {
            print_r($this->insert->errorInfo());
            $r = false;
        }
        return $r;
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

    public function selectById($id) {
        $this->selectById->execute(array(':id' => $id));
        if ($this->selectById->errorCode() != 0) {
            print_r($this->selectById->errorInfo());
        }
        return $this->selectById->fetch();
    }

    public function update($id,$libelle){
        $r = true;
        $this->update->execute(array(':id'=>$id, ':libelle'=>$libelle));
        if ($this->update->errorCode()!=0){
             print_r($this->update->errorInfo());  
             $r=false;
        }
        return $r;
    }
}
