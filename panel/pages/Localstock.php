<?php
if(@$_GET['action'] == "edit"){
    \App\App::panel("Ajouter un Local",\App\Controller\Localstock::editForm());
    if($_POST){
        if(\App\Controller\Localstock::getPost($_POST)) {
            \App\Controller\Localstock::editLocal(\App\Controller\Localstock::getPost($_POST));
            \App\View::moveTo("?page=localstock");
        }
        

    }
}elseif(@$_GET['action'] == "delete"){
    if(\App\Table\Localsock::existe($_GET['id'])) {
        if (\App\App::demmandeAuth("?page=localstock", ["Cette operattion va supprimer des autres information soyez sur avant confirmer!"]) == true) {
            \App\Table\Localsock::delete($_GET['id']);
            \App\View::moveTo("?page=localstock");
        }
    }
}elseif (@$_GET['action'] == "add"){
    \App\App::panel("Ajouter un Local",\App\Controller\Localstock::addForm());
    if($_POST){
        if(\App\Controller\Localstock::getPost($_POST))
            \App\Controller\Localstock::add(\App\Controller\Localstock::getPost($_POST));

    }
}else{
    echo '<button style="float: right" onclick="window.location.href=\'?page=localstock&action=add\'" class="btn btn-success">Ajouter</button>';
}
if(!isset($_GET['action'])):
?>
<div class="row">
<div class="col-md-12">

    <h2>Locales de stock :</h2>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Entite</th>
            <th>Stock</th>
            <th>Type de mesure</th>
            <th>Surface de base</th>
            <th>Hauteur</th>
            <th>Masse volumique</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach (\App\Table\Localsock::all() as $local):
            if($local->type == 1) $type = "mesure de vide";
            elseif($local->type == 2) $type = "Mesure normale";
            elseif($local->type == 3) $type = "Mesure direct";
            $base_surface = $local->base_surface;$hauteur = $local->hauteur;$mv = $local->mv;
            if($base_surface == 0 and $hauteur == 0 and $mv == 0 ){
                $base_surface = "--";
                $hauteur = "--";
                $mv = "--";
            }
            ?>
            <tr>
                <td><?=$local->nom?></td>
                <td><?=\App\Table\Entitie::find($local->entite)->nom?></td>
                <td><?=$local->qte?></td>
                <td><?=$type?></td>
                <td><?=$base_surface?></td>
                <td><?=$hauteur?></td>
                <td><?=$mv?></td>
                <td>
                    <button onclick="window.location.href='?page=localstock&action=edit&id=<?=$local->id?>'" class="btn btn-sm btn-success">Modifier</button>
                    <a onclick="return confirm('êtes-vous sûr de faire cette operation ? (cette operation va supprimer des nombreuses donnees)')" href='?page=localstock&action=delete&id=<?=$local->id?>'  class="btn btn-sm btn-danger">Suprimmer</a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
</div>
<?php
endif;
/**
 * Created by PhpStorm.
 * User: jawad
 * Date: 08/21/2016
 * Time: 2:09 PM
 */