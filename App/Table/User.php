<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/15/2016
 * Time: 10:46 AM
 */

namespace App\Table;

require_once "../App/Database.php";
require_once "../App/App.php";
use App\App;
App::useTable(["Table"]);

class User extends Table
{

    

    public function setUser($user){
        $this->user = $user;
    }

    public function getUser(){
        return $this->user;
    }
    public static function checkUser($username,$password){
        $users = self::all();
        foreach ($users as $user){
            if($user->username === $username and $user->password === $password){
                return $user;
            }
        }
        header("Location: ?error=1");
    }
    public static function connectUser(User $user){
        session_start();
        $_SESSION["user"] = $user;
    }
    public static function disconnectUser(){
        unset($_SESSION["user"]);
        session_destroy();
    }
}