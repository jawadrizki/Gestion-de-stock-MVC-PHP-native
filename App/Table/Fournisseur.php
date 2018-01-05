<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/12/2016
 * Time: 11:22 AM
 */

namespace App\Table;

use App\App;

App::useTable(["Table","Commande","Entite"]);

class Fournisseur extends Table
{
    protected static $table = "fournisseurs";
    protected $nom;
    protected $id;


    public function setNom($nom){
        $this->nom = $nom;
    }
    public function setId($id){
        $this->id = $id;
    }

    public static function add($nom){
        $fournisseur = new Fournisseur();
        $fournisseur->setNom($nom);
        $add = self::query("insert into ".self::getNameTable()." 
       (nom) values(?)
           ",false,[$fournisseur->nom]);
        return $add;
    }
    public static function update($nom,$id){
        $fournisseur = new Fournisseur();
        $fournisseur->setNom($nom);
        $fournisseur->setId($id);
        return self::query("update ".self::getNameTable()." set nom = ? where id = ? ",
            false,[$fournisseur->nom,$fournisseur->id]
        );
    }

    /*
    public function getActualCommande(){
        return self::query("select * from commandes where fournisseur = ? and id in(select max(id) from commandes where fournisseur = ?)",true,[$this->id,$this->id],true)->quantite;
    }
    public function getStatueCommande(){
        $actual = self::query("select sum(quantite) as quantite from receptions where commande in(select actualcommande from fournisseurs where id = ?)",true,[$this->id],true)->quantite;
        if($this->getActualCommande() - $actual < 0 ){
            return "Hors commande";
        }else{
            return $this->getActualCommande() - $actual;
        }
    }
    */
}