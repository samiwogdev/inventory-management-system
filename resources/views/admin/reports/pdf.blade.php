<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Sales Report</h1>
    <p>From: {{ $startDate }} To: {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $order)
                <tr>
                    <td>{{ $order['customer_name'] }}</td>
                    <td>{{ $order['product_name'] }}</td>
                    <td>{{ $order['quantity'] }}</td>
                    <td>{{ $order['total'] }}</td>
                    <td>{{ $order['date'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>