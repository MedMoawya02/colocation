@props(['colocation', 'userId'])

<div class="card p-3 mt-3 shadow-sm">
    <h5 class="fw-bold mb-3">💰 Qui doit à qui ?</h5>
    <ul class="list-group list-group-flush">
        @foreach($colocation->expenses as $expense)
            @php
                $userPayment = $expense->users->where('id', $userId)->first();
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