<?php
require_once 'bootstrap.php';

// Sicurezza
if(!isUserLoggedIn()){
    header("Location: login.php");
    exit;
}

// Setup variabili base (queste servono solo se NON facciamo redirect, es. Action 1 o errori)
$templateParams["titolo"] = "Manage Post - UBSpotted";
$templateParams["categorieTop"] = $dbh->getTopCategories();
$templateParams["categorie"] = $dbh->getCategories();

$userId = $_SESSION['id']; 
$stats = $dbh->getUserPostStats($userId);
$labels = [];
$data = [];
foreach($stats as $row){
    $labels[] = $row['nome'];
    $data[] = $row['num_post'];
}
$templateParams["statisticheUser"]["labels"] = $labels;
$templateParams["statisticheUser"]["data"] = $data;

// Default view
$templateParams["nome"] = "create-post.php";
$msg = "";

// GESTIONE AZIONI
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])){
    
    $action = intval($_POST["action"]);

    // -----------------------------------------------------------
    // AZIONE 1: INSERIMENTO NUOVO POST
    // -----------------------------------------------------------
    if($action == 1){
        $categoria = intval($_POST["categoria"]);
        $testo = htmlspecialchars($_POST["testo"]);
        $imagePath = null;

        if(isset($_FILES["immagine"]) && $_FILES["immagine"]["size"] > 0){
            list($result, $uploadMsg) = uploadImage(UPLOAD_DIR, $_FILES["immagine"]);
            if($result == 1){
                $imagePath = $uploadMsg;
            } else {
                $msg .= "Errore immagine: " . $uploadMsg;
            }
        }

        $id = $dbh->insertPost($userId, $categoria, $testo, $imagePath);
        
        if($id){
            $msg = "Spot pubblicato con successo!";
            // Opzionale: Se vuoi che torni alla home dopo il post, scommenta qui sotto:
            // header("Location: index.php?formmsg=" . urlencode($msg));
            // exit;
        } else {
            $msg = "Errore durante l'inserimento nel database.";
        }
        // Nota: Se Action 1 non fa redirect, caricherà create-post.php col messaggio (corretto)
    }

    // --------------------------------------------------------------
    // AZIONE 2: MODIFICA POST --> file php a parte --> edit-post.php
    // --------------------------------------------------------------

    // -----------------------------------------------------------
    // AZIONE 3: CANCELLAZIONE POST
    // -----------------------------------------------------------
    elseif($action == 3){
        $postId = intval($_POST["post_id"]);
        $admin = !empty($_SESSION['admin']) && $_SESSION['admin'] == true;
        
        $dbh->deletePost($postId, $userId, $admin);
        
        // Redirect
        $returnPage = isset($_POST["return_page"]) ? $_POST["return_page"] : "login.php";
        $queryString = "";
        if(isset($_POST["q"])){
            $queryString = "&q=" . urlencode($_POST["q"]);
        }
        
        header("Location: $returnPage?formmsg=" . urlencode("Spot cancellato!") . $queryString);
        exit; // Fondamentale
    }

    // -----------------------------------------------------------
    // AZIONE 4: CANCELLAZIONE COMMENTO 
    // -----------------------------------------------------------
    elseif($action == 4){
        //Definisco la pagina di ritorno (default: index.php)
        $returnPage = (isset($_POST["return_page"]) && !empty($_POST["return_page"])) ? $_POST["return_page"] : "index.php";

        // Manteniamo la ricerca
        $queryString = "";
        if(isset($_POST["q"]) && !empty($_POST["q"])){
            $queryString = "&q=" . urlencode($_POST["q"]);
        }

        // Recuper post_id per mantere apero il commento
        if(isset($_POST["post_id"])){
            $queryString .= "&open_post_id=" . intval($_POST["post_id"]);
        }

        // Controllo Sicurezza: Solo Admin
        if(empty($_SESSION['admin']) || $_SESSION['admin'] == false){
             header("Location: $returnPage?formmsg=" . urlencode("Non autorizzato"));
             exit;
        }

        // Eseguo Cancellazione
        if(isset($_POST["comment_id"])){
            $commentId = intval($_POST["comment_id"]);
            $dbh->deleteComment($commentId);
            $msg = "Commento eliminato!";
        } else {
            $msg = "Errore ID commento.";
        }

        header("Location: $returnPage?formmsg=" . urlencode($msg) . $queryString);
        exit; 
    }

    // -----------------------------------------------------------
    // AZIONE 5: INSERIMENTO COMMENTO
    // -----------------------------------------------------------
    elseif($action == 5){
        $postId = $_POST["post_id"];
        $testo = $_POST["testo"];
        $userId = $_SESSION['id'];
    
        if(!empty($testo)){
            $dbh->insertComment($postId, $userId, $testo);
            $msg = "Commento pubblicato!";
        } else {
            $msg = "Il commento non può essere vuoto.";
        }
    
        // Redirect
        $returnPage = isset($_POST["return_page"]) ? $_POST["return_page"] : "index.php";
        
        $queryString = "";
        if(isset($_POST["q"]) && !empty($_POST["q"])){
            $queryString = "&q=" . urlencode($_POST["q"]);
        }

        // Aggiungo il parametro per aprire la tendina
        $queryString .= "&open_post_id=" . intval($postId);
    
        header("Location: $returnPage?formmsg=" . urlencode($msg) . $queryString);
        exit; 
    }
}

// Se nessuna action ha fatto redirect (es. Action 1 o caricamento pagina GET), mostra la vista
require 'template/base.php';
?>