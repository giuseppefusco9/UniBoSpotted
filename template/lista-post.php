<?php foreach($templateParams["posts"] as $post): ?>
    <article class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3 class="card-title h5 fw-bold">
                    <?php echo $post["nome_categoria"]; ?>
                </h3>
                <small class="text-muted">Posted by: <?php echo $post["username"]; ?></small>
            </div>
            
            <p class="card-text"><?php echo ($post["testo"]); ?></p>
            
            <?php if(!empty($post["immagine_path"])): ?>
                <img src="<?php echo $post["immagine_path"]; ?>" class="img-fluid rounded mb-2">
            <?php endif; ?>
        </div>
        
        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
            <small class="text-muted">Pubblicato <?php echo date("d/m/y H:i", strtotime($post["data_pubblicazione"])); ?></small>
            
            <?php
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
                
                <?php if(isUserLoggedIn()): ?>
                    <form action="#" method="POST" class="input-group mt-3">
                        <input type="hidden" name="post_id" value="<?php echo $post["id"]; ?>">
                        <input type="text" name="testo" class="form-control" placeholder="Scrivi un commento...">
                        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-send"></i></button>
                    </form>
                <?php else: ?>
                    <div class="text-center mt-4 pt-3 border-top">
                        <small class="text-muted">Esegui il login per commentare!</small>
                        <a href="login.php" class="text-decoration-none fw-bold text-unibo ms-1">
                            Login
                        </a>
                    </div>
                    <div class="text-center mt-4 pt-3 border-top">
                        <small class="text-muted">Non sei ancora dei nostri?</small>
                        <a href="registration.php" class="text-decoration-none fw-bold text-unibo ms-1">
                            Registrati
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </article>
<?php endforeach; ?>