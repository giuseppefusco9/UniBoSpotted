<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h1 class="h4 mb-0 fw-bold text-center">Nuovo Spot</h1>
    </div>
    <div class="card-body p-4">

        <?php if(!empty($msg)): ?>
            <div class="alert alert-info" role="alert">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <form action="#" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="action" value="1">
            
            <div class="mb-3">
                <label for="categoria" class="form-label fw-bold">Categoria</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="" selected disabled>Scegli una categoria...</option>
                    <?php foreach($templateParams["categorie"] as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>">
                            <?php echo $cat['nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="testo" class="form-label fw-bold">Il tuo messaggio</label>
                <textarea class="form-control" id="testo" name="testo" rows="5" 
                            placeholder="Scrivi qui il tuo spot..." required></textarea>
            </div>

            <div class="mb-4">
                <label for="immagine" class="form-label fw-bold">Immagine (Opzionale)</label>
                <input class="form-control" type="file" id="immagine" name="immagine" accept="image/*">
                <div class="form-text">Formati supportati: JPG, JPEG, PNG, GIF.</div>
            </div>

            <div class="mb-4 p-3 bg-light rounded border border-light">
                <h6 class="fw-bold text-secondary mb-2">
                    <i class="bi bi-info-circle me-1"></i> Linee guida della community:
                </h6>
                <ul class="mb-0 small text-secondary ps-3">
                    <li>Sii rispettoso e gentile verso gli altri</li>
                    <li>No attacchi personali o molestie</li>
                    <li>Mantieniti sugli aspetti universitari</li>
                    <li>Evita spam e autopromozioni</li>
                    <li>Gli amministratori si riservano il diritto di rimuovere contenuti inappropriati</li>
                </ul>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-unibo btn-lg">Pubblica Spot</button>
            </div>

        </form>
    </div>
</div>