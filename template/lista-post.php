<?php 
if(!isset($postsLista)){
    $postsLista = $templateParams["posts"];
}
// Recuperiamo l'ID del post da tenere aperto (se presente nell'URL)
$openPostId = isset($_GET['open_post_id']) ? $_GET['open_post_id'] : null;
?>

<?php foreach($postsLista as $post): ?>
    <?php 
        $isAdmin = !empty($_SESSION['admin']) && $_SESSION['admin'] == true;
        $isAuthor = isUserLoggedIn() && isset($post['user_id']) && $_SESSION['id'] == $post['user_id'];
        
        // CALCOLO CLASSE CSS: Se l'ID corrisponde, aggiungo "show" per tenerlo aperto
        $collapseClass = "collapse";
        if($post['id'] == $openPostId){
            $collapseClass = "collapse show"; 
        }
    ?>

    <article class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            
            <div class="d-flex justify-content-between align-items-start mb-2">
                
                <h3 class="card-title h5 fw-bold">
                    <?php echo $post["nome_categoria"]; ?>
                </h3>

                <div class="d-flex align-items-center gap-2">
                    <small class="text-muted">Posted by: <?php echo $post["username"]; ?></small>

                    <?php if($isAuthor): ?>
                        <a href="edit-post.php?id=<?php echo $post['id']; ?>&return_page=<?php echo basename($_SERVER['PHP_SELF']); ?><?php echo isset($_GET['q']) ? '&q='.urlencode($_GET['q']) : ''; ?>" 
                            class="text-secondary ms-1" title="Modifica">
                            <i class="bi bi-pencil-square fs-5"></i>
                        </a>
                    <?php endif; ?>

                    <?php if($isAdmin || $isAuthor): ?>
                        <form action="process-post.php" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo post?');" class="m-0 p-0">
                            
                            <input type="hidden" name="action" value="3">
                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                            
                            <input type="hidden" name="return_page" value="<?php echo basename($_SERVER['PHP_SELF']); ?>">

                            <?php if(isset($_GET['q'])): ?>
                                <input type="hidden" name="q" value="<?php echo htmlspecialchars($_GET['q']); ?>">
                            <?php endif; ?>
                            
                            <button type="submit" class="btn btn-link p-0 text-danger border-0 ms-2" title="Elimina Post">
                                <i class="bi bi-trash fs-5"></i>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            
            <p class="card-text"><?php echo ($post["testo"]); ?></p>
            
            <?php if(!empty($post["immagine_path"])): ?>
                <img src="<?php echo $post["immagine_path"]; ?>" class="img-fluid rounded mb-2">
            <?php endif; ?>
        </div>
        
        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
            <small class="text-muted">Pubblicato <?php echo date("d/m/y H:i", strtotime($post["data_pubblicazione"])); ?></small>
            
            <?php $comments = $dbh->getComments($post["id"]); ?>

            <div class="action-btn" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#comments-post-<?php echo $post["id"]; ?>" aria-expanded="false">
                <i class="bi bi-chat-dots me-1"> <?php echo count($comments); ?> Commenti</i>
            </div>
        </div>

        <div class="<?php echo $collapseClass; ?>" id="comments-post-<?php echo $post["id"]; ?>">
            <div class="card-body border-top bg-light">
                
                <?php if(count($comments) > 0): ?>
                    <?php foreach($comments as $comment): ?>
                        
                        <div class="comment-box mb-2 border-bottom pb-2 d-flex justify-content-between align-items-start">
                            
                            <div>
                                <span class="comment-user">@<?php echo $comment["username"]; ?>:</span>
                                <span class="comment-text"><?php echo $comment["testo"]; ?></span>
                            </div>

                            <?php if($isAdmin): ?>
                                <form action="process-post.php" method="POST" onsubmit="return confirm('Vuoi eliminare questo commento?');">
                                    
                                    <input type="hidden" name="action" value="4">
                                    
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['idCommento']; ?>">

                                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                    
                                    <input type="hidden" name="return_page" value="<?php echo basename($_SERVER['PHP_SELF']); ?>">
                                    
                                    <?php if(isset($_GET['q'])): ?>
                                        <input type="hidden" name="q" value="<?php echo htmlspecialchars($_GET['q']); ?>">
                                    <?php endif; ?>

                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0 border-0 ms-2" title="Elimina commento">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="small text-muted">Non ci sono commenti.</p>
                <?php endif; ?>
                
                <?php if(isUserLoggedIn()): ?>
                    <form action="process-post.php" method="POST" class="input-group mt-3">
                        <input type="hidden" name="action" value="5"> <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">
                        
                        <input type="hidden" name="return_page" value="<?php echo basename($_SERVER['PHP_SELF']); ?>">
                        <?php if(isset($_GET['q'])): ?>
                            <input type="hidden" name="q" value="<?php echo htmlspecialchars($_GET['q']); ?>">
                        <?php endif; ?>

                        <input type="text" name="testo" class="form-control" placeholder="Scrivi un commento..." required>
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-send"></i></button>
                    </form>
                <?php else: ?>
                    <div class="text-center mt-4 pt-3 border-top">
                        <small class="text-muted">Esegui il login per commentare!</small>
                        <a href="login.php" class="text-decoration-none fw-bold text-unibo ms-1">Login</a>
                    </div>
                    <div class="text-center mt-4 pt-3 border-top">
                        <small class="text-muted">Non sei ancora dei nostri?</small>
                        <a href="registration.php" class="text-decoration-none fw-bold text-unibo ms-1">Registrati</a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </article>
<?php endforeach; ?>

<?php if($openPostId): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var element = document.getElementById("post-<?php echo $openPostId; ?>");
        if(element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
<?php endif; ?>