<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ColocApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #4F46E5, #6366F1);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .logout-btn {
            margin-top: auto;
        }

        .content {
            padding: 30px;
        }
    </style>
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">

            <div class="logo">
                🏠 ColocApp
            </div>

            <a href="#">📌 Colocations</a>
            <a href="#">💰 Dépenses</a>
            <a href="#">⚙️ Paramètres</a>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="logout-btn">
                @csrf
                <button type="submit" class="btn btn-light w-100">
                    Se déconnecter
                </button>
            </form>

        </div>

        <!-- Content -->
        <div class="col-md-9 col-lg-10 content">
            @yield('content')
        </div>

    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>