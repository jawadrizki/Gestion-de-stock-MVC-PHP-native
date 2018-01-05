<html>
<head>
    <title>Groupe OCP | Bienvenue </title>
    <link rel="stylesheet" href="public.css" type="text/css"/>
</head>
<script src="../panel/layout/js/jquery.min.js"></script>
<body>
<?php
session_start();
if(isset($_SESSION['session'])){
    header("Location: ../panel/");
}else{
    echo "ok";
}
$hide = "visibility: hidden";
$tmp = "";
if($_GET['error'] == 'failed'){
    $hide = "";
    $tmp = "<input id='tmp' type='hidden' value='1'/>";
}
?>
<img id="bg" src="../images/1.png"/>
<div class="container">
    <img class="logo" src="../images/logo.png" alt="">
    <form class="loginform" method="post">
        <table>
            <tr>
                <td><input type="password" placeholder="Mot de passe" name="pass"/></td>
            </tr>
            <tr>
                <td><input type="submit" value="Deverrouiller ce systeme" name="connecter"></td>
            </tr>
            <tr>
                <td><span id="error" style="width: 100%; color: red;<?=$hide?>"><strong>Mot de passe incorrect !</strong></span></td>
            </tr>
        </table>
    </form>
</div>
<?php
require_once "../App/App.php";
require_once "../App/view.php";
use App\App;
$app = new App();
if(isset($_POST['connecter'])){
    if($_POST['pass'] === $app::getPass()){
        App::startSession();
        \App\View::moveTo("../panel/index.php");
    }else{
        \App\View::moveTo("?error=failed");
    }
        
}
?>
<script>
    if( $("#tmp").val() == '1'){
        $("#error").fadeOut(1);
    }
</script>
</body>
</html>

