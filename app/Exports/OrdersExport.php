<?php

namespace App\Exports;

use App\Models\OrderModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return OrderModel::whereBetween('orderDate', [$this->startDate, $this->endDate])
                    ->with(['customer:id,name', 'product:id,name'])
                    ->get()
                    ->map(function ($order) {
                        return [
                            'customer_name' => $order->customer->name,
                            'product_name' => $order->product->name,
                            'quantity' => $order->quantity,
                            'total' => $order->total,
                            'date' => $order->orderDate,
                        ];
                    });
    }

    public function headings(): array
    {
        return [
            'Customer Name',
            'Product Name',
            'Quantity',
            'Total',
            'Date',
        ];
    }
}