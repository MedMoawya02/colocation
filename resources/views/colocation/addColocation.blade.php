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
                    <img src="https://images.unsplash.com/photo-1507089947368-19c1da9775ae" class="img-fluid rounded-start"
                        style="height:180px; object-fit:cover;" alt="colocation">
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
                        <!-- Bouton Inviter membre (Owner seulement) -->
                        @if(auth()->user()->colocations()->wherePivot('role', 'owner')->exists())
                            <button type="button" class="btn btn-outline-success btn-sm mb-2 w-100" data-bs-toggle="modal"
                                data-bs-target="#inviteModal">
                                Inviter membre
                            </button>
                        @endif
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
        <!-- Modal -->
        <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inviteModalLabel">Inviter un membre</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <form action="{{ route('colocation.invite',$colocation->id)}}" method="POST">
                        @csrf
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="email@example.com"
                                    required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-success">Envoyer l’invitation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endif

@endsection
