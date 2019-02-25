<?php
session_start();
include "db.php";
$requete= $bdd->prepare("SELECT solde,code FROM compte WHERE compte_user=?");
$requete->execute([$_SESSION['id']]);
$donnee = $requete->fetch();
if($donnee)
{
    $_SESSION['solde']= $donnee['solde'];
    $_SESSION['code']= $donnee['code'];
}
$requete->closeCursor();
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
                <a href="dashbord.php" class="navbar-brand"><img src="public/images/logo.png" alt=""></a>
            </nav>
            <!-- partie gauche-->
            <div class="col-lg-2 bg-primary" style="padding:0; height: 580px;">
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
            <div class="col-lg-10">
                <div class="alert alert-success mt-2">
                    <p class="h5 text-center">MON COMPTE</p>
                </div>
                <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-success">
                            <p class=" text-center h1"><i class="fa fa-piggy-bank mr-2"></i>SOLDE</p>
                        </div>
                        <div class="card-body bg-danger">
                            <p class="text-center h4"><?php echo $_SESSION['solde'] ?>FCFA</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-success">
                            <p class=" text-center h1"><i class="fa fa-key mr-2"></i>CODE SECRET</p>
                        </div>
                        <div class="card-body bg-danger">
                            <p class="text-center h4"><?php echo $_SESSION['code'] ?></p>
                        </div>
                    </div>
                </div>
                </div>

                <div class="col-lg-12">
                    <div class="card mt-2">
                        <div class="card-header ">
                            <p class=" text-center h1"><i class="fa fa-money-check mr-2"></i>TRANSFERT ENVOYE</p>
                        </div>
                        <div class="card-body ">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>MAIL DESTINATAIRE</th>
                                    <th>MONTANT</th>
                                    <th>DATE TRANSFERT</th>
                                    <th>FRAIS PAYES</th>
                                </tr>
                        <?php
                        $requete= $bdd->prepare("SELECT mail_destinataire,montant, date(date_transfert) as date,frais FROM transfert WHERE mail_expediteur = ? ORDER BY date DESC" );
                        $requete->execute([$_SESSION['mail']]);
                        $donnee = $requete->fetchAll();  ?>
                                <?php $i = 0; while($i < count($donnee)): ?>
                                <tr>
                                     <td><?php echo $donnee[$i]['mail_destinataire']?></td>
                                      <td><?php echo $donnee[$i]['montant']?> FCFA</td>
                                      <td><?php echo $donnee[$i]['date']?></td>
                                      <td><?php echo $donnee[$i]['frais']?></td>
                                </tr>
                               <?php $i++;$requete->closeCursor(); endwhile;?>
                            </table>
                        </div>
                    </div>


                    <div class="card my-3">
                        <div class="card-header ">
                            <p class=" text-center h1"><i class="fa fa-money-bill-alt mr-2"></i>TRANSFERT RECU</p>
                        </div>
                        <div class="card-body ">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>MAIL EXPEDITEUR</th>
                                    <th>MONTANT</th>
                                    <th>DATE TRANSFERT</th>
                                </tr>
                                <?php
                                $requete= $bdd->prepare("SELECT mail_expediteur,montant, date(date_transfert) as date FROM transfert WHERE mail_destinataire = ? ORDER BY date DESC");
                                $requete->execute([$_SESSION['mail']]);
                                $donnee = $requete->fetchAll(); ?>
                                <?php $i = 0; while($i < count($donnee)): ?>
                                    <tr>
                                        <td><?php echo $donnee[$i]['mail_expediteur']?></td>
                                        <td><?php echo $donnee[$i]['montant']?> FCFA</td>
                                        <td><?php echo $donnee[$i]['date']?></td>
                                    </tr>
                                    <?php $i++;$requete->closeCursor(); endwhile;?>
                            </table>
                        </div>
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