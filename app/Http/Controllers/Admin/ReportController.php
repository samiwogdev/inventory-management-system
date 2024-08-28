<?php

namespace App\Http\Controllers\Admin;

use App\Models\OrderModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    
    // generating a report based on timeline
    public function generateReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = OrderModel::query();

        if($startDate && $endDate){
            $query->whereBetween('orderDate', [$startDate, $endDate]);
        }

        $reportData = $query->select('productId', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total) as total_revenue'))
            ->with('product:id,name')
            ->groupBy('productId')
            ->orderByDesc('total')
            ->get();

        // Calculate the overall totals
        $totalOrders = $query->count();
        $totalRevenue = $query->sum('total');

        return view('admin.reports.showReport', compact('reportData', 'startDate', 'endDate'));
    
    }

    public function showGenerateReport()
    {
        return view('admin.reports.generateReport');
    }

    public function exportReportToCsv(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $query = OrderModel::query();

    if ($startDate && $endDate) {
        $query->whereBetween('orderDate', [$startDate, $endDate]);
    }

    $reportData = $query->select('productId', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total) as total_revenue'))
        ->with('product:id,name')
        ->groupBy('productId')
        ->orderByDesc('total_quantity')
        ->get();

    $csvData = [];
    $csvData[] = ['Product Name', 'Total Quantity Sold', 'Total Revenue'];

    foreach ($reportData as $data) {
        $csvData[] = [
            $data->product->name,
            $data->total_quantity,
            number_format($data->total_revenue, 2),
        ];
    }

    $filename = "orders_report_" . date('Ymd_His') . ".csv";
    $file = fopen(storage_path($filename), 'w');

    foreach ($csvData as $row) {
        fputcsv($file, $row);
    }

    fclose($file);

    return response()->download(storage_path($filename));
}

}
