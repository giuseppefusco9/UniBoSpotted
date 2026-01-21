<section class="bg-white text-center py-5 border-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-dark mb-3">La voce degli studenti dell'Alma Mater</h1>
                
                <p class="lead text-secondary mb-4">
                    Siamo la piazza digitale dove gli studenti di Bologna si incontrano, 
                    condividono storie e si aiutano a vicenda. Senza filtri, ma con rispetto.
                </p>
                <a href="index.php" class="btn btn-unibo btn-lg px-4 me-md-2">Vai al Feed</a>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <h2 class="visually-hidden">I nostri valori</h2>

    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-3">
                <div class="card-body">
                    <div class="text-unibo mb-3">
                        <span class="bi bi-chat-quote-fill display-4" aria-hidden="true"></span>
                    </div>
                    <h3 class="h5 fw-bold text-dark">Libertà di Parola</h3>
                    <p class="text-secondary">
                        Uno spazio dove raccontare quel momento imbarazzante a lezione, 
                        cercare quella persona incrociata in Via Zamboni o chiedere consigli sugli esami.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-3">
                <div class="card-body">
                    <div class="text-unibo mb-3">
                        <span class="bi bi-shield-lock-fill display-4" aria-hidden="true"></span>
                    </div>
                    <h3 class="h5 fw-bold text-dark">Anonimato Sicuro</h3>
                    <p class="text-secondary">
                        La tua privacy è la nostra priorità. Pubblica i tuoi spot in totale sicurezza, 
                        sapendo che la tua identità è protetta all'interno della community.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-3">
                <div class="card-body">
                    <div class="text-unibo mb-3">
                        <span class="bi bi-heart-fill display-4" aria-hidden="true"></span>
                    </div>
                    <h3 class="h5 fw-bold text-dark">Community Reale</h3>
                    <p class="text-secondary">
                        Non siamo solo un sito web, siamo studenti come te. Crediamo nel supporto reciproco 
                        e nel rendere la vita universitaria meno stressante e più divertente.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="storia" class="bg-white py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                
                <span class="text-uppercase text-danger fw-bold letter-spacing-2">Il Progetto</span>
                <h2 class="fw-bold mb-4">Dagli studenti, per gli studenti</h2>
                
                <p class="text-secondary lead"> 
                    UniBoSpotted nasce nei laboratori di Informatica da un'idea semplice: 
                    creare un'alternativa moderna alle vecchie pagine social, un luogo dedicato 
                    esclusivamente a noi universitari.
                </p>
                
                <p class="text-secondary">
                    Siamo stanchi delle piattaforme caotiche. Qui trovi solo contenuti rilevanti 
                    per la tua vita accademica: dal "Cercasi appunti di Analisi 1" al 
                    "Ragazzo con la felpa rossa in biblioteca, chi sei?"
                </p>
                
                <div class="alert alert-light border mt-4 d-inline-block text-start" role="alert">
                    <h3 class="alert-heading h6 fw-bold">
                        <span class="bi bi-info-circle me-2" aria-hidden="true"></span>Nota Importante
                    </h3>
                    <p class="mb-0 small text-secondary">
                        UniBoSpotted è un progetto indipendente realizzato dagli studenti. 
                        <strong>Non siamo affiliati ufficialmente</strong> con l'Alma Mater Studiorum.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="container py-5 text-center">
    <div class="bg-unibo text-white rounded-3 p-5 shadow-sm">
        <h2 class="fw-bold">Hai qualcosa da dire?</h2>
        <p class="lead mb-4">Non tenertelo dentro. Unisciti alla discussione ora.</p>
        
        <?php if(!isUserLoggedIn()):?>
            <a href="login.php" class="btn btn-light btn-lg px-4 fw-bold text-unibo">Accedi per pubblicare</a>
        <?php else: ?>
            <a href="process-post.php" class="btn btn-light btn-lg px-4 fw-bold text-unibo">Scrivi uno Spot</a>
        <?php endif; ?>
    </div>
</section>