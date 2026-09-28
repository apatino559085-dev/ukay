<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Status Update</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f5f7; padding: 20px; color: #111111;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
        <div style="background: #111111; color: #ffffff; padding: 24px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px; letter-spacing: 2px;">THRIFT FINDS</h1>
            <p style="margin: 5px 0 0; font-size: 13px; color: #aaaaaa;">ONLINE UKAY-UKAY STORE</p>
        </div>

        <div style="padding: 24px;">
            <div style="display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase; margin-bottom: 16px;
                @if($order->status == 'processing') background: #dbeafe; color: #1e40af;
                @elseif($order->status == 'shipped') background: #e0e7ff; color: #3730a3;
                @elseif($order->status == 'completed') background: #dcfce7; color: #166534;
                @else background: #fee2e2; color: #991b1b; @endif">
                STATUS: {{ strtoupper($order->status) }}
            </div>

            <h2 style="font-size: 20px; color: #0f172a; margin-top: 0;">{{ $statusTitle }}</h2>
            <p style="font-size: 14px; line-height: 1.6; color: #475569;">
                {{ $statusMessage }}
            </p>

            {{-- Phone call reminder for delivery --}}
            @if(in_array($order->status, ['processing', 'shipped']))
                <div style="background: #fefce8; border-left: 4px solid #eab308; padding: 14px 16px; margin: 20px 0; border-radius: 4px;">
                    <p style="margin: 0; font-size: 13px; color: #854d0e;">
                        📞 <strong>Pahinumdom sa Rider Call:</strong> Kung maabot na ang rider sa imong address, <strong>manawag sila sa imong contact number: {{ $order->phone }}</strong>. Palihug andama ang imong bayad (kung COD) ug siguroha nga aktibo ang imong cellphone.
                    </p>
                </div>
            @endif

            <div style="border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; padding: 16px 0; margin: 20px 0; font-size: 14px;">
                <p style="margin: 0 0 8px;"><strong>Order #:</strong> {{ $order->order_number }}</p>
                <p style="margin: 0 0 8px;"><strong>Customer:</strong> {{ $order->full_name }}</p>
                <p style="margin: 0 0 8px;"><strong>Phone:</strong> {{ $order->phone }}</p>
                <p style="margin: 0;"><strong>Delivery Address:</strong> {{ $order->shipping_address }}, {{ $order->city }}</p>
            </div>

            <h3 style="font-size: 15px; margin-bottom: 10px;">Items in this order:</h3>
            <ul style="padding-left: 20px; font-size: 14px; color: #475569; margin-bottom: 20px;">
                @foreach($order->items as $item)
                    <li style="margin-bottom: 4px;">{{ $item->product->name ?? 'Ukay item' }} (Size: {{ $item->size }}) - ₱{{ number_format($item->subtotal, 2) }}</li>
                @endforeach
            </ul>

            <p style="font-size: 16px; font-weight: bold; color: #0f172a; text-align: right;">Total: ₱{{ number_format($order->total_amount, 2) }}</p>
        </div>

        <div style="background: #f8fafc; padding: 16px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0;">
            &copy; {{ date('Y') }} THRIFT FINDS - Online Ukay-Ukay Store. All rights reserved.
        </div>
    </div>
</body>
</html>
