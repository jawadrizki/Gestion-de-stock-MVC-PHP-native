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
use App\View;

class Localstock
{
    public static function editForm(){
        $local = Localsock::find($_GET['id']);
        $html = "
        <form method='post'>
        <table class='table'>
        <input type='hidden' value='update' name='typeForm'/>
        <input type='hidden' value='{$_GET['id']}' name='id'/>
        <tr><td> Le nom de local : </td><td>".Form::input("text","nom",$local->nom)."</td>
        <tr><td>Type de mesure : </td><td><select name='type'>
        <option value='1'>Mesure de vide</option>
        <option value='2'>Mesure normale</option>
        <option value='3'>Valeur directe</option>
        </select></td></tr>
        <tr><td>Hauteur : </td><td>".Form::input("number","h",$local->hauteur). "</td></tr>
         <tr><td>Surface de base : </td><td>".Form::input("number","sb",$local->base_surface). " </td></tr>
         <tr><td>Masse volumique : </td><td>".Form::input("number","mv",$local->mv)."</td></tr>
         <tr><td>   Capacite : </td><td>".Form::input("number","capacite",$local->capacite)."</td></tr>
           <tr><td> Stock min : </td><td>".Form::input("number","stockmin",$local->stockmin)."</td></tr>
            </td></tr>
        <tr><td colspan='2'><input type='submit' name='add' class='btn btn-warning' value='Modifier'/></td></tr>
        </table></form>";
        return $html;
    }
    public static function addForm(){
        $html = "<form method='post'>
        <table class='table'>
        <input type='hidden' value='add' name='typeForm'/>
        <tr>
        <td>Type de mesure :</td><td> <select name='type'>
        <option value='1'>Mesure de vide</option>
        <option value='2'>Mesure normale</option>
        <option value='3'>Valeur directe</option>
        </select></td>
        </tr>
        <tr>
        <td>Le nom de local : </td><td>".Form::input("text","nom",@$_POST['nom'])."</td>
        </tr>
        <tr><td>Hauteur : </td><td>".Form::input("number","h",@$_POST['h']). " </td></tr>
        <tr><td>Surface de base : </td><td>".Form::input("number","sb",@$_POST['sb']). " </td></tr>
        <tr><td>Masse volumique : </td><td>".Form::input("number","mv",@$_POST['mv'])."</td></tr>
        <tr><td>Capacite : </td><td>".Form::input("number","capacite",@$_POST['capacite'])."</td></tr>
        <tr><td>Stock min : </td><td>".Form::input("number","stockmin",@$_POST['stockmin'])."</td></tr>
        <tr><td>Entite</td><td><select name='entite'>";

        foreach (Entitie::all() as $entite)
           $html.= "<option value='{$entite->id}'>{$entite->nom}</option>";
        $html.= "
</select></td></tr>
        <tr><td>Quentite initiale : </td><td>".Form::input("number","qteI",@$_POST['qteI'])."</td></tr>
        <tr><td colspan='2'><input type='submit' name='add' class='btn btn-success' value='Ajouter'/></td></tr>
        </table>";
        return $html;
    }
    public static function getPost($post){
        $errors = [];
        $i=0;
        if($post['typeForm'] === "add") {

            if(
                $post['nom'] == null or $post['nom'] == ''
                or  ($post['type'] < 3 and
                    ($post['h'] <= 0 or $post['h'] == null
                or $post['sb'] <= 0 or $post['sb'] == null
                or $post['mv'] <= 0 or $post['mv'] == null)
                )
            ) {
                if(!$post['nom']) {$errors[$i] = "Entere un nom !";$i++;}
                else{
                    $errors[$i] = "veuillez remplir tous les champs demandés";$i++;
                }
                App::showErrors($errors);
                return null;
            }
            if ($post['qteI'] === 0 or $post['qteI'] === '') $post['qteI'] = 0;
            if($post['capacite'] == 0 or $post['capacite'] == null) $post['capacite'] = $post['sb']*$post['h'];
            if($post['stockmin'] == 0 or $post['stockmin'] == null) $post['stockmin'] = $post['capacite']*20/100;
            var_dump($post['stockmin']);
            return [
                "nom" => $post['nom'],
                "type" => $post['type'],
                "qteI" => $post['qteI'],
                "entite" => $post['entite'],
                "h" => $post['h'],
                "sb" => $post['sb'],
                "mv" => $post['mv'],
                "capacite" => $post['capacite'],
                "stockmin" => $post['stockmin']
            ];
        }elseif ($post['typeForm'] === "update"){
            if(
                $post['nom'] == null or $post['nom'] == ''
                or  ($post['type'] < 3 and
                    ($post['h'] <= 0 or $post['h'] == null
                        or $post['sb'] <= 0 or $post['sb'] == null
                        or $post['mv'] <= 0 or $post['mv'] == null)
                )
            ){
                if(!$post['nom']) {$errors[$i] = "Entere un nom !";$i++;}
                else{
                    $errors[$i] = "veuillez remplir tous les champs demandés";$i++;
                }
                App::showErrors($errors);
                return null;
                return null;
            }
            if($post['capacite'] == 0 or $post['capacite'] == null) $post['capacite'] = $post['sb']*$post['h'];
            if($post['stockmin'] == 0 or $post['stockmin'] == null) $post['stockmin'] = $post['capacite']*20/100;
            return [
            "id" => $post['id'],
            "type" => $post['type'],
            "nom" => $post['nom'],
            "h" => $post['h'],
            "sb" => $post['sb'],
            "mv" => $post['mv'],
            "capacite" => $post['capacite'],
            "stockmin" => $post['stockmin']
            ];
        }

    }
    public static function editLocal($updated){
        $new = new Localsock();
        $new->setId($updated['id']);
        $new->setNom($updated['nom']);
        $new->setSurfaceBase($updated['sb']);
        $new->setMasseVolumique($updated['mv']);
        $new->setHauteur($updated['h']);
        $new->setType($updated['type']);
        $new->setCapacite($updated['capacite']);
        $new->setStockmin($updated['stockmin']);
        Localsock::update($new);
    }
    public static function add($values){
        Localsock::add($values['nom'],$values['type'],$values['h'],$values['entite'],$values['sb'],$values['mv'],$values['qteI'],$values['capacite'],$values['stockmin']);
    }
    
}