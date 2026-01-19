<?php
require_once 'bootstrap.php';

if(isUserLoggedIn()){
    header("Location: index.php");
    exit;
}

$templateParams["titolo"] = "UBSpotted - Registrazione";
$templateParams["nome"] = "registration-form.php";
$templateParams["categorieTop"] = $dbh->getTopCategories();

$templateParams["username_inserito"] = "";
$templateParams["email_inserita"] = "";
$templateParams["erroreRegistrazione"] = "";

if(isset($_POST["register"])) {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $templateParams["username_inserito"] = $username;
    $templateParams["email_inserita"] = $email;

    $msg_errore = null;

    if(empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($confirm_password)) {
        $msg_errore = "Tutti i campi sono obbligatori!";
    }

    if(empty($msg_errore) && $password !== $confirm_password) {
        $msg_errore = "Le password non coincidono!";
    }

    if(empty($msg_errore)) {
        $registrazione_ok = $dbh->insertUser($username, $email, $password);
        if($registrazione_ok) {
            header("Location: login.php?formmsg=" . urlencode("Registrazione riuscita!"));
            exit;
        } else {
            $msg_errore = "Username o email già in uso!";
        }
    }

    if(!empty($msg_errore)){
        $templateParams["erroreRegistrazione"] = $msg_errore;
    }
}

require 'template/base.php';
?>