<?php
session_start();
ini_set("display_errors",0);error_reporting(0);
include "db.php";
$mail = $code = $mailD =$mont = $frais = "";
$mailError = $codeError = $mailDError  = $montError = $fraisError = "";
$isSuccess = "False";
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //verification
    $mail= verif($_POST['mail']);
    $code = verif($_POST['code']);
    $mont= verif($_POST['mont']);
    $mailD = verif($_POST['mailD']);
    $isSuccess= "True";
    // connexion a la base de donnee
    $statut = "client";
    $requete= $bdd->prepare("SELECT mail FROM user WHERE mail != ? AND statut = ? AND mail = ?");
    $requete->execute([$_SESSION['mail'],$statut, $mailD]);
    $donnee = $requete->fetch();
    if($donnee)
    {
        $_SESSION['mailD'] = $donnee['mail'];
    }
    //mail expediteur
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
     elseif(empty($mail))
     {
         $mailError = "votre mail ne peut etre vide!!!";
         $isSuccess = "False";
     }
      //mailD
    if(!isMail($mailD))
    {
        $mailDError = "Veuillez entrer un mail valide svp!!!";
        $isSuccess = "False";
    }
    elseif (empty($mailD))
    {
        $mailDError = "votre mail ne peut etre vide!!!";
        $isSuccess = "False";
    }
    elseif ($mailD == $_SESSION['mail'])
    {
        $mailDError = "impossible de se transferer soi-meme de l'argent!!!";
        $isSuccess = "False";
    }
      elseif($mailD != $_SESSION['mailD'])
    {
        $mailDError = "Mail n'existe pas dans la base de donnee!!!";
        $isSuccess = "False";
    }

     //code
    if(!preg_match("/^[0-9]{6,}$/", $code))
    {
        $codeError = "Que des chiffres ou chiffres superieures a 5 caracteres!!!";
        $isSuccess = "False";
    }
    elseif (strlen($code) < 6)
    {
        $codeError = "Que des chiffres superieure a 5 caracteres!!!";
        $isSuccess = "False";
    }
    elseif(empty($code))
    {
        $codeError = "veuillez entrer votre code !!!";
        $isSuccess = "False";
    }
    elseif ($code != $_SESSION['code'])
    {
        $codeError = "code incorrect!!!";
        $isSuccess = "False";
    }
   //frais
    $requete= $bdd->prepare("SELECT frais FROM frais WHERE min <= ? AND max >=?");
    $requete->execute([$mont,$mont]);
    $donnee = $requete->fetch();
    if($donnee)
    {
        $frais = $donnee['frais'];
    } 
      //montant
    if(!preg_match("/^[0-9]*$/", $mont))
    {
        $montError = "Que des chiffres !!!";
        $isSuccess = "False";
    }
    elseif(empty($mont))
    {
        $montError = "veuillez entrer le montant !!!";
        $isSuccess = "False";
    }
     elseif ($_SESSION['solde'] < ($mont + $frais))
    {
        $montError = "votre solde est inferieure au montant du transfert y compris les frais";
        $isSuccess = "False";
    }
     elseif ($mont > 500000)
    {
        $montError = "le montant ne peut depasser 500000 FCFA!!!";
        $isSuccess = "False";
    }
    elseif ($mont >= $_SESSION['solde'])
    {
        $montError = "le montant ne peut depasser votre solde !!!";
        $isSuccess = "False";
    }
    elseif($mont == 0 || $mont < 0)
    {
        $montError = "le montant ne peut pas etre inferieure ou egal a zero !!!";
        $isSuccess = "False";
    }
    elseif($mont >=100 && $mont <=199)
    {
        $montError = "impossible de faire un transfert de 100 F A 199 F";
        $isSuccess = "False";
    }

    //insertion
    if($isSuccess == "True")
    {
        //mise a jour du transfert
        $bdd ->beginTransaction();
        $transfert =$bdd->prepare("INSERT INTO transfert (mail_expediteur,code_expediteur,mail_destinataire,montant,frais) VALUES (?,?,?,?,?)");
        $transfert->execute([$mail,$code,$mailD,$mont,$frais]);

        // retrait de l'argent
        $stmt1 = $bdd->prepare('UPDATE compte SET solde = solde - ? WHERE compte_user = ?');
        $stmt2 = $bdd->prepare('UPDATE compte SET solde = solde + ? WHERE mail = ?');
        
        // Retrait du Compte1
        $mont += $frais;
        $stmt1->execute([$mont, $_SESSION['id']]);

        // Credit du Compte2
        $mont -= $frais;
        $stmt2->execute([$mont, $mailD]);
        //on termine la transaction
        $bdd -> commit();

    
        $mail = $code = $mailD =$mont = $frais = "";
        header("Location:transfert.php");
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
<?php if(!empty($_SESSION['mail'])&& !empty($_SESSION['mdp']) && $_SESSION['statut'] == "client"):?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <meta charset=UTF-8">
        <title>Connexion</title>
        <meta name="viewport" content="width=device-width, initial-scale=1 , shrink-to-fit=no">
        <link rel="stylesheet" href="public/bootstrap-4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="public/fontawesome/css/all.css">
        <!--inclusion des script-->
        <script src="public/fontawesome/js/all.js"></script>
        <script src="public/bootstrap-4.2.1/js/popper.min.js"></script>
        <script src="public/bootstrap-4.2.1/js/jquery-3.3.1.slim.min.js"></script>
        <script src="public/bootstrap-4.2.1/js/bootstrap.min.js"></script>
    </head>
    <body>
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-md bg-primary col-12">
                <a href="dashbord.php" class="navbar-brand "><img src="public/images/logo.png" alt=""></a>
            </nav>
            <!-- partie gauche-->
            <div class="col-lg-2 col-12 bg-primary" style="padding:0; height: 580px;">
                <div class="text-center mt-4 bg-light mx-3" style="height: 170px;">
                    <img src="<?= $_SESSION['image'] ?>" alt="" class="img-fluid rounded-circle" style="height: 80px;">
                    <p><?php echo $_SESSION['nom']; ?></p>
                    <a class="btn btn-danger" href="deconnexion.php"><i class="fa fa-unlock-alt mr-1"></i>Deconnexion</a>
                </div>
                <div class="col-12">
                    <aside>
                        <div id="parent">
                            <div class="card-header bg-light d-flex justify-content-center">
                                <a class="btn btn-link text-danger" href="dashbord.php" style="font-size: 25px; text-decoration:none;">
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
                                        <p style="font-size: 20px; text-align: center;"><a href="profil.php"><i class="fa fa-arrow-right mr-2"></i>Mon profil</a></p>
                                        <p style="font-size: 20px; text-align: center;"><a href="modifProfil.php"><i class="fa fa-arrow-right mr-2"></i>Modifier profil</a></p>
                                    </div>
                                </div>

                            </div>

                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-center">
                                    <button class="btn btn-link text-danger" data-toggle="collapse" data-target="#compte" style="font-size: 20px; text-decoration:none;">
                                        <i class="fa fa-money-check-alt mr-1"></i>Compte
                                    </button>
                                </div>
                                <div class="collapse" id="compte" data-parent="#parent">
                                    <div class="card-body">
                                        <p style="font-size: 20px; text-align: center;"><a href="compte.php"><i class="fa fa-arrow-right mr-2"></i>Mon compte</a></p>
                                        <p style="font-size: 20px; text-align: center;"><a href="transfert.php"><i class="fa fa-arrow-right mr-2"></i>Transfert</a></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </aside>
                </div>

            </div>

            <!-- partie droite-->
            <div class="col-lg-10 col-12">
                <div class="alert alert-success mt-2">
                    <p class="h5 text-center">MON COMPTE</p>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header ">
                                <p class=" text-center h1">TARIFS</p>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th class="text-danger">MONTANTS MIN (CFA)</th>
                                        <th class="text-danger">MONTANTS MAX (CFA)</th>
                                        <th class="text-danger">FRAIS DE TRANSFERT</th>
                                    </tr>
                                    <?php
                        $requete= $bdd->query("SELECT min,max,frais FROM frais");
                        $donnee = $requete->fetchAll();  ?>
                                <?php $i = 0; while($i < count($donnee)): ?>
                                <tr>
                                     <td><?php echo $donnee[$i]['min']?> FCFA</td>
                                      <td><?php echo $donnee[$i]['max']?> FCFA</td>
                                      <td><?php echo $donnee[$i]['frais']?> FCFA</td>
                                </tr>
                               <?php $i++;$requete->closeCursor(); endwhile;?>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                    <form action="<?php $_SERVER['PHP_SELF']?>" method="post" class="bg-warning rounded" style="padding: 30px;  font-weight: bold">
                            <div class="form-group">
                                <label for="mail" class="col-form-label col-sm-12">Mail:</label>
                                <div class="col-sm-12">
                                    <input type="email" id="mail" name="mail" class="form-control" placeholder="Votre mail"
                                           value="<?php echo $mail; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $mailError; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="code" class="col-form-label col-sm-12">Code secret:</label>
                                <div class="col-sm-12">
                                    <input type="number" id="code" name="code" class="form-control" placeholder="Votre code" value="<?php echo $code; ?>" />
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $codeError; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mailD" class="col-form-label col-sm-12">Mail destinataire:</label>
                                <div class="col-sm-12">
                                    <input type="email" id="mailD" name="mailD" class="form-control" placeholder="Votre mail" value="<?php echo $mailD; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $mailDError; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mont" class="col-form-label col-sm-6">Montant:</label>
                                <div class="col-sm-12">
                                    <input type="number" id="mont" name="mont" class="form-control" placeholder="Votre numero" value="<?php echo $mont; ?>">
                                    <span class="form-text text-danger" style="font-weight: normal; font-style: italic;"><?php echo $montError; ?></span>
                                </div>
                            </div>
                            <div class="form-group ">
                                <button type="submit" class="btn btn-danger text-light offset-3 col-6">ENVOYER</button>
                            </div>
                    </form>
                </div>
                </div>

            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-md bg-primary col-12 d-flex justify-content-center">
        <a class="h5">Copyright <i class="far fa-copyright"></i> BY OBANK 2019-2024</a>
    </nav>
    </body>
    </html>
<?php else:
    header("Location: index.php"); exit();
endif;
?>