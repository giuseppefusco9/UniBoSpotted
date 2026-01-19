<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body p-4">
        
        <div class="text-center mb-4">
            <div class="mb-3">
                <i class="bi bi-person-plus-fill display-4 text-unibo"></i>
            </div>
            <h2 class="h4 fw-bold">Unisciti a UniBoSpotted</h2>
            <p class="text-muted small">Crea il tuo account</p>
        </div>

        <?php if(!empty($templateParams["erroreRegistrazione"])): ?>
            <div class="alert alert-danger d-flex align-items-center p-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                <div class="small">
                    <?php echo $templateParams["erroreRegistrazione"]; ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="registration.php" method="POST">
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required 
                       value="<?php echo htmlspecialchars($templateParams['username_inserito']); ?>">
                <label for="username">Username</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required
                       value="<?php echo htmlspecialchars($templateParams['email_inserita']); ?>">
                <label for="email">Email</label>
            </div>

            <div class="row g-2 mb-4">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Conferma" required>
                        <label for="confirm_password">Conferma</label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex">
                <a href="registration.php" class="btn btn-outline-secondary flex-grow-1">
                    Annulla
                </a>
                
                <button class="btn btn-unibo py-2 flex-grow-1" type="submit" name="register">
                    Registrati
                </button>
            </div>

        </form>

        <div class="text-center mt-4 pt-3 border-top">
            <small class="text-muted">Hai già un account?</small>
            <a href="login.php" class="text-decoration-none fw-bold action-unibo ms-1">
                Accedi
            </a>
        </div>

    </div>
</div>