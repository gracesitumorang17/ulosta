<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class SellerNewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total_amount' => $this->order->total_amount,
            'user_id' => $this->order->user_id,
            'message' => 'Pesanan baru diterima',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Pesanan Baru: ' . $this->order->order_number)
                    ->line('Anda menerima pesanan baru dengan nomor ' . $this->order->order_number)
                    ->action('Lihat Pesanan', url(route('seller.orders.show', $this->order->id)))
                    ->line('Terima kasih.');
    }
}
