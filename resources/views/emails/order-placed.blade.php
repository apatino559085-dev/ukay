<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f5f7; padding: 20px; color: #111111;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
        <div style="background: #111111; color: #ffffff; padding: 24px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px; letter-spacing: 2px;">THRIFT FINDS</h1>
            <p style="margin: 5px 0 0; font-size: 13px; color: #aaaaaa;">ONLINE UKAY-UKAY STORE</p>
        </div>

        <div style="padding: 24px;">
            <h2 style="font-size: 20px; color: #0f172a; margin-top: 0;">Salamat sa imong order, {{ $order->full_name }}!</h2>
            <p style="font-size: 14px; line-height: 1.6; color: #475569;">
                Nadawat na namo ang imong order para sa imong unique pre-loved ukay finds. I-review ug i-approve kini sa among team sa dili madugay.
            </p>

            <div style="background: #f8fafc; border-left: 4px solid #3b82f6; padding: 14px 16px; margin: 20px 0; border-radius: 4px;">
                <p style="margin: 0; font-size: 13px; color: #1e40af;">
                    <strong>Pahibalo sa Delivery:</strong> Inig abot sa imong order, <strong>manawag o mag-text ang among delivery rider sa imong rehistradong phone number ({{ $order->phone }})</strong>. Palihug ibutang kanunay nga bukas ug accessible ang imong linya.
                </p>
            </div>

            <div style="border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; padding: 16px 0; margin: 20px 0;">
                <p style="margin: 0 0 8px; font-size: 14px;"><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p style="margin: 0 0 8px; font-size: 14px;"><strong>Contact Phone:</strong> {{ $order->phone }}</p>
                <p style="margin: 0 0 8px; font-size: 14px;"><strong>Delivery Address:</strong> {{ $order->shipping_address }}, {{ $order->city }}, {{ $order->province }} ({{ $order->postal_code }})</p>
                <p style="margin: 0; font-size: 14px;"><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
            </div>

            <h3 style="font-size: 16px; margin-bottom: 12px;">Imong Gi-order nga Ukay Items:</h3>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="border-bottom: 2px solid #e2e8f0; text-align: left; font-size: 12px; color: #64748b;">
                        <th style="padding: 8px 0;">Item</th>
                        <th style="padding: 8px;">Size</th>
                        <th style="padding: 8px; text-align: right;">Presyo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px;">
                            <td style="padding: 10px 0;"><strong>{{ $item->product->name ?? 'Ukay Find' }}</strong></td>
                            <td style="padding: 10px;">{{ $item->size }}</td>
                            <td style="padding: 10px; text-align: right;">₱{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="text-align: right; margin-top: 10px;">
                <p style="margin: 4px 0; font-size: 13px; color: #64748b;">Shipping Fee: ₱{{ number_format($order->shipping_fee, 2) }}</p>
                <p style="margin: 6px 0 0; font-size: 18px; font-weight: bold; color: #0f172a;">Total: ₱{{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>

        <div style="background: #f8fafc; padding: 16px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
            &copy; {{ date('Y') }} THRIFT FINDS - Online Ukay-Ukay Store. All rights reserved.
        </div>
    </div>
</body>
</html>
