<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    public function getTransactions() {
        $transactions = Transaction::orderBy('id', 'desc')->get();
        return view('action.list_transactions', compact('transactions'));
    }

    // Add a Transaction
    public function addTransaction(Request $request) {
        $transaction = new Transaction();
        $transaction->date = $request->date;
        $transaction->vendor = $request->vendor;
        $transaction->withdraw = $request->withdraw;
        $transaction->deposit = $request->deposit;
        $transaction->balance = $this->calculateBalance($request->withdraw, $request->deposit);
        $transaction->save();
        return redirect()->route('action.list_transactions')->with('message', 'Transaction added successfully!');
    }

    public function calculateBalance($withdraw, $deposit) {
        $lastBalance = Transaction::orderBy('id', 'desc')->first()->balance;
        return $lastBalance - $withdraw + $deposit;
    }

    public function getLastBalance() {
        $lastBalance = Transaction::orderBy('id', 'desc')->first()->balance;
        return $lastBalance;
    }

    public function newTransaction() {
        $lastBalance = $this->getLastBalance();
        return view('action.new_transaction', compact('lastBalance'));
    }

    // Get a Transaction by ID
    public function getTransactionById($id) {
        $transaction = Transaction::find($id);
        return view('action/update_transaction', compact('transaction'));
    }

    // Update a Transaction
    public function updateTransaction(Request $request, $id) {
        $transaction = Transaction::find($id);
        $transaction->date = $request->date;
        $transaction->vendor = $request->vendor;
        $transaction->withdraw = $request->withdraw;
        $transaction->deposit = $request->deposit;
        $transaction->balance = $this->calculateBalance($request->withdraw, $request->deposit);
        $transaction->save();
        return redirect()->route('action.list_transactions')->with('message', 'Transaction updated successfully!');
    }

    // Delete a Transaction
    public function deleteTransaction($id) {
        $transaction = Transaction::find($id);
        if ($transaction) {
            $transaction->delete();
            return redirect()->route('action.list_transactions')->with('message', 'Transaction deleted successfully!');
        }
        return redirect()->route('action.list_transactions')->with('message', 'Transaction not found!');
    }
}
