<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/20/2016
 * Time: 5:46 PM
 */

namespace App\Controller;
require_once "C:/xampp/htdocs/ocp_gs/App/Table/Fournisseur.php";
require_once "C:/xampp/htdocs/ocp_gs/App/Table/Entite.php";

use App\App;

class Form
{
    public static function selectFournisseur($name) {
        $html ="
        <select name='$name'>";
       foreach (\App\Table\Fournisseur::all() as $fournisseur){
           $html.= "<option value = {$fournisseur->id}>{$fournisseur->nom}</option>";
       }
        $html.= "</select>";
        return $html;
    }
    public static function selectEntite($name) {
        $html = "
        <select name='$name'>";
        foreach (\App\Table\Entitie::all() as $entite){
            $html .="<option value = {$entite->id}>{$entite->nom}</option>";
        }
        $html .= "</select>";
        return $html;
    }
    public static function input($type,$name,$value = ""){
        $step = "";
        if($type == "number") $step ="step='0.0001'";
        return "<input type='$type' $step min='0' name='$name' value='$value'/>";
    }

}
