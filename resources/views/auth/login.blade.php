<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Login - ColocApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #4F46E5, #06B6D4);
            min-height: 100vh;
        }

        .login-card {
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #4F46E5;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4F46E5, #6366F1);
            border: none;
            border-radius: 12px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .illustration {
            background: #F9FAFB;
            border-radius: 0 20px 20px 0;
        }

        .logo {
            font-weight: bold;
            color: #4F46E5;
            font-size: 22px;
        }
    </style>
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="row w-100 login-card bg-white overflow-hidden">

            <!-- Form Section -->
            <div class="col-md-6 p-5">

                <div class="mb-4">
                    <div class="logo">🏠 ColocApp</div>
                    <h3 class="fw-bold mt-3">Se connecter</h3>
                    <p class="text-muted">Entrez vos informations pour accéder à votre compte.</p>
                </div>

                <form>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Adresse Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" class="form-control" placeholder="email@example.com">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" id="login-password" class="form-control" placeholder="********">
                            <button class="btn btn-outline-secondary" type="button" onclick="toggleLoginPassword()">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="remember">
                        <label class="form-check-label" for="remember">
                            Se souvenir de moi
                        </label>
                    </div>

                    <!-- Button -->
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        Se connecter
                    </button>

                    <!-- Register link -->
                    <div class="text-center mt-4">
                        <small>Pas encore de compte ?
                            <a href="{{ route('registerForm') }}" class="text-decoration-none fw-semibold">Créer un compte</a>
                        </small>
                    </div>

                </form>
            </div>

            <!-- Illustration Section -->
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center illustration">
                <div class="text-center p-4">
                    <h4 class="fw-bold">Bienvenue 👋</h4>
                    <p class="text-muted">Connectez-vous pour gérer vos colocations et dépenses partagées.</p>
                    <img src="https://cdn-icons-png.flaticon.com/512/1048/1048947.png" class="img-fluid mt-3"
                        style="max-width: 250px;">
                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleLoginPassword() {
            const password = document.getElementById("login-password");
            password.type = password.type === "password" ? "text" : "password";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>