<?php
require_once 'bootstrap.php';

// 1. Controllo Login
if(!isUserLoggedIn()){
    header("Location: login.php");
    exit;
}

$postId = 0; // Inizializziamo a 0

// 2. GESTIONE SALVATAGGIO (Quando premi "Salva Modifiche")
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_edit"])){
    
    $postId = $_POST["post_id"]; 
    $testo = $_POST["testo"];
    $categoria = $_POST["categoria"];
    $imagePath = $_POST["old_image"]; // Di default teniamo quella vecchia

    // Gestione upload nuova immagine
    if(isset($_FILES["immagine"]) && $_FILES["immagine"]["size"] > 0){
        
        // CORREZIONE QUI: Cartella "upload/"
        list($result, $uploadMsg) = uploadImage("upload/", $_FILES["immagine"]);
        
        if($result == 1){
            $imagePath = $uploadMsg; // $uploadMsg ora contiene il percorso (es. "upload/foto.jpg")
        } else {
            // Se fallisce, salviamo l'errore
            $templateParams["errore"] = "Errore immagine: " . $uploadMsg;
        }
    }

    // Se non ci sono errori, aggiorniamo il DB
    if(!isset($templateParams["errore"])){
        $dbh->updatePost($postId, $_SESSION["id"], $categoria, $testo, $imagePath);
        header("Location: login.php?formmsg=" . urlencode("Post modificato con successo!"));
        exit;
    }
}

// 3. RECUPERO DATI (Se non siamo in POST, li prendiamo dal GET)
if($postId == 0 && isset($_GET["id"])){
    $postId = $_GET["id"];
}

$post = $dbh->getPostById($postId);

// SICUREZZA
if(!$post || $post["user_id"] != $_SESSION["id"]){
    header("Location: login.php"); 
    exit;
}

// 4. PREPARAZIONE PAGINA
$templateParams["titolo"] = "UBSpotted - Modifica Post";
$templateParams["nome"] = "template/edit-post-form.php";
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["post"] = $post; 

// Se c'è stato un errore (es. upload fallito), rimettiamo il testo che l'utente stava scrivendo
if(isset($_POST["testo"])){
    $templateParams["post"]["testo"] = $_POST["testo"];
    $templateParams["post"]["categoria_id"] = $_POST["categoria"];
}

$templateParams["categorieTop"] = $dbh->getTopCategories(); 

require 'template/base.php';
?>