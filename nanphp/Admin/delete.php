<?php
include "../db.php";
session_start();

if($_SERVER['REQUEST_METHOD']=="GET")
{
    $q=$_GET['q'];
    if (!empty($_SESSION['mail']) && ! empty($_SESSION['mdp']) && $_SESSION['statut'] == "admin") {
    	$delete= $bdd->prepare("DELETE FROM user WHERE id =?");
    	$delete->execute([$q]);
    	$delete= $bdd->prepare("DELETE FROM compte WHERE compte_user=?");
    	$delete->execute([$q]);
    	
    	header("Location:client.php");
    	exit();
    }
    else
    {
    	header("Location:../index.php");
    	exit();
    }
}
?>