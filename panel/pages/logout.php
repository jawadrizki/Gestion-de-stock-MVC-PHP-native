<?php
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/23/2016
 * Time: 3:31 PM
 */
require_once "../../App/App.php";
session_start();
\App\App::endSession();
header("Location: ../../public/");
