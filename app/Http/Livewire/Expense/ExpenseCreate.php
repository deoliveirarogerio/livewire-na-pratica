<?php

namespace App\Http\Livewire\Expense;

use App\Models\Expense;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Model Expense
 */
class ExpenseCreate extends Component
{
    use WithFileUploads;

    /** @var */
    public $amount;
    /** @var */
    public $type;
    /** @var */
    public $description;
    /** @var */
    public $photo;
    /** @var */
    public $expenseDate;

    protected $rules = [
        'amount' => 'required',
        'type' => 'required',
        'description' => 'required',
        'photo' => 'image||nullable'
    ];

    /**
     * @return void
     */
    public function createExpense(): void
    {
        $this->validate();

        if($this->photo) {
            $this->photo->store('expenses-photos', 'public');
        }

        auth()->user()->expenses()->create([
            'amount' => $this->amount,
            'description' => $this->description,
            'type' => $this->type,
            'user_id' => 1,
            'photo' => $this->photo,
            'expense_date' => $this->expenseDate
        ]);

        session()->flash('message', 'Registro criado com sucesso!');

        $this->amount = $this->type = $this->description = null;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.expense.expense-create');
    }
}
