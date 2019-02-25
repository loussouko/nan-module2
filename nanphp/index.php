<?php
session_start();
?>

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
            <form action="verifConnexion.php" class="bg-light rounded" style="padding: 40px;  font-weight: bold" method="post">
                    <div class="form-group">
                        <div class="text-center">
                           <span><i class="fa fa-user-circle fa-4x text-primary "></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mail" class="col-form-label col-sm-12 text-center">Email</label>
                        <div class="col-sm-12">
                            <input type="email" id="mail" name="mail" class="form-control" placeholder="Votre email" required="required">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="mdp" class="col-form-label col-sm-12 text-center">Mot de passe</label>
                        <div class="col-12">
                            <input type="password" id="mdp" name="mdp" class="form-control" placeholder="Votre mot de passe" required>
                        </div>
                    </div>
                <div class="form-group ">
                    <label for="statut" class="col-form-label col-sm-12 text-center">Statut</label>
                    <div class="col-12">
                        <select name="statut" id="statut" class="custom-select">
                            <option value="defaut">----</option>
                            <option value="client">Client</option>
                            <option value="admin">Administrateur</option>
                        </select>
                    </div>
                </div>
                    <button type="submit" class="btn btn-warning text-light col-12" name="envoyer">CONNECTER</button>
        </div>
    </div>


    </form>
</div>
</body>
</html>