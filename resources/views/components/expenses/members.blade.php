@props(['colocation'])
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
            <button class="btn btn-outline-primary rounded-3" data-bs-toggle="modal" data-bs-target="#inviteModal">
                ➕ Inviter un membre
            </button>
        </div>

    </div>
</div>