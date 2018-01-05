<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/12/2016
 * Time: 11:23 AM
 */

namespace App\Table;
require_once "Table.php";

class Entitie extends Table
{
    protected static $table = "entites";
    protected static $nom;
    protected static $id;

    public function setNom($nom){
        $this->nom = $nom;
    }
    public function setId($nom){
        $this->id = $nom;
    }
    public static function add($nom){
        $new = new Entitie();
        $new->setNom($nom);
        return self::query("insert into ".self::getNameTable()." 
       (nom) values(?)
       ",false,[$new->nom]);
    }
    public static function findByName($nom){
        $req = self::query("select * from ".self::getNameTable()." where nom = ? ",true,[$nom],true);
        return $req;
    }
    public static function update(Entitie $entitie){
        return self::query("update ".self::getNameTable()." set nom = ? where id = ? ",
            false,[$entitie->nom,$entitie->id]
        );
    }
    
}