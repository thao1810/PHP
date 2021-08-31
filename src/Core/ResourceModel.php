<?php

namespace MVC\Core;

use MVC\config\Database;
use MVC\Core\ResourceModelInterface;
use PDO;

class ResourceModel implements ResourceModelInterface
{
    private $table;
    private $id;
    private $model;

    public function _init($table, $id, $model)
    {
        $this->table = $table;
        $this->id = $id;
        $this->model = $model;
    }
    public function getAll()
    {
        $class = get_class($this->model);
        $sql = "SELECT * FROM $this->table";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, $class);
    }
    public function get($id)
    {
        $class = get_class($this->model);
        $sql = "SELECT * FROM $this->table WHERE $this->id = $id";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        return ($req->fetchObject($class));
    }
    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE $this->id = $id";
        $req = Database::getBdd()->prepare($sql);
        return $req->execute();
    }
    public function save($model)
    {
        $arrData = $model->getProperties();
        $arrKey = [];
        foreach($arrData as $key=>$value)
        {
            array_push($arrKey, $key.' = :'.$key);
        }
        $stringModel = implode(', ', $arrKey);
        if($model->getId() === null)
        {
            $sql = "INSERT INTO $this->table SET $stringModel";
            
        }else {
            $sql = "UPDATE $this->table SET $stringModel WHERE $this->id=:id";
             
        }
        $req = Database::getBdd()->prepare($sql);
        return $req->execute($arrData);

    }

}

?>