<?php

namespace App\Notifications;

use App\Models\Invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Add_Invoice_db extends Notification
{
    use Queueable;
    private $invoices;
    /**
     * Create a new notification instance.
     */
    public function __construct(Invoices $invoices)
    {
        $this->invoices = $invoices;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDataBase()
    {
        return [
            'title' => 'تم اضافة فاتورة جديدة بواسطة ',
            'id' => $this->invoices->id,
            'user' => Auth::user()->name,
        ];
    }
    public function toArray(object $notifiable): array
    {
        return [
            // 'title' => 'New Invoices Was Added By',
            // 'id' => $this->invoices->id,
            // 'user' => Auth::user()->name,

        ];
    }
}
