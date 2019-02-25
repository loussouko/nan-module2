<?php
session_start();
include "../db.php";
$mdpR = $nom = $prenom =$num = $mdp = "";
$mdpError = $mdpRError = $nomError = $prenomError = $numError = $ageError = "";
$isSuccess = "False";
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //verification
    $nom = verif($_POST['nom']);
    $age = verif($_POST['age']);
    $num = verif($_POST['num']);
    $prenom = verif($_POST['prenom']);
    $mdp = verif($_POST['mdp']);
    $mdpR = verif($_POST['mdpR']);
    $isSuccess= "True";
    // connexion a la base de donnee
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
    elseif (!preg_match("/^[a-zA-Z]{4,}$/", $mdp))
    {
        $mdpError = "Au moins quatre lettre !!!";
        $isSuccess = "False";
    }

    if(empty($mdpR))
    {
        $mdpRError = "Veuillez entrer un mot de passe valide svp!!!";
        $isSuccess = "False";
    }
    elseif ($mdpR != $mdp)
    {
        $mdpRError = "Mot de passe incorrect!!!";
        $isSuccess = "False";
    }

    if(!preg_match("/^[0-9]{8,}$/", $num))
    {
        $numError = "Que des chiffres ou numero d'au moins 8 chiffres!!!";
        $isSuccess = "False";
    }

    if(preg_match("/^[0-9]{4}$/", $age ))
    {
        $ageError = "votre age ne peut depasser 3 chiffres!!!";
        $isSuccess = "False";
    }

    //insertion
    if($isSuccess == "True")
    {
        if($nom == $_SESSION['nom'] && $prenom == $_SESSION['prenom'] && $age == $_SESSION['age'] && $num == $_SESSION['num'] && !empty($mdp) && $mdp == $mdpR) {
            $requete = $bdd->prepare("UPDATE user SET mdp =? , mdpR = ? WHERE id=?");
            $requete->execute([sha1($mdp), sha1($mdpR), $_SESSION['id']]);

            $requete = $bdd->prepare("SELECT * FROM user WHERE id=?");
            $requete->execute([$_SESSION['id']]);
            $donnee = $requete->fetch();
            if($donnee)
            {
                $_SESSION['nom'] = $donnee['nom'];
                $_SESSION['prenom'] = $donnee['prenom'];
                $_SESSION['age'] = $donnee['age'];
                $_SESSION['num'] = $donnee['numero'];
                $_SESSION['nationalite'] = $donnee['nationalite'];
                $_SESSION['sexe'] = $donnee['sexe'];
                $_SESSION['statut'] = $donnee['statut'];
                $_SESSION['mdp'] = $donnee['mdp'];
                $_SESSION['mdpR'] = $donnee['mdpR'];
                $_SESSION['mail'] = $donnee['mail'];

            }
            header("Location:index.php");
            exit();
        }
        elseif((($nom != $_SESSION['nom'] && !empty($nom)) || ($prenom != $_SESSION['prenom'] && !empty($prenom)) || ($age != $_SESSION['age'] && !empty($age)) ||
                ($num != $_SESSION['num'] && !empty($num))) && (!empty($mdp) && $mdp == $mdpR)) {
            $requete = $bdd->prepare("UPDATE user SET nom = ? , prenom= ? ,  age=? , numero=? , mdp =? , mdpR = ? WHERE id=?");
            $requete->execute([$nom, $prenom,$age,$num, sha1($mdp), sha1($mdpR), $_SESSION['id']]);

            $requete = $bdd->prepare("SELECT * FROM user WHERE id=?");
            $requete->execute([$_SESSION['id']]);
            $donnee = $requete->fetch();
            if($donnee)
            {
                $_SESSION['nom'] = $donnee['nom'];
                $_SESSION['prenom'] = $donnee['prenom'];
                $_SESSION['age'] = $donnee['age'];
                $_SESSION['num'] = $donnee['numero'];
                $_SESSION['nationalite'] = $donnee['nationalite'];
                $_SESSION['sexe'] = $donnee['sexe'];
                $_SESSION['statut'] = $donnee['statut'];
                $_SESSION['mdp'] = $donnee['mdp'];
                $_SESSION['mdpR'] = $donnee['mdpR'];
                $_SESSION['mail'] = $donnee['mail'];

            }
            header("Location:index.php");
            exit();
        }
    }
}

function verif($var)
{
    $var = trim($var);
    $var = stripcslashes($var);
    $var = htmlspecialchars($var);

    return $var;
}


?>
<?php if(!empty($_SESSION['mail'])&& !empty($_SESSION['mdp']) && $_SESSION['statut'] == "admin"): ?>
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
                <a href="index.php" class="navbar-brand "><img src="../public/images/logo.png" alt=""></a>
            </nav>
            <!-- partie gauche-->
            <div class="col-lg-2 bg-danger" style="padding:0; height: 580px;">
                <div class="text-center mt-4 bg-light mx-3" style="height: 170px;">
                    <img src="<?= $_SESSION['image'] ?>" alt="" class="img-fluid rounded-circle" style="height: 80px;">
                    <p><?php echo $_SESSION['nom']; ?></p>
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
                                    <button class="btn btn-link text-danger" data-toggle="collapse" data-target="#compte" style="font-size: 20px; text-decoration:none;">
                                        <i class="fa fa-user-friends mr-1"></i>Clients
                                    </button>
                                </div>
                                <div class="collapse" id="compte" data-parent="#parent">
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
                <div class="alert alert-success mt-2">
                    <p class="h5 text-center">MODIFIER PROFIL</p>
                </div>

                <div>
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="post" class="bg-warning rounded" style="padding: 30px;  font-weight: bold">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nom" class="col-form-label col-sm-6">Nom:</label>
                                <div class="col-sm-12">
                                    <input type="text" id="nom" name="nom" class="form-control" placeholder="Votre nom"
                                           value="<?php if(empty($nom))echo $_SESSION['nom']; else echo $nom; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="prenom" class="col-form-label col-sm-6">Prenom:</label>
                                <div class="col-sm-12">
                                    <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Votre prenom" value="
<?php if(empty($prenom))echo $_SESSION['prenom']; else echo $prenom; ?>" />
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="age" class="col-form-label col-sm-6">Age:</label>
                                <div class="col-sm-12">
                                    <input type="number" id="age" name="age" class="form-control" placeholder="Votre age"
                                           value="<?php if(empty($age))echo $_SESSION['age']; else echo $age; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $ageError; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="num" class="col-form-label col-sm-6">Numero:</label>
                                <div class="col-sm-12">
                                    <input type="text" id="num" name="num" class="form-control" placeholder="Votre numero"
                                           value="<?php if(empty($num))echo $_SESSION['num']; else echo $num; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $numError; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mdp" class="col-form-label col-sm-6">Mot de passe:</label>
                                <div class="col-sm-12">
                                    <input type="password" id="mdp" name="mdp" class="form-control" placeholder="Votre mot de passe"  value="<?php echo $mdp ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $mdpError; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mdpR" class="col-form-label col-sm-6">Confirmer mot de passe:</label>
                                <div class="col-sm-12">
                                    <input type="password" id="mdpR" name="mdpR" class="form-control" placeholder="Votre mot de passe"  value="<?php echo $mdpR ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $mdpRError; ?></span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <a  href="index.php" class="btn btn-secondary text-light offset-lg-2 col-lg-6 offset-md-2 col-md-6  col-12">ANNULER</a>
                            </div>
                            <div class="form-group col-md-6">
                                <button type="submit" class="btn btn-danger text-light offset-lg-2 col-lg-6 offset-md-2 col-md-6   col-12">MODIFIER</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div>
                    <form action="image.php" method="post" enctype="multipart/form-data" class="bg-success rounded" style="padding: 18px;  font-weight: bold">
                        <div class="form-group row">
                            <label for="image" class="col-form-label col-sm-1">Image:</label>
                            <div class="col-sm-6">
                                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                                <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"></span>
                            </div>
                            <a  href="index.php" class="btn btn-secondary text-light col-lg-2  col-md-2 col-5 mr-1">ANNULER</a>
                            <button type="submit" name="send" class="btn btn-danger text-light col-lg-2  col-md-2 col-5">CHOISIR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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