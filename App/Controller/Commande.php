<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/20/2016
 * Time: 5:41 PM
 */

namespace App\Controller;


require_once "C:/xampp/htdocs/ocp_gs/App/Table/Fournisseur.php";
require_once "C:/xampp/htdocs/ocp_gs/App/Table/Entite.php";



class Commande
{
    public static function addForm(){
        //////  names : fournisseur, qte,entite
        $date = date("Y-m-d");
        $html = "
        <form method='post'>
        <table class='table'>
        <tr><td>Fournisseur</td>
        <td><select name='fournisseur'>
        ";
        foreach (\App\Table\Fournisseur::all() as $fournisseur)
            $html.="<option value='{$fournisseur->id}'>{$fournisseur->nom}</option>";
        $html.="
        </select>
        
        <a href='?page=commande' style='text-decoration: none;float: right'><span class='glyphicon glyphicon-remove'></span></a></td></tr>
        <tr><td>Date :</td><td><input type='date' value ='$date' name='date' required></td></tr>
        <tr><td>Quantite</td><td><input type='number' name='qte'>
        <select name='entite'>
        ";
        foreach (\App\Table\Entitie::all() as $entite)
            $html.="<option value='{$entite->id}'>{$entite->nom}</option>";
        $html.="
        </select>
        </td></tr>
        <tr><td colspan='2'><input type='submit' class='btn btn-success'  value='Ajouter' name='add'> <input style='width: 90px' class='btn btn-warning'  value='Annuler' onclick='window.location.href=\"?page=commande\"'></td></tr>
        </table>
        </form>
        ";
        return $html;
    }
    public static function editForm($commande){
        $commande = \App\Table\Commande::find($commande);
        if(!$commande){ echo "Commande invalide ! "; return null;}
        $html = "
        <form method='post'>
        <table class='table'>
        <tr><td>Date de demmande : </td><td><input type='date' value='{$commande->date}' name='date' required><a href='?page=commande' style='text-decoration: none;float: right'><span class='glyphicon glyphicon-remove'></span></a></td></tr>
        
        <tr>
        <td>Quantite demmandé : </td>
        <td>
        <input type='number' value='{$commande->quantite}' step='0.001' name='qte' required><input type='hidden' name='id' value='{$commande->id}'>
        </td>
</tr>
<tr><td colspan='2'><input type='submit' value='ajouter' name='edit'></td></tr>
</table>
</form>
        ";
        return $html;
    }
    public static function getPostValues(){
        if(@$_POST['add']){

            if(($_POST['qte'] === 0 or $_POST['qte'] === "" or $_POST['qte'] === null)){
                return null;
            }else{
                return ["fournisseur" => $_POST['fournisseur'],"qte" => $_POST['qte'],"entite" => $_POST['entite'],"date" => $_POST['date']];
            }
        }
        if(@$_POST['edit']){
            $recu = \App\Table\Commande::recu($_POST['id'])->qte;
            if(($_POST['qte'] === 0 or $_POST['qte'] === "" or $_POST['qte'] === null) or $_POST['qte'] < $recu){
                return null;
            }else{
                return ["qte" => $_POST['qte'], "date" => $_POST['date'], "id" => $_POST['id']];
            }
        }
    }

}