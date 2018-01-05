<?php
use App\Table\Localsock;
use App\Table\Entitie;
if(@$_GET['action'] == "delete"):
    $commande = \App\Table\Reception::find($_GET['id'])->commande;
    \App\Controller\Reception::delete($_GET['id']);
    \App\Table\Commande::query("update commandes set date_expiration = null where id = {$commande}");
    \App\View::moveTo("?page=reception&id=".\App\Table\Commande::find($commande)->id);
endif;
?>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Fournisseur</th>
            <th>Quantite</th>
            <th>Entite</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach (\App\Table\Reception::query("select * from receptions where commande = ?",true,[$_GET['id']]) as $reception):
?>
    <tr>
        <td><?=$reception->id?></td>
        <td><?=$reception->date?></td>
        <td><?=\App\Table\Fournisseur::find($reception->fournisseur)->nom?></td>
        <td><?=$reception->quantite?></td>
        <td><?=Entitie::find(Localsock::find($reception->local)->entite)->nom?></td>
        <?php if(\App\Table\Reception::find($reception->id)->deletable == 0): ?>
        <td><a href="?page=reception&action=delete&id=<?=$reception->id?>" class="btn btn-danger">Supprimer</a></td>
        <?php else:?>
        <td><a title="Impossible de supprimer cette element !" class="btn btn-danger disabled">Supprimer</a></td>
        <?php endif;?>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>