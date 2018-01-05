<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/16/2016
 * Time: 8:36 PM
 */

namespace App\Table;
require_once "Table.php";

class Consommation extends Table
{
    protected static $table = "consommations";
    protected static $date;
    protected static $quantite;
    protected static $entite;
    protected static $oldquantite;

    public function __construct($date = false,$quantite = false,$entite = false,$oldquantite = false)
    {
        if($date and $quantite and $entite) {
            $this->setDate($date);
            $this->setEntitie($entite);
            $this->setQuantite($quantite);
            $this->setOldquantite($oldquantite);
        }
    }

    public function setDate($date){
        $this->date = $date;
    }
    public function setEntitie($entite){
        $this->entite = $entite;
    }
    public function setQuantite($quantite){
        $this->quantite = $quantite;
    }

    public function setOldquantite($oldquantite)
    {
        $this->oldquantite = $oldquantite;
    }
    public static function add(Consommation $consommation){
        return self::query("insert into ".self::getNameTable()." 
       (date,quantite,entite) values(?,?,?)
       ",false,[@$consommation->date,@$consommation->quantite,@$consommation->entite]);
    }
    public static function update(Consommation $consommation){
        return self::query("update consommations set date = ? , quantite = ? , entite = ?, oldquantite = ? where id = ? ",
            false,[@$consommation->date,@$consommation->quantite,@$consommation->entite,@$consommation->oldquantite,@$consommation->id]
        );
    }
}