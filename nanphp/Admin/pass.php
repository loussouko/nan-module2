<?php
session_start();
ini_set("display_errors",0);error_reporting(0);
include "../db.php";
$md= $mdR =$mailE="";
$mdError = $mdRError =$mailEError= "";
$isSuccess = "False";
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //verification
    $md= verif($_POST['md']);
    $mdR = verif($_POST['mdR']);
    $mailE= verif($_POST['mailE']);
    $isSuccess= "True";
    $requete= $bdd->prepare("SELECT mail FROM user WHERE mail != ? AND mail = ?");
    $requete->execute([$_SESSION['mail'], $mailE]);
    $donnee = $requete->fetch();
    if($donnee)
    {
        $_SESSION['ml'] = $donnee['mail'];
    }
    // mot de passe
    if(empty($md))
    {
        $mdError = "Veuillez entrer un mot de passe valide svp!!!";
        $isSuccess = "False";
    }
    elseif(strlen($md) < 6)
    {
        $mdError = "Veuillez entrer un mot de passe d'au mons 6 caracteres!!!";
        $isSuccess = "False";
    }
    elseif (!preg_match("/^[a-zA-Z]{4,}$/", $md))
    {
        $mdError = "Au moins quatre lettre !!!";
        $isSuccess = "False";
    }


    //MD
     if(empty($mdR))
    {
        $mdError = "Veuillez entrer un mot de passe valide svp!!!";
        $isSuccess = "False";
    }
      elseif($md != $mdR)
    {
        $mdRError = "mot de passe different!!!";
        $isSuccess = "False";
    }
    //mail
    if(!isMail($mailE))
    {
       $mailEError = "Veuillez entrer un mail valide svp!!!";
       $isSuccess = "False";
    }
    elseif ($mailE != $_SESSION['ml']) {
        $mailEError = "le mail n'existe pas dans la base de donnee!!!";
         $isSuccess = "False";
    }
    elseif (empty($mailE)) {
        $mailEError = "le mail ne peut etre vide svp!!!";
         $isSuccess = "False";
    }
    //insertion
    if($isSuccess == "True")
    {
        $insert =$bdd->prepare("UPDATE user SET mdp = ?, mdpR=? WHERE mail=?");
        $insert->execute([sha1($md),sha1($mdR),$mailE]);
        $insert->closeCursor();
        header("Location:client.php");
        exit();
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
<?php if(!empty($_SESSION['mail'])&& !empty($_SESSION['mdp']) && $_SESSION['statut'] == "admin"):?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <meta charset=UTF-8">
        <title>Connexion</title>
        <meta name="viewport" content="width=device-width, initial-scale=1 , shrink-to-fit=no">
        <link rel="stylesheet" href="../public/bootstrap-4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="../public/fontawesome/css/all.css">
        <!--inclusion des script-->
        <script src="../public/fontawesome/js/all.js"></script>
        <script src="../public/bootstrap-4.2.1/js/popper.min.js"></script>
        <script src="../public/bootstrap-4.2.1/js/jquery-3.3.1.slim.min.js"></script>
        <script src="../public/bootstrap-4.2.1/js/bootstrap.min.js"></script>
    </head>
    <body>
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-md bg-danger col-12">
                <a href="index.php" id="bank" class="navbar-brand "><img src="../public/images/logo.png" alt=""></a>
            </nav>
            <!-- partie gauche-->
            <div class="col-lg-2 bg-danger" style="padding:0; height:1700px;">
                <div class="text-center mt-4 bg-light mx-3" style="height: 170px;">
                    <img src="<?= $_SESSION['image'] ?>" alt="" class="img-fluid rounded-circle" style="height: 80px;">
                    <p><?php echo  $_SESSION['nom']; ?></p>
                    <a class="btn btn-danger" href="../deconnexion.php"><i class="fa fa-unlock-alt mr-1"></i>Deconnexion</a>
                </div>
                <div class="col-12">
                    <aside>
                        <div id="parent">
                            <div class="card-header bg-light d-flex justify-content-center">
                                <a class="btn btn-link text-danger" href="index.php" style="font-size: 25px; text-decoration:none;">
                                    <i class="fa fa-home mr-2"></i>Home
                                </a>
                            </div>
                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-center">
                                    <button class="btn btn-link text-danger" data-toggle="collapse" data-target="#profil" style="font-size: 25px; text-decoration:none;">
                                        <i class="fa fa-user-alt mr-2"></i>Profil
                                    </button>
                                </div>
                                <div class="collapse" id="profil" data-parent="#parent">
                                    <div class="card-body">
                                        <p style="font-size: 20px; text-align: center;"><a href="profilAdmin.php"><i class="fa fa-arrow-right mr-2"></i>Mon profil</a></p>
                                        <p style="font-size: 20px; text-align: center;"><a href="modifProfilAdmin.php"><i class="fa fa-arrow-right mr-2"></i>Modifier profil</a></p>
                                    </div>
                                </div>

                            </div>

                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-center">
                                    <button class="btn btn-link text-danger" data-toggle="collapse" data-target="#compte1" style="font-size: 20px; text-decoration:none;">
                                        <i class="fa fa-user-friends mr-1"></i>Client
                                    </button>
                                </div>
                                <div class="collapse" id="compte1" data-parent="#parent">
                                    <div class="card-body">
                                        <p style="font-size: 20px; text-align: center;"><a href="client.php"><i class="fa fa-arrow-right mr-2"></i>compte</a></p>
                                        <p style="font-size: 20px; text-align: center;"><a href="transfert.php"><i class="fa fa-arrow-right mr-2"></i>Transfert</a></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </aside>
                </div>

            </div>

            <!-- partie droite-->
            <div class="col-lg-10">
                <div class="alert alert-primary mt-2">
                    <p class="h5 text-center">ADMINISTRATION DES CLIENTS</p>
                </div>        

                      <div class="col-lg-5 col-md-5 col-12 mt-2">
                        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" class="bg-warning rounded" style="padding: 30px;  font-weight: bold">
                            <h1 class="text-danger h4 text-center">RENITIALISER MOT DE PASSE</h1>
                            <div class="form-group ">
                                <label for="md" class="col-form-label col-sm-12 text-center">Mot de passe</label>
                                <div class="col-12">
                                    <input type="password" id="md" name="md" class="form-control" placeholder="Votre mot de passe"  value="<?php echo $md; ?>"required>
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $mdError; ?></span>
                                </div>
                            </div>
                             <div class="form-group ">
                                <label for="mdR" class="col-form-label col-sm-12 text-center">Confirnez Mot de passe</label>
                                <div class="col-12">
                                    <input type="password" id="mdR" name="mdR" class="form-control" placeholder="Votre mot de passe" required  value="<?php echo $mdR; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $mdRError; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mailE" class="col-form-label col-sm-12 text-center">Email</label>
                                <div class="col-sm-12">
                                    <input type="email" id="mailE" name="mailE" class="form-control" placeholder="Votre email" required="required"  value="<?php echo $mailE; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $mailEError; ?></span>
                                </div>
                            </div>
                            <div class="form-group ">
                                <button type="submit" class="btn btn-danger text-light offset-3 col-6">MODIFIER</button>
                            </div>
                        </form>
                    </div>
            </div>
                        <a href="#bank" class="col-sm-2 mt-2 " style=" float: right;">
                            <i class="fa fa-arrow-up"></i>
                        </a>
        </div>
    </div>
</div>
    <nav class="navbar navbar-expand-md bg-danger col-12 d-flex justify-content-center">
        <a class="h5">Copyright <i class="far fa-copyright"></i> BY OBANK 2019-2024</a>
    </nav>
    </body>
    </html>
<?php else:
    header("Location: ../index.php");exit();
endif;
?>