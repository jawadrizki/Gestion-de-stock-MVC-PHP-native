<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/20/2016
 * Time: 5:43 PM
 */

namespace App\Controller;

require_once "C:/xampp/htdocs/ocp_gs/App/Table/Entite.php";
require_once "C:/xampp/htdocs/ocp_gs/App/Table/Commande.php";
require_once "C:/xampp/htdocs/ocp_gs/App/App.php";
require_once "C:/xampp/htdocs/ocp_gs/App/Table/Reception.php";
use App\App;
use App\Table\Commande;
use App\Table\Entitie;
use App\Table\Reception;

class Fournisseur
{
    public static function addForm(){
        $date = date("Y-m-d");
        $html = "
        <form method='post'>
        <table class='table'>
        <tr>
        <td>Nom</td>
        <td><input type='text' name='nom' required/></td>
        </tr>
        <tr>
        <td>Commande initial</td>
        <td><input type='number' step='0.001' value='0' min='0' name='commande'required/>
        <select name='entite'>
        ";
        foreach (Entitie::all() as $entite)
            $html.="<option value='{$entite->id}'>{$entite->nom}</option>";
        $html.="
</select>
        </td>
        </tr>
        <tr><td>Date :</td><td><input type='date' name='date' value='$date' required/></td></tr>
        <tr><td colspan='2' style='text-align: center;'><input type='submit' class='btn btn-primary' value='ajouter' name='add'>&nbsp;<input style='width: 90px' class='btn btn-warning' onclick='window.location.href=\"?page=fournisseur\"' value='Annuler' /></td></tr>
        </table>
        </form>
        ";
        return $html;
    }
    public static function editForm($id){
        $fournisseur = \App\Table\Fournisseur::find($id);
        $html = "<form method='post'>
        <table class='table'>
        <tr><td>Nom</td><td><input type='text' value='{$fournisseur->nom}' name='nom'></td></tr>
         <tr><td colspan='2' style='text-align: center;'><input type='hidden' value='{$id}' name='id'><input type='submit' class='btn btn-primary' value='Modifier' name='edit'>&nbsp;<input style='width: 90px' class='btn btn-warning' onclick='window.location.href=\"?page=fournisseur\"' value='Annuler' /></td></tr>
        </table>
        </form>";
        return $html;
    }
    public static function getPostValues()
    {
        if (@$_POST['add']) {
            if (is_null($_POST['nom']) or $_POST['nom'] === "") {
                return null;
            } else {
                return ["nom" => $_POST['nom'], "commande" => $_POST['commande'], "entite" => $_POST['entite'], "date" => $_POST['date']];
            }
        } elseif (@$_POST['edit']) {
            if (is_null($_POST['nom']) or $_POST['nom'] === "") {
                App::showErrors(["Entrer un nom !"]);

                return null;
            } else {
                return ["id" => $_POST['id'], "nom" => $_POST['nom']];
            }
        }
    }

    public static function add($post){
        if($post['commande'] == 0 or $post['commande'] == ''){
            $commande = false;
        }else{
            $commande = $post['commande'];
            $entite = $post['entite'];
        }
        \App\Table\Fournisseur::add($post['nom']);
        if($commande){
            $id = \App\Table\Fournisseur::getLast()->id;
            Commande::add($id,$commande,$entite,$post['date']);

        }
    }
    public static function edit($post){
        if($post !== null){
            \App\Table\Fournisseur::update($post['nom'],$post['id']);
        }
    }
    public static function delete($id){
        Commande::query("delete from commandes where fournisseur = $id");
        Reception::query("delete from receptions where fournisseur = $id");
        \App\Table\Fournisseur::delete($id);

    }
}