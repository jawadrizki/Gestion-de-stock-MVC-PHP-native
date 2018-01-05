<?php

?>

<?php
if(isset($_POST['get'])){
    if($_POST['date'] === null or $_POST['date'] === "0000-00-00"):
        header("#");
    else:
        $date = $_POST['date'];
        require_once  "../App/App.php";
        require_once "../App/Table/Localstock.php";
        require_once "../App/Table/Mesure.php";
        require_once "actionRapport.php";
    endif;
}else{
    $date =date("Y-m-d");
    $html = '<form method="post" action="pages/actionRapport.php">
<table class="table">

      <tr>
      <td>
<input type="date" value="'.$date.'" name="date"/>      
</td>
<td>
 <input type="submit" class="btn btn-sm btn-success" name="get" value="Generer un Rapport"/>
</td>
</tr> 
</table>
        </form>';
    \App\App::panel("Rapports",$html);
}
?>

