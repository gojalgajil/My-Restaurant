<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .receipt {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .restaurant-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .restaurant-info {
            font-size: 10px;
            color: #666;
            margin-bottom: 10px;
        }
        .order-info {
            margin-bottom: 20px;
        }
        .order-info div {
            margin-bottom: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .items-table .text-right {
            text-align: right;
        }
        .totals {
            margin-top: 20px;
        }
        .totals div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            padding: 5px 0;
        }
        .totals .grand-total {
            border-top: 2px solid #333;
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
            padding-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div class="restaurant-name">{{ $restaurant['name'] }}</div>
            <div class="restaurant-info">
                {{ $restaurant['address'] }}<br>
                Tel: {{ $restaurant['phone'] }}<br>
                {{ $restaurant['email'] }}
            </div>
        </div>

        <div class="order-info">
            <div><strong>Order #:</strong> {{ $order->id }}</div>
            <div><strong>Table:</strong> {{ $order->table->number }}</div>
            <div><strong>Waiter:</strong> {{ $order->user->name }}</div>
            <div><strong>Date:</strong> {{ $date }}</div>
            <div><strong>Status:</strong> {{ ucfirst($order->status) }}</div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->food->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @if($item->notes)
                        <tr>
                            <td colspan="4" style="font-size: 10px; font-style: italic; color: #666;">
                                Note: {{ $item->notes }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div>
                <span>Subtotal:</span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div>
                <span>Tax (10%):</span>
                <span>Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
            </div>
            <div class="grand-total">
                <span>Total:</span>
                <span>Rp {{ number_format($order->final_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="footer">
            <div>Thank you for your visit!</div>
            <div>Please come again</div>
            <div>{{ $restaurant['name'] }}</div>
        </div>
    </div>
</body>
</html>
