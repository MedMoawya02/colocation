<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function store(Request $request, Colocation $colocation)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0.01',
        'user_id' => 'required|exists:users,id',
        'category_id' => 'nullable|exists:categories,id',
        'new_category' => 'nullable|string|max:255',
    ]);

    if ($request->new_category) {
        $category = Category::create([
            'name' => $request->new_category
        ]);
        $category_id = $category->id;
    } else {
        $category_id = $request->category_id;
    }

    $expense = $colocation->expenses()->create([
        'title' => $request->title,
        'amount' => $request->amount,
        'user_id' => $request->user_id,
        'category_id' => $category_id,
    ]);

    $members = $colocation->users;
    $amountPerMember = $request->amount / $members->count();

    foreach ($members as $member) {

        $expense->users()->syncWithoutDetaching([
            $member->id => [
                'amount_due' => $amountPerMember,
                'is_paid' => $member->id == $request->user_id,
                'paid_at' => $member->id == $request->user_id ? now() : null,
            ]
        ]);
    }

    return back()->with('success', 'Dépense ajoutée');
}

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return back()->with('success', 'Expense supprimé');
    }

    public function payee(Expense $expense)
    {
        $user = auth()->user();
        $pivot = $expense->users()->where('user_id', $user->id)->first();
        if ($pivot->pivot->is_paid) {
            return back()->with('info', 'Déjà marquée comme payée.');
        }
        $expense->users()->updateExistingPivot($user->id, [
            'is_paid' => true,
            'paid_at' => now(),
        ]);
         return back()->with('success', 'Paiement marqué comme effectué !');
    }
}
