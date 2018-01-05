
<?php
if(@$_GET['action'] == "add"){
    if(isset($_GET['id'])) {
        if (\App\Table\Localsock::existe($_GET['id'])) {
            \App\App::panel("Enter un nouveau jaugage", \App\Controller\Mesure::addForm());
            if ($_POST)
                if (\App\Controller\Mesure::getPost($_POST))
                    \App\Controller\Mesure::add(\App\Controller\Mesure::getPost($_POST));
        }
    }
}elseif(@$_GET['action'] == "delete"){
    \App\Controller\Mesure::delete($_GET['id']);
}
?>
<div class="row">
    <div class="col-md-12">

        <h2>Stock :</h2>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Localstock</th>
                <th>Entite</th>
                <th>Mesure</th>
                <th>Consommation J-1</th>
                <th>Date de consommation</th>
                <th>Actions</th>

            </tr>
            </thead>

            <tbody>
            <?php
            foreach (\App\Table\Localsock::all() as $local):
                $mesure = \App\Table\Mesure::getLastByLocal($local->id);
                if($mesure !== false) {
                    $consommation = $mesure->consommation;
                    $datec = $mesure->datec;
                    $exist = true;
                }else{
                    $mesure = "--";$consommation = "--";$datec = "--";$exist = false;
                }
                ?>
                <tr>
                    <td><?=$local->nom?></td>
                    <td><?=\App\Table\Entitie::find($local->entite)->nom?></td>
                    <td><?=$local->qte?></td>
                    <td><?=$consommation?></td>
                    <td><?=$datec?></td>
                    <td>
                        <a href="?page=mesure&action=add&id=<?=$local->id?>" class="btn btn-sm btn-success">+ Mesure</a>
                        <?php if($exist):?>
                            <a onclick="return confirm('confirmer vorte operation !')" href="?page=mesure&action=delete&id=<?=$mesure->id?>" class="btn btn-sm btn-danger">Supprimer</a>
                        <?php endif;?>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

