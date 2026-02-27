@extends('layout.master')

@section('content')
<div class="container-fluid">

    <h2 class="mb-4">🛠️ Dashboard Admin</h2>

    {{-- Statistiques --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Utilisateurs</h5>
                    <p class="card-text fs-3">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-danger shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Bannis</h5>
                    <p class="card-text fs-3">{{ $bannedUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Colocations</h5>
                    <p class="card-text fs-3">{{ $totalColocations }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Dépenses</h5>
                    <p class="card-text fs-3">{{ $totalExpenses }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tableau des utilisateurs --}}
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">👥 Tous les Utilisateurs</h5>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                @if($user->is_banned)
                                    <span class="badge bg-danger">Banni</span>
                                @else
                                    <span class="badge bg-success">Actif</span>
                                @endif
                            </td>
                            <td>
                                @if(!$user->is_banned)
                                    <form action="{{ route('admin.usersBan',$user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-danger">Bannir</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.usersUnban',$user->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-success">Débannir</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection