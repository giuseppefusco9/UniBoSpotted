<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-body p-4">
        <div class="text-center mb-4">
            <div class="mb-3">
                <span class="bi bi-person-circle display-4 text-unibo"></span>
            </div>
            <h2 class="h4 fw-bold">Ciao <?php echo $templateParams["username"]; ?>!</h2>
            <p class="text-muted small">Benvenuto nella tua area personale.</p>
            <div class="d-flex justify-content-center align-items-center gap-3 mt-3">
                <div class="d-flex align-items-center text-muted">
                    <span class="bi bi-megaphone me-2 text-unibo" aria-hidden="true"></span>
                    <span>
                        <strong class="text-dark"><?php echo $templateParams["numUserPosts"]; ?></strong> Spot
                    </span>
                </div>
                
                <div class="vr"></div> <div class="d-flex align-items-center text-muted">
                    <span class="bi bi-chat-dots me-2 text-unibo" aria-hidden="true"></span>
                    <span>
                        <strong class="text-dark"><?php echo $templateParams["numUserComments"]; ?></strong> Commenti
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

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