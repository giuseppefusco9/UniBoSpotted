<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h1 class="h4 mb-0 fw-bold text-center">Modifica Spot</h1>
    </div>
    
    <div class="card-body p-4">
        
        <?php if(isset($templateParams["errore"])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $templateParams["errore"]; ?>
            </div>
        <?php endif; ?>

        <form action="edit-post.php" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="post_id" value="<?php echo $templateParams['post']['id']; ?>">
            <input type="hidden" name="old_image" value="<?php echo $templateParams['post']['immagine_path']; ?>">

            <div class="mb-3">
                <label class="form-label fw-bold">Categoria</label>
                <select name="categoria" class="form-select" required>
                    <?php foreach($templateParams["categorie"] as $cat): ?>
                        <?php 
                            $selected = ($cat['id'] == $templateParams['post']['categoria_id']) ? 'selected' : ''; 
                        ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo $selected; ?>>
                            <?php echo $cat['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Testo dello Spot</label>
                <textarea name="testo" class="form-control" rows="5" required><?php echo htmlspecialchars($templateParams['post']['testo']); ?></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Immagine (Opzionale)</label>
                
                <?php if(!empty($templateParams['post']['immagine_path'])): ?>
                    <div class="mb-2 p-2 border rounded bg-light text-center">
                        <small class="d-block text-muted mb-1">Immagine attuale:</small>
                        <img src="<?php echo $templateParams['post']['immagine_path']; ?>" style="max-height: 150px; border-radius: 5px;">
                    </div>
                <?php endif; ?>
                
                <input type="file" name="immagine" class="form-control" accept="image/*">
                <div class="form-text">
                    Carica un file solo se vuoi sostituire quella attuale. Formati: JPG, PNG.
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex">
                <a href="login.php" class="btn btn-outline-secondary btn-lg flex-grow-1">Annulla</a>
                <button type="submit" name="save_edit" class="btn btn-unibo btn-lg flex-grow-1">Salva Modifiche</button>
            </div>

        </form>
    </div>
</div>