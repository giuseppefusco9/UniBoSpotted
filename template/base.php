<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UniBoSpotted</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light container-fluid p-0 overflow-x-hidden">
    <header class="bg-unibo py-4 text-center mb-4 shadow-sm">
        <h1 class="display-5 fw-bold">UniBoSpotted</h1>
        <h2 class="h5 fw-normal">La community degli studenti di UniBo</h2>
    </header>

    <div class="container-fluid px-md-5">
        <div class="row">
            <nav class="col-md-2 mb-4">
                <!-- SIDEBAR NAVIGATION -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-2">
                        <div class="nav flex-column nav-pills">
                            <a class="nav-link active" href="index.php"> <i class="bi bi-house-door-fill me-2"></i> Home </a>
                            <a class="nav-link" href="search.php"> <i class="bi bi-search me-2"></i> Search </a>
                            <a class="nav-link" href="profile.php"> <i class="bi bi-person-circle me-2"></i> Profile </a>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="col-md-6 mb-4">
                <!-- POSTS LIST -->
                <article class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h3 class="card-title h5 fw-bold">Ho perso la felpa in Aula Magna</h3>
                        <p class="card-text">Ragazzi qualcuno ha visto una felpa rossa in Aula Magna a Ingegneria? L'ho lasciata lì alle 14.</p>
                    </div>
                    
                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                        <small class="text-muted">Pubblicato 2 ore fa</small>
                        
                        <div class="action-btn" data-bs-toggle="collapse" data-bs-target="#comments-post-1" aria-expanded="false">
                            <i class="bi bi-chat-dots me-1"></i> 3 Commenti
                        </div>
                    </div>

                    <div class="collapse" id="comments-post-1">
                        <div class="card-body border-top bg-light">
                            
                            <div class="comment-box">
                                <span class="comment-user">Marco:</span>
                                <span class="comment-text">Io ne ho vista una sulle sedie in fondo!</span>
                            </div>
                            <div class="comment-box">
                                <span class="comment-user">Giulia:</span>
                                <span class="comment-text">Chiedi in portineria, portano tutto lì.</span>
                            </div>

                            <div class="input-group mt-3">
                                <input type="text" class="form-control" placeholder="Scrivi un commento...">
                                <button class="btn btn-outline-secondary" type="button"><i class="bi bi-send"></i></button>
                            </div>

                        </div>
                    </div>
                </article>

                <article class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h3 class="card-title h5 fw-bold">Cerco appunti Basi di Dati</h3>
                        <p class="card-text">Qualcuno ha gli appunti del prof aggiornati al 2024? Offro caffè!</p>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                        <small class="text-muted">Pubblicato 5 ore fa</small>
                        
                        <div class="action-btn" data-bs-toggle="collapse" data-bs-target="#comments-post-2">
                            <i class="bi bi-chat-dots me-1"></i> Commenta
                        </div>
                    </div>

                    <div class="collapse" id="comments-post-2">
                        <div class="card-body border-top bg-light">
                            <div class="text-center text-muted p-2">Nessun commento ancora. Sii il primo!</div>
                            <div class="input-group mt-2">
                                <input type="text" class="form-control" placeholder="Scrivi un commento...">
                                <button class="btn btn-outline-secondary" type="button"><i class="bi bi-send"></i></button>
                            </div>
                        </div>
                    </div>
                </article>

                <article class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h3 class="card-title h5 fw-bold">Cerco appunti Basi di Dati</h3>
                        <p class="card-text">Qualcuno ha gli appunti del prof aggiornati al 2024? Offro caffè!</p>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                        <small class="text-muted">Pubblicato 5 ore fa</small>
                        
                        <div class="action-btn" data-bs-toggle="collapse" data-bs-target="#comments-post-2">
                            <i class="bi bi-chat-dots me-1"></i> Commenta
                        </div>
                    </div>

                    <div class="collapse" id="comments-post-2">
                        <div class="card-body border-top bg-light">
                            <div class="text-center text-muted p-2">Nessun commento ancora. Sii il primo!</div>
                            <div class="input-group mt-2">
                                <input type="text" class="form-control" placeholder="Scrivi un commento...">
                                <button class="btn btn-outline-secondary" type="button"><i class="bi bi-send"></i></button>
                            </div>
                        </div>
                    </div>
                </article>

                <article class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h3 class="card-title h5 fw-bold">Cerco appunti Basi di Dati</h3>
                        <p class="card-text">Qualcuno ha gli appunti del prof aggiornati al 2024? Offro caffè!</p>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                        <small class="text-muted">Pubblicato 5 ore fa</small>
                        
                        <div class="action-btn" data-bs-toggle="collapse" data-bs-target="#comments-post-2">
                            <i class="bi bi-chat-dots me-1"></i> Commenta
                        </div>
                    </div>

                    <div class="collapse" id="comments-post-2">
                        <div class="card-body border-top bg-light">
                            <div class="text-center text-muted p-2">Nessun commento ancora. Sii il primo!</div>
                            <div class="input-group mt-2">
                                <input type="text" class="form-control" placeholder="Scrivi un commento...">
                                <button class="btn btn-outline-secondary" type="button"><i class="bi bi-send"></i></button>
                            </div>
                        </div>
                    </div>
                </article>
            </main>

            <div class="col-md-4">
                <!-- TREND ASIDE -->
                <aside class="bg-white border rounded shadow-sm p-3 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-graph-up-arrow text-danger me-2 fs-5"></i>
                        <h2 class="h5 fw-bold mb-0">Trend del momento</h2>
                    </div>

                    <div class="list-group list-group-flush">
                        
                        <a href="#" class="list-group-item list-group-item-action px-0 border-0">
                            <span class="fw-bold text-dark">#AulaStudio</span>
                            <small class="text-muted d-block" style="font-size: 0.8rem;">2.450 post</small>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action px-0 border-0">
                            <span class="fw-bold text-dark">#CaroAffitti</span>
                            <small class="text-muted d-block" style="font-size: 0.8rem;">12k post</small>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action px-0 border-0">
                            <span class="fw-bold text-dark">#Analisi1</span>
                            <small class="text-muted d-block" style="font-size: 0.8rem;">543 post</small>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action px-0 border-0">
                            <span class="fw-bold text-dark">#Tortellini</span>
                            <small class="text-muted d-block" style="font-size: 0.8rem;">89 post</small>
                        </a>

                    </div>
                </aside>
            </div>
        </div>
    </div>

    <div class="row">
        <footer class="bg-unibo text-white text-center py-3 mt-auto">
            <p class="mb-0">UniBoSpotted - A.A. 2025/2026</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>