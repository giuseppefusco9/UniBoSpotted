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
                            
                            <a class="nav-link <?php isActive('index.php'); ?>" href="index.php">
                                <i class="bi bi-house-door-fill me-2"></i> Home
                            </a>

                            <a class="nav-link <?php isActive('search.php'); ?>" href="search.php">
                                <i class="bi bi-search me-2"></i> Search
                            </a>

                            <a class="nav-link <?php isActive('profile.php'); ?>" href="profile.php">
                                <i class="bi bi-person-circle me-2"></i> Profile
                            </a>

                        </div>
                    </div>
                </div>
            </nav>

            <main class="col-md-6 mb-4">
                <!-- POSTS LIST -->
                <?php
                if(isset($templateParams["nome"])){
                    require($templateParams["nome"]);
                }
                ?>
            </main>

            <div class="col-md-4">
                <!-- TREND ASIDE -->
                <aside class="bg-white border rounded shadow-sm p-3 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-graph-up-arrow text-danger me-2 fs-5"></i>
                        <h2 class="h5 fw-bold mb-0">Trend del momento</h2>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach($templateParams["categorieTop"] as $categoria): ?>
                            <a href="categorieTop.php?id=<?php echo $categoria["id"]; ?>" class="list-group-item list-group-item-action px-0 border-0">
                                <span class="fw-bold text-dark"><?php echo $categoria["nome"]; ?></span>
                                <small class="text-muted d-block" style="font-size: 0.8rem;"><?php echo $categoria["num_post"]; ?> post</small>
                            </a>
                        <?php endforeach; ?>
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