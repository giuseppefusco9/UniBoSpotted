<?php
require_once 'bootstrap.php';

if(!isUserLoggedIn()){
    header("Location: login.php");
    exit;
}

$postId = 0; 

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_edit"])){
    
    $postId = $_POST["post_id"]; 
    $testo = $_POST["testo"];
    $categoria = $_POST["categoria"];
    $imagePath = $_POST["old_image"]; 

    if(isset($_FILES["immagine"]) && $_FILES["immagine"]["size"] > 0){
        list($result, $uploadMsg) = uploadImage(UPLOAD_DIR, $_FILES["immagine"]);
        if($result == 1){
            $imagePath = $uploadMsg; 
        } else {
            $templateParams["errore"] = "Errore immagine: " . $uploadMsg;
        }
    }

    if(!isset($templateParams["errore"])){
        $dbh->updatePost($postId, $_SESSION["id"], $categoria, $testo, $imagePath);
        $returnPage = isset($_POST["return_page"]) ? $_POST["return_page"] : "login.php";
        $queryString = "";
        if(isset($_POST["q"]) && !empty($_POST["q"])){
            $queryString = "&q=" . urlencode($_POST["q"]);
        }
        header("Location: $returnPage?formmsg=" . urlencode("Post modificato con successo!") . $queryString);
        exit;
    }
}

if($postId == 0 && isset($_GET["id"])){
    $postId = $_GET["id"];
}

$post = $dbh->getPostById($postId);

if(!$post || $post["user_id"] != $_SESSION["id"]){
    header("Location: login.php"); 
    exit;
}

$templateParams["titolo"] = "UBSpotted - Modifica Post";
$templateParams["nome"] = "edit-post-form.php";
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["post"] = $post; 
$templateParams["categorieTop"] = $dbh->getTopCategories(); 

if(isset($_POST["return_page"])){
    $templateParams["return_page"] = $_POST["return_page"];
} elseif(isset($_GET["return_page"])){
    $templateParams["return_page"] = $_GET["return_page"];
} else {
    $templateParams["return_page"] = "login.php";
}

if(isset($_POST["q"])){
    $templateParams["q"] = $_POST["q"];
} elseif(isset($_GET["q"])){
    $templateParams["q"] = $_GET["q"];
} else {
    $templateParams["q"] = "";
}

if(isset($_POST["testo"])){
    $templateParams["post"]["testo"] = $_POST["testo"];
    $templateParams["post"]["categoria_id"] = $_POST["categoria"];
}

require 'template/base.php';
?>