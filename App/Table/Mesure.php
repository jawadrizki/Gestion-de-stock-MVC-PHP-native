<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/12/2016
 * Time: 11:22 AM
 */

namespace App\Table;
use App\App;

App::useTable(["Table","Entite","Consommation"]);
use App\Table\Entitie;
class Mesure extends Table
{
    protected static $table = "mesures";
    protected static $date;
    protected static $mesure;
    protected static $consommation;
    protected static $datec;
    protected static $localstock;

    public function setDate($date){
        $this->date = $date;
    }

    public function setMesure($mesure){
        $this->mesure = $mesure;
    }
    public function setConsommation($consommation){
        $this->consommation = $consommation;
    }
    public function setDatec($datec){
        $this->datec = $datec;
    }
    public function setLocalstock($localstock){
        $this->localstock = $localstock;
    }
    public static function add($values){
        self::query("update localstock set qte = ? where id = ?",false,[$values['mesure'],$values['localstock']]);
        return self::query("insert into mesures 
        (mesure,date,localstock,consommation,datec) VALUES 
        (?,?,?,?,?)
        ",false,
            [$values['mesure'],$values['date'],$values['localstock'],$values['consommation'],$values['datec']]
            );

    }
    public static function update(Mesure $mesure){
        
        return self::query("update ".self::getNameTable()." set date = ? , mesure = ? , consommation = ?, datec = ?, localstock = ? where id = ? ",
            false,[$mesure->date,$mesure->mesure,$mesure->consommation,$mesure->datec,$mesure->localstock,$mesure->id]
        );
    }
    public static function getLastByLocal($local){
        return self::query("select * from mesures where localstock = $local order by id desc limit 1",true,null,true);
    }

}