<?php

/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/12/2016
 * Time: 10:38 AM
 */
namespace App\Table;
include_once "C:/xampp/htdocs/ocp_gs/App/Database.php";
include_once "C:/xampp/htdocs/ocp_gs/App/App.php";
use App\App;
use App\Database;
use PDO;
class Table
{
    protected static $table;


    public static function getNameTable(){
        if(static::$table === null){
            $name = explode("\\",get_called_class());
            $name_class = end($name);
            static::$table = strtolower($name_class)."s";
        }
        return static::$table;
    }
    public static function query($statment,$fetch = false,$attributes = null,$one = false){
        $conn = new Database("stock");
        $db = $conn->getPdo();
        if($attributes === null)
            $req = $db->query($statment);
        else {
            $req = $db->prepare($statment);
            $req->execute($attributes);
        }
        if($fetch) {
            $req->setFetchMode(PDO::FETCH_CLASS, get_called_class());
            if ($one) {
                return $req->fetch();
            } else {
                return $req->fetchAll();
            }
        }
    }
    public static function find($id){
        $req = self::query("select * from ".self::getNameTable()." where id = ? ",true,[$id],true);
        if(!$req) return null;
        return $req;
    }
    public static function findByEntite($id){
        $req = self::query("select * from ".self::getNameTable()." where entite = ? ",true,[$id],true);
        return $req;
    }
    public static function all(){
        $req = self::query("select * from ".self::getNameTable(),true);
        return $req;
    }
    public static function delete($id){
        return self::query("delete from ".self::getNameTable()." where id = ? ",false,[$id]);
    }
    public static function getLast(){
        return self::query("select * from ".self::getNameTable()." where id = (select max(id) from ".self::getNameTable().")",true,null,true);
    }
    public static function findByDate($date){
        $req = self::query("select * from ".self::getNameTable()." where date = ? ",true,[$date]);
        return $req;
    }
    public static function existe($id){
        if(self::find($id) === null){
            App::alert("<span class='glyphicon glyphicon-alert'> Source introuvable !</span>");
            return false;
        }else{
            return true;
        }
    }
    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->$name;
    }
}