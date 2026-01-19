<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $templateParams["titolo"]; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light container-fluid p-0 overflow-x-hidden d-flex flex-column min-vh-100">
    
    <header class="bg-unibo py-4 text-white shadow-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-3 text-start">
                    <img src="upload/logoUnibo.png" alt="Logo Università di Bologna" style="width: 120px; height: auto;">
                </div>

                <div class="col-6 text-center">
                    <h1 class="display-5 fw-bold mb-0">UniBoSpotted</h1>
                    <h2 class="h5 fw-normal mb-0">La community degli studenti</h2>
                </div>

                <?php if(isUserLoggedIn()): ?>
                <div class="col-3 text-end d-none d-md-block">
                    <a href="logout.php" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-right me-1" aria-hidden="true"></i> Logout
                    </a>
                </div>
                <?php endif; ?>

                <div class="col-3"></div>
            </div>
        </div>
    </header>

    <div class="container-fluid px-md-5 mt-4">
        <div class="row">
            
            <nav class="col-md-2 mb-4 d-none d-md-block" aria-label="Menu principale desktop">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px; z-index: 1000;">
                    <div class="card-body p-2">
                        <div class="nav flex-column nav-pills">
                            
                            <?php 
                            // Helper per capire la pagina corrente per accessibilità
                            $currentPage = basename($_SERVER['PHP_SELF']); 
                            ?>

                            <a class="nav-link <?php isActive('index.php'); ?>" href="index.php"
                               <?php echo ($currentPage == 'index.php') ? 'aria-current="page"' : ''; ?>>
                                <i class="bi bi-house-door-fill me-2" aria-hidden="true"></i> Home
                            </a>

                            <a class="nav-link <?php isActive('search.php'); ?>" href="search.php"
                               <?php echo ($currentPage == 'search.php') ? 'aria-current="page"' : ''; ?>>
                                <i class="bi bi-search me-2" aria-hidden="true"></i> Search
                            </a>

                            <a class="nav-link <?php isActive('login.php'); ?>" href="login.php"
                               <?php echo ($currentPage == 'login.php') ? 'aria-current="page"' : ''; ?>>
                                <i class="bi bi-person-circle me-2" aria-hidden="true"></i> Profile
                            </a>

                            <?php if(isUserLoggedIn()): ?>
                                <a class="nav-link <?php isActive('process-post.php'); ?>" href="process-post.php"
                                   <?php echo ($currentPage == 'process-post.php') ? 'aria-current="page"' : ''; ?>>
                                    <i class="bi bi-plus me-2" aria-hidden="true"></i> Add post
                                </a>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </nav>

            <main class="col-md-6 mb-4">
                <?php
                if(isset($templateParams["nome"])){
                    require($templateParams["nome"]);
                }
                ?>
            </main>

            <div class="col-md-4">
                
                <aside class="bg-white border rounded shadow-sm p-3 mb-4" aria-labelledby="trend-title">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-graph-up-arrow text-danger me-2 fs-5" aria-hidden="true"></i>
                        <h2 class="h5 fw-bold mb-0" id="trend-title">Trend del momento</h2>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach($templateParams["categorieTop"] as $categoria): ?>
                            <div class="list-group-item px-0 border-0">
                                <span class="fw-bold text-dark"><?php echo $categoria["nome"]; ?></span>
                                <small class="text-secondary d-block" style="font-size: 0.8rem;">
                                    <?php echo $categoria["num_post"]; ?> post
                                </small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </aside>

                <?php if(isUserLoggedIn()): ?>
                    <aside class="bg-white border rounded shadow-sm p-3 mb-4" aria-labelledby="stats-title">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-pie-chart-fill text-primary me-2 fs-5" aria-hidden="true"></i>
                            <h2 class="h5 fw-bold mb-0" id="stats-title">Le tue statistiche</h2>
                        </div>
                        <div class="d-flex justify-content-center" style="position: relative; height: 350px; width: 100%">
                            <canvas id="graficoCategorie" role="img" aria-label="Grafico a torta delle tue statistiche"></canvas>
                        </div>
                    </aside>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="bg-unibo text-white pt-5 pb-3 mt-auto mb-5 mb-md-0">
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase fw-bold mb-3">UniBoSpotted</h5>
                    <p class="small text-white-50">
                        La community non ufficiale degli studenti dell'Alma Mater Studiorum.
                        Racconta, condividi e scopri la vita universitaria.
                    </p>
                    <p class="small text-white-50 fst-italic">
                        *Questo sito non è affiliato con l'Università di Bologna.
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase fw-bold mb-3">Link Utili</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="about.php" class="text-white-50 text-decoration-none link-light">Chi siamo</a>
                        </li>
                        <li class="mb-2">
                            <a href="process-guidelines.php" class="text-white-50 text-decoration-none link-light">Linee Guida Community</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12">
                    <h5 class="text-uppercase fw-bold mb-3">Autori</h5>

                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="fw-bold text-white">Giuseppe Fusco</span>
                            <a href="https://www.instagram.com/_.giuseppefusco.__/" class="text-white text-decoration-none" aria-label="Instagram Giuseppe">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://github.com/giuseppefusco9" class="text-white text-decoration-none" aria-label="GitHub Giuseppe">
                                <i class="bi bi-github"></i>
                            </a>
                        </div>
                        <p class="small text-white-50 mb-0">giuseppe.fusco9@studio.unibo.it</p>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="fw-bold text-white">Lucia Pola</span>
                            <a href="https://www.instagram.com/luciapola_/" class="text-white text-decoration-none" aria-label="Instagram Lucia">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://github.com/luciapola04" class="text-white text-decoration-none" aria-label="GitHub Lucia">
                                <i class="bi bi-github"></i>
                            </a>
                        </div>
                        <p class="small text-white-50 mb-0">lucia.pola@studio.unibo.it</p>
                    </div>
                </div>
            </div>

            <hr class="my-4 border-light opacity-25">

            <div class="row align-items-center">
                <div class="col-12 text-center text-md-start">
                    <span class="small text-white-50">
                        © 2026 UniBoSpotted - Progetto Universitario
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <nav class="navbar fixed-bottom bg-unibo border-top d-block d-md-none shadow-lg" aria-label="Menu mobile">
        <div class="container-fluid d-flex justify-content-around">
            
            <a class="nav-link text-center <?php isActive('index.php'); ?>" href="index.php"
               <?php echo ($currentPage == 'index.php') ? 'aria-current="page"' : ''; ?>>
                <i class="bi bi-house-door-fill fs-4 text-white" aria-hidden="true"></i>
                <div class="small text-white">Home</div>
            </a>

            <a class="nav-link text-center <?php isActive('search.php'); ?>" href="search.php"
               <?php echo ($currentPage == 'search.php') ? 'aria-current="page"' : ''; ?>>
                <i class="bi bi-search fs-4 text-white" aria-hidden="true"></i>
                <div class="small text-white">Search</div>
            </a>

            <a class="nav-link text-center <?php isActive('login.php'); ?>" href="login.php"
               <?php echo ($currentPage == 'login.php') ? 'aria-current="page"' : ''; ?>>
                <i class="bi bi-person-circle fs-4 text-white" aria-hidden="true"></i>
                <div class="small text-white">Profile</div>
            </a>
            
            <?php if(isUserLoggedIn()): ?>
                <a class="nav-link text-center <?php isActive('process-post.php'); ?>" href="process-post.php"
                   <?php echo ($currentPage == 'process-post.php') ? 'aria-current="page"' : ''; ?>>
                    <i class="bi bi-plus fs-4 text-white" aria-hidden="true"></i>
                    <div class="small text-white">Add Post</div>
                </a>

                <a class="nav-link text-center" href="logout.php">
                    <i class="bi bi-box-arrow-right fs-4 text-white" aria-hidden="true"></i>
                    <div class="small text-white">Logout</div>
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php if(isUserLoggedIn() && isset($templateParams["statisticheUser"])): ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="js/graphicUser.js"></script>
        <script>
            const labelsPHP = <?php echo json_encode($templateParams["statisticheUser"]["labels"]); ?>;
            const dataPHP = <?php echo json_encode($templateParams["statisticheUser"]["data"]); ?>;
            disegnaGraficoTorta(labelsPHP, dataPHP);
        </script>
    <?php endif; ?>

</body>
</html>