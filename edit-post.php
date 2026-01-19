<?php
require_once 'bootstrap.php';

// 1. Controllo Login
if(!isUserLoggedIn()){
    header("Location: login.php");
    exit;
}

// 2. GESTIONE SALVATAGGIO (Quando premi "Salva Modifiche")
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_edit"])){
    
    $postId = $_POST["post_id"];
    $testo = $_POST["testo"];
    $categoria = $_POST["categoria"];
    $imagePath = $_POST["old_image"]; // Di base teniamo la vecchia

    // Gestione upload nuova immagine
    if(isset($_FILES["immagine"]) && $_FILES["immagine"]["size"] > 0){
        // Usa la tua funzione uploadImage presente in functions.php
        $uploadResult = uploadImage("img/", $_FILES["immagine"]);
        if($uploadResult["error"] == ""){
            $imagePath = $uploadResult["path"];
        } else {
            // Se fallisce l'upload, salviamo l'errore per mostrarlo
            $templateParams["errore"] = "Errore immagine: " . $uploadResult["error"];
        }
    }

    // Se non ci sono errori, aggiorniamo il DB
    if(!isset($templateParams["errore"])){
        $dbh->updatePost($postId, $_SESSION["id"], $categoria, $testo, $imagePath);
        // Torniamo al profilo con messaggio di successo
        header("Location: login.php?formmsg=" . urlencode("Post modificato con successo!"));
        exit;
    }
}

// 3. RECUPERO DATI PER MOSTRARE IL FORM
// Ci serve l'ID nell'URL (es. edit-post.php?id=5)
$postId = isset($_GET["id"]) ? $_GET["id"] : 0;
$post = $dbh->getPostById($postId);

// SICUREZZA:
// a) Il post deve esistere
// b) L'autore del post deve essere l'utente loggato ($_SESSION["id"])
if(!$post || $post["user_id"] != $_SESSION["id"]){
    // Se provi a modificare il post di un altro, ti rimando alla home
    header("Location: login.php"); 
    exit;
}

// 4. PREPARAZIONE PAGINA
$templateParams["titolo"] = "UBSpotted - Modifica Post";
$templateParams["nome"] = "template/edit-post-form.php";
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["post"] = $post; // Passiamo i dati del post al template
$templateParams["categorieTop"] = $dbh->getTopCategories(); // Serve per la sidebar

require 'template/base.php';
?>