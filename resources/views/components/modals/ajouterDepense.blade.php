@props(['colocation','categories'])
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