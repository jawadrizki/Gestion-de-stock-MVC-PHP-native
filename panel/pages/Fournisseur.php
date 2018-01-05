<?php
use App\Table\Fournisseur;
if(@$_GET['action'] == "add"){
    App\App::panel("Ajouter un fournisseur",\App\Controller\Fournisseur::addForm());
    if(isset($_POST)){
        $values = \App\Controller\Fournisseur::getPostValues();
        if($values !== null) {
            \App\Controller\Fournisseur::add($values);
            \App\View::moveTo("#");
        }

    }
}elseif(@$_GET['action'] == "edit"){
    if(Fournisseur::existe($_GET['id'])) {
        App\App::panel("Modification", \App\Controller\Fournisseur::editForm($_GET['id']));
        if (isset($_POST)) {
            $values = \App\Controller\Fournisseur::getPostValues();
            if ($values !== null) {
                \App\Controller\Fournisseur::edit($values);
            }
        }
    }
}elseif(@$_GET['action'] == "delete"){
    if(Fournisseur::existe($_GET['id'])) {
        $nom = Fournisseur::find($_GET['id'])->nom;
        if (\App\App::demmandeAuth("?page=fournisseur", ["Cette operation va supprimer $nom", 'supprimer toutes ces commandes']))
            \App\Controller\Fournisseur::delete($_GET['id']);
            \App\View::moveTo("#");
    }

}else{
    echo '<button style="float: right" onclick="window.location.href=\'?page=fournisseur&action=add\'" class="btn btn-success">Ajouter</button>';
}


?>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Nom</th>
        <th>Actions</th>
    </tr>
    </thead>
    <?php
    $fournisseurs = Fournisseur::all();
    if($fournisseurs === null)
        echo "<tr><td colspan='3'>Aucun enregistrement</td></tr>";
    foreach ($fournisseurs as $fournisseur):
    ?>
    <tr>
        <td><?=$fournisseur->id?></td>
        <td><?=$fournisseur->nom?></td>
        <td>
            <a class="btn btn-sm btn-success" href="?page=fournisseur&action=edit&id=<?=$fournisseur->id?>">Modifier</a>
            <a class="btn btn-sm btn-danger" href="?page=fournisseur&action=delete&id=<?=$fournisseur->id?>">Supprimer</a>
        </td>
    </tr>
    <?php endforeach;?>
</table>


