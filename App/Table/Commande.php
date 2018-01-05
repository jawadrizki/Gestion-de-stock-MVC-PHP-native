<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/16/2016
 * Time: 9:58 AM
 */

namespace App\Table;
use App\App;

App::useTable(["Table","Reception","Commande"]);

class Commande extends Table
{
    protected static $table = "commandes";
    protected static $date;
    protected static $quantite;
    protected static $fournisseur;
    protected static $entite;


    public function setDate($date){
        $this->date = $date;
    }
    
    public function setFournisseur($fournisseur){
        $this->fournisseur = $fournisseur;
    }
    public function setQuantitie($quantite){
        $this->quantite = $quantite;
    }

    public function setEntite($entite)
    {
        $this->entite = $entite;
    }
    public static function add($fournisseur,$qte,$entite,$date){

        $commande = new Commande();
        $commande->setDate($date);
        $commande->setFournisseur($fournisseur);
        $commande->setQuantitie($qte);
        $commande->setEntite($entite);
        $check = self::query("select * from commandes where fournisseur = $fournisseur and entite = $entite",true,null,true);
        if($check !== false){
            $req = Commande::query("select * from commandes where fournisseur = $fournisseur and entite = $entite",true,null,true);
            $v1 = $req->quantite;
            $v2 = self::recu($req->id);
            if($v1 > $v2->qte or $qte > $v1)
                return null;
            //$id = self::findByEntite($entite)->id;
            //self::query("delete from receptions where commande = $id");
            return self::query("insert into commandes (date,quantite,fournisseur,entite) values (?,?,?,?)",
                false,[$commande->date,$commande->quantite,$commande->fournisseur,$commande->entite]);
            //return self::query("update commandes set date = ? , fournisseur = ? , quantite = ?  where id = ? ",
             //   false,[$commande->date,$commande->fournisseur,$commande->quantite,$id]);
        }else{
            return self::query("insert into commandes (date,quantite,fournisseur,entite,date_expiration) values (?,?,?,?,CURRENT_DATE)",
                false,[$commande->date,$commande->quantite,$commande->fournisseur,$commande->entite]);
        }
    }
    public static function recu($commande){
        return Reception::query("select sum(quantite) as qte from receptions where commande = $commande",true,null,true);
    }
    public static function update($qte,$date,$id){
        return self::query("update ".self::getNameTable()." set date = ?, quantite = ?  where id = ? ",
            false,[$date,$qte,$id]
        );
    }

   
    
}