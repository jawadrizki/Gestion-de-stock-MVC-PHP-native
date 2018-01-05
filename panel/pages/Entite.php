<?php
use App\Controller\Entite;

if(\App\Table\Entitie::all() === array() ) {
    echo "<p style='padding: 10px' class='alert-danger'><b>vous n'avez pas ajouter une entite !</b></p>";
}
if(@$_GET['action'] == "add"){

    Entite::addForm();
    if($_POST)
        if(Entite::getPost($_POST)) {
            Entite::add(Entite::getPost($_POST));
            \App\View::moveTo("?page=entite");
        }
}elseif(@$_GET['action'] == "edit"){
    if(\App\Table\Entitie::existe($_GET['id'])) {
        Entite::editForm();
        if ($_POST) {
            if (Entite::getPost($_POST)) {
                Entite::editEntite(Entite::getPost($_POST));
                \App\View::moveTo("?page=entite");
            }

        }
    }
}elseif(@$_GET['action'] == "delete"){
    if(\App\App::demmandeAuth("?page=entite"))
        Entite::delete($_GET['id']);
}else{
echo '<button style="float: right" onclick="window.location.href=\'?page=entite&action=add\'" class="btn btn-warning">Ajouter</button>';
}
if(!isset($_GET['action'])):
?>

<h2>Entites</h2>
<table class="table table-hover">
    <thead>
    <tr>
        <th>id</th>
        <th>Nom</th>
        <th>Quantite actuel</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach (\App\Table\Entitie::all() as $entite):?>
    <tr>
        <td><?=$entite->id?></td>
        <td><?=$entite->nom?></td>
        <td><?=\App\Table\Localsock::qteActuel($entite->id)?></td>
        <td><a href='?page=entite&action=edit&id=<?=$entite->id?>' class="btn btn-sm btn-success">Modifier</a></td>
        <td><a onclick="return confirm('êtes-vous sûr de faire cette operation ? (cette operation va supprimer des nombreuses donnees)')" href='?page=entite&action=delete&id=<?=$entite->id?>' class="btn btn-sm btn-danger">Supprimer</a></td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php endif;?>