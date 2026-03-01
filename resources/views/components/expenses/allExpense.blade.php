@props(['colocation'])

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
                            <td>{{ $expense->user->name }}</td>
                            <td class="fw-bold text-success">{{ $expense->amount }} MAD</td>
                            <td class="text-end">
                                <form action="{{ route('depense.destroy', $expense->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>