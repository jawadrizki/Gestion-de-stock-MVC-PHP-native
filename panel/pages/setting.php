<?php
require_once "../App/App.php";
$app = new \App\App();
if(isset($_POST['save'])){
    $errors = [];
    if(isset($_POST['oldpwd']) and $_POST['oldpwd'] === $app::getPass()) {
        if (isset($_POST['pwd']) and ($_POST['pwd'] === $_POST['cpwd'])) {
            if(strlen($_POST['pwd']) < 7)
                $errors[0] = "Le mot de pass doit contenire plus que 6 caracteres";
            else
                $app::setPass($_POST['pwd']);
        }else{
            $errors[0] = "Le nouveau mot de passe n'est pas bien confirmer !";
        }
    }else{
        $errors[0] = "Le mot de passe est incorrect !";
    }
    if($errors !== [])
        \App\App::showErrors($errors);
    else
        \App\App::showSuccess("Le mot de passe etait modifier");
}
?>
<div class="col-md-3"></div>
<div class="col-md-6">

    <div class="panel panel-info">
        <div class="panel-heading">Modifier votre mot de passe</div>
        <form method="post">
            <table class="table">
                <tr>
                    <td>Mot de pass actuel :</td>
                    <td><input type="password" value="<?=@$_POST['oldpwd']?>" name="oldpwd" required></td>
                </tr>
                <tr>
                    <td>Nouveau mot de passe</td>
                    <td><input type="password" value="<?=@$_POST['pwd']?>" name="pwd" required></td>
                </tr>
                <tr>
                    <td>Confirmer votre Nouveau mot de passe</td>
                    <td><input type="password" value="<?=@$_POST['cpwd']?>" name="cpwd" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" style="float:right;" class="btn btn-success" value="Enregistrer" name="save"></td>
                </tr>

            </table>
        </form>
    </div>
</div>
<div class="col-md-3"></div>

