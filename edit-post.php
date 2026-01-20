<?php
require_once 'bootstrap.php';

// 1. Controllo Login
if(!isUserLoggedIn()){
    header("Location: login.php");
    exit;
}

$postId = 0; 

// 2. GESTIONE SALVATAGGIO (Quando premi "Salva Modifiche")
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_edit"])){
    
    $postId = $_POST["post_id"]; 
    $testo = $_POST["testo"];
    $categoria = $_POST["categoria"];
    $imagePath = $_POST["old_image"]; 

    // Gestione upload
    if(isset($_FILES["immagine"]) && $_FILES["immagine"]["size"] > 0){
        list($result, $uploadMsg) = uploadImage(UPLOAD_DIR, $_FILES["immagine"]);
        
        if($result == 1){
            $imagePath = $uploadMsg; 
        } else {
            $templateParams["errore"] = "Errore immagine: " . $uploadMsg;
        }
    }

    // Se non ci sono errori, aggiorniamo il DB e facciamo il redirect
    if(!isset($templateParams["errore"])){
        $dbh->updatePost($postId, $_SESSION["id"], $categoria, $testo, $imagePath);
        
        // RECUPERO DOVE TORNARE (POST ha la priorità assoluta qui)
        $returnPage = isset($_POST["return_page"]) ? $_POST["return_page"] : "login.php";
        
        $queryString = "";
        if(isset($_POST["q"]) && !empty($_POST["q"])){
            $queryString = "&q=" . urlencode($_POST["q"]);
        }

        // REDIRECT
        header("Location: $returnPage?formmsg=" . urlencode("Post modificato con successo!") . $queryString);
        exit;
    }
}

// 3. RECUPERO DATI (GET) - Solo se non siamo già in possesso dell'ID da POST
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
$templateParams["nome"] = "edit-post-form.php";
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["post"] = $post; 
$templateParams["categorieTop"] = $dbh->getTopCategories(); 

// --- AGGIUNTA DI SICUREZZA (ROBUSTEZZA) ---
// Qui decidiamo cosa passare al template per riempire i campi hidden.
// 1. Prima controlliamo POST (nel caso ci sia stato un errore e la pagina si sia ricaricata)
// 2. Poi controlliamo GET (quando arrivi dal link)
// 3. Infine default

// Gestione return_page
if(isset($_POST["return_page"])){
    $templateParams["return_page"] = $_POST["return_page"];
} elseif(isset($_GET["return_page"])){
    $templateParams["return_page"] = $_GET["return_page"];
} else {
    $templateParams["return_page"] = "login.php";
}

// Gestione q (query di ricerca)
if(isset($_POST["q"])){
    $templateParams["q"] = $_POST["q"];
} elseif(isset($_GET["q"])){
    $templateParams["q"] = $_GET["q"];
} else {
    $templateParams["q"] = "";
}

// Se c'è stato un errore e stiamo ricaricando il form, rimettiamo i testi inseriti dall'utente
if(isset($_POST["testo"])){
    $templateParams["post"]["testo"] = $_POST["testo"];
    $templateParams["post"]["categoria_id"] = $_POST["categoria"];
}

require 'template/base.php';
?>