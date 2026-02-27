@extends('layout.master')
<style>
    .avatar-circle {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        font-weight: bold;
        font-size: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-transform: uppercase;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        border: none;
    }

    .btn-gradient:hover {
        opacity: 0.9;
        color: white;
    }

    /* modal depense */
    .premium-input {
        border-radius: 12px;
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
        transition: 0.2s;
    }

    .premium-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.15rem rgba(99, 102, 241, 0.2);
    }

    .premium-select {
        border-radius: 12px;
        padding: 10px 14px;
        border: 1px solid #e5e7eb;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        color: white;
        border: none;
    }

    .btn-gradient:hover {
        opacity: 0.9;
        color: white;
    }
</style>
@section('content')

    @if(!$colocation)

        <!-- Empty State -->
        <div class="text-center py-5">
            <h4 class="fw-bold mb-3">Aucune colocation pour le moment</h4>
            <p class="text-muted mb-4">
                Créez votre première colocation pour commencer à gérer vos dépenses.
            </p>

            <a href="{{ route('colocationCreate') }}" class="btn btn-primary px-4">
                + Créer une colocation
            </a>
        </div>

    @else

        <div class="bg-white shadow-sm rounded-4 p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <!-- 🏠 Nom Colocation -->
                <div class="text-end">
                    <h3 class="fw-bold mb-0">
                        {{ $colocation->name }}
                    </h3>
                    <small class="text-muted">
                        Tableau de bord
                    </small>
                </div>
                <!-- 👤 User Info -->
                <div class="d-flex align-items-center">

                    <!-- Avatar lettre -->
                    <div class="avatar-circle me-3">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <!-- Nom -->
                    <div>
                        <h6 class="mb-0 fw-semibold">
                            {{ auth()->user()->name }}
                        </h6>
                        <small class="text-muted">
                            Owner de la colocation
                        </small>
                    </div>
                </div>

            </div>
            <div class="mb-4">
                @if($colocation && $colocation->isActive)
                    <!-- Owner peut clôturer -->
                    @if($colocation->isOwner(auth()->user()))
                        <button class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="modal"
                            data-bs-target="#closeColocModal">
                            🔒 Clôturer la colocation
                        </button>
                    @endif
                @else
                    <!-- Aucun colocation active, bouton créer -->
                    <a href="{{ route('colocationCreate') }}" class="btn btn-primary px-4">
                        + Créer une colocation
                    </a>
                @endif
            </div>

            {{-- Modal de confirmation --}}
            <div class="modal fade" id="closeColocModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Clôturer la colocation ?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Cette action est définitive. Toutes les dépenses et membres seront archivés. Êtes-vous sûr ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <form action="{{ route('colocation.close', $colocation->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger">Clôturer</button>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- --}}
            </div>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif
            <div class="row">

                <!-- 🧾 Dépenses -->
                <div class="col-lg-8 mb-4">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body">

                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">
                                    🧾 Liste des Dépenses
                                </h5>

                                <button class="btn btn-gradient rounded-3 px-4" data-bs-toggle="modal"
                                    data-bs-target="#addExpenseModal">
                                    ➕ Ajouter Dépense
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Titre</th>
                                            <th>Payeur</th>
                                            <th>Montant</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($colocation->expenses as $expense)
                                            <tr>
                                                <td class="fw-semibold">
                                                    {{ $expense->title }}
                                                    <small>
                                                        <span class="badge rounded-pill bg-secondary-subtle text-secondary mt-1">
                                                            {{ $expense->category?->name ?? 'Sans catégorie' }}
                                                        </span>
                                                    </small>
                                                </td>

                                                <td>
                                                    {{ $expense->user->name }}
                                                </td>

                                                <td class="fw-bold text-success">
                                                    {{ $expense->amount }} MAD
                                                </td>

                                                <td class="text-end">
                                                    <form action="{{ route('depense.destroy', $expense->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- Qui doit à qui  -->
                    <!-- Qui doit à qui (juste en dessous du tableau) -->
                    <div class="card p-3 mt-3 shadow-sm">
                        <h5 class="fw-bold mb-3">💰 Qui doit à qui ?</h5>
                        <ul class="list-group list-group-flush">

                            @foreach($colocation->expenses as $expense)
                                @php
                                    // Récupère le paiement de l'utilisateur connecté pour cette dépense
                                    $userPayment = $expense->users->where('id', auth()->user()->id)->first();
                                @endphp

                                @if($userPayment)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $expense->title }}</strong>
                                            <br>
                                            <small>
                                                Payeur : {{ $expense->user->name }} |
                                                Montant dû : {{ number_format($userPayment->pivot->amount_due, 2) }} MAD
                                            </small>
                                        </div>

                                        <!-- Bouton Marquée payée -->
                                        @if(!$userPayment->pivot->is_paid)
                                            <form action="{{ route('expense.markPaid', $expense->id) }}" method="POST" class="ms-2">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success">
                                                    Marquée payée
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-success">Payé</span>
                                        @endif
                                    </li>
                                @endif

                            @endforeach

                        </ul>
                    </div>
                    {{-- qui doit à qui end --}}
                </div>

                <!-- 👥 Membres -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body">

                            <h5 class="fw-bold mb-4">
                                👥 Membres
                            </h5>

                            @foreach($colocation->users as $user)
                                <div class="member-card d-flex justify-content-between align-items-center p-3 mb-3 rounded-4">

                                    <!-- Partie gauche -->
                                    <div class="d-flex align-items-center">

                                        <!-- Avatar -->
                                        <div class="avatar-circle me-3">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <!-- Nom + role -->
                                        <div>
                                            <div class="fw-semibold">
                                                {{ $user->name }}
                                            </div>
                                            <small class="text-muted">
                                                {{ ucfirst($user->pivot->role) }}
                                            </small>
                                        </div>

                                    </div>

                                    <!-- Badge Role -->
                                    @if($user->pivot->role == 'owner')
                                        <span class="badge bg-primary px-3 py-2">Owner</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">Member</span>
                                    @endif

                                </div>
                            @endforeach


                            <!-- Bouton inviter -->
                            <div class="d-grid mt-4">
                                <button class="btn btn-outline-primary rounded-3" data-bs-toggle="modal"
                                    data-bs-target="#inviteModal">
                                    ➕ Inviter un membre
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="inviteModalLabel">Inviter un membre</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <form action="{{ route('colocation.invite', $colocation->id)}}" method="POST">
                            @csrf
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="email" class="form-label">Adresse Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="email@example.com" required>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Envoyer l’invitation</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- modal ajouter depense --}}
            <div class="modal fade" id="addExpenseModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">

                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bold">➕ Ajouter une Dépense</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <form action="{{ route('depense.store', $colocation->id) }}" method="POST">
                                @csrf

                                <!-- Titre -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Titre</label>
                                    <input type="text" name="title" class="form-control premium-input"
                                        placeholder="Ex: Courses Marjane" required>
                                </div>

                                <!-- Montant -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Montant (MAD)</label>
                                    <input type="number" step="0.01" name="amount" class="form-control premium-input"
                                        placeholder="0.00" required>
                                </div>

                                <!-- Payeur -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Payeur</label>
                                    <select name="user_id" class="form-select premium-select" required>
                                        <option disabled selected>Choisir le payeur</option>
                                        @foreach($colocation->users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Catégorie -->
                                <div class="mb-2">
                                    <label class="form-label fw-semibold">Catégorie</label>
                                    <select name="category_id" class="form-select premium-select" id="categorySelect" required>
                                        <option disabled selected>Choisir une catégorie</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Bouton créer catégorie -->
                                <div class="mb-3 text-end">
                                    <button type="button" class="btn btn-sm btn-link text-decoration-none"
                                        onclick="toggleCategoryInput()">
                                        ➕ Nouvelle catégorie
                                    </button>
                                </div>

                                <!-- Input nouvelle catégorie -->
                                <div class="mb-3 d-none" id="newCategoryDiv">
                                    <input type="text" name="new_category" class="form-control premium-input"
                                        placeholder="Nom de la nouvelle catégorie">
                                </div>

                                <!-- Submit -->
                                <div class="d-grid mt-4">
                                    <button class="btn btn-gradient rounded-3 py-2">
                                        Ajouter Dépense
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

    @endif

@endsection
    <script>
        function toggleCategoryInput() {
            document.getElementById('newCategoryDiv').classList.toggle('d-none');
        }

        setTimeout(() => {
            const alertMsg = document.querySelector('.alert');
            if (alertMsg) {
                alertMsg.classList.remove('show');
            }
        }, 3000)
    </script>