<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/16/2016
 * Time: 8:36 AM
 */

namespace App;
require_once "App.php";

class View
{
    public static function view($page){
        if($page != "Home" and $page != "Notfound" and $page != "setting" and $page != "Rapport")
            App::useTable([$page]);
        App::$title .= " | $page";
        ob_start();
        require_once "pages/".$page.".php";
        $content = ob_get_clean();
        require_once "../panel/layout/panel.php";
    }
    public static function moveTo($page){
        return header("Location: $page");
    }
    public static function pop($content){
        echo "
<div class='col-md-3'></div>
<div id='pop' class='col-md-6'>
$content
</div>
<div class='col-md-3'></div>        ";
    }

}