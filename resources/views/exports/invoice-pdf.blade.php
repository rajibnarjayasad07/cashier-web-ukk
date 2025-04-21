<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>Invoice</h1>
    <p><strong>Transaction Date:</strong> {{ $transaction->transaction_date }}</p>
    <p><strong>Cashier:</strong> {{ $transaction->user->name }}</p>
    <p><strong>Customer:</strong> {{ $transaction->customer->name ?? 'Non-Member' }}</p>
    <p><strong>Used Poin:</strong>{{ $transaction->total_point }}</p>
    <p><strong>Poin Earned:</strong>{{ $transaction->loyalty_points }}</p>
    <p><strong>Phone:</strong> {{ $transaction->customer->phone ?? '-' }}</p>

    <h2>Purchased Products</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->detailTransaction as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ $detail->amount }}</td>
                    <td>Rp. {{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Total</h2>
    <p><strong>Total Price:</strong> Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
    <p><strong>Total Payment:</strong> Rp. {{ number_format($transaction->total_payment, 0, ',', '.') }}</p>
    <p><strong>Total Return:</strong> Rp. {{ number_format($transaction->total_return, 0, ',', '.') }}</p>
</body>

</html>
