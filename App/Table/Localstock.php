<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/20/2016
 * Time: 4:36 PM
 */

namespace App\Table;
use App\App;
if(!isset($_POST['get']))
    require_once "C:/xampp/htdocs/ocp_gs/App/App.php";
App::useTable(["Table"]);

class Localsock extends Table
{
    protected static $table = "localstock";
    protected  $nom;
    protected  $type;
    protected  $hauteur;
    protected  $entite;
    protected  $surface_base;
    protected  $masse_volumique;
    protected  $qte;
    protected  $capacite;
    protected  $stockmin;
    protected  $id;


    public function setNom($nom){$this->nom = $nom;}

    public function setId($id){$this->id = $id;}

    public function setCapacite($capacite){$this->capacite = $capacite;}

    public  function setHauteur($hauteur){$this->hauteur = $hauteur;}

    public  function setMasseVolumique($masse_volumique){$this->masse_volumique = $masse_volumique;}

    public  function setQte($qte){$this->qte = $qte;}

    public  function setSurfaceBase($surface_base){$this->surface_base = $surface_base;}

    public  function setType($type){$this->type = $type;}

    public function setEntite($entite){$this->entite = $entite;}

    public function setStockmin($stockmin){$this->stockmin = $stockmin;}

    public static function add($nom,$type,$hauteur,$entite,$surface_base,$masse_volumique,$qte,$capacite,$stockmin){
        return self::query("insert into ".self::getNameTable()." 
       (nom,type,entite,hauteur,base_surface,mv,qte,capacite,stockmin) values(?,?,?,?,?,?,?,?,?)
       ",false,[$nom,$type,$entite,$hauteur,$surface_base,$masse_volumique,$qte,$capacite,$stockmin]);
    }
    public static function update(Localsock $localsock){
        return self::query("update ".self::getNameTable()." set 
        nom = ?,
        type = ?,
        hauteur = ?,
        base_surface = ?,
        mv = ?,
        capacite = ?,
        stockmin = ?
        where id = ? ",
            false,[$localsock->nom,$localsock->type,$localsock->hauteur,$localsock->surface_base,$localsock->masse_volumique,$localsock->capacite,$localsock->stockmin,$localsock->id]
        );
    }
    public static function updateQte($local,$qte){
        return self::query("update localstock set qte = ? where id = ?",false,[$qte,$local]);
    }
    public static function qteActuel($entite){
        $req = self::query("select sum(qte) as qte from localstock where entite = ?",true,[$entite],true);
        return $req->qte;
    }
    
}