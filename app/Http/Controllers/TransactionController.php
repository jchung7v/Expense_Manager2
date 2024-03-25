<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    public function getTransactions() {
        $transactions = Transaction::all();
        return view('action.list_transactions', compact('transactions'));
    }

        // Add a Transaction
        public function addTransaction(Request $request) {
            $transaction = new Transaction();
            $transaction->date = $request->date;
            $transaction->vendor = $request->vendor;
            $transaction->withdraw = $request->withdraw;
            $transaction->deposit = $request->deposit;
            $transaction->balance = $request->balance;
            $transaction->save();
    
            return redirect()->route('action.list_transactions')->with('success', 'Transaction added successfully!');
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
            $transaction->balance = $request->balance;
            $transaction->save();
    
            return redirect()->route('action.list_transactions')->with('success', 'Transaction updated successfully!');
        }
    
        // Delete a Transaction
        public function deleteTransaction($id) {
            $transaction = Transaction::find($id);
            if ($transaction) {
                $transaction->delete();
                return redirect()->route('action.list_transactions')->with('success', 'Transaction deleted successfully!');
            }
    
            return redirect()->route('action.list_transactions')->with('error', 'Transaction not found!');
        }
}
