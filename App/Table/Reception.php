<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/12/2016
 * Time: 11:23 AM
 */

namespace App\Table;
use App\App;

App::useTable(["Table","Fournisseur","Commande","Localstock"]);

class Reception extends Table
{
    protected static $table = "receptions";
    protected static $date;
    protected static $fournisseur;
    protected static $quantite;
    protected static $local;
    protected static $commande;

    public function setDate($date){
        $this->date = $date;
    }
    public function setCommande($commande){
        $this->commande = $commande;
    }
    public function setLocal($local){
        $this->local = $local;
    }
    public function setFournisseur($fournisseur){
        $this->fournisseur = $fournisseur;
    }
    public function setQuantitie($quantite){
        $this->quantite = $quantite;
    }
    public static function add($fournisseur,$qte,$local,$date){
        $reception = new Reception();
        $reception->setDate($date);
        $reception->setLocal($local);
        $reception->setFournisseur($fournisseur);
        $reception->setQuantitie($qte);
        $entite = Localsock::find($local)->entite;
        $reception->setCommande(Commande::query("select id from commandes where fournisseur = $fournisseur and entite = $entite",true,null,true)->id);
        $commande = Commande::find($reception->commande)->quantite;
        $v = Commande::recu($reception->commande)->qte;
        if($v == null) $v = 0;
        $date = date("Y-m-d");
        if($commande <= $v + $qte)
            Commande::query("update commandes set date_expiration = '$date' where id = {$reception->commande}");
        else
            Commande::query("update commandes set date_expiration = null where id = {$reception->commande}");
        //self::query("update mesures set mesure = mesure + {$reception->quantite} where entite = {$reception->entite}");
        self::query("update localstock set qte = qte + $qte where id = $local");
       return self::query("insert into ".self::getNameTable()." 
       (date,fournisseur,quantite,local,commande) values(?,?,?,?,?)
       ",false,[$reception->date,$reception->fournisseur,$reception->quantite,$reception->local,$reception->commande]);
    }

    public static function update(Reception $reception){
        //var_dump($reception);
        return self::query("update ".self::getNameTable()." set date = ? , fournisseur = ? , quantite = ? , entite = ? where id = ? ",
        false,[$reception->date,$reception->fournisseur,$reception->quantite,$reception->entite,$reception->id]
            );
    }
}