<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>UniBoSpotted</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">

    <header class="bg-unibo py-4 text-center mb-4 shadow-sm">
        <div class="container">
            <h1 class="display-5 fw-bold">UniBoSpotted</h1>
            <h2 class="h5 fw-normal">La community degli studenti di UniBo</h2>
        </div>
    </header>

    <div class="container-fluid px-md-5">
        <div class="row">

            <nav class="col-md-2 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-2">
                        <div class="nav flex-column nav-pills">
                            <a class="nav-link active" href="index.php"> <i class="bi bi-house-door-fill me-2"></i> Home </a>
                            <a class="nav-link" href="contatti.php"> <i class="bi bi-search me-2"></i> Search </a>
                            <a class="nav-link" href="login.php"> <i class="bi bi-person-circle me-2"></i> Profile </a>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="col-md-7 mb-4">

                <article class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h2 class="card-title h5 fw-bold">Ho perso la felpa in Aula Magna</h2>
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
                        <h2 class="card-title h5 fw-bold">Cerco appunti Basi di Dati</h2>
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
        </div>
    </div>

    <footer class="bg-unibo text-white text-center py-3 mt-auto">
        <p class="mb-0">UniBoSpotted - A.A. 2024/2025</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>