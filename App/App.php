<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/14/2016
 * Time: 1:13 PM
 */

namespace App;
require_once "Database.php";
use PDO;
class App
{
    private static $db_name = "stock";
    private static $db_user = "root";
    private static $db_pass = "";
    private static $db_host = "localhost";
    private static $db;
    public static $pass;
    public static $title = "Gestion de stock";

    public function __construct()
    {
        $conn = new Database("stock");
        self::$db = $conn;

    }
    public static function getDb()
    {
        if(self::$db === null){
            $pdo = new PDO("mysql:dbname=".self::$db_name.";host=".self::$db_host,self::$db_user,self::$db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            self::$db = $pdo;
        }
        return self::$db;
    }
    public static function getPass(){
        return self::$db->query("select password from app")[0]->password;
    }
    public static function setPass($pass){
        return self::$db->query("update app set password = ? ",[$pass],false,false);
    }

    public static function useTable($tables){
        foreach ($tables as $table) {
            require_once "C:/xampp/htdocs/ocp_gs/App/Table/" . $table . ".php";
            require_once "C:/xampp/htdocs/ocp_gs/App/Controller/" . $table . ".php";
        }
    }
    public static function startSession(){
        session_start();
        $_SESSION['session'] = "active";
    }
    public static function endSession(){
        unset($_SESSION['session']);
        session_destroy();
    }
    public static function now(){
        return date("Y/m/d H:i:s");
    }
    public static function showErrors($errors){
        echo "
<div class='row'>
<div class='col-md-12'>


<div class='bg-danger' style='color: darkred;padding: 8px;margin: 6px'><b><ul>";
        foreach ($errors as $error){echo "<li>$error</li>";}
        echo "
</ul></b></div>
</div>
</div>";
    }
    public static function showSuccess($success){
        echo "
<div class='row'>
<div class='col-md-12'>


<div class='bg-danger' style='color: darkred;padding: 8px;margin: 6px'><b><ul>
<li>$success</li>
</ul></b></div>
</div>
</div>";
    }

    public static function panel($title,$html,$notices = [],$type = "info"){
        echo "
        <div class='col-md-3'></div>
        <div class='col-md-6'>
        <div class='panel panel-$type'><div class='panel-heading'>$title</div>";
        if($notices != []) {
            echo "<div class='alert alert-warning'><ul>";
            foreach ($notices as $notice)
                echo "<li>$notice</li>";
            echo "</ul></div>";
        }

        echo "$html
        </div>
        </div><div class='col-md-3'></div>
        ";
    }
    public static function demmandeAuth($retour,$notice = []){

        $html ="
        <form method='post'>
        <table class='table'>
        <tr><td>Mot de passe :</td><td><input type='password' name='pass'/></td></tr>
<tr><td colspan='2' style='text-align: center'><input type='submit' name='confirmer' value='Confirmer' class='btn btn-primary'/>&nbsp;<a class='btn btn-warning' href='$retour'>Annuler l'operation!</a></td></tr>
</table>
</form>
        ";
        self::panel("Entrer mot de passe pour confirmer cette operation",$html,$notice,"danger");
        if(@$_POST["confirmer"]){
            $app = new App();
            if($_POST['pass'] == $app::getPass()){
                return true;
            }else{
                echo "<div class='row'><div class='col-md-12'><p class='alert-danger' style='padding: 8px'><strong>Mot de passe incorrecte !</strong></p></div></div>";
                return false;
            }
        }
        return false;
    }

    public static function alert($content){
        echo "<div class='alert alert-warning'>$content</div>";
    }
}