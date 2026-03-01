@props(['colocation','user'])
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
                Member de la colocation
            </small>
        </div>
    </div>
</div>