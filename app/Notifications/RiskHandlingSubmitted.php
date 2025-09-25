<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\Channel;
use App\Models\RiskHandling;

class RiskHandlingSubmitted extends Notification
{
    use Queueable;

    public function __construct(public RiskHandling $handling) {}

    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        $this->handling->load('handledBy');

        return (new MailMessage)
            ->subject('New Risk Management Effectiveness')
            ->view('emails.risk_handling_submitted', [
                'handling' => $this->handling,
            ]);
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Risk management effectiveness has been inputted.',
            'handling_id' => $this->handling->id,
            'risk_id' => $this->handling->risk_id,
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => 'Efektivitas penanganan risiko telah diinput.',
            'handling_id' => $this->handling->id,
            'risk_id' => $this->handling->risk_id,
        ]);
    }

    public function broadcastAs()
    {
        return 'notification-handling';
    }

    public function broadcastOn(): Channel
    {
        return new Channel('risk-handling');
    }
}
