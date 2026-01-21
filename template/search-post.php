<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-3">Cerca su UniBoSpotted</h5>
        
        <form action="search.php" method="GET">
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-white border-end-0">
                    <span class="bi bi-search text-muted" aria-hidden="true"></span>
                </span>
                
                <input type="search" class="form-control border-start-0 ps-0" 
                       aria-label="Cerca nel sito"
                       placeholder="Cerca post, utenti, categorie..." 
                       name="q" 
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

    <?php 
        $postsLista = $templateParams["searchResults"];
        if(count($postsLista) > 0){
            require 'template/lista-post.php';
        } else {
            ?>
                <div class="alert alert-warning text-center" role="alert">
                    <span class="bi bi-emoji-frown display-4 d-block mb-2" aria-hidden="true"></span>
                    Nessun post trovato. Prova con parole diverse!
                </div>
            <?php
        }
    ?>

<?php endif; ?>