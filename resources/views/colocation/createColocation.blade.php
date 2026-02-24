@extends('layout.master')

@section('content')

<div class="card p-4 shadow-sm border-0">
    <h4 class="fw-bold mb-3">Créer une colocation</h4>

    <form action="{{ route('colocationStore') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom de la colocation</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <button class="btn btn-primary">
            Créer
        </button>
    </form>
</div>

@endsection