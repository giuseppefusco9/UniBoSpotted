<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-4">
        
        <div class="text-center mb-4">
            <div class="mb-3 text-secondary">
                <i class="bi bi-person-circle display-4 text-danger"></i>
            </div>
            <h2 class="h4 fw-bold">Accedi a UniBoSpotted</h2>
            <p class="text-muted small">Inserisci le tue credenziali</p>
        </div>

        <?php if(isset($templateParams["errorelogin"])): ?>
            <div class="alert alert-danger d-flex align-items-center p-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div class="small">
                    <?php echo $templateParams["errorelogin"]; ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="#" method="POST">
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-unibo py-2 fw-bold" type="submit">
                    Accedi
                </button>
            </div>

        </form>

        <div class="text-center mt-4 pt-3 border-top">
            <small class="text-muted">Non sei ancora dei nostri?</small>
            <a href="registration.php" class="text-decoration-none fw-bold text-unibo ms-1">
                Registrati
            </a>
        </div>

    </div>
</div>