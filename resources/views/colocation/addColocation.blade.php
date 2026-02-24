@extends('layout.master')

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

    <!-- Card Colocation -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="row g-0 align-items-center">

            <!-- Image -->
            <div class="col-md-3">
                <img src="https://images.unsplash.com/photo-1507089947368-19c1da9775ae"
                     class="img-fluid rounded-start"
                     style="height:180px; object-fit:cover;"
                     alt="colocation">
            </div>

            <!-- Infos -->
            <div class="col-md-6">
                <div class="card-body">
                    <h5 class="card-title fw-bold">
                        {{ $colocation->name }}
                    </h5>

                    <p class="card-text text-muted">
                        {{ $colocation->users->count() }} membres
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div class="col-md-3 text-center">
                <div class="p-3">
                    <a href="#" class="btn btn-outline-primary btn-sm mb-2 w-100">
                        Voir détails
                    </a>

                    <form action="#" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm w-100">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endif

@endsection