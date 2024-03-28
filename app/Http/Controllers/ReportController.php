<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Bucket;

class ReportController extends Controller
{
    public function show(Request $request)
    {
        $year = $request->get('year', 2023);

        $categoryTotals = $this->generateReport($year);
        $pieChartJS = $this->generatePieChartJS($year, $categoryTotals);
        $reportTable = $this->generateReportTable($year, $categoryTotals);
    
        return view('action.report', compact('year', 'pieChartJS', 'reportTable'));
    }

    private function generateReport($year)
    {
        $categoriesResult = Bucket::distinct()->get(['category']);
        $categoryTotals = [];

        foreach ($categoriesResult as $category) {
            $categoryTotals[$category->category] = 0;
        }
        $categoryTotals['Other'] = 0;

        $transactions = Transaction::select('date', 'vendor', 'withdraw')
                           ->whereYear('date', '=', $year)
                           ->get();

        foreach ($transactions as $transaction) {
            $matched = false;
            foreach ($this->getBuckets() as $bucket) {
                if (strpos($transaction->vendor, trim($bucket->vendor)) !== false) {
                    $categoryTotals[$bucket->category] += (float) $transaction->withdraw;
                    $matched = true;
                    break;
                }
            }
            if (!$matched) {
                $categoryTotals['Other'] += $transaction->withdraw;
            }
        }

        return $categoryTotals;
    }

    public function generatePieChartJS($year) {
        $report = $this->generateReport($year);
        $js = "google.charts.load('current', {'packages':['corechart']});";
        $js .= "google.charts.setOnLoadCallback(drawChart);";
        $js .= "function drawChart() {";
        $js .= "var data = google.visualization.arrayToDataTable([";
        $js .= "['Category', 'Amount'],";
        foreach ($report as $category => $amount) {
            $js .= "['" . addslashes($category) . "', " . $amount . "],";
        }
        $js .= "]);";
        $js .= "var options = {";
        $js .= "is3D: true,";
        $js .= "backgroundColor: 'transparent',";
        $js .= "legend: {textStyle: {color: 'black'}},";
        $js .= "titleTextStyle: {color: 'white'},";
        $js .= "chartArea: {width: '100%', height: '80%'},";
        $js .= "};";
        $js .= "var chart = new google.visualization.PieChart(document.getElementById('piechart'));";
        $js .= "chart.draw(data, options);";
        $js .= "}";
        return $js;
    }    

    public function generateReportTable($year) {
        $report = $this->generateReport($year);
        $html = "<h2 class='text-xl font-semibold mb-4 p-6'>Expense Report for the Year: $year</h2>";
        $html .= "<div class='overflow-hidden shadow-sm sm:rounded-lg'><div class='p-6 bg-white border-b border-gray-200'>";
        $html .= "<table class='table-fixed text-center w-full mt-4'>";
        $html .= "<thead><tr class='bg-gray-100'>";
        $html .= "<th class='border-b-2 border-gray-300 py-2 text-left px-4'>Category</th>";
        $html .= "<th class='border-b-2 border-gray-300 py-2 text-left px-4'>Amount</th>";
        $html .= "</tr></thead>";
        $html .= "<tbody>";
        $total = 0;
        foreach ($report as $category => $amount) {
            $html .= "<tr>";
            $html .= "<td class='border-b border-gray-300 py-2 px-4'>" . htmlspecialchars($category) . "</td>";
            $html .= "<td class='border-b border-gray-300 py-2 px-4'>" . number_format($amount, 2) . "</td>";
            $html .= "</tr>";
            $total += $amount;
        }
        $html .= "<tr><td class='font-bold border-b border-gray-300 py-2 px-4'>Total</td>";
        $html .= "<td class='font-bold border-b border-gray-300 py-2 px-4'>" . number_format($total, 2) . "</td></tr>";
        $html .= "</tbody></table></div></div>";
        return $html;
    }
    


    private function getBuckets()
    {
        $bucket = new Bucket();
        // Assuming this retrieves all buckets. Adapt it to use Laravel's Eloquent or Query Builder.
        return Bucket::all();
    }
}
