<?php

namespace App\Notifications;

use App\Models\Risk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\Channel;

class RiskValidationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Risk $risk,
        public bool $isApproved,
        public ?string $notes = null
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'mail', 'broadcast'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->view('emails.risk_validation', [
                'risk' => $this->risk,
                'isApproved' => $this->isApproved,
                'notes' => $this->notes,
            ])
            ->subject(
                $this->isApproved
                    ? "Risk '{$this->risk->name}' Disetujui"
                    : "Risk '{$this->risk->name}' Ditolak"
            );
    }

    public function toDatabase($notifiable): array
    {
        return [
            'risk_id' => $this->risk->id,
            'name' => $this->risk->name,
            'is_approved' => $this->isApproved,
            'notes' => $this->notes,
            'message' => $this->isApproved
                ? 'Risk disetujui Koordinator Manajemen Risiko.'
                : 'Risk ditolak Koordinator Manajemen Risiko, perlu revisi.',
            'notifiable_id' => $notifiable->id,
        ];
    }


    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }

    public function broadcastAs(): string
    {
        return 'notification-validasi-risk';
    }

    public function broadcastOn(): Channel
    {
        return new Channel('risk-validation');
    }
}
