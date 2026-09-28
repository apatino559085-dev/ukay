<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $statusTitle;
    public string $statusMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;

        switch ($order->status) {
            case 'processing':
                $this->statusTitle = 'Order Approved & Being Prepared';
                $this->statusMessage = 'Great news! Your pre-loved ukay order has been approved by our team and is currently being carefully packed.';
                break;
            case 'shipped':
                $this->statusTitle = 'Order Shipped / Ready for Delivery';
                $this->statusMessage = 'Your package is on its way! Our courier rider will contact/call your phone number (' . $order->phone . ') upon arrival at your location. Please keep your line open.';
                break;
            case 'completed':
                $this->statusTitle = 'Order Delivered Successfully';
                $this->statusMessage = 'Your order has been delivered! Thank you for choosing sustainable fashion and shopping at THRIFT FINDS.';
                break;
            case 'cancelled':
                $this->statusTitle = 'Order Cancelled';
                $this->statusMessage = 'Your order has been cancelled. If you have any questions, please contact our support.';
                break;
            default:
                $this->statusTitle = 'Order Status Updated';
                $this->statusMessage = 'Your order status has been updated to: ' . ucfirst($order->status) . '.';
                break;
        }
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Status Update: ' . $this->statusTitle . ' (' . $this->order->order_number . ') | THRIFT FINDS')
                    ->view('emails.order-status');
    }
}
