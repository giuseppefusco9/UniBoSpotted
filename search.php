<?php
require_once 'bootstrap.php';

// Base Template
$templateParams["titolo"] = "UBSpotted - Search";
$templateParams["nome"] = "search-post.php";
$templateParams["categorieTop"] = $dbh->getTopCategories();

// Inizializziamo i risultati vuoti
$templateParams["searchResults"] = [];
$templateParams["searchKeyword"] = "";

//Messaggio successo/errore
if(isset($_GET["formmsg"])){
    $templateParams["formmsg"] = htmlspecialchars($_GET["formmsg"]);
}

// LOGICA DI RICERCA
if(isset($_GET["q"])){
    $templateParams["searchKeyword"] = htmlspecialchars($_GET["q"]);
    
    // Se la ricerca non è vuota, interroghiamo il DB
    if(strlen($templateParams["searchKeyword"]) > 0){
        $templateParams["searchResults"] = $dbh->searchPosts($templateParams["searchKeyword"]);
    }
}

// Statistiche utente (solo se loggato, per la sidebar)
if(isUserLoggedIn()){
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
}

require 'template/base.php';
?>