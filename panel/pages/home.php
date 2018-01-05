<h2>Etat des Locales :</h2>

<?php
require_once "../App/Table/Localstock.php";
foreach (\App\Table\Localsock::all() as $local):
    $pourcentage = intval($local->qte*100/$local->capacite);
    $type = "progress-bar-success";
    $estvide = "";
    if($local->qte == 0) $estvide = "<em style='font-size: 13px'>  (vide)</em>";
    if($local->qte - $local->stockmin < 500 and $local->qte - $local->stockmin > -500 )
        $type = "progress-bar-warning";
    elseif($local->qte < $local->stockmin - 500)
        $type = "progress-bar-danger";
    $nomentie = \App\Table\Entitie::find($local->entite)->nom;
    ?>
    <h4><?=$local->nom." de $nomentie"." ({$local->qte}) ".$estvide?></h4>
    <div class="progress"><div class="progress-bar <?=$type?> progress-bar-striped" role="progressbar" aria-valuenow="<?=$pourcentage?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$pourcentage?>%"><span class="sr-only"><?=$pourcentage?>% Complete (success)</span></div></div>

<?php endforeach;?>


