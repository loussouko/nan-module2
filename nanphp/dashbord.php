<?php
session_start();
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
          <div class="col-lg-2 bg-primary" style="padding:0; height: 580px;">
             <div class="text-center mt-4 bg-light mx-3" style="height: 170px;">
                 <img src="<?= $_SESSION['image'] ?>" alt="" class="img-fluid rounded-circle" style="height: 80px;">
                 <p><?php echo  $_SESSION['nom']; ?></p>
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
                  <p class="h5 text-center">Bienvenue sur la plateforme de transfert d'argent</p>
              </div>
             <div class="carousel slide" data-toggle="carousel" id="carousel" style="height:490px;" data-ride="carousel">
                 <ol class="carousel-indicators">
                     <li data-target="#carousel" data-slide-to="0" class="active"></li>
                     <li data-target="#carousel" data-slide-to="1"></li>
                     <li data-target="#carousel" data-slide-to="2"></li>
                     <li data-target="#carousel" data-slide-to="3"></li>
                     <li data-target="#carousel" data-slide-to="4"></li>
                 </ol>
                 <div class="carousel-inner">
                     <div class="carousel-item active">
                         <img src="public/images/argent.jpg" alt="" class="d-block w-100" style="height: 490px;">
                     </div>
                     <div class="carousel-item ">
                         <img src="public/images/argent1.jpg" alt="" class="d-block w-100" style="height: 490px;">
                     </div>
                     <div class="carousel-item ">
                         <img src="public/images/argent3.jpg" alt="" class="d-block w-100" style="height: 490px;">
                     </div>
                     <div class="carousel-item ">
                         <img src="public/images/argent4.jpg" alt="" class="d-block w-100" style="height: 490px;">
                     </div>
                     <div class="carousel-item ">
                         <img src="public/images/argent5.jpg" alt="" class="d-block  w-100" style="height:490px;">
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
    header("Location: index.php");exit();
endif;
?>