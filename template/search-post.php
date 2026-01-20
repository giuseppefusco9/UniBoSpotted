<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-3">Cerca su UniBoSpotted</h5>
        
        <form action="search.php" method="GET">
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                
                <input type="search" class="form-control border-start-0 ps-0" 
                       placeholder="Cerca post, utenti, categorie..." 
                       aria-label="Cerca" name="q" 
                       value="<?php echo isset($templateParams["searchKeyword"]) ? $templateParams["searchKeyword"] : ''; ?>">
                
                <button class="btn btn-unibo" type="submit">Cerca</button>
            </div>
        </form>

        <div class="mt-3">
            <small class="text-muted me-2">Suggerimenti:</small>
            <?php foreach($templateParams["categorieTop"] as $categoria): ?>
                <a href="search.php?q=<?php echo urlencode($categoria["nome"]); ?>" class="text-decoration-none">
                    <span class="badge rounded-pill text-bg-light border me-1 param-cursor">
                        <?php echo $categoria["nome"]; ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php if(isset($_GET["q"])): ?>
    
    <h4 class="h5 fw-bold mb-3 text-secondary">
        Risultati per "<?php echo $templateParams["searchKeyword"]; ?>": 
        <span class="text-dark"><?php echo count($templateParams["searchResults"]); ?></span>
    </h4>

    <?php if(count($templateParams["searchResults"]) > 0): ?>
        
        <?php foreach($templateParams["searchResults"] as $post): ?>
            <article class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="card-title h5 fw-bold mb-0">
                            <?php echo $post["nome_categoria"]; ?>
                        </h3>
                        
                        <small class="text-muted">@<?php echo $post["username"]; ?></small>
                    </div>
                    
                    <p class="card-text"><?php echo $post["testo"]; ?></p>
                    
                    <?php if(!empty($post["immagine_path"])): ?>
                        <img src="<?php echo $post["immagine_path"]; ?>" class="img-fluid rounded mb-2">
                    <?php endif; ?>
                </div>
                
                <div class="card-footer bg-white border-top-0">
                    <small class="text-muted">Pubblicato <?php echo date("d/m/y H:i", strtotime($post["data_pubblicazione"])); ?></small>
                </div>
            </article>
        <?php endforeach; ?>

    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            <i class="bi bi-emoji-frown display-4 d-block mb-2"></i>
            Nessun post trovato. Prova con parole diverse!
        </div>
    <?php endif; ?>

<?php endif; ?>