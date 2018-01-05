<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/20/2016
 * Time: 5:42 PM
 */

namespace App\Controller;
require_once "C:/xampp/htdocs/ocp_gs/App/Table/Localstock.php";
use App\Table\Entitie;
use App\Table\Localsock;


class Entite
{
    public static function addForm(){
        echo "
        <div class='col-md-3'></div>
        <div class='col-md-6'>
        <div class=\"panel panel-info\"><div class='panel-heading'>Ajouter une nouvelle entite</div>
            <form method='post'>
                <table class='table'>
                <tr><th colspan='2'>Entite</th></tr>
                <tr><td>Le nom</td><td> <input type='hidden' value='add' name='typeForm'/><input type='text' name='nom' required/></td></tr>
                <tr><th colspan='2'>Local stock </th></tr>
                <tr>
                <td>type de mesure</td>
                <td><select name='typelocal'>
                <option value='1'>Mesure de vide</option>
                <option value='2'>Mesure normale</option>
                <option value='3'>Valeur directe</option>
                </select></td>
                </tr>
                <tr><td>Le nom de local</td><td> <input type='text' name='nameTunk' required/></td></tr>
                <tr><td>hauteur  </td><td>".Form::input("number","h")."</td></tr>
                <tr><td>surface de base</td><td>".Form::input("number","sb")."</td></tr>
                <tr><td>masse volumique</td><td>".Form::input("number","mv")."</td></tr>
                <tr><td>quantite initiale </td><td>".Form::input("number","qteI")."</td></tr>
                <tr><td>Capacite : </td><td><input type='number' name='capacite' required/></td></tr>
                <tr><td>Stock min : </td><td><input type='number' name='stockmin' value='0'/></td>
                <tr><td colspan='2'>".Form::input("submit","add","Ajouter")."</td></tr>
                </table>
            </form>
        </div>
        </div><div class='col-md-3'></div>
        ";
    }
    public static function getPost($post){
        if($post['typeForm'] === "add") {
            if ($post['nom'] === null or $post['nom'] === '' or $post['nameTunk'] === null or $post['nameTunk'] === '') {
                return null;
            }
            if ($post['qteI'] === 0 or $post['qteI'] === '') $post['qteI'] = 0;
            if(($post['typelocal'] == 1 or $post['typelocal'] == 2) and ($post['capacite'] == 0 or $post['capacite'] == '')) $post['capacite'] = $post['h']*$post['sb']*$post['mv'];
            if($post['stockmin'] === 0 or $post['stockmin'] === '') $post['stockmin'] = $post['capacite']*20/100;
            if($post['capacite'] == 0) return null;
            return [
                "nom" => $post['nom'],
                "typelocal" => $post['typelocal'],
                "nameTunk" => $post['nameTunk'],
                "qteI" => $post['qteI'],
                "h" => $post['h'],
                "sb" => $post['sb'],
                "mv" => $post['mv'],
                "capacite" => $post['capacite'],
                "stockmin" => $post['stockmin']
            ];
        }elseif ($post['typeForm'] === "update"){
            if(Entitie::findByName($post['newnom']) === null)
                return null;
            else{
                return [$post['id'], $post['newnom']];
            }
        }
        
    }
    public static function editForm(){
        $entite = Entitie::find($_GET['id']);

        echo "
<div class='col-md-3'></div>
<div class='col-md-6'>
<div class=\"panel panel-info\"><div class='panel-heading'>Ajouter une nouvelle entite</div>
<form method='post'>
<table class='table'>
<tr>
<td>nom</td>
<td><input type='hidden' value='update' name='typeForm'/><input type='hidden' value='{$_GET['id']}' name='id'/><input type='text' value='{$entite->nom}' name='newnom' required/></td>
</tr>
<tr><td colspan='2'>".Form::input("submit","edit","Modifier")."</td></tr>
</table>
</form>
</div>
</div><div class='col-md-3'></div>
";
    }
    public static function editEntite($values){
        $new = new Entitie();
        $new->setNom($values[1]);
        $new->setId($values[0]);
        Entitie::update($new);
    }
    public static function add($new){
        Entitie::add($new['nom']);
        Localsock::add($new['nameTunk'],$new['typelocal'],$new['h'],Entitie::getLast()->id,$new['sb'],$new['mv'],$new['qteI'],$new['capacite'],$new['stockmin']);
    }
    public static function delete($id){
        foreach (Localsock::query("select id from localstock where entite = $id",true) as $local){
            Localsock::query("delete from receptions where local = {$local->id}");
            Localsock::delete($local->id);
        }
        Entitie::delete($id);
    }
}