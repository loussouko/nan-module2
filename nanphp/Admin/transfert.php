<?php
session_start();
include"../db.php";
?>
<?php if(!empty($_SESSION['mail'])&& !empty($_SESSION['mdp']) && !empty($_SESSION['acces']) && $_SESSION['statut'] == "admin"):?>
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
            <div class="col-lg-2 bg-danger" style="padding:0; height: 720px;">
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
                                        <i class="fa fa-user-friends mr-1"></i>Clients
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
                <div class="col-lg-12">
                    <div class="alert alert-primary mt-2">
                        <p class="h5 text-center">TRANSFERT EFFECTUE</p>
                    </div>
                </div>
                    <div class="col-lg-12">
                        <div class="card mt-2">
                            <div class="card-header ">
                                <p class=" text-center h1"><i class="fa fa-money-check mr-2"></i>LISTE DES TRANSACTIONS</p>
                            </div>
                            <div class="card-body ">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th>MAIL EXPEDITEUR</th>
                                        <th>MAIL DESTINATAIRE</th>
                                        <th>MONTANT</th>
                                        <th>DATE TRANSFERT</th>
                                        <th>FRAIS PAYES</th>
                                    </tr>
                                    <?php
                                    $requete= $bdd->query("SELECT mail_destinataire,mail_expediteur,montant, date_transfert as date,frais FROM transfert ORDER BY date DESC");
                                    $donnee = $requete->fetchAll();  ?>
                                    <?php $i = 0; while($i < count($donnee)): ?>
                                        <tr>
                                            <td><?php echo $donnee[$i]['mail_expediteur']?></td>
                                            <td><?php echo $donnee[$i]['mail_destinataire']?></td>
                                            <td><?php echo $donnee[$i]['montant']?></td>
                                            <td><?php echo $donnee[$i]['date']?></td>
                                            <td><?php echo $donnee[$i]['frais']?></td>
                                        </tr>
                                        <?php $i++;$requete->closeCursor(); endwhile;?>
                                </table>
                            </div>
                        </div>
            </div>

               <div class="col-lg-12">
                        <div class="card mt-2">
                            <div class="card-header ">
                                <p class=" text-center h1"><i class="fa fa-money-check mr-2"></i>GAINS DE OBANK</p>
                            </div>
                            <div class="card-body ">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <th>GAIN</th>
                                    </tr>
                                    <?php
                                    $requete= $bdd->query("SELECT SUM(frais) As total FROM transfert ");
                                    $donnee = $requete->fetch();  ?>
                                        <tr>
                                            <td><?php echo $donnee['total'];?></td>
                                        </tr>
                                </table>
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