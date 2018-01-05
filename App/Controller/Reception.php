<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/20/2016
 * Time: 5:43 PM
 */

namespace App\Controller;


use App\App;
use App\Table\Entitie;
use App\Table\Localsock;

class Reception
{
    public static function addForm($commande){
        //////  names : fournisseur, qte,entite
        $commande = \App\Table\Commande::find($commande);
        $fournisseur = \App\Table\Fournisseur::find($commande->fournisseur);
        $date = date("Y-m-d");
        $html = "
        <form method='post'>
        <table class='table'>
        <tr><td>Fournisseur</td>
        <td><input value='{$fournisseur->nom}' readonly><input type='hidden' value='{$fournisseur->id}' name='fournisseur'>
        <input type='hidden' value='{$commande->entite}' name='entite'>
        <a href='?page=commande' style='text-decoration: none;float: right'><span class='glyphicon glyphicon-remove'></span></a></td></tr>
        <tr><td>Date :</td><td><input type='date' value='$date' name='date' required></td></tr>
        <tr><td>Quantite</td><td><input type='number' min='0' name='qte' required>
        <select name='local'>
        ";
        foreach (\App\Table\Localsock::all() as $local){
            $entite = Entitie::find($local->entite)->nom;
            if($local->entite != $commande->entite) continue;
            $html.="<option value='{$local->id}'>{$local->nom} de {$entite}</option>";
        }
        $html.="
</select>
        </td></tr>
        <tr><td colspan='2'><input type='submit' class='btn btn-primary' value='ajouter' name='add'></td></tr>
        </table>
        </form>
        ";
        return $html;
    }
    public static function getPostValues(){
        if(@$_POST['add']){
            $errors = [];
            $i = 0;
            $test1 = false;
            $test2 = false;
            foreach (\App\Table\Commande::query("select distinct entite, quantite from commandes where fournisseur = {$_POST['fournisseur']}",true) as $commande){
                if($commande->entite == $_POST['entite'] and floatval($commande->quantite) >= floatval($_POST['qte'])){
                    $test1 = true;
                    break;
                }
            }
            $local = Localsock::find($_POST['local']);
            if($local == false)
                return null;
            $stock = $local->qte;
            $capacite = $local->capacite;
            if(
                ($_POST['qte'] === 0 or $_POST['qte'] === "" or $_POST['qte'] === null)
                or $test1 === false
                or $_POST['qte'] > ($capacite - $stock)
                or $capacite == $stock
            ){
                if  ($_POST['qte'] > ($capacite - $stock)) {$errors[$i] = "la quantite depasse la capacite de local";$i++;}
                if($capacite == $stock) {$errors[$i] = "Le locale choisi est plein";$i++;}
                if($test1 === false) {$errors[$i] = "La quantite depasse la commande";$i++;}
                if($errors != [])
                    App::showErrors($errors);
                return null;
            }else{
                
                return ["fournisseur" => $_POST['fournisseur'],"qte" => $_POST['qte'],"local" => $_POST['local'],"date" => $_POST['date']];
            }
            
        }
    }
    public static function delete($id){
        $local = Localsock::find(\App\Table\Reception::find($_GET['id'])->local);
        $qte = \App\Table\Reception::find($id)->quantite;
        Localsock::query("update localstock set qte = qte - $qte where id = {$local->id}");
        \App\Table\Reception::delete($id);
    }
}