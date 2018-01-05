<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/16/2016
 * Time: 8:46 AM
 */
require_once "../App/App.php";
require_once "../App/View.php";
require_once "../App/Controller/Form.php";
use App\App;
use App\View;
if(isset($_GET["page"])){
    $page = $_GET["page"];
}else{
    $page = "home";
}
if(\App\Table\Entitie::all() !=false ){
switch ($page){
    case "fournisseur":
        View::view("Fournisseur");
        break;
    case "home":
        View::view("Home");
        break;
    case "mesure":
        View::view("Mesure");
        break;
    case "commande":
        View::view("Commande");
        break;
    case "reception":
        View::view("Reception");
        break;
    case "entite":
        View::view("Entite");
        break;
    case "localstock":
        View::view("Localstock");
        break;
    case "setting":
        View::view("setting");
        break;
    case "rapport":
        View::view("Rapport");
        break;
    default:
        View::view("Notfound");

}
}else{
    
    View::view("Entite");
}