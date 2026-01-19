<?php
require 'bootstrap.php';
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
$templateParams["titolo"] = "UBSpotted - Linee Guida Community";
$templateParams["nome"] = "guidelines.php";
$templateParams["categorieTop"] = $dbh->getTopCategories();
require 'template/base.php';
?>