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

class Mesure
{
    public static function addForm(){
        $local = Localsock::find($_GET['id']);
        $date = date("Y-m-d");
        $html = "<form method='post'>
        <table class='table'>
        
        <tr><td>Localstock : </td>
        <td><input type='hidden' value='{$local->id}' name='localstock'><input type='text' value='{$local->nom}' readonly></td>
        </tr>
        <tr><td>Mesure : </td><td><input type='number' step='0.0001' name='mesure' required></td></tr>
       
        <tr><td>Date : </td><td><input type='date'  name='date' value='$date' required></td></tr>
        <tr><td colspan='2'><input type='submit' name='add' class='btn btn-primary' value='Ajouter'/> <input style='width: 80px' onclick='window.location.href=\"?page=mesure\"' class='btn btn-warning' value='Annuler'/></td></tr>
        </table>
        ";
        return $html;
    }
    public static function delete($id){
        $mesure = \App\Table\Mesure::find($id);
        if($mesure) {
            $qteA = Localsock::find($mesure->localstock)->qte;
            Localsock::updateQte($mesure->localstock, $qteA + $mesure->consommation);
            \App\Table\Mesure::delete($id);
        }
        View::moveTo("?page=mesure");
    }
    public static function getPost($post){
        $errors = [];$i=0;
        if($post['mesure'] == ""){
            $errors[$i] = " Mesure est obligatoire ! ";$i++;
        }else{
            $local = Localsock::find($post['localstock']);
            $type = $local->type;
            if($type == 1) $mesure = ($local->hauteur - $post['mesure'])*$local->base_surface*$local->mv;
            elseif ($type == 2) $mesure = $post['mesure']*$local->base_surface*$local->mv;
            elseif ($type == 3) $mesure = $post['mesure'];
            $lastMesure = \App\Table\Mesure::getLastByLocal($post['localstock']);
            $qteA = Localsock::find($post['localstock'])->qte;
            if(!$lastMesure){
                $consommation = $qteA - $mesure;
                $datec = date("Y-m-d");
            }else{
                $datec = $lastMesure->date;
                $lastMesure = $lastMesure->mesure;
                $consommation = $lastMesure - $mesure;
            }
            if($mesure < 0 or $mesure > $qteA) {$errors[$i] = " Le mesure depasse la quantite actuel ! ";$i++;}
            if($consommation <0 ) $consommation = $qteA - $mesure;
            $date = $post['date'];
            if(!$date)  $date = date("Y-m-d");
            if($errors == null){
                return [
                    "mesure" => $mesure,
                    "consommation" => $consommation,
                    "date" => $date,
                    "datec" => $datec,
                    "localstock" => $post['localstock']
                ];
            }
            else{
                App::showErrors($errors);
                return null;
            }

        }

    }
    public static function add($array){
        $req = \App\Table\Reception::query("select max(id) as id from receptions where local = {$array['localstock']}",true,null,true);
        if($req->id !== null)
            \App\Table\Reception::query("update receptions set deletable = 1 where id={$req->id}");
        \App\Table\Mesure::add($array);
    }
}