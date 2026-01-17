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
    <header class="bg-unibo py-4 text-white shadow-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-3 text-start">
                    <img src="upload/logoUnibo.png" alt="Logo" style="width: 120px; height: auto;">
                </div>

                <div class="col-6 text-center">
                    <h1 class="display-5 fw-bold mb-0">UniBoSpotted</h1>
                    <h2 class="h5 fw-normal mb-0">La community degli studenti</h2>
                </div>
                <!-- TO BE FIXED -->
                <?php if(isUserLoggedIn()): ?>
                <div class="col-3 text-end d-none d-md-block">
                    <a href="logout.php" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
                <?php endif; ?>
                <!-- ... -->

                <div class="col-3"></div>

            </div>
        </div>
    </header>

    <div class="container-fluid px-md-5 mt-4">
        <div class="row">
            <nav class="col-md-2 mb-4 d-none d-md-block">
                <!-- SIDEBAR NAVIGATION -->
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px; z-index: 1000;">
                    <div class="card-body p-2">
                        <div class="nav flex-column nav-pills">
                            
                            <a class="nav-link <?php isActive('index.php'); ?>" href="index.php">
                                <i class="bi bi-house-door-fill me-2"></i> Home
                            </a>

                            <a class="nav-link <?php isActive('search.php'); ?>" href="search.php">
                                <i class="bi bi-search me-2"></i> Search
                            </a>

                            <a class="nav-link <?php isActive('login.php'); ?>" href="login.php">
                                <i class="bi bi-person-circle me-2"></i> Profile
                            </a>

                            <?php if(isUserLoggedIn()): ?>
                                <a class="nav-link <?php isActive('add-post.php'); ?>" href="add-post.php">
                                    <i class="bi bi-plus me-2"></i> Add post
                                </a>
                            <?php endif; ?>

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
                            <a class="list-group-item list-group-item-action px-0 border-0">
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

<!-- MOBILE NAVIGATION -->
<nav class="navbar fixed-bottom bg-unibo border-top d-block d-md-none shadow-lg">
    <div class="container-fluid d-flex justify-content-around">
        <a class="nav-link text-center <?php isActive('index.php'); ?>" href="index.php">
            <i class="bi bi-house-door-fill fs-4"></i>
            <div class="small">Home</div>
        </a>

        <a class="nav-link text-center <?php isActive('search.php'); ?>" href="search.php">
            <i class="bi bi-search fs-4"></i>
            <div class="small">Search</div>
        </a>

        <a class="nav-link text-center <?php isActive('login.php'); ?>" href="login.php">
            <i class="bi bi-person-circle fs-4"></i>
            <div class="small">Profile</div>
        </a>
        
        <?php if(isUserLoggedIn()): ?>
            <a class="nav-link text-center <?php isActive('add-post.php'); ?>" href="add-post.php">
                <i class="bi bi-plus me-2"></i>
                <div class="small">Add Post</div>
            </a>

            <a class="nav-link text-center <?php isActive('logout.php'); ?>" href="logout.php">
                <i class="bi bi-box-arrow-right fs-4"></i>
                <div class="small">Logout</div>
        <?php endif; ?>
    </div>
</nav>
</html>