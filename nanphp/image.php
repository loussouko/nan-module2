<?php
session_start();
include "db.php";
//traitement de l'image

  if(empty($_FILES['image']['name']))
  {
      header("Location:modifProfil.php");
      exit();
  }
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0)
    {
        if($_FILES['image']['size'] <= 5000000)
        {
            $error = 1;
            $imagesExtensions = strrchr($_FILES['image']['name'], '.');
            $arrayExtensions = array('.PNG', '.png', '.JPEG', '.jpeg', '.jpg', '.JPG', '.gif', '.GIF');

            if (in_array($imagesExtensions, $arrayExtensions)) {
                $address = 'public/upload/' . time() . $_SESSION['nom'] . $_SESSION['id'] . $imagesExtensions;
                move_uploaded_file($_FILES['image']['tmp_name'], $address);
                $error = 0;
                if ($res) {
                    $_SESSION['image'] = $res['image'];
                }
                if($_SESSION['image'] == "")
                {
                    $req = $bdd->prepare("INSERT INTO avatar(image,id_users) VALUES (?,?)");
                    $req->execute([$address, $_SESSION['id']]);
                    $id = $bdd->lastinsertId();
                    $req = $bdd->prepare("SELECT image FROM avatar WHERE id_users=? AND id=?");
                    $req->execute([$_SESSION['id'], $id]);
                    $res = $req->fetch();
                    if ($res) {
                        $_SESSION['image'] = $res['image'];
                    }
                    header("Location:dashbord.php");
                    exit();
                }
                else
                {
                    $req = $bdd->prepare("UPDATE avatar SET image =? WHERE id_users =?");
                    $req->execute([$address, $_SESSION['id']]);
                    $id = $bdd->lastinsertId();
                    $req = $bdd->prepare("SELECT image FROM avatar WHERE id_users=?");
                    $req->execute([$_SESSION['id']]);
                    $res = $req->fetch();
                    if ($res) {
                        $_SESSION['image'] = $res['image'];
                    }
                    header("Location:dashbord.php");
                    exit();
                }


            }
            else
            {
                header("Location:modifProfil.php");
                exit();

            }
        }
    }
?>