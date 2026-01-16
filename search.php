<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "UBSpotted - Search";
$templateParams["nome"] = "search-post.php";
$templateParams["categorieTop"] = $dbh->getTopCategories();

require 'template/base.php';
?>