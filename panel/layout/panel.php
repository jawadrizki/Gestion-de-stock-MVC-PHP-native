<?php session_start();
if(!isset($_SESSION['session']))
    header("Location: ../public/");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=\App\App::$title?></title>
    <link rel="stylesheet" href="layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/panel-style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div id="all" class="container-fluid toggled">
    <div class="row" id="navrow">
        <div id="mynav">
            <a href="#" id="togl"><span id="flesh" class="glyphicon glyphicon-menu-right"></span></a>
                <div id="nav-content">

                    <span class="glyphicon glyphicon-calendar"> <?=date("d/m/Y")?></span>
                    <span class="glyphicon glyphicon-time"> <?=date("H:i:s")?></span>
                    <span id="nav-right">
                        <a href="?page=setting"><span class="glyphicon glyphicon-cog"></span></a>
                    <a href="../panel/pages/logout.php"><span class="glyphicon glyphicon-log-out"></span></a>
                    </span>
                </div>

        </div>

    </div>
    <div class="row">
        <div id="sideBar">
            <ul>
                <li>
                    <a href="?page=home"><span class="glyphicon glyphicon-home"></span> &nbsp;Page d’accueil </a>
                </li>
                <li>
                    <a href="?page=rapport"><span class="glyphicon glyphicon-menu-hamburger"></span> &nbsp;Rapports</a>
                </li>
                <li>
                    <a href="?page=localstock"><span class="glyphicon glyphicon-menu-hamburger"></span> &nbsp;Locales de stock</a>
                </li>
                <li>
                    <a href="?page=entite"><span class="glyphicon glyphicon-menu-hamburger"></span> &nbsp;Entités</a>
                </li>
                <li>
                    <a href="?page=mesure"><span class="glyphicon glyphicon-menu-hamburger"></span> &nbsp;Mesures et consommation</a>
                </li>
                <li>
                    <a href="?page=fournisseur"><span class="glyphicon glyphicon-book"></span> &nbsp;Liste des fournisseurs</a>
                </li>
                <li>
                    <a href="?page=commande"><span class="glyphicon glyphicon-book"></span> &nbsp;Liste des commandes</a>
                </li>
            </ul>
        </div>
        <div id="content">
            <?php
            echo $content;
            ?>
        </div>
    </div>
</div>
<script src="layout/js/jquery.min.js"></script>
<script src="layout/js/myJs.js"></script>

</body>

</html>
    
   


