<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/12/2016
 * Time: 9:31 AM
 */

namespace App;

use \PDO;
class Database
{
    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $pdo;

    public function __construct($db_name, $db_user = "root", $db_pass = "", $db_host = "localhost")
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
        if($this->pdo === NULL){
            $this->pdo = $this->getDB();
        }
    }
    public function getDB(){
        if($this->pdo === NULL){
            $pdo = new PDO("mysql:dbname=".$this->db_name.";host=".$this->db_host,$this->db_user,$this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }
    public function getPdo()
    {
        return $this->pdo;
    }
    public function query($statment,$attributes = null,$one = false,$fetch = true){
        if($attributes === null)
            $req = $this->getDB()->query($statment);
        else {
            $req = $this->getDB()->prepare($statment);
            $req->execute($attributes);
        }
        $req->setFetchMode(PDO::FETCH_OBJ);
        if($fetch) {
            if ($one) {
                return $req->fetch();
            } else {
                return $req->fetchAll();
            }
        }
    }
}