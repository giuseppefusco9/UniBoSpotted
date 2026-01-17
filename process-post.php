<?php
require_once 'bootstrap.php';

if(!isUserLoggedIn()){
    header("Location: login.php");
    exit;
}

// Variabili per la vista
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

$templateParams["nome"] = "create-post.php";
$msg = "";

// Gestione invio forum
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])){
    
    $action = intval($_POST["action"]);

    // AZIONE 1: INSERIMENTO
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
        } else {
            $msg = "Errore durante l'inserimento nel database.";
        }
    }

    /*
     AZIONE 2: MODIFICA
    elseif($action == 2){
        $postId = intval($_POST["post_id"]);
        $categoria = intval($_POST["categoria"]);
        $testo = htmlspecialchars($_POST["testo"]);
        $oldImage = $_POST["old_image"]; // Immagine vecchia (hidden input)
        $imagePath = $oldImage; // Di base teniamo quella vecchia

        // Se l'utente ha caricato una NUOVA immagine
        if(isset($_FILES["immagine"]) && $_FILES["immagine"]["size"] > 0){
            list($result, $uploadMsg) = uploadImage(UPLOAD_DIR, $_FILES["immagine"]);
            if($result == 1){
                $imagePath = $uploadMsg;
            } else {
                $msg = "Errore aggiornamento immagine: " . $uploadMsg;
            }
        }

        $dbh->updatePost($postId, $userId, $categoria, $testo, $imagePath);
        $msg = "Spot aggiornato!";
        exit;
    }*/

    // AZIONE 3: CANCELLAZIONE
    elseif($action == 3){
        $postId = intval($_POST["post_id"]);
        $dbh->deletePost($postId, $userId);
        $msg = "Spot cancellato!";
    }
}

require 'template/base.php';
?>