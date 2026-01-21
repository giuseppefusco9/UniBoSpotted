<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "UBSpotted - Search";
$templateParams["nome"] = "search-post.php";
$templateParams["categorieTop"] = $dbh->getTopCategories();

$templateParams["searchResults"] = [];
$templateParams["searchKeyword"] = "";

if(isset($_GET["formmsg"])){
    $templateParams["formmsg"] = htmlspecialchars($_GET["formmsg"]);
}

if(isset($_GET["q"])){
    $templateParams["searchKeyword"] = htmlspecialchars($_GET["q"]);

    if(strlen($templateParams["searchKeyword"]) > 0){
        $templateParams["searchResults"] = $dbh->searchPosts($templateParams["searchKeyword"]);
    }
}

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