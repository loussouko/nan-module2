<?php
session_start();
include "../db.php";
$nom = $prenom =$num = $mdp = $nat = $mail =$age = $code = "";
$mdpError = $nomError = $prenomError = $numError =$codeError= $ageError = $compteError = $natError = $sexeError=$statutError=$mailError= "";
$isSuccess = "False";
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //verification
    $nom = verif($_POST['nom']);
    $prenom = verif($_POST['prenom']);
    $age = verif($_POST['age']);
    $num = verif($_POST['num']);
    $nat = verif($_POST['nat']);
    $mdp = verif($_POST['mdp']);
    $compte = verif($_POST['compte']);
    $sexe = verif($_POST['sexe']);
    $statut = verif($_POST['statut']);
    $mail = verif($_POST['mail']);
    $code = verif($_POST['code']);
    $isSuccess= "True";
    // mot de passe
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
    //nom
        if(empty($nom))
    {
        $nomError = "Veuillez entrer un nom valide svp!!!";
        $isSuccess = "False";
    }
    elseif (!preg_match("/^[a-zA-Z]{4,}$/", $nom))
    {
        $nomError = "Au moins quatre lettre !!!";
        $isSuccess = "False";
    }
    //prenom
        if(empty($prenom))
    {
        $prenomError = "Veuillez entrer un prenom valide svp!!!";
        $isSuccess = "False";
    }
    elseif (!preg_match("/^[a-zA-Z ]{4,}$/", $prenom))
    {
        $prenomError = "Au moins quatre lettre !!!";
        $isSuccess = "False";
    }
   //mail
    if(!isMail($mail))
    {
       $mailError = "Veuillez entrer un mail valide svp!!!";
       $isSuccess = "False";
    }
    elseif (empty($mail)) {
        $mailError = "le mail ne peut etre vide svp!!!";
         $isSuccess = "False";
    }
    //numero
    if(!preg_match("/^[0-9]{8,}$/", $num))
    {
        $numError = "Que des chiffres ou numero d'au moins 8 chiffres!!!";
        $isSuccess = "False";
    }
    elseif ($num == "") {
       $numError = "le numero ne peut etre vide!!!";
       $isSuccess = "False";
    }
    //age
    if(preg_match("/^[0-9]{4}$/", $age ))
    {
        $ageError = "votre age ne peut depasser 3 chiffres!!!";
        $isSuccess = "False";
    }
    elseif (empty($age)) {
        $ageError = "votre age ne peut pas etre vide chiffres!!!";
        $isSuccess = "False";
    }
    //nationalite
        if(empty($nat))
    {
        $natError = "Veuillez entrer un nom valide svp!!!";
        $isSuccess = "False";
    }
    //sexe
        if(empty($sexe))
    {
        $sexeError = "Veuillez entrer un sexe valide svp!!!";
        $isSuccess = "False";
    }
    //statut
       if(empty($statut))
    {
        $statutError = "Veuillez entrer un statut valide svp!!!";
        $isSuccess = "False";
    }
    //compte
       if(empty($compte))
    {
        $compteError = "Veuillez entrer un montant de compte valide svp!!!";
        $isSuccess = "False";
    }
    //code secret
     if(!preg_match("/^[0-9]{9}$/", $code))
    {
        $codeError = "Code egal a 9 chiffres!!!";
        $isSuccess = "False";
    }
    elseif(empty($code))
    {
        $codeError = "veuillez entrer votre code !!!";
        $isSuccess = "False";
    }
    //insertion
    if($isSuccess == "True")
    {
        $insert =$bdd->prepare("INSERT INTO user (nom,prenom,age,numero,nationalite,sexe,statut,mdp,mdpR,mail) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $insert->execute([$nom,$prenom,$age,$num,$nat,$sexe,$statut,sha1($mdp),sha1($mdp),$mail]);
        $insert->closeCursor();
        $select =$bdd->prepare("SELECT id FROM user WHERE mail=? AND statut =?");
        $select->execute([$mail,$statut]);
        if($donnee = $select->fetch())
        {
            $_SESSION['D']= $donnee['id'];
        }
        $select->closeCursor();
         $insert =$bdd->prepare("INSERT INTO compte (mail,solde,code,compte_user) VALUES (?,?,?,?)");
         $bdd->beginTransaction();
        $insert->execute([$mail,$compte,$code,$_SESSION['D']]);
        $bdd->commit();
        $insert->closeCursor();
      $nom = $prenom =$num = $mdp = $nat = $mail =$age =$code= "";
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


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header ">
                                <p class=" text-center h1">LISTE DES CLIENTS</p>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered table-responsive table-condensed">
                                    <tr>
                                        <th class="text-danger">NOM</th>
                                        <th class="text-danger">PRENOM</th>
                                        <th class="text-danger">AGE</th>
                                        <th class="text-danger">NUMERO</th>
                                        <th class="text-danger">NATIONALITE</th>
                                        <th class="text-danger">SEXE</th>
                                        <th class="text-danger">MAIL</th>
                                        <th class="text-danger">COMPTE</th>
                                        <th class="text-danger">ACTION</th>
                                    </tr>
                                    <?php
                                    $stat = "client";
                                    $requete= $bdd->prepare("SELECT *,u.id As id_u FROM user u INNER JOIN compte c ON u.id  = c.compte_user WHERE u.statut = ?");
                                    $requete->execute([$stat]);
                                    $donnee = $requete->fetchAll();  ?>
                                    <?php $i = 0; while($i < count($donnee)): ?>
                                        <tr>
                                            <td><?php echo $donnee[$i]['nom']?></td>
                                            <td><?php echo $donnee[$i]['prenom']?></td>
                                            <td><?php echo $donnee[$i]['age']?></td>
                                            <td><?php echo $donnee[$i]['numero']?></td>
                                            <td><?php echo $donnee[$i]['nationalite']?></td>
                                            <td><?php echo $donnee[$i]['sexe']?></td>
                                            <td><?php echo $donnee[$i]['mail']?></td>
                                            <td><?php echo $donnee[$i]['solde']?></td>
                                            <td><a class="btn btn-danger" href="delete.php?q=<?php echo $donnee[$i]['id_u'];?>">SUPPRIMER</button>
                                            </td>
                                        </tr>
                                        <?php $i++;$requete->closeCursor(); endwhile;?>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-12 mt-2">
                        <form action="<?php $_SERVER['PHP_SELF']?>" method="post" class="bg-warning rounded" style="padding: 30px;  font-weight: bold">
                            <h1 class="text-danger h4 text-center">CREATION DES UTILISATEURS</h1>
                            <div class="form-group">
                                <label for="mail" class="col-form-label col-sm-12 text-center">Nom:</label>
                                <div class="col-sm-12">
                                    <input type="text" id="nom" name="nom" class="form-control" placeholder="Votre nom"
                                           value="<?php echo $nom; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $nomError; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="prenom" class="col-form-label col-sm-12 text-center">Prenom</label>
                                <div class="col-sm-12">
                                    <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Votre prenom" value="<?php echo $prenom; ?>" />
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $prenomError; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="age" class="col-form-label col-sm-12 text-center">Age:</label>
                                <div class="col-sm-12">
                                    <input type="number" id="age" name="age" class="form-control" placeholder="Votre age" value="<?php echo $age; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $ageError; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="num" class="col-form-label col-sm-12 text-center">Numero:</label>
                                <div class="col-sm-12">
                                    <input type="number" id="num" name="num" class="form-control" placeholder="Votre numero" value="<?php echo $num; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $numError; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nat" class="col-form-label col-sm-12 text-center">Nationalite:</label>
                                <div class="col-sm-12">
                                    <input type="text" id="nat" name="nat" class="form-control" placeholder="Votre nationalite" value="<?php echo $nat; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $natError; ?></span>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="sexe" class="col-form-label col-sm-12 text-center">Sexe:</label>
                                <div class="col-12">
                                    <select name="sexe" id="sexe" class="custom-select">
                                        <option value="masculin">Masculin</option>
                                        <option value="feminin">Feminin</option>
                                    </select>
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $sexeError; ?></span>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="statut" class="col-form-label col-sm-12 text-center">Statut:</label>
                                <div class="col-12">
                                    <select name="statut" id="statut" class="custom-select">
                                        <option value="client">Client</option>
                                        <option value="admin">Administrateur</option>
                                    </select>
                                      <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $statutError; ?></span>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="mdp" class="col-form-label col-sm-12 text-center">Mot de passe</label>
                                <div class="col-12">
                                    <input type="password" id="mdp" name="mdp" class="form-control" placeholder="Votre mot de passe" value="<?php echo $mdp;?>"required>
                                      <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $mdpError; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mail" class="col-form-label col-sm-12 text-center">Email</label>
                                <div class="col-sm-12">
                                    <input type="email" id="mail" name="mail" class="form-control" placeholder="Votre email" required="required" value="<?php echo $mail ?>">
                                      <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $mailError; ?></span>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="compte" class="col-form-label col-sm-12 text-center">Solde Compte:</label>
                                <div class="col-12">
                                    <select name="compte" id="compte" class="custom-select">
                                        <option value="500000">500000</option>
                                    </select>
                                      <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $compteError; ?></span>
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="code" class="col-form-label col-sm-12 text-center">Code secret:</label>
                                <div class="col-sm-12">
                                    <input type="number" id="code" name="code" class="form-control" placeholder="Votre code" value="<?php echo $code; ?>" />
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $codeError; ?></span>
                                </div>
                            </div>

                            <div class="form-group ">
                                <button type="submit" class="btn btn-danger text-light offset-3 col-6">ENVOYER</button>
                            </div>


                        </form>
                    </div>

                      <div class="col-lg-5 col-md-5 col-12 mt-2">
                        <form action="pass.php" method="post" class="bg-warning rounded" style="padding: 30px;  font-weight: bold">
                            <h1 class="text-danger h4 text-center">RENITIALISER MOT DE PASSE</h1>
                            <div class="form-group ">
                                <label for="md" class="col-form-label col-sm-12 text-center">Mot de passe</label>
                                <div class="col-12">
                                    <input type="password" id="md" name="md" class="form-control" placeholder="Votre mot de passe" required>
                                </div>
                            </div>
                             <div class="form-group ">
                                <label for="mdR" class="col-form-label col-sm-12 text-center">Confirnez Mot de passe</label>
                                <div class="col-12">
                                    <input type="password" id="mdR" name="mdR" class="form-control" placeholder="Votre mot de passe" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mailE" class="col-form-label col-sm-12 text-center">Email</label>
                                <div class="col-sm-12">
                                    <input type="email" id="mailE" name="mailE" class="form-control" placeholder="Votre email" required="required">
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
