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
            <x-colocation.header :colocation="$colocation" :user="auth()->id()"/>
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
            {{-- Modal de confirmation la cloture --}}
           <x-modals.clotureColocation :colocation="$colocation"/>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                </div>
            @endif
            <div class="row">
                <!-- 🧾 Dépenses -->
                <div class="col-lg-8 mb-4">
                    <x-expenses.allExpense :colocation="$colocation" />
                    <!-- Qui doit à qui  -->
                    <x-expenses.quiDoitQui :colocation="$colocation" :userId="auth()->id()" />
                </div>
                <!-- 👥 Membres -->
                <div class="col-lg-4 mb-4">
                    <x-expenses.members :colocation="$colocation" />
                </div>
            </div>

            <!-- Modal inviter member -->
            <x-modals.inviterMember :colocation="$colocation" />
            {{-- modal ajouter depense --}}
            <x-modals.ajouterDepense :colocation="$colocation" :categories="$categories" />
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