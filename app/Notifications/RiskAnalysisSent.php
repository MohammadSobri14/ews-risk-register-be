<?php

namespace App\Notifications;

use App\Models\RiskAnalysis;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\Channel;

class RiskAnalysisSent extends Notification
{
    use Queueable;

    public function __construct(public RiskAnalysis $analysis) {}

    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->view('emails.risk_analysis_sent', [
                'analysis' => $this->analysis,
            ])
            ->subject('Analisis Risiko Baru Dikirim');
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Analisis risiko baru telah dikirim.',
            'risk_id' => $this->analysis->risk_id,
            'analysis_id' => $this->analysis->id,
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => 'Analisis risiko baru telah dikirim.',
            'risk_id' => $this->analysis->risk_id,
            'analysis_id' => $this->analysis->id,
        ]);
    }

    public function broadcastAs()
    {
        return 'notification-menris';
    }

    public function broadcastOn(): Channel
    {
        return new Channel('risk-analysis'); 
    }

}