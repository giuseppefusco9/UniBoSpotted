<h2 class="card-title h2 fw-bold mb-3">Ciao, <?php echo $templateParams["username"];?>!</h2>

<?php 
    if(isset($templateParams["userposts"])){
        $postsLista = $templateParams["userposts"];
    } else {
        $postsLista = [];
    }

    if(count($postsLista) > 0){
        require 'template/lista-post.php';
    } 
?>

<?php if(count($postsLista) == 0): ?>
    <p class="text-muted">
        Non hai ancora pubblicato nessuno spot. Cosa aspetti? 
        <a href="process-post.php">Crea il tuo primo spot!</a>
    </p>
<?php endif; ?>