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

    // AZIONE 3: CANCELLAZIONE
    elseif($action == 3){
        $postId = intval($_POST["post_id"]);
        $admin = !empty($_SESSION['admin']) && $_SESSION['admin'] == true;
        $dbh->deletePost($postId, $userId, $admin);
        $returnPage = isset($_POST["return_page"]) ? $_POST["return_page"] : "login.php";
        $queryString = "";
        if(isset($_POST["q"])){
            $queryString = "&q=" . urlencode($_POST["q"]);
        }
        header("Location: $returnPage?formmsg=" . urlencode("Spot cancellato!") . $queryString);
        exit;
    }
}

require 'template/base.php';
?>