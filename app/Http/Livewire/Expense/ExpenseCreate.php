<?php

namespace App\Http\Livewire\Expense;

use App\Models\Expense;
use Livewire\Component;

/**
 * Model Expense
 */
class ExpenseCreate extends Component
{

    /** @var */
    public $amount;
    /** @var */
    public $type;
    /** @var */
    public $description;

    protected $rules = [
        'amount' => 'required',
        'type' => 'required',
        'description' => 'required',
    ];

    /**
     * @return void
     */
    public function createExpense(): void
    {
        $this->validate();

        auth()->user()->expenses()->create([
            'amount' => $this->amount,
            'description' => $this->description,
            'type' => $this->type,
            'user_id' => 2
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
