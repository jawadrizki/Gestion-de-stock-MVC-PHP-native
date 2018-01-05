<?php

\App\App::useTable(["Entite","Fournisseur"]);
if(@$_GET['action'] == "add"){
    \App\App::panel("Ajouter une commande",\App\Controller\Commande::addForm());
    if(isset($_POST)){
        $values = \App\Controller\Commande::getPostValues();
        if($values !== null){
            \App\Table\Commande::add($values['fournisseur'],$values['qte'],$values['entite'],$values['date']);
        }

    }
}elseif(@$_GET['action'] == "addreception"){
    \App\App::panel("Ajouter",\App\Controller\Reception::addForm($_GET['id']));
    if(isset($_POST)){
        $values = \App\Controller\Reception::getPostValues();
        if($values !== null){
            \App\Table\Reception::add($values['fournisseur'],$values['qte'],$values['local'],$values['date']);
        }

    }
} elseif (@$_GET['action'] == "delete"){
    if(\App\Table\Commande::find($_GET['id']) and (\App\Table\Commande::recu($_GET['id'])->qte === null) )
        \App\Table\Commande::delete($_GET['id']);
    \App\View::moveTo("?page=commande");

}elseif (@$_GET['action'] == "edit"){
    \App\App::panel("Modifier une commande",\App\Controller\Commande::editForm($_GET['id']));
    if(isset($_POST)) {
        $values = \App\Controller\Commande::getPostValues();
        if ($values !== null) {
            \App\Table\Commande::update($values['qte'], $values['date'], $values['id']);
        }
    }
}else {
    echo '<button style="float: right" onclick="window.location.href=\'?page=commande&action=add\'" class="btn btn-success">Ajouter</button>';
}




?>
<table class="table table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>Fournisseur</th>
        <th>Date</th>
        <th>Quantite</th>
        <th>Entite</th>
        <th>Recu</th>
        <th>Recu par mois</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach (\App\Table\Fournisseur::all() as $fournisseur):
        foreach (\App\Table\Entitie::all() as $entite):
            $commandes = \App\Table\Commande::query("select * from commandes where id=(select max(id) from commandes where fournisseur = {$fournisseur->id} and entite = {$entite->id})",true);
            if($commandes === array()) continue;
            foreach ($commandes as $commande):
                $date = date_parse(date("Y-m-d"));
                $q = \App\Table\Reception::query("select sum(quantite) as q from receptions where commande = {$commande->id} and year(date) = '{$date['year']}' and month(date) = '{$date['month']}'",true,null,true);
                $style = "";
                    if(\App\Table\Commande::recu($commande->id)->qte == $commande->quantite) $style = "class = warning";
                    ?>
                <tr <?=$style?>>
                    <td><?=$commande->id?></td>
                    <td><?=\App\Table\Fournisseur::find($commande->fournisseur)->nom?></td>
                    <td><?=$commande->date?></td>
                    <td><?=$commande->quantite?></td>
                    <td><?=\App\Table\Entitie::find($commande->entite)->nom?></td>
                    <td><?=\App\Table\Commande::recu($commande->id)->qte?></td>
                    <td><?php if($q !=null) echo $q->q?></td>
                    <td width="40%">
                        <?php if((\App\Table\Commande::recu($commande->id)->qte == $commande->quantite) or \App\Table\Localsock::findByEntite($commande->entite) !== array() ): ;?>
                        <a class="btn btn-success" href="?page=commande&action=addreception&id=<?=$commande->id?>"> + Reception</a>
                        <?php endif;?>
                        <a class="btn btn-success" href="?page=commande&action=edit&id=<?=$commande->id?>">Modifier</a>
                        <a class="btn btn-success" href="?page=reception&action=liste&id=<?=$commande->id?>">Liste Receptions</a>
                        <?php if(\App\Table\Commande::recu($commande->id)->qte === null ):?>
                        <a class="btn btn-danger" onclick="return confirm('Are you sure?')" href="?page=commande&action=delete&id=<?=$commande->id?>">Supprimer</a>
                        <?php endif;?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endforeach; ?>

    </tbody>
</table>
