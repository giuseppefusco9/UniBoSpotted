<h2 class="card-title h2 fw-bold mb-3">Ciao, <?php echo $templateParams["username"];?>!</h2>
<?php foreach($templateParams["userposts"] as $post): ?>
    <article class="card shadow-sm border-0 mb-4">
        <div class="card-body"> 
            <div class="d-flex justify-content-between align-items-center mb-2">
                
                <h3 class="card-title h5 fw-bold mb-0">
                    <?php echo $post["nome_categoria"]; ?>
                </h3>

                <div class="d-flex align-items-center gap-2">
    
                    <a href="edit-post.php?id=<?php echo $post['id']; ?>" class="btn btn-link p-0 text-secondary border-0" title="Modifica">
                        <i class="bi bi-pencil-square fs-5"></i>
                    </a>

                    <form action="process-post.php" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo post?');" style="display:inline;">
                        <input type="hidden" name="action" value="3"> 
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
        
                        <button type="submit" class="btn btn-link p-0 text-danger border-0" title="Elimina">
                            <i class="bi bi-trash fs-5"></i>
                        </button>
                    </form>

                </div>
            </div>
            <p class="card-text"><?php echo ($post["testo"]); ?></p>
            
            <?php if(!empty($post["immagine_path"])): ?>
                <img src="<?php echo $post["immagine_path"]; ?>" class="img-fluid rounded mb-2">
            <?php endif; ?>
        </div>
        
        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
            <small class="text-muted">Pubblicato <?php echo date("d/m/y H:i", strtotime($post["data_pubblicazione"])); ?></small>
            
            <?php
                // Recupero commenti (se la logica è nel template, altrimenti andrebbe fatto prima)
                $comments = $dbh->getComments($post["id"]);
            ?>

            <div class="action-btn" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#comments-post-<?php echo $post["id"]; ?>" aria-expanded="false">
                <i class="bi bi-chat-dots me-1"> <?php echo count($comments); ?> Commenti</i>
            </div>
        </div>

        <div class="collapse" id="comments-post-<?php echo $post["id"]; ?>">
            <div class="card-body border-top bg-light">
                
                <?php if(count($comments) > 0): ?>
                    <?php foreach($comments as $comment): ?>
                        <div class="comment-box mb-2 border-bottom pb-2">
                            <span class="comment-user fw-bold">@<?php echo $comment["username"]; ?>:</span>
                            <span class="comment-text text-secondary text-white"><?php echo $comment["testo"]; ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="small text-muted">Non ci sono commenti.</p>
                <?php endif; ?>

                <form action="#" method="POST" class="input-group mt-3">
                    <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">
                    <input type="text" class="form-control" placeholder="Scrivi un commento...">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-send"></i></button>
                </form>

            </div>
        </div>
    </article>
<?php endforeach; ?>
<?php if(count($templateParams["userposts"]) == 0): ?>
    <p class="text-muted">Non hai ancora pubblicato nessuno spot. Cosa aspetti? <a href="process-post.php">Crea il tuo primo spot!</a></p>
<?php endif; ?>