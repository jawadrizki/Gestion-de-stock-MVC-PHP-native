<?php
if(isset($_POST['get'])) {
    if ($_POST['date'] === null or $_POST['date'] === "0000-00-00"):
        header("#");
    else:
        $date = $_POST['date'];
        require_once "C:/xampp/htdocs/ocp_gs/App/App.php";
        require_once "C:/xampp/htdocs/ocp_gs/App/Table/Localstock.php";
        require_once "C:/xampp/htdocs/ocp_gs/App/Table/Mesure.php";
        require_once "C:/xampp/htdocs/ocp_gs/App/Table/Fournisseur.php";
        require_once "actionRapport.php";
        function date_in_french ($date){
            $week_name = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");
            $month_name=array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août",
                "Septembre","Octobre","Novembre","Décembre");

            $split = preg_split('/-/', $date);
            $year = $split[0];
            $month = round($split[1]);
            $day = round($split[2]);

            $week_day = date("w", mktime(12, 0, 0, $month, $day, $year));
            return $date_fr = $week_name[$week_day] .' '. $day .' '. $month_name[$month] .' '. $year;
        }
    endif;
}
ob_start();
?>
<link href="pdf.css" type="text/css"/>

<page backright="8mm" backtop="45mm">
    <page_header>
        <img src="../../images/logo.png" id="logo"/>
        <p id="titre">
            Magasin centrale PHOSBOUCRAA<br>
            Rapport de <?=$date?>
        </p>

    </page_header>
    <div id="content">
        <div id="tab1">

            <h4>Rapport des mesures et consommation par local :</h4>
            <table>

                <thead>
                <tr>
                    <th>Local</th>
                    <th>Entite</th>
                    <th>Stock</th>
                    <th>Date</th>
                    <th>Consommation</th>
                    <th>Date de consommation</th>
                    <th>Consommation par mois</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach (\App\Table\Localsock::all() as $local):
                    $mesure = \App\Table\Mesure::query("select * from mesures where date = '$date' and localstock = {$local->id}",true,null,true);
                    $month = date_parse($date);
                    $c = \App\Table\Mesure::query("select sum(consommation) as c from mesures where month(date) = {$month['month']} and date <= '$date' and localstock = {$local->id}",true,null,true);

                    if($mesure === false ){
                        $d = "---";
                        $consommation = "--";
                        $datec = "---";
                        $c = "--";
                        $m = "--";
                    }
                    else{
                        $c = $c->c;
                        $d = $mesure->date;
                        $consommation = $mesure->consommation;
                        $datec = $mesure->datec;
                        $m = $mesure->mesure;
                    }
                    ?>
                    <tr>
                        <td><?=$local->nom?></td>
                        <td><?=\App\Table\Entitie::find($local->entite)->nom?></td>
                        <td><?php if($m != "--") echo number_format($m,4,".",","); else echo $m ?></td>
                        <td><?=$d?></td>
                        <td><?php if($consommation != "--") echo number_format($consommation,4,".",","); else echo $consommation ?></td>
                        <td><?=$datec?></td>
                        <td><?php if($c != "--") echo number_format($c,4,".",","); else echo $c ?></td>
                    </tr>
                <?php endforeach;?>

                </tbody>
            </table>
        </div>
    <div id="tab2">
        <h4>Autonomie de stock </h4>
        <table>
            <thead>
            <tr>
                <th>Entite</th>
                <th>Autonomie par jours</th>

            </tr>
            </thead>
            <tbody>
            <?php
            foreach (\App\Table\Mesure::query("select avg(consommation) moyen,localstock from mesures where date <= '$date' group by localstock",true) as $local):

                $mesure = \App\Table\Mesure::findByDate($date);
                $entite = \App\Table\Localsock::find($local->localstock)->nom;
                if($mesure == array()){
                    $autonom = "--";
                }
                else{
                    if(\App\Table\Localsock::find($local->localstock)) {
                        if($local->moyen == 0)
                            $autonom = '--';
                        else
                            $autonom = $mesure[0]->mesure / $local->moyen;
                    }
                    else{
                        $autonom = "--";
                    }
                }
                ?>
                <tr>
                    <td><?=$entite?></td>
                    <td><?php if($autonom != "--") echo number_format($autonom,1,".",","); else echo $autonom ?></td>
                    
                </tr>
                <?php
            endforeach;
            ?>
            </tbody>
        </table>
    </div>
    <div id="tab3">

        <h4>Livraison :</h4>
        <table style="text-align: center">
            <thead>
            <tr>
            <th rowspan="2">Fournisseur</th>
            <th colspan="6">
                    Commande
            </th>
            </tr>
            <tr>
                <th>Date</th>
                <th>Quantite</th>
                <th>Entite</th>
                <th>Recu global</th>
                <th>Recu par mois</th>
                <th>Recu par ans</th>

            </tr>


            </thead>
            <tbody>
            <?php
            $d = $date;
            foreach (\App\Table\Fournisseur::all() as $fournisseur):
                foreach (\App\Table\Entitie::all() as $entite):
                    $commandes = \App\Table\Commande::query("select * from commandes where  id=(select max(id) from commandes where fournisseur = {$fournisseur->id} and entite = {$entite->id})",true);
                    if($commandes === array()) continue;
                    foreach ($commandes as $commande):
                        $dex = $commande->date_expiration;
                        if($dex == null) $dex = date("Y-m-d");
                        $date_de_commande = new DateTime($commande->date);
                        $date_expiration = new DateTime($dex);
                        $date_de_rapport = new DateTime($d);
                        //var_dump($date2 > $date3);
                        if($date_de_rapport >= $date_de_commande and $date_expiration >= $date_de_rapport):
                        $date = date_parse($d);
                        $q1 = \App\Table\Reception::query("select sum(quantite) as q from receptions where commande = {$commande->id} and year(date) = '{$date['year']}' and month(date) = '{$date['month']}'",true,null,true);
                        $q2 = \App\Table\Reception::query("select sum(quantite) as q from receptions where commande = {$commande->id} and year(date) = '{$date['year']}'",true,null,true);

                        ?>
                        <tr>
                            <td><?=\App\Table\Fournisseur::find($commande->fournisseur)->nom?></td>
                            <td><?=$commande->date?></td>
                            <td><?=$commande->quantite?></td>
                            <td><?=\App\Table\Entitie::find($commande->entite)->nom?></td>
                            <td><?=\App\Table\Commande::recu($commande->id)->qte?></td>
                            <td><?php if($q1 !=null) echo $q1->q?></td>
                            <td><?php if($q2 !=null) echo $q2->q?></td>
                        </tr>
                            <?php endif;?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
    <span style="position: relative;left: 600px;top:20px;text-align: right;">Chef de service</span>
    <page_footer>
        <div style="text-align: center">A PHOSSBOUKRAA, Laayoune le <?=date_in_french(date('Y-m-d')) ?></div>
    </page_footer>
</page>
<?php
$pdf = ob_get_clean();
require_once "pdf.php";
?>


