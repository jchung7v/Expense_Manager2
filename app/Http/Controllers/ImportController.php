<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Bucket;

class ImportController extends Controller
{
    public function importCsv(Request $request)
    {
        $request->validate([
            'fileToUpload' => 'required|file|mimes:csv,txt',
        ]);

        if ($request->hasFile('fileToUpload')) {
            $path = $request->file('fileToUpload')->getRealPath();

            if (($handle = fopen($path, "r")) !== false) {
                fgetcsv($handle);

                while (($data = fgetcsv($handle)) !== false) {
                    $this->insertTransaction($data);
                    $this->insertOrUpdateBucket($data);
                }

                fclose($handle);
            }
        }

        return redirect()->route('action.list_transactions')->with('success', 'CSV data has been imported successfully!');
    }

    private function insertTransaction($data)
    {
        // Assuming $data[0] is date, $data[1] is vendor, $data[2] is withdraw, $data[3] is deposit, $data[4] is balance
        $transaction = new Transaction();
        $transaction->date = \Carbon\Carbon::createFromFormat('m/d/Y', $data[0])->format('Y-m-d');
        $transaction->vendor = $data[1];
        $transaction->withdraw = $data[2] ?? 0;
        $transaction->deposit = $data[3] ?? 0;
        $transaction->balance = $data[4];
        $transaction->save();
    }

    private function insertOrUpdateBucket($data)
    {
        $category = $this->determineCategory($data[1]) ?? 'Unknown Category';
    
        $bucket = Bucket::firstOrNew(['vendor' => $data[1], 'category' => $category]);
        if (!$bucket->exists) {
            $bucket->save();
        }
    }

    private function determineCategory($vendor)
    {
        $predefinedBuckets = [
            ['Entertainment', 'ST JAMES RESTAURAT'],
            ['Entertainment', 'PUR & SIMPLE RESTAUR'],
            ['Entertainment', 'Subway'],
            ['Entertainment', 'WHITE SPOT RESTAURAN'],
            ['Entertainment', 'MCDONALDS'],
            ['Entertainment', 'TIM HORTONS'],
            ['Groceries', 'SAFEWAY'],
            ['Groceries', 'SAFEWAY #4913'],
            ['Groceries', 'REAL CDN SUPERS'],
            ['Groceries', 'WALMART STORE'],
            ['Groceries', 'COSTCO WHOLESAL'],
            ['Groceries', '7-ELEVEN STORE'],
            ['Communication', 'ROGERS MOBILE'],
            ['Car Insurance', 'ICBC'],
            ['Gas Heating', 'FORTISBC'],
            ['Donations', 'RED CROSS'],
            ['Banking', 'GATEWAY'],
            ['Banking', 'CHQ'],
            ['Banking', 'FEE'],
        ];

        foreach ($predefinedBuckets as $bucket) {
            if (stripos($vendor, $bucket[1]) !== false) {
                return $bucket[0];
            }
        }
    }
}

