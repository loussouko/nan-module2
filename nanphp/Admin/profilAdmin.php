<?php
session_start();
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
                    <p class="h5 text-center">MON PROFIL</p>
                </div>
                <div >
                    <table class="table table-light table-striped table-hover ">
                        <tr>
                            <td class="h5">Nom:</td>
                            <td><?php echo $_SESSION['nom']; ?></td>
                        </tr>
                        <tr>
                            <td class="h5">Prenom:</td>
                            <td><?php echo $_SESSION['prenom']; ?></td>
                        </tr>
                        <tr>
                            <td class="h5">Age:</td>
                            <td><?php echo $_SESSION['age'];?></td>
                        </tr>
                        <tr>
                            <td class="h5">Numero:</td>
                            <td><?php echo $_SESSION['num'];?></td>
                        </tr>
                        <tr>
                            <td class="h5">Nationalite:</td>
                            <td><?php echo $_SESSION['nationalite'];?></td>
                        </tr>
                        <tr>
                            <td class="h5">Sexe:</td>
                            <td><?php echo $_SESSION['sexe'];?></td>
                        </tr>
                        <tr>
                            <td class="h5">Statut:</td>
                            <td><?php echo $_SESSION['statut'];?></td>
                        </tr>
                    </table>
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
    header("Location: ../index.php"); exit();
endif;
?>