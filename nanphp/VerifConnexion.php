<?php
session_start();
ini_set("display_errors",0);error_reporting(0);
include "db.php";
$mail = $mdp = "";
$statut = "defaut";
$isSuccess = "False";
$mailError = $statutError = $mdpError = "";

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //verification
    $mail = verif($_POST['mail']);
    $mdp = verif($_POST['mdp']);
    $statut = verif($_POST['statut']);
    $isSuccess= "True";
    // connexion a la base de donnee
    $requete= $bdd->prepare("SELECT * FROM user WHERE mail=?");
    $requete->execute([$mail]);
    $donnee = $requete->fetch();
    if($donnee)
    {
        $_SESSION['id']= $donnee['id'];
        $_SESSION['mail']= $donnee['mail'];
        $_SESSION['prenom']= $donnee['prenom'];
        $_SESSION['mdp']= $donnee['mdp'];
        $_SESSION['statut']= $donnee['statut'];
        $_SESSION['num']= $donnee['numero'];
        $_SESSION['sexe']= $donnee['sexe'];
        $_SESSION['nationalite']= $donnee['nationalite'];
        $_SESSION['age']= $donnee['age'];
        $_SESSION['nom']= $donnee['nom'];
    }
    $requete= $bdd->prepare("SELECT image FROM avatar WHERE id_users = ?");
    $requete->execute([$_SESSION['id']]);
    $res = $requete->fetch();
    if($donnee)
    {
        $_SESSION['image']= $res['image'];
    }
    //verification des champs
if(!isMail($mail))
{
   $mailError = "Veuillez entrer un mail valide svp!!!";
   $isSuccess = "False";
}
elseif($mail != $_SESSION['mail'])
{
    $mailError = "Mail incorrect!!!";
    $isSuccess = "False";
}

if(empty($mdp))
{
    $mdpError = "Veuillez entrer un mot de passe valide svp!!!";
    $isSuccess = "False";
}
elseif(strlen($mdp) < 6)
{
    $mdpError = "Veuillez entrer un mot de passe d'au mons 6 caracteres!!!";
    $isSuccess = "False";
}
elseif (!preg_match("/^[a-zA-Z]{4,}$/", $mdp ))
{
    $mdpError = "Au moins quatre lettre !!!";
    $isSuccess = "False";
}
elseif(sha1($mdp) != $_SESSION['mdp'])
{
    $mdpError = "mot de passe incorrect !!!";
    $isSuccess = "False";
}

if($statut == "defaut")
{
    $statutError = "Veuillez choisir votre statut svp!!!";
    $isSuccess = "False";
}
elseif($statut != $_SESSION['statut'])
{
    $statutError = "statut incorrect!!!";
    $isSuccess = "False";
}
if($isSuccess)
{
    $_SESSION['acces'] = 'ok';
}
}
function verif($var)
{
    $var = trim($var);
    $var = stripcslashes($var);
    $var = htmlspecialchars($var);

    return $var;
}
function isMail($var)
{
    return filter_var($var, FILTER_VALIDATE_EMAIL);

}
?>

<?php if($isSuccess == 'False'):?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset=UTF-8">
    <title>Connexion</title>
    <meta name="viewport" content="width=width-device, initial-scale=1 , shrink-to-fit=no">
    <link rel="stylesheet" href="public/bootstrap-4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/fontawesome/css/all.css">
    <!--inclusion des script-->
    <script src="public/fontawesome/js/all.js"></script>
    <script src="public/bootstrap-4.2.1/js/popper.min.js"></script>
    <script src="public/bootstrap-4.2.1/js/jquery-3.3.1.slim.min.js"></script>
    <script src="public/bootstrap-4.2.1/js/bootstrap.min.js"></script>
</head>
<body class="bg-primary" style="margin-top: 110px">
<div class="container">
    <div class="row">
        <div class="offset-lg-4 col-lg-4 col-sm-12 col-md-6 offset-md-3">
            <form action="<?php $_SERVER['PHP_SELF']?>" class="bg-light rounded" style="padding: 40px;  font-weight: bold" method="post">
                <div class="form-group">
                    <div class="text-center">
                        <span><i class="fa fa-user-circle fa-4x text-primary "></i></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mail" class="col-form-label col-sm-12 text-center">Email</label>
                    <div class="col-sm-12">
                        <input type="email" id="mail" name="mail" class="form-control" placeholder="Votre email" required="required" value =
                        "<?php echo $mail; ?>" >
                        <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $mailError; ?></span>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="mdp" class="col-form-label col-sm-12 text-center">Mot de passe</label>
                    <div class="col-12">
                        <input type="password" id="mdp" name="mdp" class="form-control" placeholder="Votre mot de passe" required="required"
                        value = "<?php echo $mdp; ?>">
                        <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $mdpError; ?></span>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="statut" class="col-form-label col-sm-12 text-center">Statut</label>
                    <div class="col-12">
                        <select name="statut" id="statut" class="custom-select" value=" <?php echo $statut; ?>">
                            <option value="defaut">----</option>
                            <option value="client">Client</option>
                            <option value="admin">Administrateur</option>
                        </select>
                        <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $statutError; ?></span>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning text-light col-12" >CONNECTER</button>
        </div>
    </div>

    </form>
</div>
</body>
</html>
<?php elseif($_SESSION['mail']== $mail && $_SESSION['mdp']== sha1($mdp) && $_SESSION['statut'] == "admin"):
    header("Location:Admin/index.php"); exit()?>
<?php elseif($_SESSION['mail']== $mail && $_SESSION['mdp']== sha1($mdp) && $_SESSION['statut'] == "client"):
header("Location:dashbord.php"); exit()?>
<?php else:
header("Location: index.php");
endif;
?>



