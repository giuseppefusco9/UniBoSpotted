<?php
require_once 'bootstrap.php';

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

//Base Template
$templateParams["titolo"] = "UBSpotted - Search";
$templateParams["nome"] = "search-post.php";
$templateParams["categorieTop"] = $dbh->getTopCategories();

require 'template/base.php';
?>